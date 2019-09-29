<?php
class News extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('user_model');
            $this->load->helper('url_helper');
    }

    public function login() {

    }
}
