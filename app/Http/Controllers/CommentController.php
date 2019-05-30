<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;
use DateTime;

class CommentController extends Controller
{
    public function insertComment($id, Request $request)
    {
        $rules = ([
           'comment' => 'required' 
        ]);
        
        $messages = ([
           'comment.required' => 'Post some comment!' 
        ]);
        
        $request->validate($rules, $messages);
        
        $comment = $request->get('comment');
        
        if(session()->has('user'))
        {
            $id_korisnik = session()->get('user')[0]->id_korisnik;
        }
        
        $date = new DateTime();
        $date->format('d.m.Y');
        
        try
        {
            $komentar = new Comment();
            $komentar->tekst = $comment;
            $komentar->id_post = $id;
            $komentar->id_korisnik = $id_korisnik;
            $komentar->time = $date;

            $komentar->insertComment();

            return redirect('/post/'.$komentar->id_post)->with('success', 'Uspesno ste dodali komentar.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error','Greska pri unosu komentara u bazu!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error','Desila se greska..');
        }
    }
    
    public function deleteComment($id, $cId)
    {
        try
        {
            $komentar = new Comment();
        
            $komentar->id_komentar =$cId;
            $komentar->deleteComment();
            
            return redirect()->back()->with('success', 'Uspesno ste izbrisali komentar.');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri brisanju komentara iz baze!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }       
    }
    
    public function updateComment(Request $request, $id, $cId)
    {
        try
        {
            $komentar = new Comment();
            
            $tekst = $request->get('comment');
            $komentar->id_komentar = $cId;
            $komentar->tekst = $tekst;
            
            $komentar->updateComment();
            
            return redirect('/post/'.$id)->with('success','Uspesan update komentara! ');
            
        } catch (\Illuminate\Database\QueryException $ex) {
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error', 'Greska pri menjanju komentara u bazi!');
        }
        catch(\ErrorException $ex) { 
            \Log::error('Greska '.$ex->getMessage());
            return redirect()->back()->with('error', 'Desila se greska..');
        }
    }
}