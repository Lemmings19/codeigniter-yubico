<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user($email, $password, $physicalKey)
    {
        $query = $this->db->get_where('users', array('email' => $email, 'password' => $password, 'physical_key' => $physicalKey));
        return $query->row_array();
    }

    public function set_user()
    {
        $useTfa = $this->input->post('use_tfa');
        $useSns = $this->input->post('use_sns');
        $usePhysicalKey = $this->input->post('use_physical_key');

        $loginIndicators = ($useTfa ? 1 : 0) . ($useSns ? 1 : 0) . ($usePhysicalKey ? 1 : 0);

        $data = array(
            'name'             => $this->input->post('name'),
            'email'            => $this->input->post('email'),
            'password'         => $this->input->post('password'), // TODO: Encrypt this if used for an actual application
            'login_indicators' => $loginIndicators,
            'physical_key'     => $this->input->post('physical_key'), // TODO: (possibly) Encrypt this if used for an actual application
        );

        return $this->db->insert('users', $data);
    }
}
