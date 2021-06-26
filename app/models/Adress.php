<?php

class Adress {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAdress( $id ){
        $this->db->query("SELECT * FROM adress WHERE `userId`='. $id .'");
        $result =  $this->db->resultSet();
        return $result;
    }

    public function insertAdress($data) {
        $ins=$this->db->prepare('INSERT INTO adress (userId, street, suite, city, zipcode, lat, lng) VALUES (
            :userId, :street, :suite, :city, :zipcode, :lat, :lng  )');
        $ins->bindValue(':userId', $data['userId'], PDO::PARAM_INT);
        $ins->bindValue(':street', $data['street'], PDO::PARAM_STR);
        $ins->bindValue(':suite', $data['suite'], PDO::PARAM_STR);
        $ins->bindValue(':city', $data['city'], PDO::PARAM_STR);
        $ins->bindValue(':zipcode', $data['zipcode'], PDO::PARAM_STR);
        $ins->bindValue(':lat', $data['lat'], PDO::PARAM_INT);
        $ins->bindValue(':lng', $data['lng'], PDO::PARAM_INT);
        $ins->execute();
    }

}