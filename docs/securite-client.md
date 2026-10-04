# Sécurité : preuves et limites

## Vérification CSRF sur le serveur local

Les tests Feature Laravel désactivent normalement le contrôle CSRF. Leur
succès ne démontre donc pas cette protection. Après initialisation du TP 04 :

1. Lancer `docker compose up app`, ouvrir `/login`, afficher le champ `_token`.
2. Envoyer un POST `/login` sans jeton et sans en-tête d'origine de confiance :
   `curl.exe -i -X POST http://127.0.0.1:8000/login -d "email=tech@example.test&password=demo-cours"`.
3. Attendre le refus CSRF (419 dans cette configuration), puis effectuer le
   login normal du formulaire avec son jeton et ses cookies : succès attendu.
4. Conserver le statut, le résultat et la version testée. Le mécanisme Laravel 13
   peut aussi utiliser la vérification d'origine ; annoncer les en-têtes testés.

## Matrice client

| Risque | Scénario | Preuve attendue |
|:--|:--|:--|
| Accès hors assignation | Autre technicien, POST direct | 403 et état inchangé |
| Mutation de champ non admis | Accueil envoie statut=clos | État initial recu en BD |
| Donnée invalide | Description trop courte | Erreur et nombre de lignes inchangé |
| Transition interdite | Double démarrage | 409 et ancien état conservé |
| XSS dans la recherche | Texte avec balise | HTML encodé ; pas de balise active |
| CSRF | POST sans jeton/origine admise | Refus sur le vrai serveur |
| Mot de passe en clair | Examiner le stockage | Hash et vérification par le hasher |

Le prototype n'est pas une certification de sécurité. Les tests de droits portent
sur le traitement d'une intervention, pas sur tous les accès possibles. Les
consultations sont ouvertes aux utilisateurs authentifiés du prototype. Les
tests de charge, restauration, audit complet ASVS et tests d'intrusion restent
des vérifications distinctes à définir selon le périmètre client.

## Modèle de rapport à compléter après exécution

Version Git :
Environnement et date :
Exigence / risque :
Données fictives :
Action autorisée et résultat observé :
Action interdite et résultat observé :
Vérification de la BD après refus :
Commande / preuve jointe :
Limites et anomalies restant à corriger :

Ne pas écrire « application inviolable ». Les preuves doivent être rattachées
aux risques annoncés et à l'environnement effectivement testé.

Sources : [OWASP ASVS](https://owasp.org/projects/asvs),
[autorisation](https://cheatsheetseries.owasp.org/cheatsheets/Authorization_Cheat_Sheet.html),
[Laravel CSRF](https://laravel.com/docs/13.x/csrf),
[tests](https://laravel.com/docs/13.x/http-tests).
