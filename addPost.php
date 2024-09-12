<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
</head>
<body>
    <?php
        $conn = new mysqli("127.0.0.1", "root", "", "ecs417");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST["title"];
            $content = $conn -> real_escape_string($_POST["content"]);
            date_default_timezone_set('Europe/London');
            $currentDateTime = date("Y-m-d H:i:s");

            $sql = "INSERT INTO BLOG (title, content, entry_date) 
            VALUES ('$title', '$content', '$currentDateTime')";
            
            $conn->query($sql);
            $conn->close();
            header("Location: blog.php");
        }
    ?>
</body>
</html>