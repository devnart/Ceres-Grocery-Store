<?php
    class Appointment {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function readByRef($data) {
            $this->db->query("SELECT * FROM appointment WHERE userRef = :reference");

            //Bind values
            $this->db->bind(':reference', $data['reference']);

            //Execute function
            $appointments = $this->db->resultSet();
            
            return $appointments;
        }

        public function getByDate($data) {
            $this->db->query("SELECT * FROM appointment WHERE date = :date");

            //Bind values
            $this->db->bind(':date', $data['date']);

            //Execute function
            $appointments = $this->db->resultSet();
            
            return $appointments;
        }

        public function store($data) {
           $this->db->query('INSERT INTO appointment (date, startTime, endTime, userRef) VALUES(:date, :startTime, :endTime, :reference)');
            // $this->db->query('INSERT INTO appointment (date, startTime, userRef) VALUES(:date, :startTime, :reference)');
           //Bind values
           $this->db->bind(':date', $data['date']);
           $this->db->bind(':startTime', $data['startTime']);
           $this->db->bind(':endTime', $data['endTime']);
           $this->db->bind(':reference', $data['reference']);
           
           //Execute function
           try {
               $this->db->execute();
           } catch(PDOException $e) {
               return $e->getMessage();
           }
        }

        public function update($data){
            $this->db->query("UPDATE appointment SET date=:date, startTime=:startTime, endTime=:endTime WHERE id=:id");

            $this->db->bind(':date', $data['date']);
            $this->db->bind(':startTime', $data['startTime']);
            $this->db->bind(':endTime', $data['endTime']);
            $this->db->bind(':id', $data['id']);

            //Execute function
            try {
                $this->db->execute();
            } catch(PDOException $e) {
                return $e->getMessage();
            }
        }

        public function delete($data){
            $this->db->query("DELETE FROM appointment WHERE id=:id");

            $this->db->bind(':id', $data['id']);

            //Execute function
            try {
                $this->db->execute();
                return $ok = "ok";
            } catch(PDOException $e) {
                return $e->getMessage();
            }
        }
    }