<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Post;
use App\Models\User;
use App\Models\PostType;
use \Firebase\JWT\JWT;


class PostController extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        //
        $post = new Post;
        return $this->respond(['post' => $post->findAll()], 200);
    }

    public function show($id){
        $post = new Post;
        $post_type = new PostType;
        $user = new User;
        $post = $post->where('id', $id)->first();

        return $this->respond(['post' => $post], 200);
    }

    public function create(){
        //
    }

    public function update(){
        //
    }

    public function delete(){
        //
    }
}
