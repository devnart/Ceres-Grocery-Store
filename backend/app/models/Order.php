<?php
class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function getOrdersByUserId($userId)
    {

        $this->db->query('SELECT * FROM orders WHERE clientId=:userId');

        $this->db->bind(':userId', $userId);

        $orders = $this->db->resultSet();
        return $orders;
    }

    // cancel order
    public function cancelOrder($orderId)
    {
        $this->db->query('UPDATE orders SET status=:status WHERE id=:orderId');
        $this->db->bind(':status', 'cancelled');
        $this->db->bind(':orderId', $orderId);
        $this->db->execute();
    }
}