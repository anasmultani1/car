<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DatabaseTest extends Controller
{
    public function index()
    {
        try {
            $db = Database::connect();
            if ($db->connect()) {
                echo "✅ Database connection successful!";
            } else {
                echo "❌ Database connection failed!";
            }
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }
    }
}
