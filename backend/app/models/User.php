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
        $this->db->query("SELECT * FROM client WHERE name = :name AND password = :password");

        //Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        $user = $this->db->single();

        return $user;
    }

    public function storeClient($data)
    {
        $this->db->query('INSERT INTO client (name, email, password) VALUES(:name, :email, :password)');

        //Bind values

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        try {
            $this->db->execute();
            return $data = true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function updateClientInfo($data,$id)
    {

    
        $this->db->query("UPDATE client SET name=:name, email=:email WHERE id=:id");

        //Bind values

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $id);

        //Execute function
        try {
            $this->db->execute();
            return $data = true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function checkPassword($data,$id){
        $this->db->query("SELECT * FROM client WHERE id = :id AND password = :password");

        $this->db->bind(':id', $id);
        $this->db->bind(':password', $data['oldPassword']);

        $this->db->execute();
        return $this->db->rowCount();

    }

    public function updateClientPassword($data,$id)
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

    public function deleteUser($id){
        $this->db->query("DELETE FROM client WHERE id=:id");

        $this->db->bind(':id', $id);

        //Execute function
        try {
            $this->db->execute();
            return "ok";
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}
