<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Post {
    
    public $id;
    public $naslov;
    public $id_korisnik;
    public $id_slika;
    public $created_at;
    public $updated_at;
    public $putanja;
    public $ip;
    
    public function getAll()
    {
        $rezultat = DB::table('post')
                ->select('*', 'post.created_at as postCreated', 'post.updated_at as postUpdated')
                ->join('slika', 'slika.id_slika', '=', 'post.id_slika')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'post.id_korisnik')
                ->orderBy('created_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function getPost($id)
    {
        $rezultat = DB::table('post')
                ->select('*', 
                        'korisnici.korisnicko_ime as postKorisnik',
                        'k.korisnicko_ime as komentarKorisnik',
                        \DB::raw("(SELECT count(id_pregled) FROM pregledi WHERE id_post = $id) as views"))
                ->join('slika', 'slika.id_slika', '=', 'post.id_slika')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'post.id_korisnik')
                ->leftJoin('komentar', 'post.id_post', '=', 'komentar.id_post')
                ->leftJoin('korisnici AS k', 'k.id_korisnik', '=', 'komentar.id_korisnik')
                ->where('post.id_post', $id)
                ->first();
        return $rezultat;           
    }
    
    public function Post($id)
    {
        $rezultat = DB::table('post')
                ->select('*')
                ->join('slika', 'slika.id_slika', '=', 'post.id_slika')
                ->where('post.id_post', $id)
                ->first();
        return $rezultat;
    }
    
    public function insertPost()
    {
        $rezultat = DB::table('post')
                ->insert([
                   'naslov' =>  $this->naslov,
                   'id_slika' => $this->id_slika,
                   'id_korisnik' => $this->id_korisnik,
                   'created_at' => $this->created_at,
                   'updated_at' => $this->updated_at
                ]);
        return $rezultat;
    }
    
    public function updatePost()
    {
        $data['naslov'] = $this->naslov;
        $data['updated_at'] = $this->updated_at;
        
        $rezultat = DB::table('post')
                ->where('id_post', $this->id)
                ->update($data);
        return $rezultat;
    }
    
    public function deletePost()
    {
        $rezultat = DB::table('post')
                ->where('id_post', $this->id)
                ->delete();
        return $rezultat;
    }
    
    public function views($id, $ip)
    {
        return DB::table('pregledi')
            ->insert([
                'ip' => $ip,
                'id_post' => $id
            ]);
    }
}