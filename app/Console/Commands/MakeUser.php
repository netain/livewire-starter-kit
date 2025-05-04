<?php

namespace App\Console\Commands;

use App\Actions\User\CreateUser;
use App\Models\Role;
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
        $roles = Role::all()->pluck('code')->toArray();

        $this->info('Creating a new user...');

        $firstName = $this->ask('What is the first name of the user?');
        $lastName = $this->ask('What is the last name of the user?');
        $email = $this->ask('What is the email of the user?');
        $roleCode = $this->choice('What is the role of the user?', $roles);

        (new CreateUser())->handle([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'role_id' => Role::where('code', $roleCode)->first()->id,
        ]);

        $this->info('User created successfully.');
    }
}
