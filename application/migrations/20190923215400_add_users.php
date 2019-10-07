<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint'     => 5,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ),
            'email' => array(
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ),
            'password' => array(
                'type'         => 'VARCHAR',
                'constraint' => '255',
            ),
            'login_indicators' => array(
                'type'         => 'VARCHAR',
                'constraint' => '255',
            ),
            'physical_key' => array(
                'type'       => 'VARCHAR',
                'constraint' => '2000',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    /*
    CREATE TABLE `users` (
      `id` int(10) UNSIGNED NOT NULL,
      `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
      `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
      `login_indicators` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `physical_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ALTER TABLE `users`
        ADD PRIMARY KEY (`id`);
    ALTER TABLE `users`
        MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    */

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}
