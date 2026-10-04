## Positionnement du module

Ce module s'adresse à la L3 Développement de l'ISMAGI. Il comporte douze séances de trois heures, soit 36 heures encadrées sur trois mois. Laravel est étudié dès la séance 1 et occupe les séances 1 à 4. Symfony commence à la séance 5. Les notions PHP nécessaires sont introduites à partir des routes, des contrôleurs, des modèles et des tests ; PHP ne constitue pas un bloc principal séparé. Le module suppose des bases en HTML, en SQL et en programmation ; un diagnostic initial permet de repérer les difficultés.

Je souhaite que vous sachiez comprendre une demande, choisir une solution simple, produire une modification vérifiable et expliquer votre décision. La connaissance d'une méthode se vérifie dans l'IDE et dans la documentation. La compréhension de son rôle doit vous rester.

## Résultats d'apprentissage

À l'issue du module, l'étudiant doit pouvoir :

1. Reformuler un besoin en scénario utilisateur et en critères d'acceptation observables.
2. Justifier une maquette, un modèle relationnel et des responsabilités de classes à partir de ce scénario.
3. Lire et modifier du PHP typé, notamment les constructions introduites en PHP 8 utilisées dans les frameworks.
4. Retrouver une déclaration, une signature, une utilisation et une dépendance dans un projet local.
5. Développer une fonctionnalité Laravel, puis retrouver route, contrôleur, service, vue, validation et persistance dans Symfony.
6. Vérifier la sécurité d'une opération et écrire des tests du comportement métier.
7. Relier les concepts de Laravel à leurs équivalents Symfony sans supposer que les API sont identiques.
8. Utiliser l'IA pour une tâche délimitée, vérifier sa proposition et défendre le résultat livré.

## Projet retenu : Atelier Solidaire

L'application suit les interventions d'un atelier fictif qui répare des ordinateurs. Elle aide l'accueil à retrouver une machine et son historique, le technicien à suivre son travail et le responsable à repérer les dossiers qui restent bloqués. La comparaison de dix missions Upwork figure dans le document compagnon **Comparaison des projets Upwork**. Le choix repose sur le besoin métier d'une mission de remise en ordre d'un système d'atelier sous Notion, et non sur une commande Symfony réelle. Le scénario informatique, les personnages et toutes les données sont des adaptations pédagogiques fictives.

Une personne peut confier plusieurs machines. Une machine peut revenir pour plusieurs interventions. Un retour crée une nouvelle intervention, sans créer une nouvelle machine. Cette règle se prête à la modélisation, aux tests et à une discussion avec un utilisateur. Les premiers écrans utilisent des données en mémoire ; la persistance apparaît seulement lorsque les étudiants savent expliquer les identités et les relations.

Le périmètre comprend les personnes, les machines, les interventions, leurs états, les rôles, un historique et un rapport simple. La facturation, les paiements, les SMS réels et les données de clients réels ne font pas partie du prototype de classe. Les extensions pourront être proposées après la démonstration du parcours principal.

## Progression par séance

### Séance 1 : une première fonctionnalité Laravel

**Problème.** L'accueil veut les interventions encore présentes à l'atelier. **Objectifs.** Relier un besoin à une route, une action et une vue ; exécuter le squelette fourni ; comprendre le cycle HTTP ; lire les tableaux, conditions, boucles et comparaisons PHP rencontrés. **Activités.** Métier et rémunérations observées en 2026 ; clarification du besoin ; maquette du parcours ; route nommée, contrôleur, Blade ; filtre d'interventions ; navigation IDE ; quiz et correction. **Production.** Liste ouverte et critères d'acceptation. **Preuve.** Statut HTTP correct, intervention close exclue, cas vide. **À retenir.** Le besoin fixe le résultat ; la route oriente, le contrôleur coordonne, la vue affiche.

### Séance 2 : requête, service et recherche Laravel

**Problème.** Retrouver une panne malgré les espaces et la casse de la recherche. **Objectifs.** Lire Request, fonction typée, nullable, closure, constructeur et injection ; traiter une entrée externe ; distinguer validation et échappement. **Activités.** Contrat d'un service, normalisation, Blade et échappement, tests Feature, revue d'un petit diff IA, signature et usages retrouvés en local. **Production.** Recherche et détail. **Preuve.** Cas nul/blanc, résultat absent, requête mal formée refusée, texte HTML affiché comme texte. **À retenir.** Les types ne remplacent pas les règles ; la preuve HTTP complète le test de la fonction.

### Séance 3 : données et historique avec Eloquent

**Problème.** Une machine revient ; l'ancienne fiche doit garder son historique. **Objectifs.** Justifier la maquette, les identités, les cardinalités et les classes ; utiliser migration, modèle et relation Eloquent ; retrouver une API dans vendor. **Activités.** Diagramme relationnel, diagramme de classes, propriétés et méthodes PHP, seeders SQLite, création liée à une machine existante, tests avec BD isolée. **Production.** Historique persistant. **Preuve.** Une nouvelle intervention, une seule machine, référence valide, modèle cohérent. **À retenir.** L'ORM ne choisit pas les identités à votre place ; le modèle et la BD protègent des propriétés complémentaires.

### Séance 4 : une réception Laravel validée et autorisée

**Problème.** Une saisie peut être invalide, un état peut être falsifié et un autre technicien peut tenter une modification. **Objectifs.** Lire FormRequest, CSRF, identité authentifiée et policy ; comprendre enum, match et service métier ; produire des tests de refus et un rapport de preuves. **Activités.** Formulaire et flux POST/redirection, état initial côté serveur, champs validés, policy rôle/assignation, transition, tests nominaux et adverses, quiz corrigés. Le login, les migrations et une partie des tests sont fournis pour concentrer le TP sur validation et autorisation. **Production.** Réception et traitement contrôlés. **Preuve.** Saisie refusée sans création, état falsifié non accepté, autre technicien refusé sans mutation, parcours légitime accepté. **À retenir.** Un formulaire n'est pas une frontière de sécurité ; le serveur décide, et les tests vérifient aussi les effets de bord.

### Séance 5 : retrouver la consultation dans Symfony

**Problème.** La même consultation doit fonctionner dans une équipe Symfony. **Concepts.** Squelette fourni, attribut Route, Request/Response, contrôleur, Twig, profiler ; correspondance avec Laravel. **TP.** Liste et détail équivalents. **Preuve.** Mêmes critères d'acceptation, 404 pour le dossier absent, échappement vérifié. **Rappel.** Transférer les responsabilités avant de chercher le nom des méthodes.

### Séance 6 : services Symfony et PHP moderne

**Problème.** La règle de recherche doit être testable indépendamment du contrôleur. **Concepts.** Conteneur, autowiring, interface, namespace, PSR-4, promotion, readonly, nullable, nullsafe, arguments nommés et unions selon les signatures utiles. **TP.** Injecter un dépôt et une horloge remplaçables. **Preuve.** Deux implémentations respectent le contrat ; cas limite de date testé. **Rappel.** Le constructeur annonce les dépendances ; une métadonnée n'agit que si un outil la lit.

### Séance 7 : Doctrine et migrations

**Problème.** Conserver la même identité et les interventions sous Symfony. **Concepts.** Entités, mapping par attributs, relations, repository, migration et fixtures ; comparaison Eloquent/Doctrine. **TP.** Historique d'une machine connue. **Preuve.** Retour sans doublon et contraintes exercées dans une BD isolée. **Rappel.** Le changement d'ORM ne change pas les règles du domaine.

### Séance 8 : formulaires, contraintes et CSRF

**Problème.** Réceptionner une machine connue sans accepter un état forgé. **Concepts.** FormType, contraintes, DTO si nécessaire, traitement POST, CSRF et redirection. **TP.** Réception et reprise des cas Laravel. **Preuve.** Données invalides, jeton absent et champ interdit ; état et nombre d'enregistrements vérifiés. **Rappel.** Une validation décide si la donnée convient ; un contrôle CSRF et une autorisation répondent à d'autres menaces.

### Séance 9 : identité, droits et voter Symfony

**Problème.** Un technicien demande l'intervention d'un autre. **Concepts.** Security, hachage, session, rôles, voter et moindre privilège. **TP.** Contrôle par dossier. **Preuve.** Anonyme, bon utilisateur et autre utilisateur ; accès direct à l'URL ; données non exposées et mutation absente. **Rappel.** Un bouton caché ne protège pas une action ; le contrôle est effectué à chaque requête.

### Séance 10 : transitions, historique et transactions

**Problème.** Restituer une machine en cours de réparation est interdit. **Concepts.** Enum, service de transition, journal horodaté, transaction, test unitaire et test d'intégration. **TP.** Changement d'état et historique cohérent. **Preuve.** Succès, refus, double action, effet de bord et rollback. **Rappel.** Un état correspond à une règle ; un refus ne doit pas laisser une opération partielle.

### Séance 11 : rapport utile et préparation à la livraison

**Problème.** Le responsable veut les interventions ouvertes depuis plus de quatorze jours. **Concepts.** DateTimeImmutable, filtre, pagination, export CSV autorisé, requêtes paramétrées, dépendances, configuration et sauvegarde/restauration. **TP.** Rapport limité et export. **Preuve.** Date frontière, dossier clos, autorisation, formule CSV neutralisée selon le format ; revue de configuration et audit de dépendances. **Rappel.** Un scan vide ne démontre pas l'absence de vulnérabilité ; chaque preuve a un périmètre.

### Séance 12 : extension assistée par IA et démonstration client

**Problème.** L'atelier choisit une amélioration prioritaire. **Concepts.** Découpage, critères indépendants, petits diffs, revue, tests et rapport de preuves. **TP.** Rappel interne simulé, recherche supplémentaire ou amélioration d'historique. **Preuve.** Parcours permis/refusé, tests réellement exécutés, commit, environnement, limites et modification surprise. **Rappel.** Vous pouvez déléguer une proposition de code ; vous devez pouvoir expliquer et vérifier la livraison.

## Animation d'une séance

Le conducteur indicatif d'une séance est : rappel actif et problème (15 min), exploration et premier exemple (35 min), exercice court et correction (25 min), pause (10 min), TP guidé (55 min), revue collective (25 min), quiz de sortie et synthèse (15 min). La répartition s'adapte aux difficultés constatées. Les diapositives ne portent pas ces durées : elles sont organisées par problème, concept, exemple, vérification et rappel.

Chaque séance commence par une question tirée d'une séance antérieure. Un concept important est revu dans un exercice différent : filtre de tableau, filtre de repository, puis filtre de rapport. L'étudiant doit prédire un résultat avant l'exécution et expliquer un échec après l'exécution. Les questions portent sur les responsabilités, les contrats et les règles ; la mémorisation des signatures n'est pas évaluée.

## Supports et rythme de diffusion

La présentation de chaque séance constitue le support principal durant la séance. Elle comprend les exemples indispensables, les problèmes, les quiz et des corrections séparées des questions. Le livre Quarto développe les raisonnements, les limites des exemples et les corrigés. Il sert à la préparation du professeur et peut être remis aux étudiants à la fin de chaque groupe de quatre séances. Les séances 1 à 4 font l'objet des supports détaillés de cette livraison ; les séances 5 à 12 sont cadrées par ce syllabus.

## Évaluation proposée

Cette pondération est une proposition pédagogique à adapter au règlement de l'ISMAGI : TP et explication individuelle, 30 % ; fonctionnalité Laravel vérifiée à la séance 4, 20 % ; fonctionnalité Symfony vérifiée à la séance 8, 20 % ; extension et défense à la séance 12, 30 %.

La grille commune porte sur la compréhension du besoin (20 %), la cohérence du modèle et des responsabilités (20 %), le résultat observable (25 %), la qualité des vérifications (20 %) et l'explication individuelle ainsi que la traçabilité de l'IA (15 %). Une production générée par IA reçoit les mêmes exigences de comportement et d'explication qu'une production rédigée manuellement. Le nombre de lignes ne constitue pas un critère.

## Cadre d'utilisation de l'IA

L'étudiant formule d'abord le scénario et au moins un exemple d'échec. Il donne à l'assistant une tâche limitée, les versions, les fichiers utiles et les critères d'acceptation. Il relit la différence produite, retrouve les méthodes utilisées dans l'IDE ou la documentation et exécute des vérifications indépendantes. Il consigne le prompt utile, une proposition rejetée et les tests retenus. Il doit pouvoir changer une règle simple et expliquer l'impact sans régénérer tout le projet.

L'IA peut aider à proposer des cas limites, expliquer une erreur, produire un squelette ou améliorer une première solution. Elle n'est pas une source de vérité pour une API, un résultat de test ou une règle métier. Les données de classe sont fictives ; les prompts ne contiennent pas de secrets.

## Sécurité et preuves à présenter au client

La sécurité intervient dès la définition du besoin. Pour chaque opération, l'étudiant identifie les données à protéger, les acteurs autorisés, une action abusive possible et le contrôle attendu. Il transforme cette réflexion en critère testable : « un technicien non assigné ne peut pas modifier cette intervention, même avec son URL ». Le périmètre utilise un sous-ensemble explicite d'exigences inspirées d'OWASP ASVS 5.0.0 ; il ne constitue pas une certification ASVS.

Les séances 1 à 4 introduisent sous Laravel les frontières de confiance, la validation, l'échappement HTML, la persistance, les contrôles CSRF, les policies et les tests de refus. Les séances 5 à 10 reprennent ces propriétés sous Symfony et approfondissent les services, Doctrine, les voters et les transactions. Les séances 9 à 12 vérifient les effets d'une action refusée, les exports autorisés, les dépendances, la configuration et la conservation des preuves. La génération par IA suit les mêmes exigences : les tests métier sont dérivés du besoin avant la proposition de code ; les tests supplémentaires générés sont relus et exécutés ; la suppression d'un test en échec n'est jamais assimilée à une correction.

La démonstration client comprend un parcours permis et son équivalent refusé. Le dossier indique le scénario, le résultat attendu, le résultat réellement observé, la version Git, l'environnement, la preuve et les limites. Il doit notamment couvrir l'accès anonyme, l'accès d'un autre utilisateur, le jeton CSRF absent, l'injection de texte HTML, les données invalides et l'absence de mutation après un refus. Les scans de dépendances et la revue de configuration complètent les tests applicatifs ; un scan vide ne prouve pas l'absence de vulnérabilités. La disponibilité, les sauvegardes et la restauration sont vérifiées séparément, selon un objectif convenu avec le client.

Le support détaillé contient un chapitre **Développer avec l'IA, tester et préparer la sécurité**, une matrice de risques et un modèle de rapport client. Les TP Laravel fournissent les premières preuves HTTP et de persistance ; le contrôle CSRF est vérifié hors du mode de test qui le désactive normalement. Les preuves Symfony seront produites lors des séances correspondantes.

## Environnement et points de départ Git

La cible pédagogique est PHP 8.3 ou supérieur ; les constructions enseignées au premier groupe de séances sont compatibles avec PHP 8.3. Symfony 7.4 LTS demande PHP 8.2 au minimum ; Laravel 13 demande PHP 8.3 au minimum. Les projets fournissent un fichier Composer de verrouillage ; les dépendances doivent être installées avant la séance. L'IDE est VS Code avec un service de langage PHP, ou PhpStorm. Le choix d'IDE ne change pas l'objectif de navigation locale.

Le dépôt est <https://github.com/M2P-git/tp-framework-php>. Chaque branche `seance-01` à `seance-04` fournit un exercice exécutable, un énoncé et une base commune ; les corrections sont dans le support et dans les branches `corrige-01` à `corrige-04`. Les séances Symfony suivantes auront des instantanés propres, préparés avant leur utilisation. La remise à zéro reprend l'instantané distant ; elle efface le travail local non conservé. L'expérimentation personnelle s'effectue dans un dossier neuf, créé sans copier la solution du cours. Les commandes détaillées figurent dans le dépôt et le livre.

## Références essentielles

- [PHP : manuel](https://www.php.net/manual/fr/) ; [nouveautés PHP 8.0](https://www.php.net/manual/en/migration80.new-features.php) ; [PHP 8.1](https://www.php.net/manual/en/migration81.new-features.php).
- [Symfony 7.4](https://symfony.com/releases/7.4) ; [documentation Symfony 7.4](https://symfony.com/doc/7.4/index.html) ; [Laravel 13](https://laravel.com/docs/13.x/releases).
- [Composer : autoload](https://getcomposer.org/doc/04-schema.md#autoload) ; [PSR-4](https://www.php-fig.org/psr/psr-4/).
- [VS Code : navigation](https://code.visualstudio.com/docs/editing/editingevolved) ; [PhpStorm : navigation](https://www.jetbrains.com/help/phpstorm/navigating-through-the-source-code.html).
- [GitHub : revue du code généré par IA](https://docs.github.com/en/enterprise-cloud%40latest/copilot/tutorials/review-ai-generated-code).
- [OWASP ASVS 5.0.0](https://owasp.org/projects/asvs) ; [autorisation](https://cheatsheetseries.owasp.org/cheatsheets/Authorization_Cheat_Sheet.html) ; [développement avec l'IA](https://cheatsheetseries.owasp.org/cheatsheets/Secure_Coding_with_AI_Cheat_Sheet.html).
- [Mission Upwork d'atelier](https://www.upwork.com/freelance-jobs/apply/Notion-Database-Systems-Specialist-Existing-Repair-Shop-CRM-Cleanup_~022090284885617756583/) : annonce indexée, page directe retirée au contrôle du 4 octobre 2026.

Les références web sont consultées le 4 octobre 2026. Les annonces servent d'observation des besoins, sans constituer une validation commerciale du prototype.
