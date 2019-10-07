<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user($email, $password, $physicalKey = null)
    {
        if ($physicalKey) {
            $query = $this->db->get_where('users', ['email' => $email, 'password' => $password, 'physical_key' => $physicalKey]);
        } else {
            $query = $this->db->get_where('users', ['email' => $email, 'password' => $password]);
        }

        return $query->row_array();
    }

    public function set_user($name, $email, $password, $useTfa, $useSns, $usePhysicalKey, $randId, $physicalKey = null)
    {
        $loginIndicators = ($useTfa ? 1 : 0) . ($useSns ? 1 : 0) . ($usePhysicalKey ? 1 : 0);

        $data = array(
            'name'             => $name,
            'email'            => $email,
            'password'         => $password, // TODO: Encrypt this if used for an actual application
            'login_indicators' => $loginIndicators,
            'physical_key'     => $physicalKey,
            'rand_id'          => $randId,
        );

        return $this->db->insert('users', $data);
    }

    public function update_physical_key($id, $physicalKey) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['physical_key' => $physicalKey]);
    }

    public static function requiresPhysKey($indicators) {
        return str_split($indicators)[2] ? true : false;
    }
}
