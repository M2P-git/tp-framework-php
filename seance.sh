#!/usr/bin/env bash
# ============================================================================================
#  seance.sh : met le dépôt du cours à l'état d'une séance, puis prépare la machine Docker.
#  Pour macOS et Linux. Sous Windows : seance.bat, qui fait la même chose.
#
#  Dans un terminal, dans le dossier du dépôt du cours (tp-framework-php) :
#      ./seance.sh 03            ou      bash seance.sh 03
#
#  ATTENTION : toutes vos modifications DANS CE DOSSIER sont effacées. C'est voulu : toute la classe
#  repart des mêmes fichiers et des mêmes données. Votre propre projet Laravel, dans un autre dossier,
#  n'est pas touché. Gardez ailleurs ce que vous voulez conserver d'un TP.
#  Les fichiers ignorés par Git (.env, vendor, base SQLite) restent ; la base est recréée.
#  Option --oui : ne pas demander de confirmation.
# ============================================================================================

arret() {
  echo
  echo "Arrêt du script : $1" >&2
  exit 1
}

# docker compose (Docker récent) ou docker-compose (ancienne installation sous Linux)
choisir_compose() {
  command -v docker >/dev/null 2>&1 || arret "Docker est introuvable : installez Docker Desktop (macOS) ou Docker Engine (Linux)."
  if docker compose version >/dev/null 2>&1; then
    COMPOSE=(docker compose)
  elif command -v docker-compose >/dev/null 2>&1; then
    COMPOSE=(docker-compose)
  else
    arret "Docker Compose est introuvable : installez Docker Desktop, ou le paquet docker-compose-plugin."
  fi
}

demarrer_docker() {
  echo "Docker ne répond pas."
  case "$(uname -s)" in
    Darwin)
      echo "Démarrage de Docker Desktop..."
      open -a Docker 2>/dev/null || arret "Docker Desktop est introuvable : installez-le, puis relancez."
      ;;
    *)
      if docker info 2>&1 | grep -qi "permission denied"; then
        arret "votre compte n'a pas accès à Docker. Tapez : sudo usermod -aG docker \$USER, puis fermez la session et reconnectez-vous."
      fi
      echo "Démarrez Docker (Docker Desktop, ou : sudo systemctl start docker). J'attends..."
      ;;
  esac
  for _ in $(seq 1 60); do
    docker info >/dev/null 2>&1 && return 0
    sleep 3
  done
  arret "Docker ne démarre pas : lancez-le à la main, puis relancez ce script."
}

# Sous Linux, la machine Docker crée ses fichiers (.env, base, logs, fichiers générés par artisan) au nom de root :
# l'étudiant ne pourrait plus les modifier ni les effacer. On les lui rend, avant Git et à la fin.
# Sous macOS (et Windows), Docker Desktop s'en charge déjà.
rendre_fichiers() {
  [ "$(uname -s)" = Linux ] || return 0
  [ -f compose.yaml ] || return 0
  command -v docker >/dev/null 2>&1 || return 0
  docker info >/dev/null 2>&1 || return 0
  choisir_compose
  if "${COMPOSE[@]}" ps --status running --services 2>/dev/null | grep -qx app; then
    "${COMPOSE[@]}" exec -T app sh -c \
      "find /app -path /app/vendor -prune -o ! -user $(id -u) -print0 | xargs -0 -r chown $(id -u):$(id -g)" \
      >/dev/null 2>&1 || true
  fi
}

# Tout le travail est dans une fonction : bash la lit en entier avant de l'exécuter.
# Git peut ainsi remplacer ce fichier pendant qu'il s'exécute, sans rien casser.
principal() {
  local seance="" confirmer=oui arg branche origine reponse
  for arg in "$@"; do
    case "$arg" in
      -y|--oui|/oui) confirmer=non ;;
      *) seance="$arg" ;;
    esac
  done
  if [ -z "$seance" ]; then
    printf 'Numéro de la séance (par exemple 03) : '
    read -r seance
  fi
  seance="${seance#seance-}"
  case "$seance" in
    "") arret "aucune séance donnée." ;;
    [0-9]) seance="0$seance" ;;
  esac
  branche="seance-$seance"

  # ------------------------------------------------------------ ce dossier est-il le dépôt du cours ?
  command -v git >/dev/null 2>&1 || arret "Git est introuvable (macOS : xcode-select --install ; Linux : sudo apt install git)."
  [ -d .git ] || arret "ce dossier n'est pas un dépôt Git : $(pwd). Placez-vous dans tp-framework-php, puis relancez."
  origine="$(git remote get-url origin 2>/dev/null || true)"
  case "$origine" in
    *M2P-git/tp-framework-php*) ;;
    *) arret "ce dossier n'est pas le dépôt du cours : $(pwd). Rien n'a été modifié." ;;
  esac

  echo "Récupération des séances en ligne..."
  git fetch origin --prune || arret "git fetch a échoué : vérifiez la connexion."
  if ! git rev-parse --verify --quiet "origin/$branche" >/dev/null; then
    echo "La séance $branche n'existe pas en ligne. Séances disponibles :"
    git branch -r --list 'origin/seance-*'
    arret "séance inconnue."
  fi

  # ------------------------------------------------------------ confirmation
  if [ "$confirmer" = oui ]; then
    echo
    echo "Le dossier $(pwd) va passer à la séance $branche."
    echo "Les modifications ci-dessous seront EFFACÉES (aucune ligne : rien à effacer) :"
    git status --short
    echo
    printf 'Continuer ? [o/N] '
    read -r reponse
    case "$reponse" in
      o|O|oui|Oui|OUI) ;;
      *) echo "Annulé : rien n'a été modifié."; exit 0 ;;
    esac
  fi

  # ------------------------------------------------------------ Git : remise à l'état de la séance
  rendre_fichiers
  git reset --hard -q
  git clean -fdq
  git checkout -q -B classe "origin/$branche" || arret "changement de branche impossible."
  git reset --hard -q "origin/$branche"
  echo "Dépôt aligné sur $branche."

  if [ ! -f compose.yaml ]; then
    echo
    echo "Cette séance n'utilise pas Docker. Lisez README.md pour commencer."
    exit 0
  fi

  # ------------------------------------------------------------ Docker : la machine du cours
  choisir_compose
  docker info >/dev/null 2>&1 || demarrer_docker
  echo "Démarrage de la machine Docker (la première fois : quelques minutes)..."
  "${COMPOSE[@]}" up -d --build || arret "si le port 8000 est déjà pris, une autre machine du cours tourne encore : arrêtez-la avec docker compose down, dans son dossier, puis relancez."
  echo "Installation des paquets (composer install)..."
  "${COMPOSE[@]}" exec -T app composer install --no-interaction --no-progress || arret "composer install a échoué."
  "${COMPOSE[@]}" exec -T app php scripts/prepare.php
  "${COMPOSE[@]}" exec -T app php artisan key:generate
  echo "Base de données de la séance (migrate:fresh --seed)..."
  if ! "${COMPOSE[@]}" exec -T app php artisan migrate:fresh --seed; then
    echo
    echo "Le remplissage de la base s'est arrêté sur une erreur. Au départ d'un TP, c'est souvent voulu :"
    echo "l'énoncé vous demande justement de la corriger."
  fi
  "${COMPOSE[@]}" exec -d app php artisan serve --host=0.0.0.0 --port=8000
  rendre_fichiers

  echo
  echo "==============================================================="
  echo " Le dépôt est à la séance $branche."
  echo "   Site de la séance       : http://127.0.0.1:8000"
  echo "   Terminal de la machine  : docker compose exec app bash"
  echo "   Tests                   : docker compose exec app php artisan test"
  echo "==============================================================="
  exit 0
}

# principal() se termine toujours par exit : bash ne relit rien de ce fichier après cette ligne.
principal "$@"
