<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Séance 3 : chaque test reçoit une base neuve (SQLite en mémoire, voir phpunit.xml),
    // créée par les migrations puis remplie par DatabaseSeeder. Les tests ne touchent jamais
    // database/database.sqlite.
    use RefreshDatabase;

    protected bool $seed = true;
}
