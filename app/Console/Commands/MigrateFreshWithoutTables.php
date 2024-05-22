<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateFreshWithoutTables extends Command
{
    protected $signature = 'migrate:fresh-without {--tables=}';
    protected $description = 'Drop all tables and re-run all migrations, excluding specified tables';

    public function handle()
    {
        // Get the tables to exclude
        $tablesToExclude = $this->option('tables') ? explode(',', $this->option('tables')) : [];

        // Get all tables in the database
        $allTables = DB::select('SHOW TABLES');
        $dbName = 'Tables_in_' . env('DB_DATABASE');
        $allTables = array_map(function ($table) use ($dbName) {
            return $table->$dbName;
        }, $allTables);

        // Tables to drop
        $tablesToDrop = array_diff($allTables, $tablesToExclude);

        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Drop the tables
        foreach ($tablesToDrop as $table) {
            Schema::dropIfExists($table);
        }

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Run the migrations
        $this->call('migrate', ['--force' => true]);

        $this->info('Database refreshed and migrations run successfully, excluding: ' . implode(', ', $tablesToExclude));
    }
}
