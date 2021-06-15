<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSqliteDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "db:sqlite.create";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create empty sqlite database file if it doesn't exist";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $databasePath = config("database.connections.sqlite.database");
        if (file_exists($databasePath)) {
            $this->warn("Database already exists.");
            return 0;
        }

        try {
            file_put_contents($databasePath, "");
            $this->info("Done. You have an empty database now.");
            return 0;
        } catch (\Exception $e) {
            $this->error(
                "Something went wrong when trying to create a database file."
            );
            $this->error($e->getMessage());
            return 1;
        }
    }
}
