# Atelier Solidaire : Laravel, séance 01

Dr Paul Mbilong, L3 Développement, ISMAGI. Compléter les TODO ; les tests doivent détecter les comportements manquants.

Lire [l'énoncé](ENONCE.md), [l'aide IDE](docs/ide-et-aide-locale.md),
[la remise à zéro](docs/git-et-experimentation.md) et [les preuves de sécurité](docs/securite-client.md).

## Installation avec Docker

Docker Desktop lancé ; aucune installation PHP/Composer sur Windows nécessaire.
Les dépendances sont dans un volume Linux pour éviter les lenteurs de vendor sur Windows.

```powershell
docker compose run --rm composer install
docker compose run --rm app php scripts/prepare.php
docker compose run --rm app php artisan key:generate
docker compose run --rm app php scripts/cache-ide.php
docker compose run --rm app php artisan migrate:fresh --seed
docker compose run --rm app php artisan test
docker compose up app
```

Ouvrir http://127.0.0.1:8000. Les tests en échec sur une base sont attendus jusqu'à correction.
`migrate:fresh --seed` efface et recrée UNIQUEMENT la BD SQLite locale de ce TP.
Ne pas utiliser cette commande avec des données à conserver ou en production.
Les séances 1 et 2 utilisent la liste en mémoire ; la BD de l'atelier commence à la séance 3.

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
