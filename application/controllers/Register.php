<?php
class Register extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url_helper');
    }

    public function register()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name',             'Name',             'required|min_length[1]|max_length[100]');
        $this->form_validation->set_rules('email',            'Email',            'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password',         'Password',         'required|min_length[8]|max_length[255]');
        $this->form_validation->set_rules('use_tfa',          'Use Two-Factor Autentication',     null);
        $this->form_validation->set_rules('use_sns',          'Use Simple Notification Services', null);
        $this->form_validation->set_rules('use_physical_key', 'Use Physical Key',                 null);
        $this->form_validation->set_rules('physical_key',     'Physical Key',                     'min_length[12]|max_length[12]');

        if ($this->form_validation->run() === false)
        {
            $data['title'] = 'Register';
            $this->load->view('templates/header', $data);
            $this->load->view('pages/register', $data);
            $this->load->view('templates/footer', $data);

        } else {
            $data['title'] = 'Login';

            $name           = $this->input->post('name');
            $email          = $this->input->post('email');
            $password       = $this->input->post('password');
            $useTfa         = $this->input->post('use_tfa');
            $useSns         = $this->input->post('use_sns');
            $usePhysicalKey = $this->input->post('use_physical_key');
            $physicalKey    = ($this->input->post('physical_key') ? $this->input->post('physical_key') : null);

            // Create the user
            $this->user_model->set_user($name, $email, $password, $useTfa, $useSns, $usePhysicalKey, $physicalKey);

            $this->load->view('templates/header', $data);
            $this->load->view('pages/login', $data);
            $this->load->view('templates/footer', $data);
        }
    }
}
