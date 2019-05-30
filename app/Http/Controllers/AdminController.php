<?php

namespace App\Http\Controllers;
use App\Models\Navigation;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Role;
use App\Models\Anketa;

class AdminController extends Controller
{
    public $data;
    
    public function __construct() {
        $nav = new Navigation();
        $this->data['allNav'] = $nav->all();
        $this->data['all'] = $nav->getAll();
        $this->data['user'] = $nav->getUser();
        $this->data['admin'] = $nav->getAdmin();
    }
    
    public function getUsers()
    {
        try
        {
            $users = new User();
            $this->data['users'] = $users->getUsers();
            return view('admin.admin_users', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function getPosts()
    {
        try
        {
            $post = new Post();
            $this->data['posts'] = $post->getAll();
            return view('admin.admin_posts', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function getNavigations()
    {
        try
        {
            return view('admin.admin_nav', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function getRoles()
    {
        try
        {
            $role = new Role();
            $this->data['roles'] = $role->getAll();
            return view('admin.admin_roles', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function getPoll()
    {
        try
        {
            $poll = new Anketa();
            $this->data['polls'] = $poll->showAnketa();
            return view('admin.admin_poll', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showFormUser()
    {
        try
        {
            $role = new Role();
            $this->data['roles'] = $role->getAll();
            return view('admin.admin_insert_user', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showFormPost()
    {
        try
        {
            $getUser = new User();
            $this->data['allUsers'] = $getUser->getUsers();
            return view('admin.admin_insert_post', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showFormNav()
    {
        try
        {
            return view('admin.admin_insert_nav', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showFormRole()
    {
        try
        {
            return view('admin.admin_insert_role', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showFormPoll()
    {
        try
        {
            return view('admin.admin_insert_poll', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showUserForm($id)
    {
        try
        {
            $s = new User();
            $t = new Role();
            $this->data['showKor'] = $s->getUser($id);
            $this->data['roles'] = $t->getAll();
            return view('admin.admin_update_user', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showPostForm($id)
    {
        try
        {
            $p = new Post();
            $this->data['showPost'] = $p->Post($id);
            return view('admin.admin_update_post', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showNavForm($id)
    {
        try
        {
            $n = new Navigation();
            $this->data['showNav'] = $n->getNav($id);
            return view('admin.admin_update_nav', $this->data);
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showRoleForm($id)
    {
        try
        {
            $r = new Role();
            $this->data['showRole'] = $r->getRole($id);
            return view('admin.admin_update_role', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function showPollForm($id)
    {
        try
        {
            $p = new Anketa();
            $p->id_anketa = $id;
            $this->data['showPoll'] = $p->getPoll();
            return view('admin.admin_update_poll', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
    
    public function getGallery()
    {
        try
        {
            $galerija = new Post();
            $this->data['slike'] = $galerija->getAll();
            return view('pages.gallery', $this->data);
            
        } catch (\Exception $ex) {
            \Log::error($ex->getMessage());
        }
    }
}