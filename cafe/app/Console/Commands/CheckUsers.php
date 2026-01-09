<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all users in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(['id', 'name', 'email', 'role', 'is_active']);
        
        if ($users->isEmpty()) {
            $this->error('No users found in database!');
            return 1;
        }

        $this->info('Users in database:');
        $this->table(
            ['ID', 'Name', 'Email', 'Role', 'Active'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->is_active ? 'Yes' : 'No'
                ];
            })->toArray()
        );

        return 0;
    }
}
