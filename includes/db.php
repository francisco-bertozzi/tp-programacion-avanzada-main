<?php

class DB {
    private static $_instance;
    private $_connection;

    private final function __construct()
    {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->_connection = new mysqli('127.0.0.1', 'root', '', 'amaclon');
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection()
    {
        return $this->_connection;
    }

    private function __clone() { }
}