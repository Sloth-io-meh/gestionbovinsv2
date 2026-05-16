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
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info("Starting migration from {$filePath}...");
        // Future steps will add table migration calls here
        return 0;
    }
}
