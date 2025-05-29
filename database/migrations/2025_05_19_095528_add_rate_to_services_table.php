<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class AddRateToServicesTable extends Migration
   {
       public function up()
       {
           if (!Schema::hasTable('services')) {
               Schema::create('services', function (Blueprint $table) {
                   $table->id();
                   $table->string('name');
                   $table->decimal('rate', 8, 2); // Added rate column with 8 digits total, 2 after decimal
                   $table->string('estimated_time');
                   $table->boolean('availability')->default(true);
                   $table->timestamps();
               });
           } else {
               if (!Schema::hasColumn('services', 'rate')) {
                   Schema::table('services', function (Blueprint $table) {
                       $table->decimal('rate', 8, 2)->after('name'); // Add rate after name
                   });
               }
           }
       }

       public function down()
       {
           Schema::table('services', function (Blueprint $table) {
               if (Schema::hasColumn('services', 'rate')) {
                   $table->dropColumn('rate');
               }
           });

           if (Schema::hasTable('services') && !Schema::hasColumns('services', ['name', 'estimated_time', 'availability', 'created_at', 'updated_at'])) {
               Schema::dropIfExists('services');
           }
       }
   }