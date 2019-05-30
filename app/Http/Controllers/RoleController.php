<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use DateTime;

class RoleController extends Controller{
    
    public function delete($id)
    {
        try
        {
            $role = new Role();
            $role->id = $id;

            $role->deleteRole();
            
            return redirect('/admin/role')->with('success', 'Uspesno ste izbrisali ulogu.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error','Greska pri brisanju uloga iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error','Desila se greska..');
        }
    }
    
    public function updateRole($id, Request $request)
    {
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            $naziv = $request->get('naziv');
            $role = new Role();

            $role->id = $id;
            $role->naziv = $naziv;
            $role->updated_at = $date;

            $role->updateRole($id);
            
            return redirect('/admin/role')->with('success', 'Uspesno ste promenili ulogu '.$role->naziv);
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska sa bazom pri promeni uloge!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
    
    public function insertRole(Request $request)
    {
        $request->validate([
            'naziv' => 'required'
        ],[
            'required' => 'Polje :attribute je obavezno.'
        ]);
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            $role = new Role();
            $role->naziv = $request->get('naziv');
            $role->created_at = $date;
            $role->updated_at = null;
            $rez = $role->insertRole();
            
            if($rez == 1)
            {
                return redirect('/admin/role')->with('success','Uspesno ste dodali ulogu '.$role->naziv);
            }
            else
            {
                return redirect('/admin/show/insert/role')->with('error','Niste uspeli da dodate ulogu '.$role->naziv);
            }     
        } 
        catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri unosu!');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}
