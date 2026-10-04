# Vérifications du professeur, 4 octobre 2026

Laravel 13.34.0, PHP 8.5 CLI dans Docker, SQLite de test en mémoire.
Cette fiche décrit des résultats réellement observés sur les fichiers corrigés.
Le commit de publication est à relever dans Git pour toute nouvelle exécution.

| Branche | Tests réussis | Assertions |
|:--|--:|--:|
| corrige-01 | 3 | 6 |
| corrige-02 | 8 | 18 |
| corrige-03 | 4 | 10 |
| corrige-04 | 15 | 38 |

Commandes : initialisation locale, clé d'application puis `php artisan test`.
Les tests des départs échouent volontairement sur les TODO : respectivement
1, 2, 1 et 2 échecs. Les quatre corrigés réussissent.

## Contrôle HTTP CSRF distinct

Sur le serveur local de corrige-04 et des données fictives : POST login sans
jeton = 419 ; login avec cookie et jeton = accepté ; POST démarrage sans jeton =
419 ; démarrage avec jeton = accepté. Les requêtes n'avaient ni Origin ni
Sec-Fetch-Site. Le compte 2 était assigné au dossier 1.

Les tests Feature désactivent normalement le CSRF. Le contrôle HTTP ci-dessus
est une preuve séparée, limitée à cet environnement et à ces scénarios.
Les comptes demo-cours sont publics et réservés à la classe. Le prototype
ne démontre pas une sécurité complète, la confidentialité de toutes les pages
ou la résistance aux accès concurrents. Les fonctions Symfony sont futures.
