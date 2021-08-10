<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

class OrderController extends Controller
{
    public $data = [];

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }

    // get orders by user id
    public function getOrdersByUserId()
    {
        $userId = $this->data['userId'];
        $orders = $this->orderModel->getOrdersByUserId($userId);

        print_r(json_encode($orders));
    }

    // cancel order
    public function cancelOrder()
    {
        $orderId = $this->data['orderId'];
        $status = $this->orderModel->cancelOrder($orderId);
    }

    // accept order
    public function acceptOrder()
    {
        $orderId = $this->data['orderId'];
        $status = $this->orderModel->acceptOrder($orderId);
    }

    // reject order
    public function rejectOrder()
    {
        $orderId = $this->data['orderId'];
        $status = $this->orderModel->rejectOrder($orderId);
    }

    // pendding order
    public function pendingOrder()
    {
        $orderId = $this->data['orderId'];
        $status = $this->orderModel->pendingOrder($orderId);
    }
    // get all orders
    public function getAllOrders()
    {
        $page =  $this->data['page'];
        $limit =  7;
        $offset = ($page - 1) * $limit;
        $orders = $this->orderModel->getAllOrders($limit, $offset);

        if ($orders) {
            $pages = ceil($orders[1] / $limit);

            print_r(json_encode(
                array(
                    'orders' => $orders[0],
                    'pages' => $pages,
            )));
            
        } else {
            print_r(json_encode("No Order found"));
        }

    }

    // last orders
    public function getLastOrders()
    {
        $orders = $this->orderModel->getLastOrders();
        print_r(json_encode($orders));
    }

    // get order by id
    public function getOrderById($id)
    {
        $order = $this->orderModel->getOrderById($id);
        print_r(json_encode($order));
    }



}