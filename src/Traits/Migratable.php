<?php

namespace Dalyio\Challenge\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait Migratable
{
    /**
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tableName);
    }

    /**
     * Set autoincrement on `id`
     *
     * @return void
     */
    protected function autoincrement()
    {
        if (property_exists($this, 'autoincrement')) {
            Schema::table($this->tableName, function(Blueprint $table){
                $sql = 'ALTER TABLE '.config('database.mysql.prefix').$this->tableName.' AUTO_INCREMENT = '.(string) $this->autoincrement;
                DB::connection()->getPdo()->exec($sql);
            });
        }
    }
}
