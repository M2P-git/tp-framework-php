# Séance 03 : Laravel, Atelier Solidaire. Les données et l'historique avec Eloquent

La machine A12 revient à l'atelier pour un écran noir. Elle était déjà venue pour un disque lent.
L'accueil veut voir **tout l'historique** de A12 sur une page, et le retour ne doit **jamais** créer
une seconde fiche A12 : il crée seulement une nouvelle intervention.

Nouveauté : les données quittent `config/atelier.php` pour une base SQLite. Les migrations
(`database/migrations/`) et les modèles (`app/Models/`) sont fournis ; il vous reste à écrire deux
relations, la fin du seeder, la liaison du service avec la base, et la page de l'historique.

1. **Les relations** (5 min). `php artisan test` : lisez le **premier** message d'erreur.
   Dans `app/Models/Machine.php`, écrivez `interventions()` (une machine a plusieurs interventions) ;
   dans `app/Models/Intervention.php`, écrivez `machine()` (une intervention concerne une machine).
   Modèles à imiter : `Personne::machines()` et `Machine::personne()`. Combien de tests passent ensuite ?
2. **Le seeder** (10 min). Dans `database/seeders/AtelierSeeder.php`, créez les trois interventions
   indiquées par le `TODO`, avec leurs pièces, en passant par les relations. Donnez toujours le statut.
   Lancez `php artisan migrate:fresh --seed` : la commande doit aller jusqu'au bout.
3. **Le service branché sur la base** (10 min). Dans `app/Providers/AppServiceProvider.php`, donnez à
   `CatalogueInterventions` les interventions de la base au lieu de `config('atelier.interventions')`,
   sous la même forme (des tableaux avec `id`, `serie`, `description`, `statut`). Utilisez `with('machine')` :
   le test `pas de requete par intervention` vérifie que la page fait au plus deux requêtes.
   Le service, le contrôleur et les vues de la séance 2 ne changent pas. Supprimez ensuite `config/atelier.php`.
4. **L'historique d'une machine** (15 min). Écrivez la route `GET /machines/{machine:serie}`
   (nommée `machines.show`), la méthode `MachineController::show()` et la boucle de la vue
   `resources/views/machines/show.blade.php`. Ajoutez le lien « historique » dans la liste des interventions.
   Ouvrez <http://127.0.0.1:8000/machines/A12> : les deux interventions de A12 apparaissent dans l'ordre.

Tous les tests doivent passer, dont `un retour ne cree pas de machine`.

Quiz : où Laravel trouve-t-il la colonne `machine_id` quand vous écrivez `hasMany(Intervention::class)` ?
Pourquoi le seeder crée-t-il les personnes avant les machines ? Que donne `/machines/Z99`, et quelle
ligne de votre code produit ce résultat ?
