<?php

class Db {
    public $db;
    public function __construct()
    {
            /*$config = require 'config/db.php';
            $this->db = mysqli_connect("$config[host]", "$config[user]", "", "$config[database]");*/
            $this->db = mysqli_connect("localhost", "root", "", "metrostroi-forum");
            if (!$this->db) {
                echo "MYSQL Error";
            }
            $this->db->query("SET NAMES 'utf8';");
            $this->db->query("SET CHARACTER SET 'utf8';");
            $this->db->query("SET SESSION collation_dbion = 'utf8_general_ci';");

    }
    function json() {
    $str = '{"head":"counter", "a":$a, "b":"$a" }';
    $json = json_decode($str, false);
    switch ($json->head) {
        case "counter":
            echo $json->a + $json->b;
                break;
    }
        }
}

?>