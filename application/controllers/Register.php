<?php
class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url_helper');
    }

    public function register() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Register';

        $this->form_validation->set_rules('name',             'Name',             'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('email',            'Email',            'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password',         'Password',         'required|min_length[8]|max_length[255]');
        $this->form_validation->set_rules('use_tfa',          'Use Two-Factor Autentication',     null);
        $this->form_validation->set_rules('use_sns',          'Use Simple Notification Services', null);
        $this->form_validation->set_rules('use_physical_key', 'Use Physical Key',                 null);

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/register', $data);
            $this->load->view('templates/footer', $data);

        } else {
            $this->user_model->set_user();
            $this->load->view('templates/header', $data);
            $this->load->view('pages/login', $data);
            $this->load->view('templates/footer', $data);
        }
    }
}
