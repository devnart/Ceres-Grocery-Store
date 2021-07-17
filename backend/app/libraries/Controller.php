<?php
    require_once '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    //Load the model and the view
    class Controller {
        protected $key = "test@123";

        public function model($model) {
            //Require model file
            require_once '../app/models/' . $model . '.php';
            //Instantiate model
            return new $model();
        }

        public function userAuth($reference, $hash)
        {
            $iat = time();
            $exp = $iat + 60 * 60;
            $payload = array(
                "iss" => "localhost",
                "aud" => "localhost",
                "iat" => $iat,
                'exp' => $exp,
                'reference' => $reference,
                'hash' => $hash,
                'admin' => false
            );

            $token = JWT::encode($payload, $this->key, 'HS512');
            
            return $token;
        }

        public function adminAuth($reference, $hash)
        {
            $iat = time();
            $exp = $iat + 60 * 60;
            $payload = array(
                "iss" => "localhost",
                "aud" => "localhost",
                "iat" => $iat,
                'exp' => $exp,
                'reference' => $reference,
                'hash' => $hash,
                'admin' => true
            );

            $token = JWT::encode($payload, $this->key, 'HS512');
            
            return $token;
        }

        public function verifyAuth($token){
            $decoded = JWT::decode($token, $this->key, array('HS512'));
            return $decoded;
        }
    }
