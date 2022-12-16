<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\User;
use \Firebase\JWT\JWT;

class UserController extends BaseController
{

    use ResponseTrait;
     
    public function login()
    {
        $userModel = new User();
  
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
          
        $user = $userModel->where('email', $email)->first();
  
        if(is_null($user)) {
            return $this->respond(['error' => 'User with following email not found'], 401);
        }
  
        $pwd_verify = password_verify($password, $user['password']);
  
        if(!$pwd_verify) {
            return $this->respond(['error' => 'Invalid password.'], 401);
        }
 
        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;
 
        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user['email'],
        );
         
        $token = JWT::encode($payload, $key, 'HS256');
 
        $response = [
            'message' => 'Login Succesful',
            'user' => $user,
            'token' => $token
        ];
         
        return $this->respond($response, 200);
    }

    public function register()
    {
        $rules = [
            'fullname' => ['rules' => 'required|max_length[255]'],
            'phone' => ['rules' => 'required|min_length[10]|max_length[14]|is_unique[users.phone]'],
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'],
            'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
            'confirm_password'  => [ 'label' => 'confirm password', 'rules' => 'matches[password]']
        ];
            
  
        if($this->validate($rules)){
            $model = new User();
            $data = [
                'fullname' => $this->request->getVar('fullname'),
                'phone'    => $this->request->getVar('phone'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);
             
            return $this->respond(['message' => 'Registered Successfully',
                                    'data'   => $data], 200);
        }else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 409);
             
        }
            
    }

    public function index()
    {
        //
        $users = new User;
        return $this->respond(['users' => $users->findAll()], 200);
        
    }
}
