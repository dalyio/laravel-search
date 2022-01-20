<?php

namespace Dalyio\Challenge\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zipcode extends Model
{
    /**
     * @var string
     */
    protected $table = 'challenge_geo_zipcodes';
    
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * @var array
     */
    protected $fillable = [
        'zipcode', 'coordinate'
    ];
    
    /**
     * @var type 
     */
    protected $searchable = [
        'zipcode'
    ];
    
    /**
     * @var boolean
     */
    public $timestamps = false;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }
    
    /**
     * @return int
     */
    public function id()
    {
        return $this->getAttribute('id');
    }

    /**
     * @return string
     */
    public function zipcode()
    {
        return $this->getAttribute('zipcode');
    }
    
    /**
     * @return point
     */
    public function coordinate()
    {
        return $this->getAttribute('coordinate');
    }
    
    /**
     * @return mixed
     */
    public function point()
    {
        return $this->getAttribute('point');
    }
    
    /**
     * @return string
     */
    public function latitude()
    {
        return ($this->point()) ? round($this->point()->latitude, 6) : null;
    }
    
    /**
     * @return string
     */
    public function longitude()
    {
        return ($this->point()) ? round($this->point()->longitude, 6) : null;
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        unset($this->attributes['coordinate']);
        return array_replace_recursive(parent::toArray(), [
            'latitude' => $this->latitude(),
            'longitude' => $this->longitude(),
        ]);
    }
    
    /**
     * Hook into the boot method to format spatial values when model is retrieved
     * 
     * @return void
     */
    public static function boot() 
    {
	parent::boot();
        
        self::updating(function (self $model) {
            unset($model->attributes['point']);
        });

	self::retrieved(function (self $model) {
            
            $point = DB::table($model->getTable())
                ->select(DB::raw('ST_X(coordinate) as latitude, ST_Y(coordinate) as longitude'))
                ->where('id', $model->id())
                ->first();
            
            $model->setAttribute('point', $point);
        });
    }
}
