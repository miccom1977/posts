<?php

class Pages extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
    }

    public function index(){
        $posts = $this->postModel->getPosts();
        $data = [
            'title' => ' tytuł',
            'posts' => $posts
       ];
        $this->view('newsList', $data);
    }

    public function loadDataToBase(){
        $this->userModel->truncateDB();
        $this->userModel->loadUsersToBase();
        $this->postModel->loadPostsToBase();
        $posts = $this->postModel->getPosts();
        $data = [
            'title' => 'Tytuł strony',
            'posts' => $posts
       ];
        $this->view('newsList', $data);
    }
}