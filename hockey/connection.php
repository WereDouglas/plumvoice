<?php

/**
 * Class created -> if have more than just the user object,for all database transactions
 */
Class Connection
{
    public $conn;
    //create a connection
    function __construct()
    {

        try {

            $this->conn = new PDO("mysql:host=localhost;dbname=hockey",
                'admin','Admin', [
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
    public function searchByLastName($name)
    {

        $sql = "SELECT CONCAT_WS(' ',first_name,last_name) AS name,signed_date FROM player WHERE last_name =:name";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':name', $name);
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

    public function disconnect()
    {
        $this->conn = null;
    }
}

?>