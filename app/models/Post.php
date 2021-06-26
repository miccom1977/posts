<?php

class Post {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getPosts(){
        $this->db->query("SELECT `ps`.`title`, `ps`.`body`, `us`.`name` FROM `posts` AS `ps` LEFT JOIN `users` AS `us` ON `ps`.`userId` = `us`.`id` ");
        $result =  $this->db->resultSet();
        return $result;
    }

    public function insertPost($data) {
        $this->db->query('INSERT INTO posts (userId, title, body) VALUES (
            :userId, :title, :body)');
        $this->db->bind(':userId', $data['userId'], null);
        $this->db->bind(':title', $data['title'], null);
        $this->db->bind(':body', $data['body'], null);
        $this->db->execute();
    }

    public function loadPostsToBase(){
        $data = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $fullData = json_decode($data, TRUE);
        foreach( $fullData AS $singleData ){
            $dataIns = [
                'userId' => $singleData['userId'],
                'title' => $singleData['title'],
                'body' => $singleData['body']
            ];
            $this->insertPost($dataIns);
        }
    }
}