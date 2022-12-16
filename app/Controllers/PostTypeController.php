<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PostType;
use \Firebase\JWT\JWT;

class PostTypeController extends BaseController
{

    use ResponseTrait;

    public function index()
    {
        //
        $post_type = new PostType;
        return $this->respond(['post_type' => $post_type->findAll()], 200);
    }

    public function get(){
        
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
