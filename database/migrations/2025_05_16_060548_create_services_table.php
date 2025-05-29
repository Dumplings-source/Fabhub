<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateServicesTable extends Migration
  {
      public function up()
      {
          Schema::create('services', function (Blueprint $table) {
              $table->id();
              $table->string('name');
              $table->decimal('price', 8, 2);
              $table->string('file_formats');
              $table->string('materials');
              $table->string('estimated_time');
              $table->boolean('availability')->default(true);
              $table->text('description')->nullable();
              $table->timestamps();
          });
      }

      public function down()
      {
          Schema::dropIfExists('services');
      }
  }