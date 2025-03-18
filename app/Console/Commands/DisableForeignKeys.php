<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DisableForeignKeys extends Command
{
    protected $signature = 'db:disable-foreign-key {action=disable}';
    protected $description = 'Disable or enable foreign key checks in SQLite';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = $this->argument('action');

        if (DB::getDriverName() === 'sqlite') {
            if ($action === 'disable') {
                DB::statement('PRAGMA foreign_keys = OFF;');
                $this->info('Foreign key checks are now OFF in SQLite.');
            } elseif ($action === 'enable') {
                DB::statement('PRAGMA foreign_keys = ON;');
                $this->info('Foreign key checks are now ON in SQLite.');
            } else {
                $this->error('Invalid action. Use "disable" or "enable".');
            }
        } else {
            $this->info('This command is only applicable to SQLite databases.');
        }
    }
}
