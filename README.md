# Atelier Solidaire : Laravel, séance 01

Dr Paul Mbilong, L3 Développement, ISMAGI. Compléter les TODO ; les tests doivent détecter les comportements manquants.

Lire [l'énoncé](ENONCE.md), [l'aide IDE](docs/ide-et-aide-locale.md),
[la remise à zéro](docs/git-et-experimentation.md) et [les preuves de sécurité](docs/securite-client.md).

## Installation avec Docker : la « machine » du cours

Deux chemins mènent au même résultat : **Docker** (ci-dessous) ou une **installation PHP locale**
(plus bas). Avec Docker, PHP 8.5, Composer et Git vivent dans une « machine » jetable : **rien
à installer sur Windows**, et tout le monde a exactement le même environnement.

Prérequis : [Docker Desktop](https://www.docker.com/products/docker-desktop/) installé et **lancé**
(attendre qu'il indique « Engine running »), et Git.

### 1. Le vocabulaire, en six mots

| Mot | Ce que c'est | Dans ce TP |
|:--|:--|:--|
| **Image** | un modèle figé, comme un fichier d'installation | `php:8.5-cli` (PHP officiel), puis `tp-laravel:8.5` (notre version) |
| **Conteneur** (la « machine ») | l'image **en marche** : un petit ordinateur Linux isolé, qu'on peut détruire et recréer | le service `app` |
| **Dockerfile** | la **recette** qui fabrique l'image : ce qu'on met **dans** la machine | le fichier `Dockerfile` |
| **compose.yaml** | la **fiche de démarrage** : comment lancer la machine (dossiers partagés, ports) | le fichier `compose.yaml` |
| **Volume** | un dossier partagé entre votre ordinateur et la machine, ou un espace de stockage géré par Docker | votre dépôt est partagé ; `vendor/` a son propre volume |
| **Port** | la porte par laquelle votre navigateur parle au serveur de la machine | `8000` |

### 2. Démarrer la machine : les deux commandes à retenir

Dans un terminal (PowerShell), **depuis la racine du dépôt** (le dossier qui contient `compose.yaml`) :

```bash
git clone --branch seance-01 https://github.com/M2P-git/tp-framework-php.git tp-laravel
cd tp-laravel

docker compose up -d --build   # construit puis démarre « la machine » (1re fois : 1 à 3 min)
docker compose exec app bash   # ouvre un terminal DANS la machine
```

Le prompt change : vous êtes maintenant **dans la machine**.

```text
PS C:\...\tp-laravel>      <- votre ordinateur (PowerShell)
root@3f2a9c1b7d4e:/app#    <- la machine (Linux, dossier /app)
```

Que veut dire chaque mot ?

| Morceau | Sens |
|:--|:--|
| `docker compose` | le programme qui lit `compose.yaml` et pilote la machine (**avec un espace** : pas `docker-compose`) |
| `up` | créer la machine si elle n'existe pas, puis la **démarrer** |
| `-d` | *detached* : la machine tourne **en arrière-plan**, votre terminal reste libre |
| `--build` | (re)construire l'image avec le `Dockerfile` avant de démarrer. Long la 1re fois (téléchargement de PHP), quasi instantané ensuite car Docker réutilise ce qu'il a déjà construit |
| `exec` | **exécuter** une commande dans une machine déjà démarrée |
| `app` | le **nom du service** dans `compose.yaml` |
| `bash` | la commande à exécuter : un terminal. `exit` le quitte, **la machine continue de tourner** |

> **Règle d'or : deux endroits, deux sortes de commandes.**
> Les commandes `docker ...` et `git ...` se tapent **sur votre ordinateur**.
> Les commandes `php ...`, `composer ...` et `php artisan ...` se tapent **dans la machine**
> (prompt `root@...:/app#`). Si `php` « n'existe pas », vous êtes sur votre ordinateur : lancez
> `docker compose exec app bash`.

### 3. Dans la machine : installer et lancer le TP

À faire une seule fois, dans le terminal de la machine :

```bash
composer install                              # télécharge Laravel et ses paquets dans vendor/ (quelques minutes)
php scripts/prepare.php                       # crée .env et la base SQLite locale
php artisan key:generate                      # génère la clé secrète de cette application
php scripts/cache-ide.php                     # facultatif (3 min) : copie de vendor/ pour « aller à la définition » dans l'éditeur
php artisan migrate:fresh --seed              # crée les tables et les données fictives
php artisan test                              # 1 échec attendu (voir ENONCE.md), 2 réussis
php artisan serve --host=0.0.0.0 --port=8000  # démarre le serveur ; Ctrl+C l'arrête
```

Ouvrir ensuite <http://127.0.0.1:8000/interventions> dans le navigateur de votre ordinateur.

- `--host=0.0.0.0` est **indispensable** : sans lui, le serveur n'écoute que *dans* la machine et
  votre navigateur n'y accède pas.
- `serve` occupe le terminal tant qu'il tourne. Pour continuer à travailler, ouvrez un **second**
  terminal sur votre ordinateur et tapez `docker compose exec app bash`.
- Les tests en échec sur une base sont attendus jusqu'à correction.
  `migrate:fresh --seed` efface et recrée UNIQUEMENT la BD SQLite locale de ce TP.
  Ne pas utiliser cette commande avec des données à conserver ou en production.
  Les séances 1 et 2 utilisent la liste en mémoire ; la BD de l'atelier commence à la séance 3.

### 4. Les commandes Docker du cours (aide-mémoire)

À taper **sur votre ordinateur**, depuis la racine du dépôt.

| Je veux… | Commande |
|:--|:--|
| Construire puis démarrer la machine (1re fois) | `docker compose up -d --build` |
| La redémarrer un autre jour (rien à reconstruire) | `docker compose up -d` |
| Ouvrir un terminal dans la machine | `docker compose exec app bash` |
| Exécuter **une seule** commande, sans ouvrir de terminal | `docker compose exec app php artisan test` |
| Voir si la machine tourne | `docker compose ps` |
| L'éteindre (vos fichiers restent) | `docker compose down` |
| Reconstruire après avoir modifié le `Dockerfile` | `docker compose up -d --build` |
| **Tout** remettre à zéro, y compris `vendor/` | `docker compose down -v` puis `docker compose up -d --build` et `composer install` |
| Lancer une commande dans une machine **temporaire** (créée puis supprimée), que la machine du cours soit allumée ou non | `docker compose run --rm app php artisan test` |

Attention à `down -v` : le `-v` supprime aussi le volume `vendor`, il faudra relancer
`composer install`. Vos fichiers du dépôt (code, `.env`, base SQLite) ne sont jamais supprimés.

### 5. Le Dockerfile : ce qu'il y a dans la machine

Le `Dockerfile` est lu **de haut en bas** ; chaque instruction ajoute une couche à l'image.

| Instruction | Rôle |
|:--|:--|
| `FROM php:8.5-cli` | point de départ : l'image officielle PHP 8.5 en ligne de commande (SQLite, mbstring, DOM... déjà inclus) |
| `RUN apt-get install ... git unzip curl nano procps` | ajoute des outils Linux : Git, `unzip` (Composer en a besoin), `curl`, `nano`, `ps`/`top` |
| `COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer` | récupère le programme Composer dans l'image officielle `composer:2` |
| `WORKDIR /app` | dossier de travail de la machine : celui où votre dépôt est partagé |
| `CMD ["sleep", "infinity"]` | commande lancée au démarrage : ne rien faire, pour que la machine **reste allumée** et que `exec` puisse s'y connecter |

On construit l'image **une fois** ; ensuite chaque démarrage de la machine est immédiat.

### 6. compose.yaml : comment on la lance

| Ligne | Rôle |
|:--|:--|
| `services:` / `app:` | la liste des machines ; ici une seule, nommée `app` (le nom qu'on tape dans `exec app`) |
| `build: .` | construire l'image avec le `Dockerfile` du dossier courant |
| `image: tp-laravel:8.5` | le nom donné à l'image construite |
| `working_dir: /app` | dossier où l'on arrive en ouvrant un terminal |
| `init: true`, `tty: true`, `stdin_open: true` | arrêt propre de la machine (`down` en 1 s) et terminal interactif disponible |
| `.:/app` | **dossier partagé** : `.` (votre dépôt) apparaît dans la machine sous `/app`. Éditez dans VS Code, exécutez dans la machine |
| `vendor:/app/vendor` | `vendor/` est stocké dans un **volume Docker** (disque Linux) et non dans votre dossier Windows : bien plus rapide pour Composer |
| `"127.0.0.1:8000:8000"` | port `ORDINATEUR:MACHINE` : le serveur de la machine (8000) répond sur `http://127.0.0.1:8000`, **depuis votre ordinateur seulement** |
| `volumes: vendor:` | déclare le volume nommé utilisé ci-dessus |

### 7. Dockerfile ou compose.yaml : lequel modifier ?

| | **Dockerfile** | **compose.yaml** |
|:--|:--|:--|
| Question posée | « Qu'y a-t-il **dans** la machine ? » | « Comment la **lancer** ? » |
| On y trouve | PHP, Composer, Git, `WORKDIR`, `CMD` | nom du service, dossiers partagés, ports |
| On le modifie pour | installer un outil de plus | changer un port ou un dossier partagé |
| Ensuite | `docker compose up -d --build` | `docker compose up -d` |

On pourrait tout écrire dans une longue commande `docker run`. `compose.yaml` garde ces réglages
dans un fichier lisible et suivi par Git, et `docker compose` les relit à chaque commande.

### 8. Comment ça marche

```text
 VOTRE ORDINATEUR (Windows)                     LA MACHINE (conteneur Linux, service « app »)
 ┌──────────────────────────────┐               ┌──────────────────────────────────────┐
 │ tp-laravel\ (VS Code)        │◄── partagé ──►│ /app          code, .env, SQLite     │
 │                              │               │ /app/vendor   volume (Composer)      │
 │ navigateur                   │               │ php artisan serve (port 8000)        │
 │ http://127.0.0.1:8000        │◄─ port 8000 ─►│                                      │
 └──────────────────────────────┘               └──────────────────────────────────────┘
```

- Votre code, `.env` et la base SQLite sont dans le dossier **partagé** : ils survivent à
  `docker compose down`.
- Tout ce que vous installez à la main dans la machine **en dehors** de `/app` (par exemple avec
  `apt-get install`) est perdu à `docker compose down`. Pour garder un outil, ajoutez-le au `Dockerfile`.
- Git peut rester sur votre ordinateur (clone, commit, changement de branche) : c'est le plus simple.
  Après un changement de branche, relancez `docker compose up -d --build`, puis `composer install`
  dans la machine si `composer.lock` a changé.
- Après un redémarrage de l'ordinateur ou de Docker Desktop, la machine est éteinte :
  `docker compose up -d`.

### 9. Si quelque chose ne va pas

| Message | Cause probable | Que faire |
|:--|:--|:--|
| `failed to connect to the docker API ... the daemon is running` | Docker Desktop n'est pas lancé | le démarrer, attendre « Engine running », relancer la commande |
| `no configuration file provided: not found` | vous n'êtes pas dans le dossier du dépôt | `cd tp-laravel` (le dossier qui contient `compose.yaml`) |
| `service "app" is not running` | la machine est éteinte | `docker compose up -d` |
| `Bind for 127.0.0.1:8000 failed: port is already allocated` | le port 8000 est pris (autre serveur, ou machine d'un autre dossier du cours) | `Ctrl+C` dans l'autre serveur, ou `docker compose down` dans l'autre dossier |
| `Failed opening required '/app/vendor/autoload.php'` | `composer install` pas fait (ou `vendor` supprimé par `down -v`) | `composer install` dans la machine |
| `No application encryption key has been specified` | `key:generate` oublié | `php artisan key:generate` dans la machine |
| `php: command not found` | vous tapez dans PowerShell, pas dans la machine | `docker compose exec app bash` |
| le serveur tourne mais le navigateur n'affiche rien | `serve` lancé sans `--host=0.0.0.0` | l'arrêter (`Ctrl+C`) et le relancer avec la commande complète |
| `composer install` très lent | connexion lente (des centaines de paquets à télécharger) | patienter ; s'il est interrompu, le relancer |

## Installation PHP locale

PHP >= 8.3 avec pdo_sqlite, mbstring, DOM et extensions requises par Composer.
Exécuter `composer install`, copier `.env.example` en `.env`, ajuster `DB_DATABASE`
au chemin ABSOLU de `database/database.sqlite` local, créer le fichier, puis
`php artisan key:generate`, `php artisan migrate:fresh --seed`, `php artisan test`,
`php artisan serve`. Les dépendances sont verrouillées avec platform.php=8.3.0.
Aucun build Node n'est nécessaire : les vues du TP utilisent du CSS simple.

## Périmètre

Laravel 13 et PHPUnit, application de démonstration, données fictives, serveur de développement.
Les comptes de la séance 4 sont annoncés sur la page login, jamais destinés à la production.
Les tests CSRF se font sur le serveur local réel ; le mode Feature les contourne normalement.
