# Base commune et expérience personnelle

## Premier démarrage

```powershell
git clone https://github.com/M2P-git/tp-framework-php.git
cd tp-framework-php
git fetch origin
git switch -C classe origin/seance-01
```

Suivre ensuite le README de la branche pour Composer, la configuration et Docker.

## Nouvelle séance

Sauvegarder dans un autre dossier ou une branche personnelle ce que vous souhaitez
garder avant la remise à zéro. Les commandes suivantes effacent le travail local
de classe ; remplacer 02 par la séance annoncée.

```powershell
git fetch origin
git reset --hard
git clean -nd
git clean -fd
git switch -C classe origin/seance-02
git reset --hard origin/seance-02
docker compose run --rm composer install
docker compose run --rm app php artisan migrate:fresh --seed
git status --short
```

`clean -nd` prévisualise la suppression ; `clean -fd` l'exécute. Les fichiers
ignorés restent présents : `.env`, dépendances et SQLite. La commande `fresh`
efface et recrée seulement la BD fictive de classe. Ne jamais l'utiliser sur
une BD de production ou des données à conserver. `pull` seul peut fusionner du
travail local et ne garantit pas une base identique.

Les corrigés vont de `corrige-01` à `corrige-04`. Pour comprendre une solution :
`git diff origin/seance-02 origin/corrige-02 -- app`.

## Nouveau projet Laravel, sans copier la solution

Voie locale : PHP 8.3+, Composer, extensions nécessaires et réseau initial.

```powershell
composer create-project laravel/laravel:"13.*" mon-atelier-laravel
cd mon-atelier-laravel
git init
php artisan key:generate
php artisan serve
```

Avec Docker uniquement, depuis un dossier parent :

```powershell
docker run --rm -v "${PWD}:/app" -w /app composer:2 create-project laravel/laravel:"13.*" mon-atelier-laravel
```

Préparer ensuite PHP et la configuration suivant le README du squelette.
Le Compose technique de classe peut être adapté, sans recopier ses solutions
métier. Définir un seul besoin, une route et un test, puis étendre progressivement.
L'IA intervient sur un petit diff après rédaction des critères.

## Nouveau projet Symfony pour la suite du parcours

```powershell
composer create-project symfony/skeleton:"7.4.*" mon-atelier-symfony
cd mon-atelier-symfony
composer require webapp
```

Le dossier reste indépendant du projet remis à zéro. Cette création nécessite
un accès réseau initial ; suivre la documentation de la version installée.

Sources : [Git reset](https://git-scm.com/docs/git-reset),
[clean](https://git-scm.com/docs/git-clean), [switch](https://git-scm.com/docs/git-switch),
[Laravel](https://laravel.com/docs/13.x/installation),
[Symfony](https://symfony.com/doc/7.4/setup.html).
