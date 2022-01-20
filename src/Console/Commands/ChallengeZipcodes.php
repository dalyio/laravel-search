<?php

namespace Dalyio\Challenge\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChallengeZipcodes extends Command
{
    /**
     * @var string
     */
    protected $signature = 'challenge:zipcodes {filename}';

    /**
     * @var string
     */
    protected $description = 'Import the zipcode coordinate data';
    
    /**
     * @var array
     */
    protected $config = [];
    
    /**
     * @var string
     */
    private $directory = '/storage/bin';

    /**
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        if ($filepath = $this->filepath()) {
            
            $content = File::get($filepath);
            $lines = preg_split("/\r\n|\n|\r/", $content);
            $columns = array_map(function($column) {
                return trim($column, '"');
            }, explode(",", array_shift($lines)));
            
            foreach ($lines as $key => $zipcodeString) {
                $zipcodeArray = array_combine($columns, explode(",", $zipcodeString));
                
                $zipcode = \Dalyio\Challenge\Models\Geo\Zipcode::updateOrCreate([
                    'zipcode' => trim($zipcodeArray['zipcode'], '"'),
                ], [
                    'coordinate' => DB::raw("GeomFromText('POINT(".trim($zipcodeArray['latitude'], '"')." ".trim($zipcodeArray['longitude'], '"').")')"),
                ]);
                
                $this->line($zipcode->zipcode().' was created');
            }
        }
    }
    
    protected function filepath()
    {
        return realpath(base_path($this->directory).DIRECTORY_SEPARATOR.$this->argument('filename'));
    }
}
