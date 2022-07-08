<?php
namespace App\Support;

use Doctrine\DBAL\Connection;
use App\Support\Dbal;

class DAO
{
    protected $db;

    public function __construct($db = null)
    {
        if ($db instanceof Connection) {
            $this->db = $db;
        } else {
            $this->db = Dbal::conn();
        }
    }
}
