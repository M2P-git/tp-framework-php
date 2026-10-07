<?php

declare(strict_types=1);

// Vérificateur du TP : php tests/check.php
// Il appelle le routeur directement, sans navigateur ni serveur : c'est l'intérêt d'un objet Request.

use App\InterventionController;
use Mini\Http\Request;
use Mini\Http\Response;
use Mini\Http\Router;

require __DIR__ . '/../src/autoload.php';

/** Construit l'application avec les données voulues (comme public/index.php). */
function application(array $interventions): Router
{
    $routeur = new Router();
    (require __DIR__ . '/../app/routes.php')($routeur, new InterventionController($interventions));

    return $routeur;
}

function appeler(Router $routeur, string $chemin): Response
{
    return $routeur->repartir(new Request('GET', $chemin));
}

$donnees = require __DIR__ . '/../app/data.php';
$echecs = 0;

function verifier(string $nom, callable $test, string $indice): void
{
    global $echecs;

    try {
        $ok = $test() === true;
    } catch (Throwable $erreur) {
        $ok = false;
        $indice .= ' [' . $erreur::class . ' : ' . $erreur->getMessage() . ']';
    }

    printf("[%s] %s%s\n", $ok ? 'OK' : 'KO', $nom, $ok ? '' : "\n     piste : $indice");
    $echecs += $ok ? 0 : 1;
}

$app = application($donnees);

echo "Point de contrôle 1 : le routeur\n";
verifier('/ redirige (302) vers /interventions', function () use ($app) {
    $r = appeler($app, '/');
    return $r->statut === 302 && ($r->entetes['Location'] ?? '') === '/interventions';
}, 'Router::get() mémorise-t-il la route ? repartir() la retrouve-t-il ?');
verifier('/interventions répond 200', fn () => appeler($app, '/interventions')->statut === 200,
    'comparez le chemin demandé à chaque modèle de route');
verifier('/inconnu répond 404 (alors que /interventions existe)',
    fn () => appeler($app, '/interventions')->statut === 200 && appeler($app, '/inconnu')->statut === 404,
    'que renvoie repartir() quand aucune route ne correspond ?');

echo "Point de contrôle 2 : le contrôleur\n";
verifier('A12 (reçue) et C19 (en cours) sont listées', function () use ($app) {
    $corps = appeler($app, '/interventions')->corps;
    return str_contains($corps, 'A12') && str_contains($corps, 'C19');
}, 'liste() garde-t-elle les interventions dont le statut n\'est pas « clos » ?');
verifier('B07 (close) est absente', function () use ($app) {
    $r = appeler($app, '/interventions');
    return $r->statut === 200 && !str_contains($r->corps, 'B07');
}, 'array_filter avec le test $i[\'statut\'] !== \'clos\'');
verifier('aucune intervention ouverte : message dédié', function () {
    $vide = application([['id' => 1, 'serie' => 'Z99', 'description' => 'x', 'statut' => 'clos']]);
    return str_contains(appeler($vide, '/interventions')->corps, 'Aucune intervention ouverte');
}, 'le cas vide est géré par le gabarit liste.php');

echo "Point de contrôle 3 : l'échappement\n";
verifier('un texte HTML est affiché comme texte', function () {
    $piege = application([[
        'id' => 7, 'serie' => 'X01', 'description' => '<script>alert(1)</script>', 'statut' => 'recu',
    ]]);
    $corps = appeler($piege, '/interventions')->corps;
    return str_contains($corps, '&lt;script&gt;') && !str_contains($corps, '<script>');
}, 'e() doit appeler htmlspecialchars (src/vue.php)');

echo "Point de contrôle 4 : la route avec paramètre\n";
verifier('/interventions/101 affiche A12 (200)', function () use ($app) {
    $r = appeler($app, '/interventions/101');
    return $r->statut === 200 && str_contains($r->corps, 'A12');
}, 'transformez {id} en capture nommée, puis passez-la à l\'action : $action(...$parametres)');
verifier('/interventions/999 répond 404 (alors que /interventions/101 existe)',
    fn () => appeler($app, '/interventions/101')->statut === 200 && appeler($app, '/interventions/999')->statut === 404,
    'detail() doit renvoyer le gabarit 404 avec le statut 404');
verifier('/interventions/abc répond 404',
    fn () => appeler($app, '/interventions/101')->statut === 200 && appeler($app, '/interventions/abc')->statut === 404,
    'un identifiant inconnu n\'est pas une erreur du serveur');

echo $echecs === 0 ? "\nTout est vert : vous avez écrit un framework.\n" : "\n$echecs contrôle(s) en échec.\n";
exit($echecs === 0 ? 0 : 1);
