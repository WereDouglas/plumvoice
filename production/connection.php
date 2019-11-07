<?php

/**
 * Class created -> if have more than just the user object,for all database transactions
 */
Class connection
{
    public $conn;
    public $config;

    //create a connection when the class is called
    function __construct()
    {
        include('config.php');
        try {

            $this->conn = new PDO("mysql:host=" . $config['HOST'] . ";dbname=" . $config['DATABASE'],
                $config['USERNAME'], $config['PASSWORD'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
        } catch (PDOException $e) {
            echo "Connection Error:" . $e->getMessage();
        }
    }

    /**default connection variable on the connection object **/

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

    public function singleResult($sql, $data)
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute($data);
        return $statement->fetch();
    }

    public function update($sql, $data)
    {
        $statement = $this->conn->prepare($sql);
        return $statement->execute($data);
    }

    public function save($sql, $data)
    {
        $statement = $this->conn->prepare($sql);
        $statement->execute($data);
        return $this->conn->lastInsertId();
    }

    public function delete($sql)
    {
        $statement = $this->conn->prepare($sql);
        return $statement->execute();
    }

    /**
     * @param $sql
     * @return bool
     */
    public function updateQuery($sql)
    {
        $statement = $this->conn->prepare($sql);
        return $statement->execute();
    }

    public function disconnect()
    {
        $this->conn = null;
    }
}
