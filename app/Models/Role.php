<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Role {
    
    public $id;
    public $naziv;
    public $created_at;
    public $updated_at;
    
    public function getAll()
    {
        return DB::table('uloge')
                ->get();
    }
    
    public function getRole($id)
    {
        $rezultat = DB::table('uloge')
                ->select('*')
                ->where('id_uloga', $id)
                ->first();
        return $rezultat;
    }
    
    public function deleteRole()
    {
        $rezultat = DB::table('uloge')
                ->where('id_uloga', $this->id)
                ->delete();
        return $rezultat;
    }
    
    public function insertRole()
    {
        $rezultat = DB::table('uloge')
                ->insert([
                   'naziv' =>  $this->naziv,
                   'created_at' => $this->created_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function updateRole($id)
    {
        $data = ([
           'naziv' => $this->naziv,
           'updated_at' => $this->updated_at
        ]);
        
        $rezultat = DB::table('uloge')
                ->where('id_uloga', $id)
                ->update($data);
        return $rezultat;
    }
}
