# « La machine » du cours : PHP 8.5 + Composer + Git, sans rien installer sur votre ordinateur.
# Construite une seule fois par `docker compose up -d --build` (1 à 3 minutes).
#
# Un Dockerfile est la RECETTE de la machine : chaque instruction ajoute une couche.
# On le modifie rarement ; si on le modifie, on relance `docker compose up -d --build`.

# 1. Point de départ : l'image officielle PHP 8.5 (ligne de commande), avec SQLite,
#    mbstring, DOM, tokenizer... c'est-à-dire tout ce que Laravel demande.
FROM php:8.5-cli

# 2. Outils système : git (Composer s'en sert parfois), unzip (décompresser les paquets),
#    curl (appeler le serveur depuis la machine), nano (éditer vite), procps (ps, top).
RUN apt-get update \
 && apt-get install -y --no-install-recommends git unzip curl nano procps ca-certificates \
 && rm -rf /var/lib/apt/lists/* \
 # le dossier du cours appartient à un autre utilisateur que celui de la machine : on autorise Git
 && git config --system --add safe.directory '*'

# 3. Composer : on copie le programme depuis l'image officielle « composer:2 ».
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# 4. Dossier de travail : c'est ici que le dépôt est partagé (voir compose.yaml).
#    Le fichier .env.example indique d'ailleurs /app/database/database.sqlite.
WORKDIR /app

# 5. La machine reste allumée tant qu'on ne l'éteint pas : on s'y connecte
#    avec `docker compose exec app bash`.
CMD ["sleep", "infinity"]
