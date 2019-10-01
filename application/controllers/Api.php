<?php

include APPPATH . 'third_party/WebAuthn.php';

class Api extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('user_model');
    }

    // public function check_phys_key_requirement() {
    //     if (!$this->input->get('email') || !$this->input->get('password'))
    //     {
    //         set_status_header(400, 'Email and/or password missing.');
    //         return false;
    //     }

    //     $user = $this->user_model->get_user($this->input->get('email'), $this->input->get('password'));

    //     $data = ['require_phys_key' => false];

    //     if ($user) {
    //         $data['require_phys_key'] = $this->user_model->requiresPhysKey($user['login_indicators']);
    //     }

    //     set_status_header(200);
    //     echo json_encode($data);
    // }

    // Initiate registration
    public function register_username() {
        $webauthn = new WebAuthn($_SERVER['HTTP_HOST']);

        if (!$this->input->get('name') || !$this->input->get('password')) {
            set_status_header(400);
            echo 'Name or password missing';
            return false;
        }

        $name = $this->input->get('name');
        $password = $this->input->get('password');

        $crossPlatform = (!empty($this->input->get('crossplatform')) && $this->input->get('crossplatform'));

        $name           = $this->input->get('name');
        $email          = $this->input->get('email');
        $password       = $this->input->get('password');
        $useTfa         = $this->input->get('use_tfa');
        $useSns         = $this->input->get('use_sns');
        $usePhysicalKey = $this->input->get('use_physical_key');

        // Create the user
        $this->user_model->set_user($name, $email, $password, $useTfa, $useSns, $usePhysicalKey, null);
        $user = $this->user_model->get_user($email, $password);

        $_SESSION['name'] = $name;

        header('Content-type: application/json');
        echo json_encode(['challenge' => $webauthn->prepareChallengeForRegistration($user['name'], $user['id'], $crossPlatform)]);
        exit;
    }

    // Complete registration
    public function register() {
        $webauthn = new WebAuthn($_SERVER['HTTP_HOST']);

        if (!$this->input->get('name') || !$this->input->get('password')) {
            set_status_header(400);
            echo 'Name or password missing';
            return false;
        }
        $name        = $this->input->get('name');
        $password    = $this->input->get('password');
        $physicalKey = $webauthn->register($this->input->get('register'), '');

        $user = $this->user_model->get_user($email, $password);

        // Save the result to enable a challenge to be raised against this newly created key in order to log in
        $this->user_model->update_physical_key($user['id'], $physicalKey);

        header('Content-type: application/json');
        echo json_encode('ok');
        exit;
    }

    public function login() {

    }
}
