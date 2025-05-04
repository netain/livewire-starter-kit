<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('is_super')->default(false);
            $table->timestamps();
        });

        $role = Role::create([
            'name' => 'User',
            'code' => 'user',
            'is_super' => false,
        ]);

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Role::class)->constrained();
            $table->primary(['user_id', 'role_id']);
        });

        Schema::table('users', function (Blueprint $table) use ($role) {
            $table->foreignIdFor(Role::class)->default($role->id)->constrained();
        });
    }
};
