# Séance 03 : Laravel, Atelier Solidaire. Les données et l'historique avec Eloquent

Ce dépôt est le projet de l'atelier ; vous le découvrez dans ce TP. Il contient déjà une liste des interventions
ouvertes, avec une recherche (`/interventions`), un contrôleur (`InterventionController`) et un service
(`CatalogueInterventions`) qui fournit les interventions au contrôleur. Les données sont dans une base SQLite :
les migrations (`database/migrations/`) et les modèles (`app/Models/`) sont fournis.

La machine A12 revient à l'atelier pour un écran noir. Elle était déjà venue pour un disque lent.
L'accueil veut voir **tout l'historique** de A12 sur une page, et le retour ne doit **jamais** créer
une seconde fiche A12 : il crée seulement une nouvelle intervention.

Avant de commencer, remettez le dépôt à l'état de la séance 3 (voir le `README.md`, ou la diapositive
« Démarrer le TP ») : vos modifications précédentes dans ce dossier sont effacées, c'est voulu.

1. **Les relations** (5 min). `php artisan test` : lisez le **premier** message d'erreur.
   Dans `app/Models/Machine.php`, écrivez `interventions()` (une machine a plusieurs interventions) ;
   dans `app/Models/Intervention.php`, écrivez `machine()` (une intervention concerne une machine).
   Modèles à imiter : `Personne::machines()` et `Machine::personne()`. Combien de tests passent ensuite ?
2. **Le seeder** (10 min). Dans `database/seeders/AtelierSeeder.php`, créez les trois interventions
   indiquées par le `TODO`, avec leurs pièces, en passant par les relations. Donnez toujours le statut.
   Lancez `php artisan migrate:fresh --seed` : la commande doit aller jusqu'au bout.
3. **La liste sans requêtes en boucle** (5 min). Dans `app/Providers/AppServiceProvider.php`, la fonction qui
   construit le service lit les interventions avec `Intervention::all()` : pour afficher la série de chaque
   machine, Laravel fait une requête par intervention. Chargez les machines avec `with('machine')`. Le test
   `pas de requete par intervention` doit passer.
4. **L'historique d'une machine** (15 min). Écrivez la route `GET /machines/{machine:serie}`
   (nommée `machines.show`), la méthode `MachineController::show()` et la boucle de la vue
   `resources/views/machines/show.blade.php`. Ajoutez le lien « historique » dans la liste des interventions.
   Ouvrez <http://127.0.0.1:8000/machines/A12> : les deux interventions de A12 apparaissent dans l'ordre.

Tous les tests doivent passer, dont `un retour ne cree pas de machine`.

Quiz : où Laravel trouve-t-il la colonne `machine_id` quand vous écrivez `hasMany(Intervention::class)` ?
Pourquoi le seeder crée-t-il les personnes avant les machines ? Que donne `/machines/Z99`, et quelle
ligne de votre code produit ce résultat ?
