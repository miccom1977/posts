<?php

class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getUsers(){
        $this->db->query("SELECT * FROM users");
        $result =  $this->db->resultSet();
        return $result;
    }

    public function insertUser($data) {
        $this->db->query('INSERT INTO users (name, username, phone, website) VALUES (
            :name, :username, :phone, :website )');
        $this->db->bind(':name', $data['name'], null);
        $this->db->bind(':username', $data['username'], null);
        $this->db->bind(':phone', $data['phone'], null);
        $this->db->bind(':website', $data['website'], null);
        $this->db->execute();
    }

    public function insertUserCompany($data) {
        $this->db->query('INSERT INTO company (userId, name, catchPhrase, bs) VALUES (
            :userId, :name, :catchPhrase, :bs )');
        $this->db->bind(':userId', $data['userId']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':catchPhrase', $data['catchPhrase']);
        $this->db->bind(':bs', $data['bs']);
        $this->db->execute();
    }

    public function insertAdress($data) {
        $this->db->query('INSERT INTO address (userId, street, suite, city, zipcode, lat, lng) VALUES (
            :userId, :street, :suite, :city, :zipcode, :lat, :lng  )');
        $this->db->bind(':userId', $data['userId']);
        $this->db->bind(':street', $data['street']);
        $this->db->bind(':suite', $data['suite']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':zipcode', $data['zipcode']);
        $this->db->bind(':lat', $data['lat']);
        $this->db->bind(':lng', $data['lng']);
        $this->db->execute();
    }

    public function loadUsersToBase(){
        $data = file_get_contents('https://jsonplaceholder.typicode.com/users');
        $fullData = json_decode($data, TRUE);
        foreach( $fullData AS $singleData ){
            $dataUs = [
                'name' => $singleData['name'],
                'username' => $singleData['username'],
                'phone' => $singleData['phone'],
                'website' => $singleData['website']
            ];
            $this->insertUser($dataUs);
            
            $dataAddress = [
                'userId' => $singleData['id'],
                'street' => $singleData['address']['street'],
                'suite' => $singleData['address']['suite'],
                'city' => $singleData['address']['city'],
                'zipcode' => $singleData['address']['zipcode'],
                'lat' => $singleData['address']['geo']['lat'],
                'lng' => $singleData['address']['geo']['lng']
            ];
            $this->insertAdress($dataAddress);

            $dataCompany = [
                'userId' => $singleData['id'],
                'name' => $singleData['company']['name'],
                'catchPhrase' => $singleData['company']['catchPhrase'],
                'bs' => $singleData['company']['bs']
            ];
            $this->insertUserCompany($dataCompany);
        }
    }

    public function truncateDB() {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->execute();
        $this->db->query('TRUNCATE TABLE users');
        $this->db->execute();
        $this->db->query('TRUNCATE TABLE address');
        $this->db->execute();
        $this->db->query('TRUNCATE TABLE posts');
        $this->db->execute();
        $this->db->query('TRUNCATE TABLE company');
        $this->db->execute();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        $this->db->execute();
    }

}