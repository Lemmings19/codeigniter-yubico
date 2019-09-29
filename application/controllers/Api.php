<?php
require(APPPATH . '/libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('user_model');
    }

    function check_phys_key_requirement() {
        if(!$this->get('email') || !$this->get('password'))
        {
            $this->response(NULL, 400);
        }

        $user = $this->user_model->get_user($this->get('email'), $this->get('password'));

        $data = ['require_phys_key' => false];

        if ($user) {
            $data['require_phys_key'] = $this->user_model->requiresPhysKey($user['login_indicators']);
        }

        return $this->response($data, 200);
    }
}
