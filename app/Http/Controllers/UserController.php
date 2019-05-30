<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Registracija;
use App\Models\User;
use DateTime;

class UserController extends Controller {
    
    public function register(Request $request)
    {
        $rules = ([
            'korisnickoIme' => 'regex:/^[\w\d\s]{2,20}$/|unique:korisnici,korisnicko_ime',
            'ime' => 'regex:/^[A-z]{3,20}$/',
            'prezime' => 'regex:/^[A-z]{4,25}$/',
            'email' => 'regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'lozinka' => 'regex:/^[\w\d\s]{3,15}$/|confirmed',
            'avatar' => 'mimes:jpg,jpeg,png,gif|max:4000'
        ]);
        
        $custom_messages = ([
            'max' => 'Fajl ne sme biti veci od :max KB',
            'mimes' => 'Dozvoljeni formati su: :values',
            'korisnickoIme.regex' => 'Polje :attribute nije u ispravnom formatu',
            'ime.regex' => 'Polje :attribute nije u ispravnom formatu',
            'prezime.regex' => 'Polje :attribute nije u ispravnom formatu',
            'email.regex' => 'Polje :attribute nije u ispravnom formatu',
            'lozinka.regex' => 'Polje :attribute nije u ispravnom formatu',
            'korisnickoIme.unique' => 'Korisnicko ime je zauzeto'
        ]);
        
        $request->validate($rules, $custom_messages);
         
        $avatar = $request->file('slika');
        
        $tmp_putanja = $avatar->getPathName();
        $ekstenzija = $avatar->getClientOriginalExtension();
        $ime_fajla = time().'.'.$ekstenzija;
        $putanja = 'images/avatar/'.$ime_fajla;
        
        $putanja_server = $putanja;
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            File::move($tmp_putanja, $putanja_server);

            $korisnik = new Registracija();
            $korisnik->korisnicko_ime = $request->get('korisnickoIme');
            $korisnik->ime = $request->get('ime');
            $korisnik->prezime = $request->get('prezime');
            $korisnik->email = $request->get('email');
            $korisnik->lozinka = $request->get('lozinka');
            $korisnik->avatar = $putanja;
            $korisnik->registered_at = $date;
            $korisnik->updated_at = null;
            
            $korisnik->reg();
            
            return redirect('/')->with('success', 'Uspesno ste se registrovali '.$korisnik->korisnicko_ime);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri registraciji!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'korisnickoIme' => ['required','alpha_num'],
            'lozinka' => ['required']
            ], [
                'required' => 'Polje :attribute je obavezno!'
        ]);
        
        $korisnickoIme = $request->get('korisnickoIme');
        $lozinka = $request->get('lozinka');
        
        $korisnik = new Registracija();
        $korisnik->korisnicko_ime = $korisnickoIme;
        $korisnik->lozinka = $lozinka;
        
        $korisnikLogin = $korisnik->log();
        
        if(!empty($korisnikLogin))
        {
            $request->session()->push('user', $korisnikLogin);
            if(session()->get('user')[0]->naziv == 'admin')
            {
                return redirect('/admin')->with('success', 'Uspesno ste se ulogovali '.$korisnickoIme);                
            }
            else
            {
                return redirect('/user')->with('success', 'Uspesno ste se ulogovali '.$korisnickoIme);
            }               
        }
        return redirect('/register')->with('error', 'Pogresan username ili password!'); 
    }
    
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->flush();
        return redirect('/');
    }
    
    public function updateUser($id, Request $request)
    {
        $request->validate([
            'slika' => 'mimes:jpg,jpeg,png,gif|max:4000'
        ],[
            'slika.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.'
        ]);
        
        $korisnicko_ime = $request->get('korisnickoIme');
        $email = $request->get('email');
        
        $pass = $request->get('password');
        
        if(strlen($pass) == 32)
        {
            $password = $request->get('password');
        }
        else
        {
            $password = md5($request->get('password'));
        }
        
        $avatar = $request->file('slika');
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try{
            $kor = new User();
            $kor->id = $id;
            $kor->username = $korisnicko_ime;
            $kor->email = $email;
            $kor->password = $password;
            $kor->updated_at = $date;
            
            if(!empty($avatar))
            {
                $korisnik_to_update = $kor->getUser($id);
                File::delete($korisnik_to_update->avatar);

                $tmp_putanja = $avatar->getPathName();
                $ime_fajla = time().'.'.$avatar->getClientOriginalExtension();
                $putanja = 'images/avatar/'.$ime_fajla;
                $putanja_server = $putanja;

                File::move($tmp_putanja, $putanja_server);

                $kor->avatar = $putanja;
            }

                $kor->updateUser($id);
            
            return redirect('/user')->with('success','Uspesan update!');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju korisnika u bazi!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function delete($id)
    {
        $user = new User();
        $user->id = $id;
        
        try{
            $korisnik_to_delete = $user->getUser($id);
            File::delete($korisnik_to_delete->avatar);

            $user->deleteUser();
            
            return redirect('/admin')->with('success', 'Uspesno ste izbrisali korisnika ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri bisanju korisnika iz baze!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertUser(Request $request)
    {
        
        $request->validate([
            'korisnickoIme' => 'unique:korisnici,korisnicko_ime',
            'ddlUloga' => 'required|not_in:0',
            'slika' => 'required|mimes:jpg,jpeg,png,gif'
        ],[
            'slika.mimes' => 'Format nije dozvoljen!',
            'max' => 'Fajl ne sme biti veci od :max KB.',
            'required' => 'Polje :attribute je obavezno.',
            'ddlUloga.not_in' => 'Izaberite ulogu.',
            'korisnickoIme.unique' => 'Korisnicko ime je zauzeto'
        ]);
        
        $avatar = $request->file('slika');
        
        $tmp_putanja = $avatar->getPathName();
        $ekstenzija = $avatar->getClientOriginalExtension();
        $ime_fajla = time().'.'.$ekstenzija;
        $putanja = 'images/avatar/'.$ime_fajla;
        
        $putanja_server = $putanja;
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            File::move($tmp_putanja, $putanja_server);
            
            $korisnik = new User();
            $korisnik->username = $request->get('korisnickoIme');
            $korisnik->ime = $request->get('ime');
            $korisnik->prezime = $request->get('prezime');
            $korisnik->email = $request->get('email');
            $korisnik->password = $request->get('lozinka');
            $korisnik->avatar = $putanja;
            $korisnik->registered_at = $date;
            $korisnik->updated_at = null;
            $korisnik->id_uloga = $request->get('ddlUloga');
            
            $korisnik->insertUser();
            
            return redirect('/admin')->with('success', 'Uspesno ste uneli korisnika '.$korisnik->username);
            
        }
        catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri unosu korisnika!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function update($id, Request $request)
    {
        $request->validate([
           'ddlUloga' => 'not_in:0',
           'avatar' => 'mimes:jpg,jpeg,png,gif|max:4000'
        ],[
           'ddlUloga.not_in' => 'Uloga mora biti izabrana.',
           'max' => 'Fajl ne sme biti veci od :max KB',
           'mimes' => 'Dozvoljeni formati su: :values'
        ]);
        
        $korisnicko_ime = $request->get('korisnickoIme');
        $ime = $request->get('ime');
        $prezime = $request->get('prezime');
        $email = $request->get('email');
        $id_uloga = $request->get('ddlUloga');
        
        $pass = $request->get('lozinka');
        if(strlen($pass) == 32)
        {
            $password = $pass;
        }
        else
        {
            $password = md5($pass);
        }

        $avatar = $request->file('avatar');
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            $kor = new User();
            $kor->id = $id;
            $kor->username = $korisnicko_ime;
            $kor->ime = $ime;
            $kor->prezime = $prezime;
            $kor->email = $email;
            $kor->password = $password;
            $kor->updated_at = $date;
            $kor->id_uloga = $id_uloga; 

            if(!empty($avatar))
            {
                $korisnik_to_update = $kor->getUser($id);
                File::delete($korisnik_to_update->avatar);

                $tmp_putanja = $avatar->getPathName();
                $ime_fajla = time().'.'.$avatar->getClientOriginalExtension();
                $putanja = 'images/avatar/'.$ime_fajla;
                $putanja_server = $putanja;

                File::move($tmp_putanja, $putanja_server);

                $kor->avatar = $putanja;
            }

            $kor->updateAdminUser($id);
            
            return redirect('/admin')->with('success','Uspesan update korisnika! '.$kor->username);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri menjanju korisnika!');
        }
        catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
            \Log::error('Problem sa file-om '.$ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju avatara!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}