<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class MakeMaterialsNullableInServicesTable extends Migration
   {
       public function up()
       {
           Schema::table('services', function (Blueprint $table) {
               $table->string('materials')->nullable()->change();
           });
       }

       public function down()
       {
           Schema::table('services', function (Blueprint $table) {
               $table->string('materials')->nullable(false)->change();
           });
       }
   }