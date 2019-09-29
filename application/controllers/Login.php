<?php
class Login extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('user_model');
            $this->load->helper('url_helper');
    }

    public function login()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email',        'Email',            'required|callback_email_exists');
        $this->form_validation->set_rules('password',     'Password',         'required|min_length[8]|max_length[255]');
        $this->form_validation->set_rules('physical_key', 'Physical Key',     null);

        $user = $this->user_model->get_user($this->input->post('email'), $this->input->post('password'), $this->input->post('physical_key'));

        if ($this->form_validation->run() === false || !$user)
        {
            $data['title'] = 'Login';
            $data['error'] = 'User not found.';
            $this->load->view('templates/header', $data);
            $this->load->view('pages/login', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data['title'] = 'Dashboard';
            $data['name'] = $user['name'];
            $this->load->view('templates/header', $data);
            $this->load->view('pages/dashboard', $data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function email_exists($email)
    {
        return true; // TODO: If used in a real application, validate that the email exists.
    }
}
