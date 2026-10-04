# Retrouver une réponse en local

Dans VS Code, installer un service de langage PHP (par exemple Intelephense),
puis ouvrir le dossier du projet entier. Les raccourcis sont ceux de Windows
et peuvent varier avec votre clavier ou votre configuration.

| Besoin | VS Code | PhpStorm |
|:--|:--|:--|
| Fichier | Ctrl+P | Ctrl+Shift+N |
| Recherche dans le projet | Ctrl+Shift+F | Ctrl+Shift+F |
| Déclaration | F12 | Ctrl+B |
| Utilisations | Shift+F12 | Alt+F7 |
| Signature / paramètres | Ctrl+Shift+Espace | Ctrl+P |
| Documentation rapide | Survol / Ctrl+K puis Ctrl+I | Ctrl+Q |
| Action oubliée | Ctrl+Shift+P | Ctrl+Shift+A |

Une fonction interne à PHP n'a pas de corps PHP dans `app/` : l'IDE peut montrer
un stub contenant sa signature. Les méthodes d'une bibliothèque sont dans
`vendor/` après installation. Vérifier les types et les conditions de la
méthode, puis tester un exemple réduit. Sans connexion, le code et les stubs
indexés restent consultables ; une documentation externe non téléchargée
ne devient pas disponible par magie.

## Aide locale de référence

- `trim(string $string): string` supprime les caractères blancs de début/fin.
  Pour les exercices, les descriptions sont ASCII ; un traitement complet
  des espaces Unicode demanderait une décision supplémentaire.
- `strlen(string $string): int` mesure des octets, pas des caractères Unicode.
- `array_filter(array $array, ?callable $callback = null): array` conserve les
  clés des éléments retenus. `array_values` réindexe le résultat.
- `str_contains(string $haystack, string $needle): bool` est sensible à la casse.
- `htmlspecialchars($texte, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')` prépare
  du texte pour un contexte HTML. Il ne sécurise pas une requête SQL.
- `DateTimeImmutable` crée un nouvel objet lors d'une modification de date.

Sources : [PHP](https://www.php.net/manual/fr/),
[VS Code](https://code.visualstudio.com/docs/editing/editingevolved),
[PhpStorm](https://www.jetbrains.com/help/phpstorm/navigating-through-the-source-code.html).

## Navigation Windows lorsque vendor est dans le volume Docker

Docker conserve les dépendances dans un volume Linux, qui n'est pas visible
directement par l'éditeur Windows. Pour disposer d'une copie de lecture locale :

```powershell
docker compose run --rm app php scripts/cache-ide.php
```

Le dossier `.ide-vendor` contient les fichiers PHP copiés depuis les dépendances
installées ; il est ignoré par Git. Les settings VS Code fournis l'ajoutent aux
chemins Intelephense. Laisser l'indexation terminer, puis F12 sur une méthode
Laravel. Dans PhpStorm, ajouter cette copie comme bibliothèque PHP ou configurer
l'interpréteur Docker avec le vrai vendor du conteneur. Ne pas éditer cette copie
pour corriger l'application. La régénérer après un changement du lock.
Pour une recherche globale, inclure les fichiers ignorés si l'IDE les masque.

Avec une installation Composer locale, le vrai dossier vendor suffit. Les
fonctions PHP intégrées restent décrites par des stubs, pas par cette copie.
