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
        print_r(json_encode($status));
    }


}