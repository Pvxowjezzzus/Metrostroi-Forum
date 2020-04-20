<?php
require 'lib/Db.php';

abstract class Model {

    public $conn;
    public function __construct() {
        $this->conn = new Db();
    }

}
?>
