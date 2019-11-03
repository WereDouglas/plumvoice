<?php

Class Connection
{
    public $conn;
    public $config;

    //create a connection
    function __construct()
    {
        include('Config.php');
        try {

            $this->conn = new PDO("mysql:host=" . $config['HOST'] . ";dbname=" . $config['DATABASE'],
                $config['USERNAME'], $config['PASSWORD'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
        } catch (PDOException $e) {
            echo "Connection Error:" . $e->getMessage();
        }
    }

    public function Connect()
    {
        return $this->conn;
    }

    /**
     * collect results to any given query
     */
    public function listResults($sql)
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function save($sql, $data)
    {
        $statement = $this->conn->prepare($sql);
       return ($statement->execute($data))?true:false;
    }

    public function disconnect()
    {
        $this->conn = null;
    }
}

?>