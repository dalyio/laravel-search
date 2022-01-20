<?php

use Dalyio\Challenge\Traits\Migratable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeGeoZipcodesTable extends Migration
{
    use Migratable;
    
    protected $tableName = 'challenge_geo_zipcodes';
    protected $autoincrement = 1000000000;
    
    /**
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('zipcode')->unique();
            $table->point('coordinate')->spatialIndex();
        });
        
        $this->autoincrement();
    }
}
