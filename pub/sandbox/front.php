<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandbox - front</title>
</head>
<body>

<?php
    $db = new mysqli('localhost', 'root', '', 'memy');
    $sql = "SELECT filename FROM post ORDER BY timestamp";
    $result = $db->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "<img width='300' src=img/" . $row['filename'] . "><br>";
    }
    $db->close();
?>
</body>
</html>