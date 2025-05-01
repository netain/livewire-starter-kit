<?php

namespace App\Console\Commands;

use App\Actions\Role\CreateRole;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:role {name}
                            {--super : Create a super role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $isSuper = $this->option('super');

        $role = (new CreateRole())->handle([
            'name' => $name,
            'code' => Str::slug($name),
            'is_super' => $isSuper,
        ]);

        $this->info("Role {$role->name} created successfully.");
    }
}
