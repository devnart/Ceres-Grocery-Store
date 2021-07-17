<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class UserController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {

        $this->userModel->storeClient($this->data);
    }

    public function find()
    {

        $user = $this->userModel->find($this->data);
        if ($user) {

            $token = $this->userAuth($user->name, $user->password);
            unset($user->password);
            print_r(json_encode(array(
                'User' => $user,
                'Token' => $token,
            )));
        } else {
            print_r(json_encode("Incorrect Password or Name !"));
        }
    }

    public function update($id)
    {



        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $this->verifyAuth($headers[1]);
                $update = $this->userModel->updateClientInfo($this->data, $id);
                if ($update) {
                    print_r('Success! ');
                }
            } catch (Throwable $th) {
                print_r(json_encode(array(
                    "error" => "unauthorized1",
                )));
            }
        } else {
            print_r(json_encode(array(
                "error" => "unauthorized2",
            )));
        }
    }

    public function updatePassword($id)
    {


        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {

                // role management 
                $verify = $this->verifyAuth($headers[1]);
                $exploaded = get_object_vars($verify);
                print_r($exploaded['admin']);

                $checkPassword = $this->userModel->checkPassword($this->data, $id);

                if ($checkPassword) {

                    $updatePassword = $this->userModel->updateClientPassword($this->data, $id);
                    if ($updatePassword) {
                        print_r('Password Updated Successfully ! ');
                    }
                } else {
                    print_r(json_encode('The current password is incorrect. Please try again'));
                }
            } catch (Throwable $th) {
                print_r(json_encode(array(
                    "error" => "unauthorized1",
                )));
            }
        } else {
            print_r(json_encode(array(
                "error" => "unauthorized2",
            )));
        }
    }

    public function checkpassword($id)
    {
        $checkp = $this->userModel->checkPassword($this->data, $id);
        if ($checkp) {
            print_r(json_encode($checkp . 'true'));
        } else {
            print_r(json_encode($checkp . 'false'));
        }
    }

    public function delete($id)
    {

        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                // role management
                $verify = $this->verifyAuth($headers[1]);
                $exploaded = get_object_vars($verify);

                if ($exploaded['admin']) {

                    // *** The Important Stuff *** //

                    $this->userModel->deleteUser($id);
                    print_r(json_encode('Client Deleted Successfully'));
                } else {
                    print_r(json_encode(array(
                        "error" => "401",
                    )));
                }
            } catch (Throwable $th) {
                print_r(json_encode(array(
                    "error" => "unauthorized1",
                )));
            }
        } else {
            print_r(json_encode(array(
                "error" => "unauthorized2",
            )));
        }
    }
}
