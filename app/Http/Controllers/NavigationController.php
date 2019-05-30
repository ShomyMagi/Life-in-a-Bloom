<?php

namespace App\Http\Controllers;
use App\Models\Navigation;
use Illuminate\Http\Request;
use DateTime;

class NavigationController extends Controller {

    public function delete($id)
    {
        try
        {
            $nav = new Navigation();
        
            $nav->id = $id;
            $nav->deleteNav();

            return redirect()->back()->with('success', 'Uspesno ste izbrisali meni u navigaciji.');
        
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju menija iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function updateNav($id, Request $request)
    {
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            $naziv = $request->get('naziv');
            $putanja = $request->get('putanja');
            $navigation = new Navigation();

            $navigation->id = $id;
            $navigation->naziv = $naziv;
            $navigation->putanja = $putanja;
            $navigation->updated_at = $date;

            $navigation->updateNav($id);

            return redirect('/admin/navigation')->with('success', 'Uspesno ste promenili meni '.$navigation->naziv);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri promeni menija!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertNav(Request $request)
    {   
        $request->validate([
            'naziv' => 'required',
            'putanja' => 'required'
        ],[
            'required' => 'Polje :attribute je obavezno.'
        ]);
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            $nav = new Navigation();
            $nav->naziv = $request->get('naziv');
            $nav->putanja = $request->get('putanja');
            $nav->created_at = $date;
            $nav->updated_at = null;
            
            $nav->insertNav();
            
            return redirect('/admin/navigation')->with('success','Uspesno ste dodali meni u navigaciji '.$nav->naziv);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri unosu menija u bazu!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}