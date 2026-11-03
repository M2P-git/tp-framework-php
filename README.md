# TP séance 1 : un mini-framework en PHP pur

ISMAGI, L3 Développement, Dr Paul Mbilong. Module « Framework PHP : Laravel et Symfony ».

Vous écrivez les pièces qu'un framework utilise pour appeler votre code : point d'entrée, routeur,
contrôleur, vue, réponse. Lisez l'énoncé : [ENONCE.md](ENONCE.md).

## Pour commencer

PHP 8.3 ou plus. Aucune bibliothèque, pas de Composer.

```powershell
php tests/check.php                  # 10 contrôles : tous rouges au départ
php -S 127.0.0.1:8000 -t public      # serveur de développement, point d'entrée : public/index.php
```

Les endroits à compléter sont signalés par `TODO` dans `src/Http/Router.php`,
`app/InterventionController.php` et `src/vue.php`. Le vérificateur donne une piste pour chaque
contrôle en échec ; il passe au vert au fur et à mesure.

## Contenu

| Chemin | Rôle |
|:--|:--|
| `public/index.php` | point d'entrée (fourni) |
| `src/autoload.php` | chargement automatique des classes (fourni) |
| `src/Http/` | `Request`, `Response` (fournis), `Router` (à compléter) |
| `src/vue.php` | `vue()` (fournie), `e()` (à compléter) |
| `app/` | données, routes, contrôleur (à compléter) |
| `templates/` | gabarits HTML (fournis) |
| `tests/check.php` | vérificateur : `php tests/check.php` |

## Changer de séance

Le dépôt contient une branche par séance. Pour passer à une autre séance, dans le dossier du dépôt :

| Votre ordinateur | Commande |
|:--|:--|
| Windows (PowerShell, ou le terminal de VS Code) | `.\seance.bat 03` |
| macOS et Linux (Terminal) | `./seance.sh 03` |

Le script demande confirmation, puis **efface vos modifications dans ce dossier** et le met à l'état de la séance.
Pour les séances Laravel, il prépare aussi la machine Docker (voir le README de la séance).
