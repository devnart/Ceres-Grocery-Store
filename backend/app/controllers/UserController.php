<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST,PUT');
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

        if ($this->userModel->storeClient($this->data)) {
            print_r(json_encode("Registred Sucssefully"));
        }
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
    // check jwt token
    public function checkToken()
    {
        $token = $this->data['token'];

        try {
            if ($this->verifyAuth($token)) {
                print_r(json_encode("valid"));
            }
        } catch (\Throwable $th) {
            //throw $th;
            print_r(json_encode(array(
                "error" => "unauthorized" . $th->getMessage(),
            )));
        }
    }
    // get user by id
    public function getUser()
    {
        $id = $this->data['id'];
        $user = $this->userModel->getUser($id);
        if ($user) {
            print_r(json_encode($user));
        } else {
            print_r(json_encode(false));
        }
    }

    // get all clients
    public function getAllClients()
    {
        $clients = $this->userModel->getAllClients();
        if ($clients) {
            print_r(json_encode($clients));
        } else {
            print_r(json_encode("No clients found"));
        }
    }
    // pagination
    public function getAll()
    {
        $page =  $this->data['page'];
        $limit =  7;
        $offset = ($page - 1) * $limit;
        $users = $this->userModel->getAll($limit, $offset);

        if ($users) {
            $pages = ceil($users[1] / $limit);

            print_r(json_encode(
                array(
                    'users' => $users[0],
                    'pages' => $pages,
                )
            ));
        } else {
            print_r(json_encode("No users found"));
        }
    }

    // get last 4 clients
    public function getLast4Clients()
    {
        $clients = $this->userModel->getLast4Clients();
        if ($clients) {
            print_r(json_encode($clients));
        } else {
            print_r(json_encode("No clients found"));
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
                    print_r('success');
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
    // update avatar
    public function updateAvatar($id)
    {
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                $this->verifyAuth($headers[1]);
                $filename = $_FILES["uploadfile"]["name"];
                $tempname = $_FILES["uploadfile"]["tmp_name"];
                $folder = "./img/" . $filename;

                if (move_uploaded_file($tempname, $folder)) {
                    $msg = "Image uploaded successfully";
                } else {
                    $msg = "Failed to upload image";
                }

                $this->userModel->updateAvatar($id, $filename);
                print_r(json_encode($msg));
            } catch (Throwable $th) {
                print_r(json_encode(array(
                    "unauthorized Token",
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
                        print_r(json_encode('success'));
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

    public function checkEmail()
    {
        $checkEmail = $this->userModel->checkEmail($this->data);

        if ($checkEmail >= 1) {
            print_r(json_encode(true));
        } else {
            print_r(json_encode(false));
        }
    }

    public function delete($id)
    {
        header('Access-Control-Allow-Methods: DELETE');

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
