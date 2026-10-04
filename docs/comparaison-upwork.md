## Méthode de sélection

Le relevé a été réalisé le 4 octobre 2026 sur dix annonces de demandes client, et non sur des offres de services de freelances. Certaines pages sont retirées ; leur description reste accessible dans les résultats indexés. Le tableau indique cette limite. Les annonces ne constituent ni un échantillon représentatif du marché ni une estimation du coût raisonnable de développement.

Chaque critère reçoit une note de 1 à 5, attribuée par l'enseignant : utilité compréhensible (U, 25 %), faisabilité d'un périmètre réduit en 36 heures (F, 25 %), richesse des concepts Laravel/Symfony (P, 25 %), extensions par modules (E, 15 %), données fictives et dépendances maîtrisables (D, 10 %). Le score vaut `0,25U + 0,25F + 0,25P + 0,15E + 0,10D`. La faisabilité porte sur l'adaptation pédagogique décrite, pas sur la réalisation intégrale de la mission.

| ID | Besoin observé | Score / 5 |
|:--|:--|--:|
| P1 | Atelier : clients, machines, interventions | 5,00 |
| P2 | Boutique : stock et ventes | 4,60 |
| P3 | Association : rapports et révision | 4,50 |
| P4 | Incidents : tickets et escalade | 4,55 |
| P5 | Construction : ERP multi-sites | 3,80 |
| P6 | Clinique : rendez-vous multi-rôles | 3,85 |
| P7 | Musique : suite Symfony et applications | 3,55 |
| P8 | Location : plateforme et marketing | 3,55 |
| P9 | Crédit : CRM PHP et automatisation | 3,55 |
| P10 | WordPress : formulaire vers CRM | 3,25 |

**Détail des notes attribuées.**

| ID | U | F | P | E | D |
|:--|--:|--:|--:|--:|--:|
| P1 | 5 | 5 | 5 | 5 | 5 |
| P2 | 5 | 4 | 5 | 5 | 4 |
| P3 | 5 | 4 | 5 | 4 | 4 |
| P4 | 5 | 4 | 5 | 5 | 3 |
| P5 | 4 | 2 | 5 | 5 | 3 |
| P6 | 5 | 2 | 5 | 5 | 1 |
| P7 | 4 | 2 | 5 | 4 | 2 |
| P8 | 4 | 3 | 4 | 4 | 2 |
| P9 | 4 | 3 | 4 | 4 | 2 |
| P10 | 4 | 4 | 3 | 2 | 2 |

Le score de P1 exprime son adéquation à nos critères ; il ne signifie pas que la mission professionnelle est simple. P2 et P3 restent de bonnes alternatives. Les notes constituent un jugement pédagogique explicite et révisable.

## Analyse des dix missions

### P1 : suivi d'un atelier de réparation

Le client demande de corriger un système Notion reliant les clients, leurs machines et les interventions. Il insiste sur l'historique et sur l'absence de doublons lorsqu'une machine revient. Le budget fixe doit être proposé par le prestataire ; aucune somme n'est annoncée. La page directe est retirée, mais la description détaillée est indexée. Nous adaptons le besoin à des ordinateurs et construisons un nouveau prototype PHP, Laravel puis Symfony, ce qui diffère de la remise en ordre du système Notion existant. **Intérêt :** identités, cardinalités, états, historique, règles testables. [Annonce](https://www.upwork.com/freelance-jobs/apply/Notion-Database-Systems-Specialist-Existing-Repair-Shop-CRM-Cleanup_~022090284885617756583/).

### P2 : stock et ventes d'une petite boutique

Une boutique d'accessoires mobiles demande une liste de produits, une recherche, un enregistrement de vente, des alertes et deux niveaux d'accès. Budget affiché : 100 USD forfaitaires ; ce montant n'est pas un devis de référence. Page accessible. Le projet réduit pourrait se limiter au catalogue et aux mouvements de stock. **Intérêt :** besoin concret et modules clairs. **Difficulté :** calculs monétaires, transactions et concurrence dès que des ventes réelles sont enregistrées. [Annonce](https://www.upwork.com/freelance-jobs/apply/Simple-Inventory-Sales-Tracker-Web-App_~022103087157306558605/).

### P3 : plateforme d'une association

Une association recherche un audit de son application Laravel 10 de dépôt et de révision de rapports. Elle veut réduire la maintenance et permettre une reprise par un autre développeur. Fourchette affichée : 25 à 47 USD/h ; page accessible. **Intérêt :** utilité sociale, permissions, pièces justificatives, maintien du logiciel. **Difficulté :** la mission porte sur un audit de code existant auquel nous n'avons pas accès. [Annonce](https://www.upwork.com/freelance-jobs/apply/Laravel-PHP-Expert-Needed-Review-Existing-Bespoke-Platform-Recommend-Alternatives_~022106300295166770171/).

### P4 : tickets d'incident et escalade

Un portail existant doit recevoir un module de tickets avec attribution, gravité, délais, notifications et historique. Budget affiché : 300 USD forfaitaires ; description indexée. **Intérêt :** workflow, rôles et journal. **Difficulté :** les 168 scénarios annoncés et les minuteries d'escalade dépassent notre périmètre ; un prototype doit conserver seulement quelques types d'incident et simuler les notifications. [Annonce](https://www.upwork.com/freelance-jobs/apply/Full-Stack-Developer-Needed-Build-Incident-Ticketing-Escalation-Portal_~022098363696536931833/).

### P5 : ERP de construction multi-sites

L'annonce rassemble stocks, fournisseurs, finances, clients et permissions par chantier ; la rémunération horaire n'est pas fixée. Page accessible. **Intérêt :** modèle riche et isolation des accès. **Difficulté :** trop de domaines métier pour un premier module de frameworks. Un sous-projet de transferts de matériaux serait plus réaliste que l'ERP complet. [Annonce](https://www.upwork.com/freelance-jobs/apply/Custom-Construction-ERP-Inventory-Management-System_~022094721355810213634/).

### P6 : rendez-vous d'une plateforme de clinique

La demande historique de 2025 comporte application Flutter, dashboards, paiements et documents médicaux ; budget indexé : 6 000 USD forfaitaires. La page directe redirige vers la liste générale. **Intérêt :** réservation et disponibilité. **Difficulté :** données sensibles, multi-tenancy, applications mobiles et intégrations financières. Une démonstration de créneaux fictifs ne couvrirait qu'une faible partie de cette demande. [Annonce historique](https://www.upwork.com/freelance-jobs/apply/Full-Stack-Flutter-Developer-for-Clinic-Appointment-Management-Platform_~021934583997856058904/).

### P7 : outils pour les professionnels de la musique

La mission accessible a évolué vers Symfony, Angular et Ionic. Elle demande maintenance, API, bases SQL/NoSQL, messaging et tests. Fourchette initiale indexée : 10 à 20 USD/h, susceptible d'évolution. **Intérêt :** demande Symfony explicite et lecture d'un code existant. **Difficulté :** environnement existant, mobile et technologies supplémentaires ; le métier sous-jacent est peu borné. [Annonce](https://www.upwork.com/freelance-jobs/apply/Web-Mobile-Developer-Symfony-Angular-Ionic_~022101045966118286688/).

### P8 : plateforme de location et acquisition commerciale

La mission associe maintenance d'une plateforme existante, parcours de réservation, paiements, SEO et publicité. Le test initial est affiché à 50 USD ; la page directe est retirée. **Intérêt :** amélioration mesurée par une action utilisateur. **Difficulté :** mélange développement/marketing et accès au site réel ; une réservation fictive serait une adaptation importante. [Annonce](https://www.upwork.com/freelance-jobs/apply/Full-Stack-Developer-SEO-Google-Ads-Specialist-for-Custom-Website_~022100851555417997414/).

### P9 : CRM PHP de prêts à de petites entreprises

Le client souhaite faire évoluer son CRM et ses API après compréhension de l'interface existante. Fourchette affichée : 10 à 35 USD/h ; page accessible. **Intérêt :** lecture de code et automatisation. **Difficulté :** règles financières, confidentialité et absence de cahier des charges détaillé accessible. [Annonce](https://www.upwork.com/freelance-jobs/apply/PHP-Developer-for-CRM-Automation_~022092481983004591802/).

### P10 : intégration WordPress vers un CRM

La demande transmet des formulaires à un CRM via API REST, avec correspondance des données et gestion des erreurs. Budget affiché : 100 USD forfaitaires ; page accessible. **Intérêt :** tâche limitée et vérifiable. **Difficulté :** dépendance au CRM et à WordPress ; peu de progression de domaine sur douze séances. Ce besoin pourrait devenir un exercice d'intégration ultérieur. [Annonce](https://www.upwork.com/freelance-jobs/apply/WordPress-API-Integration-Custom-PHP-Development-for-CRM_~022100631879693281012/).

## Décision et adaptation

Le projet retenu est **Atelier Solidaire**. Son noyau comprend personne, machine, intervention et changement d'état. L'étudiant peut comprendre chaque règle à partir d'une situation courante et montrer une preuve en quelques minutes. L'application conserve le même vocabulaire au passage de Laravel à Symfony. La comparaison porte sur les responsabilités et les mêmes critères d'acceptation.

Les modules envisagés sont consultation, recherche, réception, persistance, autorisation, historique et rapport de retard. L'extension finale propose un rappel interne simulé ; aucun envoi externe n'est nécessaire. Les données restent fictives. La réussite pédagogique se mesure à la capacité de modifier une règle, retrouver un symbole et vérifier un parcours, et non à une promesse de répondre à la mission Upwork originale.
