```
   <?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up(): void
       {
           Schema::create('orders', function (Blueprint $table) {
               $table->id();
               $table->unsignedBigInteger('user_id');
               $table->unsignedBigInteger('service_id');
               $table->string('material');
               $table->integer('quantity');
               $table->date('preferred_date');
               $table->string('status')->default('pending');
               $table->string('file_path');
               $table->timestamps();

               $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
               $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
           });
       }

       public function down(): void
       {
           Schema::dropIfExists('orders');
       }
   };
