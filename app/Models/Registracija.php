<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Registracija {
     
    public $korisnicko_ime;
    public $ime;
    public $prezime;
    public $email;
    public $lozinka;
    public $avatar;
    public $registered_at;
    public $updated_at;
    
    public function reg()
    {
        $rezultat = DB::table('korisnici')
                ->insert([
                    'korisnicko_ime' => $this->korisnicko_ime,
                    'ime' => $this->ime,
                    'prezime' => $this->prezime,
                    'email' => $this->email,
                    'lozinka' => md5($this->lozinka),
                    'avatar' => $this->avatar,
                    'id_uloga' => 2,
                    'registered_at' => $this->registered_at,
                    'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function log()
    {
        $rezultat = DB::table('korisnici')
                ->select('korisnici.*', 'uloge.naziv')
                ->join('uloge', 'uloge.id_uloga', '=', 'korisnici.id_uloga')
                ->where([
                    'korisnicko_ime' => $this->korisnicko_ime,
                    'lozinka' => md5($this->lozinka)
                ])
                ->first();
        return $rezultat;
    }
}