<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AddAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an admin user to the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'name' => 'admin',
            'password' => Hash::make('q1q1q1q1'),
        ]);

        $this->info('Admin user created successfully!');

        return 0;
    }
}
