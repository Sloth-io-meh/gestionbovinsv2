<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GrantAdmin extends Command
{
    protected $signature = 'admin:grant {email? : Email of the user to promote (or create)}';
    protected $description = 'Grant admin rights to an existing user, or create a new admin account';

    public function handle(): int
    {
        $email = $this->argument('email') ?? $this->ask('Email address');

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->is_admin) {
                $this->info("User [{$email}] is already an admin.");
                return self::SUCCESS;
            }

            $user->update(['is_admin' => true]);
            $this->info("Admin rights granted to [{$email}].");
            return self::SUCCESS;
        }

        $this->warn("No user found with email [{$email}].");

        if (! $this->confirm('Create a new admin account with this email?', true)) {
            return self::FAILURE;
        }

        $name     = $this->ask('Full name');
        $password = $this->secret('Password (min 8 chars)');

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters.');
            return self::FAILURE;
        }

        User::create([
            'name'               => $name,
            'email'              => $email,
            'password'           => $password,
            'is_admin'           => true,
            'email_verified_at'  => now(),
        ]);

        $this->info("Admin account created for [{$email}].");
        return self::SUCCESS;
    }
}
