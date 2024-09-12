<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/blog.css">
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="screen and (max-width: 768px)">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=PT+Sans+Caption:wght@400;700&family=Slabo+27px&display=swap" rel="stylesheet">    
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
                    echo '<div id="login"><a href="logout.php">Logout</a></div>';
                } else {
                    echo '<div id="login"><a href="login.html">Login</a></div>';
                }

                $conn = new mysqli("127.0.0.1", "root", "", "ecs417");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
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
                <li><a href="#contact" class="internal-link">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Blog content -->
    <section class="blog-section no-hide-effect">
        <article class="blog">
            <h3 id="title">Welcome to my blog</h3>
            
            <!-- Posts -->
            <div id="posts">
                <form action="blog.php" method="get">
                <label for="month">Select month:</label>
                    <!-- Drop down menu for selecting month -->
                    <select name="month" id="month">
                        <?php
                            if (isset($_GET['month'])) {
                                $selected_month = $_GET['month'];
                            } else {
                                $selected_month = 'select';
                            }
                            echo "<option value='select'>All</option>";
                            
                            $sql = "SELECT DISTINCT DATE_FORMAT(entry_date, '%Y-%m') AS month FROM blog ORDER BY entry_date ASC";
                            $result = $conn->query($sql);
                            
                            while ($row = $result->fetch_assoc()) {
                                $month_value = $row['month'];
                                $month_label = date('F Y', strtotime($month_value));
                                if ($month_value === $selected_month)
                                    echo "<option value='$month_value' selected>$month_label</option>";
                                else
                                    echo "<option value='$month_value'>$month_label</option>";
                            }
                        ?>
                    </select>
                    <input type="submit" value="Filter">
                </form>
                <!-- Display posts using data from database -->
                <?php
                    // Retrieve the entries from the database
                    if (isset($_GET['month']) && $_GET['month'] !== 'select') {
                        $sql = "SELECT title, content, entry_date FROM BLOG WHERE DATE_FORMAT(entry_date, '%Y-%m') = '$selected_month'";
                    } else {
                        $sql = "SELECT title, content, entry_date FROM BLOG";
                    }
                    $result = $conn->query($sql);
                    $entries = [];

                    while ($row = $result->fetch_assoc()) {
                        $entries[] = $row;
                    }

                    // Sort the entries in reverse chronological order by date using bubble sort
                    $length = count($entries);
                    for ($i = 0; $i < $length - 1; $i++) {
                        for ($j = 0; $j < $length - $i - 1; $j++) {
                            $date1 = new DateTime($entries[$j]['entry_date'], new DateTimeZone('UTC'));
                            $date2 = new DateTime($entries[$j + 1]['entry_date'], new DateTimeZone('UTC'));
                            if ($date1 < $date2) {
                                // Swap the entries
                                $temp = $entries[$j];
                                $entries[$j] = $entries[$j + 1];
                                $entries[$j + 1] = $temp;
                            }
                        }
                    }

                    // Display the sorted entries
                    foreach ($entries as $entry) {
                        $date = new DateTime($entry['entry_date'], new DateTimeZone('UTC'));
                        $formattedDate = $date->format('jS F Y, H:i T');
                        echo <<<EOL
                        <section class="no-hide-effect">
                            <div class="post-header">
                                <h4>{$entry['title']}</h4>
                                <h2>&#x1F552 $formattedDate</h2>
                            </div>
                            <hr>
                            <p>{$entry['content']}</p>
                        </section>
                        EOL;
                    }

                    $result->close();
                    $conn->close();
                ?>
                <button><a href="addEntry.php">+ Add Post</a></button>
            </div>

            <!-- Links -->
            <aside id="links">
                <h4>Other Posts</h4>
                <hr>
                <figure>
                    <a href="top_5_attractions.html">
                        <img src="images/attractions_thumbnail.png">
                        <figcaption>My Top 5 Attractions To Visit</figcaption>
                    </a>
                </figure>
                <figure>
                    <a href="top5movies.html">
                        <img src="images/movies_thumbnail.png">
                        <figcaption>My Top 5 Movies</figcaption>
                    </a>
                </figure>
            </aside>

            <!-- Contact section -->
            <aside id="contact">
                <h4>Contact Me</h4>
                <hr>
                <ul>
                    <li><a href="mailto:ahmadaneeka@outlook.com?subject">ahmadaneeka@outlook.com</a></li>
                    <li><a>+447404428519</a></li>
                </ul>
            </aside>
        </article>
    </section>

    <footer>
        <p class="footer"><i>Copyright &#169 2024 | Aneeka Ahmad</i></p>
    </footer>
</body>
</html>