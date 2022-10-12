<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            // $table->id();
            // $table->string('uuid');
            // $table->string('county');
            // $table->string('country');
            // $table->string('town');
            // $table->string('postcode')->nullable();
            // $table->text('description');
            // $table->string('image_full');
            // $table->string('image_thumbnail');
            // $table->string('address');
            // $table->integer('latitude');
            // $table->integer('longitude');
            // $table->integer('num_bedrooms');
            // $table->integer('num_bathrooms');
            // $table->string('price');
            // $table->enum('property_type', ['Flat', 'Detatched', 'Semi-detached', 'Terraced', 'End of Terrace', 'Cottage', 'Bungalow']);
            // $table->boolean('for_sale');
            // $table->boolean('for_rent');
            // $table->timestamps();
            $table->id();
            $table->string('name');
            $table->text('detail');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
