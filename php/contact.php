<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Real Estate Company - Profile</title>
    <script src="../js/JavaScript.js"></script>
</head>
<body>
<header> <!-- naglowek -->
    <div class="header-container">
        <div class="left-nav">
            <img src="../img/logo.png">
            <nav>
                <ul>
                    <li><h1>Real Estate Company</h1></li><br><br>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php"><u>Contact</u></a></li>
                    <li><a href="archive.php">Archive</a></li>
                </ul>
            </nav>
        </div>
        <?php
        if (isset($_SESSION['login_user'])) {  //jezeli user zalogowany, wyswietlac mozliwosc wylogowania
            echo '<div class="right-nav">';
            echo '<nav>';
            echo '<ul>';
            echo '<li><h1>Hello, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
            echo '<li><a href="profile.php">Profile</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';
            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        } else { //jezeli nie zalogowany, wyswietlac mozliwosc logowania i stworzenia konta
            echo '<div class="right-nav">';
            echo '<nav>';
            echo '<ul>';
            echo '<li><a href="login.php">Login</a></li><br><br>';
            echo '<li><a href="register.php">Sign up</a></li>';
            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        }
        ?>
    </div>
</header>
<section class="content-section"> <!-- sekcja opisowa strony -->
        <section class="form-container-index" style="font-size: 20px">
        If you have any inquiries or would like to learn more about our services, please don't hesitate to get in touch with us. Our friendly and knowledgeable team is ready to assist you.

        <br><br>Phone: 123321321<br>
        Email: office@szy.bani<br>
        Office Address: Bojano B3<br><br>
        We look forward to serving you and helping you achieve your real estate goals!
    </section>
    </section>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>
