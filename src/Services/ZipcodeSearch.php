<?php

namespace Dalyio\Challenge\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ZipcodeSearch
{   
    /**
     * @param string $search
     * @return \Dalyio\Challenge\Models\Geo\Zipcode[]
     */
    public function search($search)
    {
        return \Dalyio\Challenge\Models\Geo\Zipcode::where('zipcode', 'like', '%'.$search.'%')->get();
    }
}
