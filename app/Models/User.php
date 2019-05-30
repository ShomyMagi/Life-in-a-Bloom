<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;


class User {
    
    public $id;
    public $avatar;
    public $username;
    public $ime;
    public $prezime;
    public $email;
    public $password;
    public $registered_at;
    public $updated_at;
    public $id_uloga;
    
    public function getUsers()
    {
        return DB::table('korisnici')
                ->select('*', 'korisnici.updated_at as korUpdate')
                ->join('uloge', 'uloge.id_uloga', '=', 'korisnici.id_uloga')
                ->get();
    }
    
    public function getUser($id)
    {
        $rezultat = DB::table('korisnici')
                ->select('*')
                ->join('uloge', 'uloge.id_uloga', '=', 'korisnici.id_uloga')
                ->where('id_korisnik', $id)
                ->first();
        return $rezultat;
    }

    public function deleteUser()
    {
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', $this->id)
                ->delete();
        return $rezultat;
    }
    
    public function user($id)
    {
        $rezultat = DB::table('post')
                ->select('*', 'korisnici.updated_at as profileChanged')
                ->join('slika', 'slika.id_slika', '=', 'post.id_slika')
                ->join('korisnici', 'korisnici.id_korisnik', '=', 'post.id_korisnik')
                ->where('post.id_korisnik', '=', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        return $rezultat;
    }
    
    public function userAbout($id)
    {
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', '=', $id)
                ->first();
        return $rezultat;
    }
    
    public function updateUser($id)
    {
        $data = ([
           'korisnicko_ime' => $this->username,
           'email' => $this->email,
           'lozinka' => $this->password,
           'updated_at' => $this->updated_at
        ]);
        
        if(!empty($this->avatar))
        {
            $data['avatar'] = $this->avatar;
        }
        
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', $id)
                ->update($data);
        return $rezultat;
    }
    
    public function updateAdminUser($id)
    {
        $data = ([
           'korisnicko_ime' => $this->username,
           'ime' => $this->ime,
           'prezime' => $this->prezime,
           'email' => $this->email,
           'lozinka' => $this->password,
           'updated_at' => $this->updated_at,
           'id_uloga' => $this->id_uloga
        ]);
        
        if(!empty($this->avatar))
        {
            $data['avatar'] = $this->avatar;
        }
        
        $rezultat = DB::table('korisnici')
                ->where('id_korisnik', $id)
                ->update($data);
        return $rezultat;
    }
    
    public function insertUser()
    {
        return DB::table('korisnici')
                ->insert([
                   'korisnicko_ime' => $this->username,
                   'ime' => $this->ime,
                   'prezime' => $this->prezime,
                   'email' => $this->email,
                   'lozinka' => md5($this->password),
                   'avatar' => $this->avatar,
                   'registered_at' => $this->registered_at,
                   'updated_at' => $this->updated_at,
                   'id_uloga' => $this->id_uloga
                ]);
    }
}