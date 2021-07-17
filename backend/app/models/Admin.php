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
        $this->db->query("SELECT * FROM admin WHERE name = :name AND password = :password");

        //Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':password', $data['password']);

        //Execute function
        $admin = $this->db->single();

        return $admin;
    }
}