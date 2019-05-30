<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Comment {
    
    public $id_komentar;
    public $tekst;
    public $id_post;
    public $id_korisnik;
    public $time;
    
    public function insertComment()
    {
        return DB::table('komentar')
                ->insert([
                   'tekst' => $this->tekst,
                   'id_post' => $this->id_post,
                   'id_korisnik' => $this->id_korisnik,
                   'time' => $this->time
                ]);
    }
    
    public function getAll($id)
    {
        return DB::table('komentar')
            ->select('*')    
            ->join('korisnici', 'komentar.id_korisnik', '=', 'korisnici.id_korisnik')
            ->join('post AS p', 'p.id_post', '=', 'komentar.id_post')
            ->join('slika', 'slika.id_slika', '=', 'p.id_slika')
            ->where('p.id_post', '=', $id)
            ->orderBy('time', 'desc')
            ->get();
    }
    
    public function get()
    {
        return DB::table('komentar')
                ->select('*')
                ->where('id_komentar', $this->id_komentar)
                ->first();
    }
    
    public function deleteComment()
    {
        return DB::table('komentar')
                ->where('id_komentar', $this->id_komentar)
                ->delete();
    }
    
    public function updateComment()
    {
        $rezultat = DB::table('komentar')
                ->where('id_komentar', $this->id_komentar)
                ->update([
                    'tekst' => $this->tekst
                ]);
        return $rezultat;
    }
}