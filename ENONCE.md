# TP séance 1 : écrire le plus petit framework possible

Dr Paul Mbilong, L3 Développement, ISMAGI. Durée : 50 minutes en classe, en binôme.
PHP 8.3 ou plus. Aucune bibliothèque, pas de Composer : uniquement PHP.

## Le but

Vous avez vu qu'un framework **appelle votre code**. Ici, vous écrivez les pièces qui l'appellent :
un point d'entrée, un routeur, un contrôleur, une vue, un objet réponse. Ce sont les mêmes pièces que
dans Laravel et Symfony, à l'échelle d'une dizaine de petits fichiers.

Le scénario est celui de l'Atelier Solidaire : l'accueil veut la liste des interventions **ouvertes**
(A12 reçue, C19 en cours ; B07 est close), et le détail d'une intervention.

## Mise en route (7 minutes)

```powershell
# depuis la racine du dépôt cloné
php tests/check.php                  # 10 contrôles : tous rouges au départ
php -S 127.0.0.1:8000 -t public      # serveur de développement, point d'entrée : public/index.php
```

1. Lancez le vérificateur et lisez la **piste** sous chaque contrôle en échec.
2. Ouvrez <http://127.0.0.1:8000/interventions> : que voyez-vous, et pourquoi ?
3. Lisez `public/index.php` : repérez les cinq étapes numérotées.
4. Lisez `src/autoload.php`. **Prédisez** : dans quel fichier PHP cherchera-t-il `Mini\Http\Response` ?
   Et `App\InterventionController` ?

## Les quatre points de contrôle

Les endroits à compléter sont marqués `TODO` dans le code.

### Point 1 : le routeur (10 min), `src/Http/Router.php`

`get($modele, $action)` mémorise la route dans `$this->routes` (modèle => action). `repartir($requete)`
cherche l'action dont le modèle est égal au chemin de la requête, l'appelle et renvoie sa réponse ;
sinon elle renvoie une réponse `404`.
Pistes : un tableau associatif, l'opérateur `??`, un `callable` s'appelle avec `$action()`.

Attendu : `/` redirige (302), `/interventions` répond 200, `/inconnu` répond 404.

### Point 2 : le contrôleur (8 min), `app/InterventionController.php`, méthode `liste()`

Ne garder que les interventions dont le statut n'est **pas** `clos`.
Pistes : `array_filter`, une fonction fléchée `fn (array $i): bool => ...`, la comparaison stricte `!==`,
puis `array_values`. **Prédisez d'abord** ce que le filtre renvoie pour B07.

Attendu : A12 et C19 listées, B07 absente, message dédié si la liste est vide.

### Point 3 : l'échappement (7 min), `src/vue.php`, fonction `e()`

Une description peut contenir du HTML. Réparez `e()` avec `htmlspecialchars`
(`ENT_QUOTES | ENT_SUBSTITUTE`, `'UTF-8'`).

Attendu : `<script>alert(1)</script>` s'affiche comme du texte (`&lt;script&gt;`).

### Point 4 : une route avec paramètre (15 min)

1. Dans `Router::repartir()`, transformez le modèle `/interventions/{id}` en expression régulière à
   capture nommée : `'#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $modele) . '$#'`.
2. Avec `preg_match`, récupérez les captures ; gardez les clés **textuelles** avec
   `array_filter($trouve, 'is_string', ARRAY_FILTER_USE_KEY)`.
3. Appelez l'action avec `$action(...$parametres)` : depuis PHP 8.1, des clés textuelles deviennent des
   **arguments nommés**.
4. Dans `InterventionController::detail(string $id)`, trouvez l'intervention (attention : `$id` est un
   texte, `'id'` dans les données est un entier) et affichez la vue `detail` ; sinon la vue `404` avec le
   statut 404.

Attendu : `/interventions/101` affiche A12 ; `/interventions/999` et `/interventions/abc` répondent 404.

## Bilan

`php tests/check.php` doit afficher « Tout est vert ». Écrivez dans votre mémento :
quelles sont les six pièces que vous avez assemblées, et comment s'appelle chacune dans Laravel
et dans Symfony ?

## Pour les plus rapides

1. Dans l'onglet Réseau du navigateur, observez `302` puis `200` pour `/`.
2. Une intervention au statut `rendue` doit-elle être listée ? Écrivez le test dans `tests/check.php`
   et **justifiez** votre réponse à votre voisin.
3. Cassez volontairement une chose (renommez `{id}` en `{identifiant}` dans `app/routes.php`) et lisez
   le message d'erreur en entier avant de corriger.

## À faire avant la séance 2

- Terminer ce TP.
- Cloner le dépôt de la classe, ouvrir la branche `seance-01` (projet Laravel), le lancer (voir son
  `README.md`), répondre aux six questions « retrouvez les pièces » de la présentation, compléter
  `CatalogueInterventions::ouvertes()` et obtenir des tests verts.
