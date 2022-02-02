<?php

class MysqlDB {

    private static $instance = null;
    protected $connect;
    protected $mysqli_db;

    private function __construct() {
        $this->connect = $this->connectToDB();
    }

    public function connectToDB() {
        $this->mysqli_db =  new mysqli(APP_DB_HOST, 'root', APP_DB_PASSWORD, APP_DB_NAME);
        return $this->mysqli_db;
    }

    public static function getInstance() {
        if (self::$instance == null)
        {
            self::$instance = new MysqlDB();
        }

        return self::$instance;
    }

    public function query($sql) {
        $result = $this->connect->query($sql);
        if (!is_object($result)) {
            return $result;
        }
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}