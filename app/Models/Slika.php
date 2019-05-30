<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Slika {
    
    public $id;
    public $alt;
    public $putanja;
    public $id_pos;
    
    public function getSlika()
    {
        $rezultat = DB::table('slika')
                ->select('*')
                ->join('post', 'post.id_slika', '=', 'slika.id_slika')
                ->where('post.id_post', $this->id_pos)
                ->first();
        return $rezultat;
    }
    
    public function insert()
    {
        $id = DB::table('slika')
                ->insertGetId([
                    'alt' => $this->alt,
                    'putanja' => $this->putanja
                ]);
        return $id;
    }
    
    public function updatePostSlika()
    {
        if(!empty($this->putanja))
        {
            $data['slika.putanja'] = $this->putanja;
        }
        $data['slika.alt'] = $this->alt;
        $rezultat = DB::table('slika')
                ->join('post', 'post.id_slika', '=', 'slika.id_slika')
                ->where('post.id_post', $this->id_pos)
                ->update($data);
        return $rezultat;
    }
    
    public function deleteSlika()
    {
        return DB::table('slika')
                ->join('post', 'post.id_slika', '=', 'slika.id_slika')
                ->where('post.id_post', '=', $this->id_pos)
                ->delete();
    }
}