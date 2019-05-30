<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Slika;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use DateTime;

class PostController extends COntroller {
    
    public function insertPost(Request $request)
    {
        
        $request->validate([
            'slika' => 'required|mimes:jpg,jpeg,png,gif|max:4000',
            'naziv' => 'required'
        ],[
            'mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.',
            'required' => 'Polje :attribute je obavezno.'
        ]);
        
        $photo = $request->file('slika');
        
        $tmp_putanja = $photo->getPathName();
        $ekstenzija = $photo->getClientOriginalExtension();
        $ime_fajla = time().'.'.$ekstenzija;
        $putanja = 'images/'.$ime_fajla;
        
        $putanja_server = $putanja;
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            File::move($tmp_putanja, $putanja_server);
            
            $slika = new Slika();
            $slika->alt = $ime_fajla;
            $slika->putanja = $putanja;
            $slika_id = $slika->insert();

            $post = new Post();
            $post->naslov = $request->get('naziv');
            $post->id_slika = $slika_id;
            $post->id_korisnik = session()->get('user')[0]->id_korisnik;
            $post->created_at = $date;
            $post->insertPost();

            return redirect('/user')->with('success','Uspesno ste dodali post '.$post->naslov);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri unosu posta u bazu!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertAdminPost(Request $request)
    {
        $request->validate([
            'slika' => 'required|mimes:jpg,jpeg,png,gif|max:4000',
            'ddlKorisnik' => 'required|not_in:0',
            'naziv' => 'required'
        ],[
            'slika.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.',
            'required' => 'Polje :attribute je obavezno.',
            'ddlKorisnik.not_in' => 'Izaberite korisnika!'
        ]);
                
        
        $photo = $request->file('slika');
        
        $tmp_putanja = $photo->getPathName();
        $ekstenzija = $photo->getClientOriginalExtension();
        $ime_fajla = time().'.'.$ekstenzija;
        $putanja = 'images/'.$ime_fajla;
        
        $putanja_server = $putanja;
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            File::move($tmp_putanja, $putanja_server);
            
            $slika = new Slika();
            $slika->alt = $ime_fajla;
            $slika->putanja = $putanja;
            $slika_id = $slika->insert();

            $post = new Post();
            $post->naslov = $request->get('naziv');
            $post->id_slika = $slika_id;
            $post->id_korisnik = $request->get('ddlKorisnik');
            $post->created_at = $date;
            $post->updated_at = null;
            $post->insertPost();
            
            return redirect('/admin/post')->with('success','Uspesno ste dodali post '.$post->naslov);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri unosu posta u bazu!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updatePost($id, Request $request)
    {
        $request->validate([
            'slika' => 'mimes:jpg,jpeg,png,gif|max:4000'
        ],[
            'slika.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.'
        ]);
        
        $slikaPutanja = $request->file('slika');
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        { 
            if(!empty($slikaPutanja))
            {     
                $slika = new Slika();
                $slika->id_pos = $id;
                
                $slika_to_update = $slika->getSlika();
                File::delete($slika_to_update->putanja);

                $tmp_putanja = $slikaPutanja->getPathName();
                $ime_fajla = time().'.'.$slikaPutanja->getClientOriginalExtension();
                $putanja = 'images/'.$ime_fajla;
                $putanja_server = $putanja;

                File::move($tmp_putanja, $putanja_server);

                $slika->putanja = $putanja;
                $slika->alt = $ime_fajla;
                
                $slika->updatePostSlika();
            }
            
            $naslov = $request->get('naslov'); 
            $new = new Post();

            $new->id = $id;
            $new->naslov = $naslov;
            $new->updated_at = $date;

            $new->updatePost();

            return redirect('/admin/post')->with('success','Uspesan update post-a! '.$new->naslov);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri menjanju post-a!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function deletePost($id)
    {
        $postUser = new Post();
        $postUser->id = $id;
        
        $slikaUser = new Slika();
        $slikaUser->id_pos = $id;
        
        try
        {
            $post_to_delete = $slikaUser->getSlika();
            File::delete($post_to_delete->putanja);

            $slikaUser->deleteSlika();
            $postUser->deletePost();
            
            return redirect('/user')->with('success', 'Uspesno ste izbrisali post.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju slike iz baze!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function delete($id)
    {
        $post = new Post();
        $post->id = $id;
        
        $slika = new Slika();
        $slika->id_pos = $id;
        
       try{
            $post_to_delete = $slika->getSlika();
            File::delete($post_to_delete->putanja);

            $slika->deleteSlika();
            $post->deletePost();
            
            return redirect('/admin/post')->with('success', 'Uspesno ste izbrisali post ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju slike iz baze!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju slike!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}