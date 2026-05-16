<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        // Future steps will add table migration calls here
        return 0;
    }

    private function parseInsertStatements($filePath, $tableName)
    {
        $content = file_get_contents($filePath);
        // Find INSERT INTO `tableName` (...) VALUES (...), (...);
        $pattern = "/INSERT INTO `{$tableName}` \((.*?)\) VALUES (.*?);/is";
        if (preg_match($pattern, $content, $matches)) {
            $columns = array_map(function($col) {
                return trim($col, '` ');
            }, explode(',', $matches[1]));

            // Split multiple value groups: (val1, val2), (val3, val4)
            $valuesString = $matches[2];
            preg_match_all("/\((.*?)\)(?:,|$)/is", $valuesString, $valueGroups);

            $results = [];
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
            return $results;
        }
        return [];
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
