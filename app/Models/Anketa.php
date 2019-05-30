<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Anketa {
    
    public $id_user;
    public $id_anketa;
    public $id_odgovor;
    public $odgovor;
    public $odgovor1;
    public $response;
    public $response1;
    public $pitanje;
    public $created_at;
    public $updated_at;
    
    public function show()
    {
        return DB::table('anketa')
                ->select('*', 'anketa.id_anketa as idAnketa','odgovori.id_odgovor as idOdgovor')
                ->join('odgovori', 'odgovori.id_anketa', '=', 'anketa.id_anketa')
                ->where('active', '=', 1)
                ->get();
    }
    
    public function showAnketa(){
        return DB::table('anketa')
                ->get();
    }
    
    public function findUser()
    {
        return DB::table('anketa_vezna')
                ->join('anketa', 'anketa.id_anketa', '=', 'anketa_vezna.id_anketa')
                ->where([
                    ['anketa_vezna.id_user', '=', $this->id_user],
                    ['anketa.active', '=', 1]
                ])
                ->first();
    }
    
    public function insertVote()
    {
        return DB::table('anketa_vezna')
                ->insertGetId([
                    'id_anketa' => $this->id_anketa,
                    'id_user' => $this->id_user
                ]);
    }
    
    public function incResponse()
    {
        return DB::table('odgovori')
                ->where('id_odgovor', '=', $this->id_odgovor)
                ->increment('br_glasova', 1);
    }
    
    public function insertResponse()
    {
        return DB::table('odgovori')
                ->insert([
                    'id_anketa' => $this->id_anketa,
                    'odgovor' => $this->odgovor,
                    'br_glasova' => 0
                ]);
    }
    
    public function insertResponse1()
    {
        return DB::table('odgovori')
                ->insert([
                    'id_anketa' => $this->id_anketa,
                    'odgovor' => $this->odgovor1,
                    'br_glasova' => 0
                  
                ]);
    }
    
     public function insertPoll()
    {
        return DB::table('anketa')
                ->insertGetId([
                    'pitanje' => $this->pitanje,
                    'active' => 0,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at
                ]);
    }
    
    public function updatePoll()
    {
        return DB::table('anketa')
                ->where('id_anketa', '=', $this->id_anketa)
                ->update([
                    'pitanje' => $this->pitanje,
                    'updated_at' => $this->updated_at
                ]);
    }
    
    
    public function getPoll()
    {
        return DB::table('anketa')
                ->select('*', 'anketa.id_anketa as idAnketa', 'odgovori.id_odgovor as idOdg')
                ->join('odgovori', 'odgovori.id_anketa', '=', 'anketa.id_anketa')
                ->where('anketa.id_anketa', '=', $this->id_anketa)
                ->get();
    }
    
    public function updateResponse()
    {
        return DB::table('odgovori')
                ->where([
                    'id_anketa' => $this->id_anketa,
                    'id_odgovor' => $this->id_response
                ])
                ->update([
                   'odgovor' => $this->odgovor
                ]);
    }
    
    public function updateResponse1()
    {
        return DB::table('odgovori')
                ->where([
                    'id_anketa' => $this->id_anketa,
                    'id_odgovor' => $this->id_response1
                ])
                 ->update([
                   'odgovor' => $this->odgovor1
                ]);
    }
    
    public function delete(){
        return DB::table('anketa')
                ->where('id_anketa', $this->id_anketa)
                ->delete();
    }
    
    public function activate()
    {
        return DB::table('anketa')
                ->where('id_anketa', '=', $this->id_anketa)
                ->update([
                    'active' => 1
                ]);
    }
    
    public function deactivate()
    {
        return DB::table('anketa')
                ->update([
                    'active' => 0
                ]);
    }
}
