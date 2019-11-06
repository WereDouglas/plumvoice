<?php
/**
 * Created by PhpStorm.
 * User: Douglas
 * Date: 11/5/2019
 * Time: 5:49 PM
 */
$results = null;

if (isset($_GET['submit'])) {
    include 'connection.php';
    $conn = new Connection();
    $name = strip_tags($_GET['last_name']);
     $results = $conn->searchByLastName($name);

}
?>
<html>
<body>
<form action="" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label>Player Last name</label>
    <input type="text" name="last_name">
    <input type="submit" name="submit">
</form>
<?php
if (count($results) > 0) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Full name</th>
            <th>Signed Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($results as $player) {
            echo '<tr>';
            echo '<td>' . $player['name'] . '</td>';
            echo '<td>' . $player['signed_date'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>
</body>
</html>

