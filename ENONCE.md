# Séance 02 : Laravel, Atelier Solidaire. Un service testable

L'accueil tape `  ECRAN  ` et veut retrouver « Ecran noir ». Une recherche vide montre toutes les
interventions ouvertes ; un mot absent affiche « Aucune intervention ouverte » ; une adresse
fabriquée (`?q[]=x`) est refusée. Les interventions closes ne reviennent **jamais**.

Nouveauté : les données sont dans `config/atelier.php`, et `CatalogueInterventions` les **reçoit**
par son constructeur. Le service ne sait plus d'où elles viennent : on peut donc le tester seul.

1. **Démarrer** (5 min). `php artisan test` : lisez le **premier** message d'erreur. Quelle classe le
   conteneur n'arrive-t-il pas à construire, et pourquoi ?
2. **Apprendre au conteneur** (8 min). Dans `app/Providers/AppServiceProvider.php`, méthode
   `register()`, liez `CatalogueInterventions` à une fonction qui le construit avec
   `config('atelier.interventions')`. Relancez les tests : lesquels passent, lesquels échouent encore ?
3. **Écrire la recherche** (12 min). Complétez `CatalogueInterventions::chercher()` : sans mot (null
   ou blanc) => les ouvertes ; sinon, les ouvertes dont la description contient le mot, sans tenir
   compte des espaces autour ni de la casse. Tous les tests doivent passer.
4. **Prouver** (10 min). Dans `tests/Unit/CatalogueInterventionsTest.php`, écrivez
   `test_un_dossier_clos_ne_revient_jamais`. Puis lisez `tests/Feature/RemplacementTest.php` :
   expliquez en une phrase ce que fait `$this->app->instance(...)`.

Quiz : `?string` est-il une validation ? Qui exécute `new InterventionController(...)` ?
Pourquoi le test HTTP « `%20ECRAN%20` » passe-t-il alors que le test unitaire « `  ECRAN  ` » échoue ?
