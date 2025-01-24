<?php

use App\Models\Integration;
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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('owner_type');
            $table->string('owner_id');
            $table->string('provider');
            $table->timestamps();
        });

        $user = User::query()->create([
            'email' => 'mateus@junges.dev',
            'password' => bcrypt('password'),
            'name' => 'Mateus Junges',
        ]);

        Integration::query()->create([
            'owner_type' => 'user',
            'owner_id' => $user->id,
            'provider' => 'dummy_provider'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
