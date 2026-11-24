# Séance 04 : Laravel, Atelier Solidaire. Des données à la page protégée

Toute la séance se fait dans ce dépôt, sur les modèles de l'atelier (`Personne`, `Machine`, `Intervention`,
`Piece`) : vous refaites chaque démonstration des diapositives, puis les deux exercices.

Avant de commencer, remettez le dépôt à l'état de la séance 4 (voir le `README.md`) : vos modifications
précédentes dans ce dossier sont effacées, c'est voulu.

## Les parties de la séance

1. **Factories et seeders** : `PersonneFactory`, `MachineFactory`, `InterventionFactory`, `HasFactory` dans les
   modèles. Le test `FactoryTest` échoue au départ, puis passe.
2. **Contrôleurs** : `AtelierController` (contrôleur simple), `MachineController` (contrôleur ressource).
3. **Eloquent dans le contrôleur** : `with()` avant `get()`, `load()` sur un objet déjà lu.
4. **Vues Blade** : la liste et la fiche des machines.
5. **Exercice 1** : les pages des personnes. Vérification :
   `php artisan test tests/Exercices/Exercice1Test.php` (5 tests).
6. **Conteneur de services, middlewares, guards** : `StatistiquesAtelier`, `JournalDesVisites`, la connexion
   (fournie : `ConnexionController`, vue `connexion`, routes `/connexion` et `/deconnexion`).
7. **Exercice final** : le catalogue des pièces. Vérification :
   `php artisan test tests/Exercices/ExerciceFinalTest.php` (8 tests).

Connexion : `test@example.com`, mot de passe `password` (après `php artisan migrate:fresh --seed`).

À la fin de la séance, `php artisan test` et `php artisan test tests/Exercices` passent entièrement.
