<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector');

        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('response');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE responses ADD COLUMN embedding vector(1536)');
        DB::statement('CREATE INDEX ON responses USING ivfflat (embedding vector_cosine_ops) WITH (lists = 100)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
