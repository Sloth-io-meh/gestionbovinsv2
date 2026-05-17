<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Etable;
use App\Models\Quarantaine;
use App\Models\Vendeur;
use App\Models\Veto;
use App\Models\Tansporteur;
use App\Models\Vehicule;
use App\Models\Stock;
use App\Models\Meds;
use App\Models\Visite;
use App\Models\Bovin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudIntegrityTest extends TestCase
{
    use RefreshDatabase;

    // ── Auth helpers ─────────────────────────────────────────────────────────

    private function admin(): User { return User::factory()->create(['is_admin' => true]); }
    private function user(): User  { return User::factory()->create(['is_admin' => false]); }

    // ── Model seed helpers ────────────────────────────────────────────────────

    private function etable(): Etable
    {
        return Etable::create(['nom' => 'Étable Test']);
    }

    private function quarantaine(): Quarantaine
    {
        return Quarantaine::create(['libelle' => 'Non']);
    }

    private function vendeur(): Vendeur
    {
        return Vendeur::create([
            'nom_vend' => 'Dupont', 'prenom_vend' => 'Jean',
            'tel_vend' => '0600000001', 'farm_vend' => null,
        ]);
    }

    private function veto(): Veto
    {
        return Veto::create([
            'id_vet' => 'AA' . rand(100000, 999999),
            'nom_vet' => 'Martin', 'prenom_vet' => 'Paul', 'tel_vet' => '0600000002',
        ]);
    }

    private function tansporteur(): Tansporteur
    {
        return Tansporteur::create([
            'cin_t' => 'TT' . rand(1000, 9999), 'nom' => 'Bernard',
            'prenom' => 'Luc', 'tel' => '0600000003',
        ]);
    }

    private function bovin(?Etable $e = null, ?Vendeur $v = null, ?Quarantaine $q = null): Bovin
    {
        $e ??= $this->etable();
        $v ??= $this->vendeur();
        $q ??= $this->quarantaine();

        return Bovin::create([
            'race' => 'Test Race', 'dateachat' => '2023-01-01',
            'prixachat' => 500, 'poidachat' => 30, 'lieuachat' => 'Test lieu',
            'vendu' => 0, 'mort' => 0, 'poidAct' => 30,
            'id_etab' => $e->id_etab, 'id_vend' => $v->id_vend, 'id_q' => $q->id_q,
        ]);
    }

    private function stock(): Stock
    {
        return Stock::create([
            'libelle_st' => 'Foin', 'description_s' => 'Foin de prairie',
            'quantite_s' => 100, 'quantiteAct' => 100, 'prix_s' => 50,
            'dateachat' => '2023-01-01', 'dateexp_s' => '2025-01-01',
        ]);
    }

    private function meds(): Meds
    {
        return Meds::create([
            'libelle' => 'Antibio', 'description' => 'Antibiotique test',
            'quantite_med' => 50, 'prix_med' => 30,
            'dateachat' => '2023-01-01', 'dateexp_med' => '2025-01-01',
        ]);
    }

    private function visite(?Bovin $b = null, ?Veto $vt = null): Visite
    {
        $b  ??= $this->bovin();
        $vt ??= $this->veto();

        return Visite::create([
            'description_v' => 'Visite test', 'datepres' => '2023-06-01',
            'prix_pres' => 200, 'id_bov' => $b->id_bov, 'id_vet' => $vt->id_vet,
        ]);
    }

    // =========================================================================
    // ETABLES
    // =========================================================================

    public function test_etables_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('etables.index'))->assertOk();
    }

    public function test_etables_index_redirects_guest(): void
    {
        $this->get(route('etables.index'))->assertRedirect(route('login'));
    }

    public function test_etables_create_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())->get(route('etables.create'))->assertForbidden();
    }

    public function test_etables_create_accessible_to_admin(): void
    {
        $this->actingAs($this->admin())->get(route('etables.create'))->assertOk();
    }

    public function test_etables_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('etables.store'), ['nom' => 'Nouvelle Étable'])
            ->assertForbidden();
        $this->assertDatabaseMissing('etables', ['nom' => 'Nouvelle Étable']);
    }

    public function test_etables_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('etables.store'), ['nom' => 'Nouvelle Étable'])
            ->assertRedirect(route('etables.index'));
        $this->assertDatabaseHas('etables', ['nom' => 'Nouvelle Étable']);
    }

    public function test_etables_show_accessible_to_non_admin(): void
    {
        $this->actingAs($this->user())
            ->get(route('etables.show', $this->etable()))->assertOk();
    }

    public function test_etables_edit_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->get(route('etables.edit', $this->etable()))->assertForbidden();
    }

    public function test_etables_update_works_for_admin(): void
    {
        $etable = $this->etable();
        $this->actingAs($this->admin())
            ->put(route('etables.update', $etable), ['nom' => 'Modifiée'])
            ->assertRedirect(route('etables.index'));
        $this->assertDatabaseHas('etables', ['id_etab' => $etable->id_etab, 'nom' => 'Modifiée']);
    }

    public function test_etables_destroy_works_for_admin(): void
    {
        $etable = $this->etable();
        $this->actingAs($this->admin())
            ->delete(route('etables.destroy', $etable))
            ->assertRedirect(route('etables.index'));
        $this->assertSoftDeleted($etable);
    }

    // =========================================================================
    // QUARANTAINES
    // =========================================================================

    public function test_quarantaines_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('quarantaines.index'))->assertOk();
    }

    public function test_quarantaines_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('quarantaines.store'), ['libelle' => 'Oui'])
            ->assertForbidden();
    }

    public function test_quarantaines_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('quarantaines.store'), ['libelle' => 'Oui'])
            ->assertRedirect(route('quarantaines.index'));
        $this->assertDatabaseHas('quarantaines', ['libelle' => 'Oui']);
    }

    public function test_quarantaines_update_works_for_admin(): void
    {
        $q = $this->quarantaine();
        $this->actingAs($this->admin())
            ->put(route('quarantaines.update', $q), ['libelle' => 'Modifié'])
            ->assertRedirect(route('quarantaines.index'));
        $this->assertDatabaseHas('quarantaines', ['id_q' => $q->id_q, 'libelle' => 'Modifié']);
    }

    public function test_quarantaines_destroy_works_for_admin(): void
    {
        $q = $this->quarantaine();
        $this->actingAs($this->admin())
            ->delete(route('quarantaines.destroy', $q))
            ->assertRedirect(route('quarantaines.index'));
        $this->assertDatabaseMissing('quarantaines', ['id_q' => $q->id_q]);
    }

    // =========================================================================
    // VENDEURS
    // =========================================================================

    public function test_vendeurs_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('vendeurs.index'))->assertOk();
    }

    public function test_vendeurs_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('vendeurs.store'), [
                'nom_vend' => 'Test', 'prenom_vend' => 'User',
                'tel_vend' => '0600000099',
            ])->assertForbidden();
    }

    public function test_vendeurs_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('vendeurs.store'), [
                'nom_vend' => 'Benali', 'prenom_vend' => 'Omar',
                'tel_vend' => '0611223344',
            ])->assertRedirect(route('vendeurs.index'));
        $this->assertDatabaseHas('vendeurs', ['nom_vend' => 'Benali']);
    }

    public function test_vendeurs_update_works_for_admin(): void
    {
        $v = $this->vendeur();
        $this->actingAs($this->admin())
            ->put(route('vendeurs.update', $v), [
                'nom_vend' => 'Updated', 'prenom_vend' => 'Name', 'tel_vend' => '0699999999',
            ])->assertRedirect(route('vendeurs.index'));
        $this->assertDatabaseHas('vendeurs', ['id_vend' => $v->id_vend, 'nom_vend' => 'Updated']);
    }

    public function test_vendeurs_destroy_works_for_admin(): void
    {
        $v = $this->vendeur();
        $this->actingAs($this->admin())
            ->delete(route('vendeurs.destroy', $v))
            ->assertRedirect(route('vendeurs.index'));
        $this->assertSoftDeleted($v);
    }

    // =========================================================================
    // VETOS
    // =========================================================================

    public function test_vetos_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('vetos.index'))->assertOk();
    }

    public function test_vetos_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('vetos.store'), [
                'id_vet' => 'ZZ123456', 'nom_vet' => 'Test',
                'prenom_vet' => 'Vet', 'tel_vet' => '0600000010',
            ])->assertForbidden();
    }

    public function test_vetos_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('vetos.store'), [
                'id_vet' => 'ZZ123456', 'nom_vet' => 'Idrissi',
                'prenom_vet' => 'Amine', 'tel_vet' => '0655443322',
            ])->assertRedirect(route('vetos.index'));
        $this->assertDatabaseHas('vetos', ['id_vet' => 'ZZ123456']);
    }

    public function test_vetos_update_works_for_admin(): void
    {
        $vt = $this->veto();
        $this->actingAs($this->admin())
            ->put(route('vetos.update', $vt), [
                'nom_vet' => 'Updated', 'prenom_vet' => 'Vet', 'tel_vet' => '0699888777',
            ])->assertRedirect(route('vetos.index'));
        $this->assertDatabaseHas('vetos', ['id_vet' => $vt->id_vet, 'nom_vet' => 'Updated']);
    }

    public function test_vetos_destroy_works_for_admin(): void
    {
        $vt = $this->veto();
        $this->actingAs($this->admin())
            ->delete(route('vetos.destroy', $vt))
            ->assertRedirect(route('vetos.index'));
        $this->assertSoftDeleted($vt);
    }

    // =========================================================================
    // TANSPORTEURS
    // =========================================================================

    public function test_tansporteurs_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('tansporteurs.index'))->assertOk();
    }

    public function test_tansporteurs_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('tansporteurs.store'), [
                'cin_t' => 'AA1234', 'nom' => 'Test', 'prenom' => 'Trans', 'tel' => '0600000020',
            ])->assertForbidden();
    }

    public function test_tansporteurs_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('tansporteurs.store'), [
                'cin_t' => 'BB5678', 'nom' => 'Fassi', 'prenom' => 'Said', 'tel' => '0677665544',
            ])->assertRedirect(route('tansporteurs.index'));
        $this->assertDatabaseHas('tansporteurs', ['cin_t' => 'BB5678']);
    }

    public function test_tansporteurs_update_works_for_admin(): void
    {
        $t = $this->tansporteur();
        $this->actingAs($this->admin())
            ->put(route('tansporteurs.update', $t), [
                'cin_t' => $t->cin_t, 'nom' => 'Updated', 'prenom' => 'Trans', 'tel' => '0611111111',
            ])->assertRedirect(route('tansporteurs.index'));
        $this->assertDatabaseHas('tansporteurs', ['id_trans' => $t->id_trans, 'nom' => 'Updated']);
    }

    public function test_tansporteurs_destroy_works_for_admin(): void
    {
        $t = $this->tansporteur();
        $this->actingAs($this->admin())
            ->delete(route('tansporteurs.destroy', $t))
            ->assertRedirect(route('tansporteurs.index'));
        $this->assertSoftDeleted($t);
    }

    // =========================================================================
    // VEHICULES
    // =========================================================================

    public function test_vehicules_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('vehicules.index'))->assertOk();
    }

    public function test_vehicules_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('vehicules.store'), ['Matricule' => '9999-A-99', 'type' => '4x4'])
            ->assertForbidden();
    }

    public function test_vehicules_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('vehicules.store'), ['Matricule' => '1234-B-12', 'type' => 'Camion'])
            ->assertRedirect(route('vehicules.index'));
        $this->assertDatabaseHas('vehicules', ['Matricule' => '1234-B-12']);
    }

    public function test_vehicules_update_works_for_admin(): void
    {
        $v = Vehicule::create(['Matricule' => '0000-A-00', 'type' => 'Van']);
        $this->actingAs($this->admin())
            ->put(route('vehicules.update', $v), ['Matricule' => '0000-A-00', 'type' => 'SUV'])
            ->assertRedirect(route('vehicules.index'));
        $this->assertDatabaseHas('vehicules', ['id_veh' => $v->id_veh, 'type' => 'SUV']);
    }

    public function test_vehicules_destroy_works_for_admin(): void
    {
        $v = Vehicule::create(['Matricule' => '8888-Z-88', 'type' => 'Moto']);
        $this->actingAs($this->admin())
            ->delete(route('vehicules.destroy', $v))
            ->assertRedirect(route('vehicules.index'));
        $this->assertSoftDeleted($v);
    }

    // =========================================================================
    // STOCK
    // =========================================================================

    public function test_stock_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('stock.index'))->assertOk();
    }

    public function test_stock_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('stock.store'), [
                'libelle_st' => 'Foin', 'description_s' => 'Test',
                'quantite_s' => 10, 'prix_s' => 20,
                'dateachat' => '2023-01-01', 'dateexp_s' => '2025-01-01',
            ])->assertForbidden();
    }

    public function test_stock_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('stock.store'), [
                'libelle_st' => 'Aliment', 'description_s' => 'Aliment de base',
                'quantite_s' => 200, 'prix_s' => 150,
                'dateachat' => '2023-01-01', 'dateexp_s' => '2026-01-01',
            ])->assertRedirect();
        $this->assertDatabaseHas('stocks', ['libelle_st' => 'Aliment']);
    }

    public function test_stock_update_works_for_admin(): void
    {
        $s = $this->stock();
        $this->actingAs($this->admin())
            ->patch(route('stock.update', $s), ['libelle_st' => 'Foin Modifié'])
            ->assertRedirect();
        $this->assertDatabaseHas('stocks', ['id_stock' => $s->id_stock, 'libelle_st' => 'Foin Modifié']);
    }

    public function test_stock_destroy_works_for_admin(): void
    {
        $s = $this->stock();
        $this->actingAs($this->admin())
            ->delete(route('stock.destroy', $s))
            ->assertRedirect(route('stock.index'));
        $this->assertSoftDeleted($s);
    }

    public function test_stock_deduct_works_for_admin(): void
    {
        $s = $this->stock();
        $this->actingAs($this->admin())
            ->post(route('stock.deduct', $s), ['quantity' => 10])
            ->assertRedirect();
        $s->refresh();
        $this->assertEquals(90, $s->quantiteAct);
    }

    public function test_stock_deduct_forbidden_for_non_admin(): void
    {
        $s = $this->stock();
        $this->actingAs($this->user())
            ->post(route('stock.deduct', $s), ['quantity' => 10])
            ->assertForbidden();
    }

    // =========================================================================
    // MEDS
    // =========================================================================

    public function test_meds_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('meds.index'))->assertOk();
    }

    public function test_meds_store_forbidden_for_non_admin(): void
    {
        $this->actingAs($this->user())
            ->post(route('meds.store'), [
                'libelle' => 'Doliprane', 'description' => 'Antidouleur',
                'quantite_med' => 10, 'prix_med' => 5,
                'dateachat' => '2023-01-01', 'dateexp_med' => '2025-01-01',
            ])->assertForbidden();
    }

    public function test_meds_store_works_for_admin(): void
    {
        $this->actingAs($this->admin())
            ->post(route('meds.store'), [
                'libelle' => 'Vaccin X', 'description' => 'Vaccin contre X',
                'quantite_med' => 20, 'prix_med' => 100,
                'dateachat' => '2023-01-01', 'dateexp_med' => '2026-01-01',
            ])->assertRedirect();
        $this->assertDatabaseHas('meds', ['libelle' => 'Vaccin X']);
    }

    public function test_meds_update_works_for_admin(): void
    {
        $m = $this->meds();
        $this->actingAs($this->admin())
            ->patch(route('meds.update', $m), [
                'libelle' => 'Antibio Modifié', 'description' => 'Modifié',
                'quantite_med' => 40, 'prix_med' => 35,
                'dateexp_med' => '2026-06-01',
            ])->assertRedirect();
        $this->assertDatabaseHas('meds', ['id_med' => $m->id_med, 'libelle' => 'Antibio Modifié']);
    }

    public function test_meds_destroy_works_for_admin(): void
    {
        $m = $this->meds();
        $this->actingAs($this->admin())
            ->delete(route('meds.destroy', $m))
            ->assertRedirect(route('meds.index'));
        $this->assertSoftDeleted($m);
    }

    public function test_meds_deduct_works_for_admin(): void
    {
        $m = $this->meds();
        $this->actingAs($this->admin())
            ->post(route('meds.deduct', $m), ['quantity' => 5])
            ->assertRedirect();
        $m->refresh();
        $this->assertEquals(45, $m->quantite_med);
    }

    public function test_meds_deduct_forbidden_for_non_admin(): void
    {
        $m = $this->meds();
        $this->actingAs($this->user())
            ->post(route('meds.deduct', $m), ['quantity' => 5])
            ->assertForbidden();
    }

    // =========================================================================
    // VISITES
    // =========================================================================

    public function test_visites_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('visites.index'))->assertOk();
    }

    public function test_visites_store_forbidden_for_non_admin(): void
    {
        $b = $this->bovin(); $vt = $this->veto();
        $this->actingAs($this->user())
            ->post(route('visites.store'), [
                'description_v' => 'Contrôle', 'datepres' => '2023-06-01',
                'prix_pres' => 300, 'id_bov' => $b->id_bov, 'id_vet' => $vt->id_vet,
            ])->assertForbidden();
    }

    public function test_visites_store_works_for_admin(): void
    {
        $b = $this->bovin(); $vt = $this->veto();
        $this->actingAs($this->admin())
            ->post(route('visites.store'), [
                'description_v' => 'Contrôle annuel', 'datepres' => '2023-06-01',
                'prix_pres' => 300, 'id_bov' => $b->id_bov, 'id_vet' => $vt->id_vet,
            ])->assertRedirect();
        $this->assertDatabaseHas('visites', ['description_v' => 'Contrôle annuel']);
    }

    public function test_visites_update_works_for_admin(): void
    {
        $visite = $this->visite();
        $b = $visite->bovin; $vt = $visite->veto;
        $this->actingAs($this->admin())
            ->patch(route('visites.update', $visite), [
                'description_v' => 'Mise à jour visite', 'datepres' => '2023-07-01',
                'prix_pres' => 400, 'id_bov' => $b->id_bov, 'id_vet' => $vt->id_vet,
            ])->assertRedirect();
        $this->assertDatabaseHas('visites', ['id_pres' => $visite->id_pres, 'description_v' => 'Mise à jour visite']);
    }

    public function test_visites_destroy_works_for_admin(): void
    {
        $visite = $this->visite();
        $this->actingAs($this->admin())
            ->delete(route('visites.destroy', $visite))
            ->assertRedirect(route('visites.index'));
        $this->assertSoftDeleted($visite);
    }

    // =========================================================================
    // BOVINS
    // =========================================================================

    public function test_bovins_index_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user())->get(route('bovins.index'))->assertOk();
    }

    public function test_bovins_store_forbidden_for_non_admin(): void
    {
        $e = $this->etable(); $v = $this->vendeur(); $q = $this->quarantaine();
        $this->actingAs($this->user())
            ->post(route('bovins.store'), [
                'race' => 'Frise', 'dateachat' => '2023-01-01',
                'prixachat' => 800, 'poidachat' => 40, 'lieuachat' => 'Marché',
                'id_etab' => $e->id_etab, 'id_vend' => $v->id_vend, 'id_q' => $q->id_q,
            ])->assertForbidden();
    }

    public function test_bovins_store_works_for_admin(): void
    {
        $e = $this->etable(); $v = $this->vendeur(); $q = $this->quarantaine();
        $this->actingAs($this->admin())
            ->post(route('bovins.store'), [
                'race' => 'Frise', 'dateachat' => '2023-01-01',
                'prixachat' => 800, 'poidachat' => 40, 'lieuachat' => 'Marché',
                'id_etab' => $e->id_etab, 'id_vend' => $v->id_vend, 'id_q' => $q->id_q,
            ])->assertRedirect();
        $this->assertDatabaseHas('bovins', ['race' => 'Frise']);
    }

    public function test_bovins_show_accessible_to_non_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->user())
            ->get(route('bovins.show', $b))->assertOk();
    }

    public function test_bovins_update_works_for_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->admin())
            ->patch(route('bovins.update', $b), ['race' => 'Limousine'])
            ->assertRedirect();
        $this->assertDatabaseHas('bovins', ['id_bov' => $b->id_bov, 'race' => 'Limousine']);
    }

    public function test_bovins_update_forbidden_for_non_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->user())
            ->patch(route('bovins.update', $b), ['race' => 'Hack'])
            ->assertForbidden();
    }

    public function test_bovins_destroy_works_for_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->admin())
            ->delete(route('bovins.destroy', $b))
            ->assertRedirect(route('bovins.index'));
        $this->assertSoftDeleted($b);
    }

    public function test_bovins_mark_sold_works_for_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->admin())
            ->post(route('bovins.mark-sold', $b), [
                'prixavente' => 1200, 'poidvente' => 50,
                'lieuvente' => 'Marché central', 'datevente' => '2023-12-01',
            ])->assertRedirect();
        $b->refresh();
        $this->assertEquals(1, $b->vendu);
    }

    public function test_bovins_mark_dead_works_for_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->admin())
            ->post(route('bovins.mark-dead', $b), ['datemort' => '2023-11-15'])
            ->assertRedirect();
        $b->refresh();
        $this->assertEquals(1, $b->mort);
    }

    public function test_bovins_update_weight_works_for_admin(): void
    {
        $b = $this->bovin();
        $this->actingAs($this->admin())
            ->post(route('bovins.update-weight', $b), ['poidAct' => 55])
            ->assertRedirect();
        $b->refresh();
        $this->assertEquals(55, $b->poidAct);
    }
}
