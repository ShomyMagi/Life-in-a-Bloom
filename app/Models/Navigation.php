<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;


class Navigation {
    
    public $id;
    public $naziv;
    public $putanja;
    public $created_at;
    public $updated_at;
    
    public function all()
    {
        return DB::table('navigacija')
                ->get();
    }
    
    public function getAll()
    {
        return DB::table('navigacija')
                ->whereNotIn('id_navigacija', [6,7,8])
                ->get();
    }
    
    public function getUser()
    {
        return DB::table('navigacija')
                ->whereNotIn('id_navigacija', [5,7])
                ->get();
    }
    
    public function getAdmin()
    {
        return DB::table('navigacija')
                ->whereNotIn('id_navigacija', [5])
                ->get();
    }
    
    public function getNav($id)
    {
        $rezultat = DB::table('navigacija')
                ->select('*')
                ->where('id_navigacija', $id)
                ->first();
        return $rezultat;
    }
    
    public function updateNav($id)
    {
        $data = ([
           'naziv' => $this->naziv,
           'putanja' => $this->putanja,
           'updated_at' => $this->updated_at
        ]);
        
        $rezultat = DB::table('navigacija')
                ->where('id_navigacija', $id)
                ->update($data);
        return $rezultat;
    }
    
    public function deleteNav()
    {
        $rezultat = DB::table('navigacija')
                ->where('id_navigacija', $this->id)
                ->delete();
        return $rezultat;
    }
    
    public function insertNav()
    {
        $rezultat = DB::table('navigacija')
                ->insert([
                   'naziv' =>  $this->naziv,
                   'putanja' => $this->putanja,
                   'created_at' => $this->created_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
}