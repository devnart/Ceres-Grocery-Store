<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class AdminController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->adminModel = $this->model('Admin');
    }

    public function login(){
         
        $admin = $this->adminModel->find($this->data);

        if($admin){

            $token = $this->adminAuth($admin->name, $admin->password);
            unset($admin->password);
            print_r(json_encode(array(
                'User' => $admin,
                'Token' => $token,
            )));
        }else {
            print_r(json_encode("Incorrect Password or Name !"));
        }
    }

}