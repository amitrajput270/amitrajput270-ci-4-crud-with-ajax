<?php

namespace App\Controllers;

class Home extends BaseController
{

    private $db;
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index(): string
    {
        try {
            $query = $this->db->query('SELECT * FROM users');
            print_r($query->getResult());
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return view('welcome_message');
    }
}
