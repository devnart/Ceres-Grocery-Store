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

    // accept order
    public function acceptOrder($orderId)
    {
        $this->db->query('UPDATE orders SET status=:status WHERE id=:orderId');
        $this->db->bind(':status', 'delivered');
        $this->db->bind(':orderId', $orderId);
        $this->db->execute();
    }

    // reject order
    public function rejectOrder($orderId)
    {
        $this->db->query('UPDATE orders SET status=:status WHERE id=:orderId');
        $this->db->bind(':status', 'rejected');
        $this->db->bind(':orderId', $orderId);
        $this->db->execute();
    }

    // pending order
    public function pendingOrder($orderId)
    {
        $this->db->query('UPDATE orders SET status=:status WHERE id=:orderId');
        $this->db->bind(':status', 'pending');
        $this->db->bind(':orderId', $orderId);
        $this->db->execute();
    }
    
    // get all orders ordered by date
    public function getAllOrders($limit,$start)
    {

        // total rows
        $this->db->query("SELECT COUNT(*) AS total FROM orders");
        $total = $this->db->single();
        $total = $total->total;

        $this->db->query('SELECT * FROM orders  ORDER BY created DESC LIMIT :limit OFFSET :start' );
        $this->db->bind(':limit', $limit);
        $this->db->bind(':start', $start);
        $orders = $this->db->resultSet();
        return array($orders, $total);

    }

    // last orders
    public function getLastOrders()
    {
        $this->db->query('SELECT o.id,c.name,c.avatar,o.products,o.status,o.totalPrice  FROM client c ,orders o WHERE c.id=o.clientId
        ORDER BY o.id DESC LIMIT 4');
        $orders = $this->db->resultSet();
        return $orders;
    }

    // get order by id
    public function getOrderById($orderId)
    {
        $this->db->query('SELECT o.id,c.name,c.email,o.products,o.status,o.totalPrice,o.adress,o.phone,o.first_name,o.last_name  FROM client c ,orders o WHERE c.id=o.clientId AND o.id=:orderId ');

        // $this->db->query('SELECT * FROM orders WHERE id=:orderId');
        $this->db->bind(':orderId', $orderId);
        $order = $this->db->single();
        return $order;
    }
}