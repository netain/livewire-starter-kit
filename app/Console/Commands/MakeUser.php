<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new user...');

        $firstName = $this->ask('What is the first name of the user?');
        $lastName = $this->ask('What is the last name of the user?');
        $email = $this->ask('What is the email of the user?');
        $role = $this->choice('What is the role of the user?', ['admin', 'user']);

        // Here you would typically create the user in your database
        // User::create([...]);

        $this->info('User created successfully.');
    }
}
