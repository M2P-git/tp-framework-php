<?php
// Initialisation locale explicite. Ne pas exécuter sur un hébergement réel.
if (!file_exists(__DIR__ . '/../.env')) { copy(__DIR__ . '/../.env.example', __DIR__ . '/../.env'); }
if (!file_exists(__DIR__ . '/../database/database.sqlite')) { touch(__DIR__ . '/../database/database.sqlite'); }
echo "Configuration locale et fichier SQLite prepares. Executer ensuite key:generate.\n";
