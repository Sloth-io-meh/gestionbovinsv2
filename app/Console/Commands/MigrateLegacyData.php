<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Etable;
use App\Models\Quarantaine;
use App\Models\Vendeur;
use App\Models\Tansporteur;
use App\Models\Veto;
use App\Models\Bovin;
use App\Models\Vehicule;
use App\Models\Visite;
use App\Models\Nourriture;
use App\Models\Medicsconsumed;
use App\Models\Stock;
use App\Models\Meds;
use Illuminate\Support\Facades\Hash;

class MigrateLegacyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-legacy-data {--file=../gestionbovins/gestionbovins.sql : Path to the legacy SQL file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate legacy cattle management data from SQL file to Laravel database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->option('file');
        if (! file_exists($filePath)) {
            $this->error("File not found: {$filePath}");

            return 1;
        }

        $this->info("Starting migration from {$filePath}...");

        $this->migrateUsers($filePath);
        $this->migrateEtables($filePath);
        $this->migrateQuarantaine($filePath);
        $this->migrateVendeurs($filePath);
        $this->migrateTansporteurs($filePath);
        $this->migrateVeto($filePath);
        $this->migrateBovins($filePath);
        $this->migrateVehicules($filePath);
        $this->migrateVisites($filePath);
        $this->migrateNourriture($filePath);
        $this->migrateMedicsconsumed($filePath);
        $this->migrateStock($filePath);
        $this->migrateMeds($filePath);

        $this->info("Migration completed successfully!");
        return 0;
    }

    private function migrateUsers($filePath)
    {
        $this->info("Migrating Users...");
        $rows = $this->parseInsertStatements($filePath, 'information');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            User::updateOrCreate(
                ['id' => $row['Id_user']],
                [
                    'name' => trim(($row['prenom'] ?? '') . ' ' . ($row['nom'] ?? '')),
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'adresse' => $row['adresse'],
                    'ville' => $row['ville'],
                    'code' => $row['code'],
                    'tel' => $row['tel'],
                    'email' => $row['mail'],
                    'password' => Hash::needsRehash($row['password']) ? Hash::make($row['password']) : $row['password'],
                    'email_verified_at' => now(),
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateEtables($filePath)
    {
        $this->info("Migrating Etables...");
        $rows = $this->parseInsertStatements($filePath, 'etables');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Etable::updateOrCreate(
                ['id_etab' => $row['id_etab']],
                ['nom' => $row['nom']]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateQuarantaine($filePath)
    {
        $this->info("Migrating Quarantaine...");
        $rows = $this->parseInsertStatements($filePath, 'quarantaine');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Quarantaine::updateOrCreate(
                ['id_q' => $row['id_q']],
                ['libelle' => $row['libelle']]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateVendeurs($filePath)
    {
        $this->info("Migrating Vendeurs...");
        $rows = $this->parseInsertStatements($filePath, 'vendeur');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Vendeur::updateOrCreate(
                ['id_vend' => $row['id_vend']],
                [
                    'nom_vend' => $row['nom_vend'],
                    'prenom_vend' => $row['prenom_vend'],
                    'tel_vend' => $row['tel_vend'],
                    'farm_vend' => $row['farm_vend'],
                    'id_bov' => $row['id_bov'] && $row['id_bov'] !== 'NULL' ? $row['id_bov'] : null,
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateTansporteurs($filePath)
    {
        $this->info("Migrating Tansporteurs...");
        $rows = $this->parseInsertStatements($filePath, 'tansporteur');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Tansporteur::updateOrCreate(
                ['id_trans' => $row['id_trans']],
                [
                    'cin_t' => trim($row['cin_t']),
                    'nom' => trim($row['nom']),
                    'prenom' => trim($row['prenom']),
                    'tel' => trim($row['tel']),
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateVeto($filePath)
    {
        $this->info("Migrating Veto...");
        $rows = $this->parseInsertStatements($filePath, 'veto');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Veto::updateOrCreate(
                ['id_vet' => trim($row['id_vet'])],
                [
                    'nom_vet' => trim($row['nom_vet']),
                    'prenom_vet' => trim($row['prenom_vet']),
                    'tel_vet' => trim($row['tel_vet']),
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateBovins($filePath)
    {
        $this->info("Migrating Bovins...");
        $rows = $this->parseInsertStatements($filePath, 'bovins');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Bovin::updateOrCreate(
                ['id_bov' => $row['id_bov']],
                [
                    'race' => $row['race'],
                    'dateachat' => $this->cleanDate($row['dateachat']),
                    'prixachat' => $row['prixachat'],
                    'poidachat' => $row['poidachat'],
                    'lieuachat' => $row['lieuachat'],
                    'datevente' => $this->cleanDate($row['datevente']),
                    'prixavente' => $row['prixavente'],
                    'poidvente' => $row['poidvente'],
                    'lieuvente' => $row['lieuvente'],
                    'vendu' => $row['vendu'] == '1',
                    'mort' => $row['mort'] == '1',
                    'datemort' => $this->cleanDate($row['datemort']),
                    'id_etab' => $row['id_etab'],
                    'id_vend' => $row['id_vend'],
                    'id_q' => $row['id_q'],
                    'poidAct' => $row['poidAct'],
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateVehicules($filePath)
    {
        $this->info("Migrating Vehicules...");
        $rows = $this->parseInsertStatements($filePath, 'vehicule');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Vehicule::updateOrCreate(
                ['id_veh' => $row['id_veh']],
                [
                    'Matricule' => $row['Matricule'],
                    'type' => $row['type'],
                    'id_trans' => $row['id_trans'],
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateVisites($filePath)
    {
        $this->info("Migrating Visites...");
        $rows = $this->parseInsertStatements($filePath, 'visites');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Visite::updateOrCreate(
                ['id_pres' => $row['id_pres']],
                [
                    'description_v' => $row['description_v'],
                    'datepres' => $this->cleanDate($row['datepres']),
                    'prix_pres' => $row['prix_pres'],
                    'id_bov' => $row['id_bov'],
                    'id_vet' => $row['id_vet'],
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateNourriture($filePath)
    {
        $this->info("Migrating Nourriture...");
        $rows = $this->parseInsertStatements($filePath, 'nourriture');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Nourriture::updateOrCreate(
                ['id_n' => $row['id_n']],
                [
                    'libelle_n' => $row['libelle_n'],
                    'quantite_n' => $row['quantite_n'],
                    'prix' => $row['prix'],
                    'id_bov' => $row['id_bov'],
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateMedicsconsumed($filePath)
    {
        $this->info("Migrating Medicsconsumed...");
        $rows = $this->parseInsertStatements($filePath, 'medicsconsumed');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Medicsconsumed::updateOrCreate(
                ['id_m' => $row['id_m']],
                [
                    'libelle_m' => $row['libelle_m'],
                    'quantite_m' => $row['quantite_m'],
                    'id_bov' => $row['id_bov'],
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateStock($filePath)
    {
        $this->info("Migrating Stock...");
        $rows = $this->parseInsertStatements($filePath, 'stock');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Stock::updateOrCreate(
                ['id_stock' => $row['id_stock']],
                [
                    'libelle_st' => $row['libelle_st'],
                    'description_s' => $row['description_s'],
                    'quantite_s' => $row['quantite_s'],
                    'quantiteAct' => $row['quantiteAct'],
                    'prix_s' => $row['prix_s'],
                    'dateachat' => $this->cleanDate($row['dateachat']),
                    'dateexp_s' => $this->cleanDate($row['dateexp_s']),
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function migrateMeds($filePath)
    {
        $this->info("Migrating Meds...");
        $rows = $this->parseInsertStatements($filePath, 'meds');
        $bar = $this->output->createProgressBar(count($rows));

        foreach ($rows as $row) {
            Meds::updateOrCreate(
                ['id_med' => $row['id_med']],
                [
                    'libelle' => $row['libelle'],
                    'description' => $row['description'],
                    'quantite_med' => $row['quantite_med'],
                    'prix_med' => $row['prix_med'],
                    'dateachat' => $this->cleanDate($row['dateachat']),
                    'dateexp_med' => $this->cleanDate($row['dateexp_med']),
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();
    }

    private function parseInsertStatements($filePath, $tableName)
    {
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            return [];
        }

        $results = [];
        $currentStatement = '';
        $inStatement = false;

        // Pattern to detect start of INSERT for this table
        $startPattern = "/INSERT\s+INTO\s+`?{$tableName}`?\s+/i";

        while (($line = fgets($handle)) !== false) {
            if (! $inStatement) {
                if (preg_match($startPattern, $line)) {
                    $inStatement = true;
                    $currentStatement = $line;
                }
            } else {
                $currentStatement .= $line;
            }

            if ($inStatement && str_contains($line, ';')) {
                // We reached the end of the statement
                $results = array_merge($results, $this->processSingleStatement($currentStatement, $tableName));
                $currentStatement = '';
                $inStatement = false;
            }
        }

        fclose($handle);

        return $results;
    }

    private function processSingleStatement($statement, $tableName)
    {
        $pattern = "/INSERT\s+INTO\s+`?{$tableName}`?\s+\((.*?)\)\s+VALUES\s+(.*?);/is";
        
        $results = [];
        if (preg_match($pattern, $statement, $matches)) {
            $columns = array_map(function($col) {
                return trim($col, '` ');
            }, explode(',', $matches[1]));

            // Split multiple value groups: (val1, val2), (val3, val4)
            $valuesString = $matches[2];
            preg_match_all("/\((.*?)\)(?:,|$)/is", $valuesString, $valueGroups);

            foreach ($valueGroups[1] as $group) {
                // Split values correctly handling strings with commas
                $parsedValues = str_getcsv($group, ',', "'", "\\");
                $parsedValues = array_map(function($val) {
                    $val = trim($val);
                    if (strtoupper($val) === 'NULL') return null;
                    return trim($val, "'");
                }, $parsedValues);

                if (count($columns) === count($parsedValues)) {
                    $results[] = array_combine($columns, $parsedValues);
                }
            }
        }
        return $results;
    }

    private function cleanDate($date)
    {
        if (empty($date) || strtoupper($date) === 'NULL') return null;
        
        // Handle DD-MM-YYYY
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        }
        
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
