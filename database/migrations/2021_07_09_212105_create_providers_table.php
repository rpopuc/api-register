<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);
            $table->text('definition')->nullable(false);
            $table->text('tags')->nullable(true);
            $table->text('owner')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
