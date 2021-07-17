<?php
    class Appointments extends Controller {
        public $data = [];

        public function __construct() {
            $this->appointmentModel = $this->model('Appointment');
        }

        public function index(){
            $headers = apache_request_headers();
            $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
            if ($headers) {
                try {
                    $this->verifyAuth($headers[1]);
                    $appointments = $this->appointmentModel->readByRef($this->data);
                    $data = [
                        'appointments' => $appointments
                    ];
                } catch (Throwable $th) {
                    print_r(json_encode(array(
                        "error" => "unauthorized",
                    )));
                }
            }else{
                print_r(json_encode(array(
                    "error" => "unauthorized",
                )));
            }
            echo json_encode($data['appointments']);
        }

        public function indexByDate(){
            $headers = apache_request_headers();
            $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
            if ($headers) {
                try {
                    $this->verifyAuth($headers[1]);
                    $appointments= $this->appointmentModel->getByDate($this->data);
                    $data = [
                        'appointments' => $appointments
                    ];
                } catch (Throwable $th) {
                    print_r(json_encode(array(
                        "error" => "unauthorized1",
                    )));
                }
            }else{
                print_r(json_encode(array(
                    "error" => "unauthorized2",
                )));
            }
            echo json_encode($data['appointments']);
        }

        public function create(){
            $headers = apache_request_headers();
            $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
            if ($headers) {
                try {
                    $this->verifyAuth($headers[1]);
                    $this->appointmentModel->store($this->data);
                } catch (Throwable $th) {
                    print_r(json_encode(array(
                        "error" => "unauthorized1",
                    )));
                }
            }else{
                print_r(json_encode(array(
                    "error" => "unauthorized2",
                )));
            }
        }

        public function edit(){
            $headers = apache_request_headers();
            $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
            if ($headers) {
                try {
                    $this->verifyAuth($headers[1]);
                    $this->appointmentModel->update($this->data);
                } catch (Throwable $th) {
                    print_r(json_encode(array(
                        "error" => "unauthorized",
                    )));
                }
            }else{
                print_r(json_encode(array(
                    "error" => "unauthorized",
                )));
            }
        }

        public function delete(){
            $headers = apache_request_headers();
            $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
            if ($headers) {
                try {
                    $this->verifyAuth($headers[1]);
                    $this->appointmentModel->delete($this->data);
                } catch (Throwable $th) {
                    print_r(json_encode(array(
                        "error" => "unauthorized",
                    )));
                }
            }else{
                print_r(json_encode(array(
                    "error" => "unauthorized",
                )));
            }
        }
    }