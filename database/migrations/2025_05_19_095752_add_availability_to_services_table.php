<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class AddAvailabilityToServicesTable extends Migration
   {
       public function up()
       {
           if (Schema::hasTable('services') && !Schema::hasColumn('services', 'availability')) {
               Schema::table('services', function (Blueprint $table) {
                   $table->boolean('availability')->default(true)->after('estimated_time');
               });
           }
       }

       public function down()
       {
           Schema::table('services', function (Blueprint $table) {
               if (Schema::hasColumn('services', 'availability')) {
                   $table->dropColumn('availability');
               }
           });
       }
   }