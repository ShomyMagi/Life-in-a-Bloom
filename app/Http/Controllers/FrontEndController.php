<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Navigation;
use App\Models\Post;
use App\Models\About;
use App\Models\User;
use App\Models\Comment;
use App\Models\Anketa;

class FrontEndController extends Controller {
    
    public $data;
    
    public function __construct() {
        $nav = new Navigation();
        $this->data['all'] = $nav->getAll();
        $this->data['user'] = $nav->getUser();
        $this->data['admin'] = $nav->getAdmin();
    }
    public function index()
    {
        try
        {
            $post = new Post();
            $this->data['posts'] = $post->getAll();
            return view('pages.index', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
        
    }
    public function getPost(Request $request, $id, $cId = null)
    {
        try
        {
            $post = new Post();
            $comm = new Comment();
            $comm->id_komentar = $cId;
            $post->views($id, $request->ip());
            $this->data['singlePost'] = $post->getPost($id);
            $this->data['onePost'] = $post->Post($id);
            $this->data['singleComm'] = $comm->getAll($id);
            $this->data['selectedComm'] = $comm->get();
            return view('pages.onePost', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    public function getRegister()
    {
        try
        {
            return view('pages.register', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    public function about(Request $request)
    {
        if($request->session()->has('user'))
        {
            $idUser = $request->session()->get('user')[0]->id_korisnik;
            $anketa = new Anketa();
            $anketa->id_user = $idUser;
            $rez = $anketa->findUser();
            if($rez)
            {
                $this->data['rez'] = $rez;
            }
            else
            {
                $this->data['rez'] = $rez;
            }
        }
        try
        {
            $about = new About();
            $this->data['me'] = $about->get();
            return view('pages.about', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    public function user()
    {
        try
        {
            $user = new User();
            if(session()->has('user'))
            {
                $id = session()->get('user')[0]->id_korisnik;
                $this->data['showKor'] = $user->user($id);
                $this->data['showAbout'] = $user->userAbout($id);
                return view('pages.user', $this->data);
            }
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    public function showUser($id)
    {
        try
        {
            $u = new User();
            $this->data['showUser'] = $u->getUser($id);
            return view('pages.userUpdate', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showAnketa()
    {
        try{
            $anketa = new Anketa();
            $mojaAnketa = $anketa->show();
            return response($mojaAnketa, 200);
    	}
    	catch(\Exception $ex){
            \Log::error('Greska: ' . $ex->getMessage());
            return response(null, 500);
    	}
    }
    
    public function download(){
        $headers = array(
          'Content-Type: application/pdf',
        );
        return response()->download(public_path('Dokumentacija.pdf'), 'Dokumentacija.pdf', $headers);
    }
}