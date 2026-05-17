<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MigrateLegacyData extends Command
{
    protected $signature = 'app:migrate-legacy-data
                            {--file= : Path to the legacy SQL file}
                            {--fresh : Truncate all tables before migrating}';

    protected $description = 'Migrate legacy gestionbovins SQL data into the secure Laravel database';

    private string $sqlPath;

    public function handle(): int
    {
        $file = $this->option('file')
            ?? base_path('../gestionbovins/gestionbovins.sql');

        if (! file_exists($file)) {
            $file = 'C:/Users/ULTRAPC/Desktop/security/gestionbovins/gestionbovins.sql';
        }

        if (! file_exists($file)) {
            $this->error("SQL file not found. Pass --file=<path>.");
            return 1;
        }

        $this->sqlPath = $file;
        $this->info("Source: {$file}");

        if ($this->option('fresh')) {
            $this->truncateAll();
        }

        // Disable FK enforcement during bulk insert
        DB::statement('PRAGMA foreign_keys = OFF');

        $this->migrate('etables',        fn($r) => $this->etable($r));
        $this->migrate('quarantaine',    fn($r) => $this->quarantaine($r));
        $this->migrate('vendeur',        fn($r) => $this->vendeur($r));
        $this->migrate('tansporteur',    fn($r) => $this->tansporteur($r));
        $this->migrate('veto',           fn($r) => $this->veto($r));
        $this->migrate('bovins',         fn($r) => $this->bovin($r));
        $this->migrate('vehicule',       fn($r) => $this->vehicule($r));
        $this->migrate('meds',           fn($r) => $this->med($r));
        $this->migrate('stock',          fn($r) => $this->stock($r));
        $this->migrate('visites',        fn($r) => $this->visite($r));
        $this->migrate('medicsconsumed', fn($r) => $this->medicsconsumed($r));
        $this->migrate('nourriture',     fn($r) => $this->nourriture($r));
        $this->migrateUser();

        DB::statement('PRAGMA foreign_keys = ON');

        $this->info('');
        $this->info('Migration complete.');
        return 0;
    }

    // ── Table mappers ────────────────────────────────────────────────────────

    private function etable(array $r): void
    {
        DB::table('etables')->updateOrInsert(
            ['id_etab' => $r['id_etab']],
            ['nom' => $r['nom'], 'created_at' => now(), 'updated_at' => now()]
        );
    }

    private function quarantaine(array $r): void
    {
        DB::table('quarantaines')->updateOrInsert(
            ['id_q' => $r['id_q']],
            ['libelle' => $r['libelle'], 'created_at' => now(), 'updated_at' => now()]
        );
    }

    private function vendeur(array $r): void
    {
        DB::table('vendeurs')->updateOrInsert(
            ['id_vend' => $r['id_vend']],
            [
                'nom_vend'    => $r['nom_vend'],
                'prenom_vend' => $r['prenom_vend'],
                'tel_vend'    => $r['tel_vend'],
                'farm_vend'   => $this->nullable($r['farm_vend']),
                'id_bov'      => $this->nullable($r['id_bov'] ?? null),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }

    private function tansporteur(array $r): void
    {
        DB::table('tansporteurs')->updateOrInsert(
            ['id_trans' => $r['id_trans']],
            [
                'cin_t'      => trim($r['cin_t']),
                'nom'        => trim($r['nom']),
                'prenom'     => trim($r['prenom']),
                'tel'        => trim($r['tel']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function veto(array $r): void
    {
        DB::table('vetos')->updateOrInsert(
            ['id_vet' => trim($r['id_vet'])],
            [
                'nom_vet'    => trim($r['nom_vet']),
                'prenom_vet' => trim($r['prenom_vet']),
                'tel_vet'    => trim($r['tel_vet']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function bovin(array $r): void
    {
        DB::table('bovins')->updateOrInsert(
            ['id_bov' => $r['id_bov']],
            [
                'race'       => $r['race'],
                'dateachat'  => $this->date($r['dateachat']),
                'prixachat'  => $this->nullable($r['prixachat']),
                'poidachat'  => $this->nullable($r['poidachat']),
                'lieuachat'  => $this->nullable($r['lieuachat']),
                'datevente'  => $this->date($r['datevente']),
                'prixavente' => $this->nullable($r['prixavente']),
                'poidvente'  => $this->nullable($r['poidvente']),
                'lieuvente'  => $this->nullable($r['lieuvente']),
                'vendu'      => $r['vendu'] === '1' ? 1 : 0,
                'mort'       => $r['mort'] === '1' ? 1 : 0,
                'datemort'   => $this->date($r['datemort']),
                'id_etab'    => $this->nullable($r['id_etab']),
                'id_vend'    => $this->nullable($r['id_vend']),
                'id_q'       => $this->nullable($r['id_q']),
                'poidAct'    => $r['poidAct'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function vehicule(array $r): void
    {
        DB::table('vehicules')->updateOrInsert(
            ['id_veh' => $r['id_veh']],
            [
                'Matricule'  => $r['Matricule'],
                'type'       => $r['type'],
                'id_trans'   => $this->nullable($r['id_trans']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function med(array $r): void
    {
        DB::table('meds')->updateOrInsert(
            ['id_med' => $r['id_med']],
            [
                'libelle'      => $r['libelle'],
                'description'  => $r['description'],
                'quantite_med' => $r['quantite_med'],
                'prix_med'     => $r['prix_med'],
                'dateachat'    => $this->date($r['dateachat']),
                'dateexp_med'  => $this->date($r['dateexp_med']),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        );
    }

    private function stock(array $r): void
    {
        DB::table('stocks')->updateOrInsert(
            ['id_stock' => $r['id_stock']],
            [
                'libelle_st'    => $r['libelle_st'],
                'description_s' => $r['description_s'],
                'quantite_s'    => $r['quantite_s'],
                'quantiteAct'   => $r['quantiteAct'],
                'prix_s'        => $r['prix_s'],
                'dateachat'     => $this->date($r['dateachat']),
                'dateexp_s'     => $this->date($r['dateexp_s']),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }

    private function visite(array $r): void
    {
        DB::table('visites')->updateOrInsert(
            ['id_pres' => $r['id_pres']],
            [
                'description_v' => $r['description_v'],
                'datepres'      => $this->date($r['datepres']),
                'prix_pres'     => $this->nullable($r['prix_pres']),
                'id_bov'        => $this->nullable($r['id_bov']),
                'id_vet'        => $r['id_vet'] !== 'NULL' ? trim($r['id_vet']) : null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }

    private function medicsconsumed(array $r): void
    {
        DB::table('medicsconsumed')->updateOrInsert(
            ['id_m' => $r['id_m']],
            [
                'libelle_m'  => $r['libelle_m'],
                'quantite_m' => $r['quantite_m'],
                'id_bov'     => $r['id_bov'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function nourriture(array $r): void
    {
        DB::table('nourriture')->updateOrInsert(
            ['id_n' => $r['id_n']],
            [
                'libelle_n'  => $r['libelle_n'],
                'quantite_n' => $r['quantite_n'],
                'prix'       => $this->nullable($r['prix']),
                'id_bov'     => $r['id_bov'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    private function migrateUser(): void
    {
        $this->info('Migrating users from information table...');
        $rows = $this->parse('information');

        foreach ($rows as $r) {
            $name = trim(($r['prenom'] ?? '') . ' ' . ($r['nom'] ?? ''));
            DB::table('users')->updateOrInsert(
                ['email' => $r['mail']],
                [
                    'name'              => $name ?: $r['mail'],
                    'nom'               => $r['nom'],
                    'prenom'            => $r['prenom'],
                    'adresse'           => $r['adresse'],
                    'ville'             => $r['ville'],
                    'code'              => $r['code'],
                    'tel'               => $r['tel'],
                    'password'          => Hash::make($r['password']),
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]
            );
        }

        $this->line('  → ' . count($rows) . ' user(s) migrated (password bcrypt-hashed from plaintext)');
    }

    // ── Shared helpers ───────────────────────────────────────────────────────

    private function migrate(string $legacyTable, callable $handler): void
    {
        $rows = $this->parse($legacyTable);
        $this->info("Migrating {$legacyTable} (" . count($rows) . " rows)...");
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $r) {
            $handler($r);
            $bar->advance();
        }

        $bar->finish();
        $this->line('');
    }

    public function parse(string $tableName): array
    {
        $sql = file_get_contents($this->sqlPath);
        $results = [];

        $pattern = "/INSERT\s+INTO\s+`?{$tableName}`?\s+\(([^)]+)\)\s+VALUES\s+([\s\S]+?);/i";
        if (! preg_match_all($pattern, $sql, $blocks, PREG_SET_ORDER)) {
            return [];
        }

        foreach ($blocks as $block) {
            $columns = array_map(fn($c) => trim($c, '` '), explode(',', $block[1]));

            preg_match_all('/\(([^()]*(?:\([^()]*\)[^()]*)*)\)/', $block[2], $valueGroups);

            foreach ($valueGroups[1] as $group) {
                $values = str_getcsv($group, ',', "'", '\\');
                $values = array_map(function ($v) {
                    $v = trim($v);
                    return strtoupper($v) === 'NULL' ? 'NULL' : trim($v, "'");
                }, $values);

                if (count($columns) === count($values)) {
                    $results[] = array_combine($columns, $values);
                }
            }
        }

        return $results;
    }

    private function date(?string $value): ?string
    {
        if (! $value || strtoupper($value) === 'NULL' || trim($value) === '') {
            return null;
        }
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
            return Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        }
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception) {
            return null;
        }
    }

    private function nullable(mixed $value): mixed
    {
        if ($value === null || strtoupper((string) $value) === 'NULL' || trim((string) $value) === '') {
            return null;
        }
        return $value;
    }

    private function truncateAll(): void
    {
        $this->warn('Truncating tables...');
        DB::statement('PRAGMA foreign_keys = OFF');
        foreach (['nourriture', 'medicsconsumed', 'visites', 'vehicules', 'bovins',
                  'vendeurs', 'vetos', 'tansporteurs', 'quarantaines', 'etables',
                  'meds', 'stocks'] as $t) {
            DB::table($t)->truncate();
        }
        DB::statement('PRAGMA foreign_keys = ON');
    }
}
