<?php
class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function find($data)
    {
        $this->db->query("SELECT * FROM client WHERE email = :email AND password = :password");

        //Bind values
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        $user = $this->db->single();

        return $user;
    }

    public function storeClient($data)
    {
        $this->db->query('INSERT INTO client (name, email,phone, password) VALUES(:name, :email,:phone, :password)');

        //Bind values

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        try {
            $this->db->execute();
            return $data = true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    // pagination
    public function getAll($limit, $start)
    {
        // total rows
        $this->db->query("SELECT COUNT(*) AS total FROM client");
        $total = $this->db->single();
        $total = $total->total;

        $this->db->query("SELECT * FROM client  ORDER BY registred DESC LIMIT :limit OFFSET :start");
        $this->db->bind(':limit', $limit);
        $this->db->bind(':start', $start);
        $users = $this->db->resultSet();
        return array($users, $total);
    }
    // get all clients
    public function getAllClients()
    {
        $this->db->query('SELECT * FROM client');
        $clients = $this->db->resultSet();
        return $clients;
    }

    // get last 4 clients
    public function getLast4Clients()
    {
        $this->db->query('SELECT * FROM client ORDER BY id DESC LIMIT 4');
        $clients = $this->db->resultSet();
        return $clients;
    }

    // get user
    public function getUser($id)
    {
        $this->db->query("SELECT * FROM client WHERE id = :id");
        $this->db->bind(':id', $id);
        $user = $this->db->single();
        return $user;
    }

    // update avatar
    public function updateAvatar($id, $avatar)
    {
        $this->db->query("UPDATE client SET avatar = :avatar WHERE id = :id");
        $this->db->bind(':avatar', $avatar);
        $this->db->bind(':id', $id);
        $this->db->execute();
    }

    public function updateClientInfo($data, $id)
    {

        $this->db->query("UPDATE client SET name=:name, email=:email, phone=:phone WHERE id=:id");

        //Bind values

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':id', $id);

        //Execute function
        try {
            $this->db->execute();
            return $data = true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function checkPassword($data, $id)
    {
        $this->db->query("SELECT * FROM client WHERE id = :id AND password = :password");

        $this->db->bind(':id', $id);
        $this->db->bind(':password', $data['oldPassword']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateClientPassword($data, $id)
    {
        $this->db->query("UPDATE client SET password=:password WHERE id=:id");

        //Bind values

        $this->db->bind(':password', $data['newPassword']);
        $this->db->bind(':id', $id);

        //Execute function
        try {
            $this->db->execute();
            return $data = true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function checkEmail($data)
    {

        $this->db->query("SELECT * FROM client WHERE email=:email");

        $this->db->bind(':email', $data['email']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteUser($id)
    {
        $this->db->query("DELETE FROM client WHERE id=:id");

        $this->db->bind(':id', $id);

        //Execute function
        try {
            $this->db->execute();
            return "ok";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
