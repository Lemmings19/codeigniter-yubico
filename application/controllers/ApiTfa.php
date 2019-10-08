<?php

use PragmaRX\Google2FA\Google2FA;

class ApiTfa extends CI_Controller {
    private $name = 'TFAExample';
    private $email = 'tfaexample@example.com';
    private $secretKey;
    private $keySize = 25;
    private $keyPrefix = '';

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
        if (!$this->input->get('name') || !$this->input->get('password')) {
            set_status_header(400);
            echo 'Name or password missing';
            return false;
        }

        $googleTfa = new Google2FA();

        $name = $this->input->get('name');
        $password = $this->input->get('password');

        $name           = $this->input->get('name');
        $email          = $this->input->get('email');
        $password       = $this->input->get('password');
        $useTfa         = $this->input->get('use_tfa');
        $useSns         = $this->input->get('use_sns');
        $usePhysicalKey = $this->input->get('use_physical_key');
        $randId         = $googleTfa->generateSecretKey();

        // Create the user
        $this->user_model->set_user($name, $email, $password, $useTfa, $useSns, $usePhysicalKey, $randId, null);
        $user = $this->user_model->get_user($email, $password);

        $googleUrl = ''; //$googleTfa->getQRCodeGoogleUrl($this->name, $this->email, $key);
        $inlineUrl = ''; //$googleTfa->getQRCodeInline($this->name, $this->email, $key);

        header('Content-type: application/json');
        echo json_encode(['secret' => $randId, 'googleUrl' => $googleUrl, 'inlineUrl' => $inlineUrl]);
        exit;
    }

    // Complete registration
    public function register() {
        if (!$this->input->get('name') || !$this->input->get('email')  || !$this->input->get('password') || !$this->input->get('tfa_code')) {
            set_status_header(400);
            echo 'Name, email, password, or code missing';
            return false;
        }

        $googleTfa = new Google2FA();

        $email    = $this->input->get('email');
        $password = $this->input->get('password');
        $code     = $this->input->get('tfa_code');

        $user = $this->user_model->get_user($email, $password);

        if (!$googleTfa->verifyKey($user['rand_id'], $code)) {
            set_status_header(400);
            echo 'Invalid code';
            return false;
        } else {
            header('Content-type: application/json');
            echo json_encode('ok');
            exit;
        }
    }

    public function login_username() {
        session_start();
        $webauthn = new WebAuthn($_SERVER['HTTP_HOST']);

        if (!$this->input->get('email') || !$this->input->get('password')) {
            set_status_header(400);
            echo 'Email or password missing';
            return false;
        }
        $email    = $this->input->get('email');
        $password = $this->input->get('password');

        $user = $this->user_model->get_user($email, $password);

        $_SESSION['loginname'] = $user['name'];
        /* note: that will emit an error if username does not exist. That's not
        good practice for a live system, as you don't want to have a way for
        people to interrogate your user database for existence */
        $challenge = $webauthn->prepareForLogin($user['physical_key']);

        header('Content-type: application/json');
        echo json_encode(['challenge' => $challenge]);
        exit;
    }

    public function login() {
        session_start();
        $webauthn = new WebAuthn($_SERVER['HTTP_HOST']);

        $name = $_SESSION['loginname'];
        if (empty($name)) {
            set_status_header(400);
            echo 'Username not set';
            return false;
        }

        if (!$this->input->get('email') || !$this->input->get('password')) {
            set_status_header(400);
            echo 'Email or password missing';
            return false;
        }
        $email    = $this->input->get('email');
        $password = $this->input->get('password');

        $user = $this->user_model->get_user($email, $password);

        if (!$user) {
            set_status_header(400);
            echo 'Bad email or password';
        }

        if (!$this->input->get('key_info')) {
            set_status_header(400);
            echo 'Key information missing';
            return false;
        }

        $physKey = $this->input->get('key_info');

        if (!$webauthn->authenticate($physKey, $user['physical_key'])) {
            http_response_code(401);
            echo 'failed to authenticate with that key';
            exit;
        }

        header('Content-type: application/json');
        echo json_encode('ok');
        exit;
    }

    /**
     * Generates a random alphanumeric key.
     *
     * @param int $length
     *
     * @return string
     */
    private function generateKey($length = 25) {
        $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
        for($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }

}
