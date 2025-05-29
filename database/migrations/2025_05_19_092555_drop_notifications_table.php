<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Support\Facades\Schema;

   class DropNotificationsTable extends Migration
   {
       public function up()
       {
           Schema::dropIfExists('notifications');
       }

       public function down()
       {
           // Optional: Recreate table if needed for rollback, but since you want to remove, leave empty or minimal
           Schema::create('notifications', function ($table) {
               $table->uuid('id')->primary();
               $table->string('type');
               $table->string('notifiable_type');
               $table->unsignedBigInteger('notifiable_id');
               $table->text('data');
               $table->timestamp('read_at')->nullable();
               $table->timestamps();
               $table->index(['notifiable_type', 'notifiable_id']);
           });
       }
   }