<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@example.com';
        $password = 'admin123456';

        // Check if admin already exists
        if (User::where('email', $email)->exists()) {
            $this->info('❌ Admin user already exists!');
            return;
        }

        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info('✅ Admin user created successfully!');
        $this->line('Email: ' . $email);
        $this->line('Password: ' . $password);
    }
}
