<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class MakeDescriptionNullableInServicesTable extends Migration
   {
       public function up()
       {
           Schema::table('services', function (Blueprint $table) {
               $table->string('description')->nullable()->change();
           });
       }

       public function down()
       {
           Schema::table('services', function (Blueprint $table) {
               $table->string('description')->nullable(false)->change();
           });
       }
   }