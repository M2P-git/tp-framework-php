<?php
namespace Tests\Feature;
use Tests\TestCase;
class ConsultationTest extends TestCase {
    public function test_liste_ouverte(): void {
        $this->get('/interventions')->assertOk()->assertSee('A12')->assertSee('C19')->assertDontSee('B07');
    }
    public function test_detail_absent(): void { $this->get('/interventions/999')->assertNotFound(); }
    public function test_route_nommee(): void {
        $this->assertSame('/interventions', route('interventions.index', [], false));
    }
}
