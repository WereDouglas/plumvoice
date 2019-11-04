<?php
include 'Connection.php';

$connection = new connection();
$conn = $connection->Connect();

$sql = "Select * from position";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) :
    echo '<br> ' . $row["name"];
endforeach;

