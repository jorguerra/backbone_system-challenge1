<?php

use App\Models\{FederalEntity, Municipality, SettlementType, ZipCode, Settlement};
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
        Schema::create('federal_entities', function (Blueprint $table) {
            $table->integer('key')->primary();
            $table->string('name',50);
            $table->string('code')->nullable();
        });

        Schema::create('settlement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',20)->unique();
        });

        Schema::create('settlements', function (Blueprint $table) {
            $table->integer('key')->primary();
            $table->string('name',50);
            $table->enum('zone_type',['Urbano','Rural']);
            $table->foreignIdFor(SettlementType::class, 'type_id');
        });

        Schema::create('municipalities', function (Blueprint $table) {
            $table->integer('key')->primary();
            $table->string('name',50);
        });

        Schema::create('zip_codes', function (Blueprint $table) {
            $table->char('zip_code',5)->primary();
            $table->string('locality')->empty();
            $table->foreignIdFor(FederalEntity::class, 'federal_entity_id');
            $table->foreignIdFor(Municipality::class, 'municipality_id');
        });

        Schema::create('zip_codes_has_settlements', function (Blueprint $table) {
            $table->foreignIdFor(ZipCode::class,'zip_code');
            $table->foreignIdFor(Settlement::class,'settlement');
            $table->primary(['zip_code','settlement']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('federal_entities');
        Schema::dropIfExists('settlement_types');
        Schema::dropIfExists('settlements');
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('zip_codes_has_settlements');
        Schema::dropIfExists('zip_codes');
    }
};
