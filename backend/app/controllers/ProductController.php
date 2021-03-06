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
    public function getSingle($id)
    {
        $product = $this->productModel->getSingle($id);
        print_r(json_encode($product));
    }

    // get all products
    public function getProducts()
    {
        $page =  $this->data['page'];
        $limit =  7;
        $offset = ($page - 1) * $limit;
        $products = $this->productModel->getAll($limit, $offset);

        if ($products) {
            $pages = ceil($products[1] / $limit);


            print_r(json_encode(
                array(
                    'products' => $products[0],
                    'pages' => $pages,
                )
            ));
        } else {
            print_r(json_encode("No Order found"));
        }
    }

    public function getAll()
    {
        $products = $this->productModel->getProducts();
        if ($products) {
            foreach ($products as $product) {
                $product->qty = 1;
            }

            print_r(json_encode($products));
        } else {
            print_r(json_encode("No products found"));
        }
    }

    // get products by category
    public function getProductsByCategory($category)
    {
        $products = $this->productModel->getProductsByCategory($category);
        if ($products) {
            foreach ($products as $product) {
                $product->qty = 1;
            }
            print_r(json_encode($products));
        } else {
            print_r(json_encode(false));
        }
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
                    // show $_files content
                    $filename = $_FILES["img"]["name"];
                    $filesize = $_FILES["img"]["size"];
                    $tempname = $_FILES["img"]["tmp_name"];
                    $folder = "./img/products/" . $filename;

                    if ($filesize > 8000000) {
                        die(json_encode(array("error" => "File size is too big")));
                    }

                    if (move_uploaded_file($tempname, $folder)) {
                        $msg = "Image uploaded successfully";
                    } else {
                        $msg = "Failed to upload image";
                    }


                    $added = $this->productModel->addProduct($_REQUEST, $filename);
                    print_r(json_encode($added));
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
    public function updateProduct($id)
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
                    $this->productModel->updateProduct($_REQUEST, $id);
                    print_r(json_encode(true));
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

    public function deleteProduct()
    {
        header('Access-Control-Allow-Methods: DELETE');

        $id = $this->data['id'];
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

    public function checkout()
    {

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

    public function revenues()
    {
        // create object
        $revenue = new stdClass();
        $revenue->today = $this->revenueToday();
        $revenue->yesterday = $this->revenueYesterday();
        $revenue->thisWeek = $this->revenueThisWeek();
        $revenue->thisMonth = $this->thisMonthRevenue();

        print_r(json_encode($revenue));
    }
    // Calculate Earning (Today)
    public function revenueToday()
    {

        $r = $this->productModel->revenueToday();
        return $r;
        // print_r();

        // Calculate the Difference
        // $new = $r->revenue;
        // $old = $this->revenueYesterday();

        // $diff = $new - $old;
        // $diff = $diff / $old * 100;
        // $diff = round($diff, 2);
        // print_r(json_encode('the diff : ' . $diff));
    }

    // Calculate Earning (Yesterday)
    public function revenueYesterday()
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $r = $this->productModel->revenueYesterday($yesterday);
        return $r;

        // return print_r($r->revenue);
    }
    // get this week's revenue
    public function revenueThisWeek()
    {
        $thisWeek = date('Y-m-d', strtotime('-7 day'));
        $r = $this->productModel->revenueThisWeek($thisWeek);
        // return print_r($r->revenue);
        return $r;
    }

    // Calculate Earning (This Month)
    public function thisMonthRevenue()
    {

        $r = $this->productModel->thisMonthRevenue();
        // print_r($r->revenue);
        return $r;
    }

    // Calculate Earning (Previous Month)
    public function previousMonthRevenue()
    {

        $r = $this->productModel->previousMonthRevenue();
        print_r($r);
    }
}
