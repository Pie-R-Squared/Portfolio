<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="screen and (max-width: 768px)">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=PT+Sans+Caption:wght@400;700&family=Slabo+27px&display=swap" rel="stylesheet">
    <script src="js/script.js" defer></script>
</head>
<body class="parallax">
    <header>
        <div id="header-top">
            <div>
                <h1>Aneeka Ahmad</h1>
                <h2>Student at Queen Mary's</h2>
            </div>
            <?php
                session_start();
                if (isset($_SESSION['UserID'])) {
                    echo '<div id="post-login"><div id="login"><a href="logout.php">Logout</a></div>';
                    echo '<aside id="login-notification"><p>Welcome back, Aneeka</p> </aside></div>';
                } else {
                    header("Location: login.html");
                }
            ?>
        </div>

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

    <!-- Blog content -->
    <section class="blog-post">
        <form action="addPost.php" method="post">
            <legend>Create new post</legend>

            <fieldset id="title-section">
                <!-- Title field -->
                <input type="text" id="title" name="title" placeholder="Title" required>
            </fieldset>

            <fieldset id="content-section">
                <!-- Content field with variable textbox size -->
                <textarea id="content" name="content" placeholder="Content..." required></textarea>
            </fieldset>

            <fieldset class="buttons">
                <button type="submit" id="submit-post">Submit</button>
                <button id="preview">Preview</button>
                <button type="reset">Clear</button>
            </fieldset>
        </form>
    </section>

    <footer>
        <p class="footer"><i>Copyright &#169 2024 | Aneeka Ahmad</i></p>
    </footer>
</body>
</html>