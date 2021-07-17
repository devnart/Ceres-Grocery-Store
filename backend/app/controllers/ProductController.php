<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class ProductController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    // get single product by ID
    public function getSingle($id){
        $product = $this->productModel->getSingle($id);
        print_r(json_encode($product));
    }

    // get all products
    public function getProducts(){
        $products = $this->productModel->getAll();

        foreach ($products as $product) {
            $product->qty = 1;

        }
        print_r(json_encode($products));

    }

    // Add Product 
    public function addProduct()
    {

        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                // role management ( so only the admin can add products)
                $verify = $this->verifyAuth($headers[1]);
                $exploaded = get_object_vars($verify);

                if ($exploaded['admin']) {

                    // *** The Important Stuff *** //

                    $this->productModel->addProduct($this->data);
                    print_r(json_encode('Product Added Successfully'));
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

    // update product
    public function updateProduct($id){

        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                // role management ( so only the admin can add products)
                $verify = $this->verifyAuth($headers[1]);
                $exploaded = get_object_vars($verify);

                if ($exploaded['admin']) {

                    // *** The Important Stuff *** //
                    
                    $this->productModel->updateProduct($this->data,$id);
                    print_r(json_encode('Product Updated Successfully'));
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

    public function deleteProduct($id){


        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {
                // role management ( so only the admin can add products)
                $verify = $this->verifyAuth($headers[1]);
                $exploaded = get_object_vars($verify);

                if ($exploaded['admin']) {

                    // *** The Important Stuff *** //
                    
                    $this->productModel->deleteProduct($id);
                    print_r(json_encode('Product Deleted Successfully'));
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

    public function checkout(){
        
        $headers = apache_request_headers();
        $headers = isset($headers['Authorization']) ? explode(' ', $headers['Authorization']) : null;
        if ($headers) {
            try {

                // Token Verification
                $this->verifyAuth($headers[1]);
                $this->productModel->checkout($this->data);
                print_r(json_encode(true));

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


    // Calculate Earning (Today)
    public function revenueToday(){

        $r = $this->productModel->revenueToday();
        print_r(json_encode($r));

        // Calculate the Difference
        $new = $r->revenue;
        $old = $this->revenueYesterday();

        $diff = $new - $old;
        $diff = $diff / $old * 100;
        $diff = round($diff, 2);
        print_r('the diff : ' . $diff);


    }

    // Calculate Earning (Yesterday)
    public function revenueYesterday(){

        $r = $this->productModel->revenueYesterday();
        return $r->revenue;

    }

    // Calculate Earning (This Month)
    public function thisMonthRevenue(){

        $r = $this->productModel->thisMonthRevenue();
        print_r($r->revenue);

    }

    // Calculate Earning (Previous Month)
    public function previousMonthRevenue(){

        $r = $this->productModel->previousMonthRevenue();
        print_r($r->revenue);

    }
}
