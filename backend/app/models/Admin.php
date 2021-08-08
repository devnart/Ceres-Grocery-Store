<?php
class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function find($data)
    {
        $this->db->query("SELECT * FROM admin WHERE email = :email AND password = :password");

        //Bind values
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        $admin = $this->db->single();

        return $admin;
    }
}