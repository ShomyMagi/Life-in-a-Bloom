<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class About {
    
    public function get()
    {
        return DB::table('about')
                ->first();
    }
}
