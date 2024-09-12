<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authenticate Login Details</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="screen and (max-width: 768px)">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=PT+Sans+Caption:wght@400;700&family=Slabo+27px&display=swap" rel="stylesheet">
</head>
<body class="parallax">
    <header>
        <h1>Aneeka Ahmad</h1>
        <h2>Student at Queen Mary's</h2>

        <!-- navigation-bar -->
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="skills_experience.html">Skills/Experience</a></li>
                <li><a href="my_CV.html">My CV</a></li>
                <li><a href="projects.html">Projects</a></li>
                <li><a href="blog.php">Blog</a></li>
            </ul>
        </nav>
    </header>
    <section id="error-window">
        <form action="login.php" method="post">
            <legend>Login Failed</legend>
            <fieldset>
                <h3>&#9888 Incorrect login credentials.</h3>
                <h3>Redirecting...</h3>
            </fieldset>
        </form>
    </section>
    <?php
        session_start();
        $loginSuccess = false;
        $conn = new mysqli("127.0.0.1", "root", "", "ecs417");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $sql = "SELECT ID, email, password FROM LOGINDATA";
            $result = $conn->query($sql);

            while ($row = $result -> fetch_assoc()) {
                if (($row['email'] == $_POST['email']) && ($row['password'] == $_POST['password'])) {
                    $loginSuccess = true;
                    $_SESSION['UserID'] = $row['ID'];
                    header("Location: addEntry.php");
                }
            }

            if (!$loginSuccess) {
                header("Refresh: 5; URL={$_SERVER['HTTP_REFERER']}");
            }
            $result->close();
            $conn->close();
        }
    ?>

    <footer>
        <p class="footer"><i>Copyright &#169 2024 | Aneeka Ahmad</i></p>
    </footer>
</body>
</html>