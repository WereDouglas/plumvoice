<?php
include 'Connection.php';
$connection = new connection();
$sql = "Select * from position";
$result = $connection->listResults($sql);
?>
<table>
    <thead>
    <tr>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo ($row["name"]); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>