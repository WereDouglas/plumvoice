<form method="post">
    <label for="name">Name of the position</label>
    <input type="text" name="name" id="name"/>
    <input type="submit" name="submit" value="Submit">
</form>
<?php
if (isset($_POST['submit'])) {

    include 'Connection.php';
    $connection = new Connection();
    $position =[
        "name" =>  htmlspecialchars(strip_tags($_POST['name']))
    ];
    $sql = "INSERT INTO position (name) VALUES (:name)";
    $connection->save($sql,$position);

}

?>