<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandbox - index</title>
</head>
<body>

    <form actions="" method="post" enctype="multipart/form-data">
        <label for="uploadedFileInput">
                Wybierz plik do wgrania na serwer:
        </label>
        <input type="file" name="uploadedFile" id="uploadedFileInput">
        <input type="submit" value="Wyślij plik" name="submit">
    </form>
<?php 
    $db = new mysqli('localhost', 'root', '', 'memy');
    if(isset($_POST['submit']))
    {
        $fileName = $_FILES['uploadedFile']['name'];
        $targetDir = "img/";
        $imageInfo = getimagesize($_FILES["uploadedFile"]["tmp_name"]);
        if(!is_array($imageInfo)) {
            die("Nieprawidłowy format obrazu!");
        }
        $imgString = file_get_contents($_FILES["uploadedFile"]["tmp_name"]);
        $gdImage = imagecreatefromstring($imgString);
        $targetExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $targetExtension = strtolower($targetExtension);
        $targetFileName = $fileName . hrtime(true);
        $targetFileName = hash("sha256", $targetFileName);
        $targetUrl = $targetDir . $targetFileName . "." . $targetExtension;      
        if(file_exists($targetUrl))
        {
            die("Plik o tej nazwie już istnieje");
        }
        $targetUrl = $targetDir . $targetFileName . ".webp";  
        imagewebp($gdImage, $targetUrl);
        $fileName = $targetFileName . ".webp";
        $dateTime = DATE("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO post (timestamp, filename, ip)
            VALUES ('$dateTime', '$fileName', '$ip')";
        $db->query($sql);
        $db->close();
    }
?>
</body>
</html>