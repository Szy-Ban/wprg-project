<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Real Estate Company</title>
    <script src="../js/JavaScript.js"></script>
</head>
<body>
<header>  <!-- naglowek -->
<div class="header-container">
        <div class="left-nav">
        <img src="../img/logo.png">
            <nav>
                <ul>
                <li><h1>Real Estate Company</h1></li><br><br>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
        <?php
        if (isset($_SESSION['login_user'])) { //zmiana wyswietlania headera  w zaleznosci od zalogowania
            echo '<div class="right-nav">';
            echo '<nav>';
            echo '<ul>';
            echo '<li><h1>Hello, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
            echo '<li><a href="profile.php">Profil</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';
            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        } else {
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
    <section class="search-container"> <!-- tlo sekcji do szukania -->
        <section class="search-section"> <!-- sekcja do szukania -->
            <div class="search-buttons">
                <button id="buyButton" class="active" onclick="toggleButton('buyButton')">Buy</button>
                <button id="rentButton" onclick="toggleButton('rentButton')">Rent</button>
              </div>
            <div class="search-bar"> <!-- pole do szukania -->
                <input type="text" placeholder="Search for your dream property | Enter city">
                <button>Search</button>
            </div>
        </section>
    </section>
    <section class="content-section"> <!-- sekcja opisowa strony -->

        Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...<br>
        Curabitur et arcu vel orci vehicula sodales at sit amet nisl. Mauris ultricies varius pellentesque
        
    </section>
    <footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
    </footer>
</body>
</html>
