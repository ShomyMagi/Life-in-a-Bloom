<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Anketa;
use DateTime;

class AnketaController extends Controller
{
    public function storeVote(Request $request)
    {
        $anketa = new Anketa();
        $anketa->id_user = $request->get('id_user');
        $anketa->id_anketa = $request->get('id_anketa');
        $anketa->id_odgovor = $request->get('id_odgovor');
        
        try {
            $rez = $anketa->insertVote();
            $anketa->incResponse();
            return response($rez, 200);
         } catch (\Exception $ex) {
            \Log::error('Moja greska: '.$ex->getMessage());
            return response(500);
        }
    }
    
    public function insertPoll(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'response' => 'required',
            'response1' => 'required'
        ],[
            'question.required' => 'Pitanje je obavezno!',
            'response.required' => 'Odgovor 1 je obavezan!',
            'response1.required' => 'Odgovor 2 je obavezan!',
        ]);
        
        $question = $request->get('question');
        $response = $request->get('response');
        
        $response1 = $request->get('response1');
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try {
            $anketa = new Anketa();
            $anketa->pitanje = $question;
            $anketa->odgovor = $response;
            $anketa->odgovor1 = $response1;
            $anketa->created_at = $date;
            $anketa->updated_at = null;
            $anketa->id_anketa = $anketa->insertPoll();
            $anketa->insertResponse();
            $anketa->insertResponse1();
            
            return redirect('/admin/poll')->with('success', 'Uspesno ste dodali anketu.');
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri dodavanju ankete!');
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'response' => 'required',
            'response1' => 'required'
        ],[
           'question.required' => 'Pitanje je obavezno!', 
           'response.required' => 'Odgovor 1 je obavezan!', 
           'response1.required' => 'Odgovor 2 je obavezan!', 
        ]);
        
        $question = $request->get('question');
        $response = $request->get('response');
        $response1 = $request->get('response1');
        $idRes = $request->get('odg');
        $idRes1 = $request->get('odg1');
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try {
            $anketa = new Anketa();
            $anketa->id_anketa = $id;
            $anketa->pitanje = $question;
            $anketa->updated_at = $date;
            $anketa->id_response = $idRes;
            $anketa->id_response1 = $idRes1;
            $anketa->odgovor = $response;
            $anketa->odgovor1 = $response1;
            
            $anketa->updateResponse();
            $anketa->updateResponse1();
            
            $anketa->updatePoll();
            

            return redirect('/admin/poll')->with('success', 'Anketa uspesno promenjena.');

        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju ankete!');
        }
    }
    
    public function delete($id)
    {
        $anketa = new Anketa();
        $anketa->id_anketa = $id;
        
        $anketa->delete();
        
       try{
            return redirect('/admin/poll')->with('success', 'Uspesno brisanje ankete.');
        }
        catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska prilikom brisanja ankete!');
        }
    }
    
    public function active($id)
    {
        try {
            
            $anketa = new Anketa();
            $anketa->id_anketa = $id;
            $anketa->deactivate();
            $anketa->activate();
            
            return redirect('/admin/poll')->with('success', 'Aktivirana anketa.');

        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska!');
        }
    }
}
