<?php
class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getSingle($id)
    {

        $this->db->query('SELECT * FROM product WHERE id=:id');

        $this->db->bind(':id', $id);

        $products = $this->db->single();
        return $products;
    }

    public function getAll($limit, $start)
    {
        // total rows
        $this->db->query("SELECT COUNT(*) AS total FROM product");
        $total = $this->db->single();
        $total = $total->total;

        $this->db->query('SELECT * FROM product  ORDER BY added DESC LIMIT :limit OFFSET :start');
        $this->db->bind(':limit', $limit);
        $this->db->bind(':start', $start);
        $products = $this->db->resultSet();
        return array($products, $total);
    }

    public function getProducts()
    {
        $this->db->query('SELECT * FROM product  ORDER BY added DESC');
        $products = $this->db->resultSet();
        return $products;
    }

    public function addProduct($data, $avatar)
    {

        $this->db->query('INSERT INTO product (name, description,img, category, price, unit) VALUES(:name, :description, :img, :category, :price, :unit)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':img', $avatar);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':unit', $data['unit']);

        //Execute function 
        if (!$this->db->execute()) {
            return false;
        }
        return true;
    }

    public function updateProduct($data, $id)
    {

        $this->db->query("UPDATE product SET name=:name, description=:description, category=:category, price=:price, unit=:unit WHERE id=:id");

        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':unit', $data['unit']);

        //Execute function
        try {
            $this->db->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteProduct($id)
    {
        $this->db->query("DELETE FROM product WHERE id=:id");

        $this->db->bind(':id', $id);

        //Execute function
        try {
            $this->db->execute();
            return "ok";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function checkout($data)
    {

        $this->db->query('INSERT INTO orders (clientId, products, first_name,last_name, phone, adress,totalPrice) VALUES(:clientId, :products, :first_name, :last_name, :phone, :adress, :totalPrice)');

        $this->db->bind(':clientId', $data['clientId']);
        $this->db->bind(':products', $data['products']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':adress', $data['adress']);
        $this->db->bind(':totalPrice', $data['totalPrice']);

        //Execute function

        try {
            $this->db->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function revenueToday()
    {

        $this->db->query("SELECT SUM(totalPrice) AS 'revenue' FROM `orders` WHERE date(created)  = CURDATE() ");

        //Execute function
        $products = $this->db->single();
        return $products;
    }

    public function revenueYesterday($yesterday)
    {

        $this->db->query("SELECT SUM(totalPrice) AS 'revenue' FROM `orders` WHERE date(created)  =:yesterday ");

        $this->db->bind(':yesterday', $yesterday);
        //Execute function
        $products = $this->db->single();
        return $products;
    }

    // get this week's revenue
    public function revenueThisWeek($thisweek)
    {
        $this->db->query("SELECT SUM(totalPrice) AS 'revenue' FROM `orders` WHERE date(created)  BETWEEN :thisweek AND DATE_ADD(:thisweek, INTERVAL 7 DAY) ");
        $this->db->bind(':thisweek', $thisweek);
        //Execute function
        $products = $this->db->single();
        return $products;
    }

    public function thisMonthRevenue()
    {

        $this->db->query("SELECT SUM(totalPrice) AS 'revenue' FROM `orders` WHERE MONTH(created)  = MONTH(CURDATE())");

        //Execute function
        $products = $this->db->single();
        return $products;
    }

    public function previousMonthRevenue()
    {

        $this->db->query("SELECT SUM(totalPrice) AS 'revenue' FROM `orders` WHERE MONTH(created)  = MONTH(CURDATE())-1");

        //Execute function
        $products = $this->db->single();
        return $products;
    }
}
