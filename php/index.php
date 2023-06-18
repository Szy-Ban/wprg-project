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
                    <li><a href="index.php"><u>Home</u></a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
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
<section class="search-container" id="searchContainer"> <!-- tlo sekcji do szukania -->
    <section class="search-section"> <!-- sekcja do szukania -->
        <div class="search-buttons">
            <button class="button active" id="buyButton" onclick="toggleButton('buyButton')">Buy</button>
            <button class="button" id="rentButton" onclick="toggleButton('rentButton')">Rent</button>
        </div>
        <div class="search-bar"> <!--pole do szukania, formularz i przechodzenie do podstrony wyszukiwania -->
            <form action="search.php" method="GET">
                <input type="text" name="city" placeholder="Enter city">
                <input type="hidden" id="type" name="type" value="0">
                <button type="submit">Search</button>
            </form>
        </div>
    </section>
</section>
    <section class="content-section"> <!-- sekcja opisowa strony -->
    <section class="form-container-index" style="font-size: 20px">
        Welcome to Real Estate Company, your trusted partner in finding your dream property. We specialize in providing exceptional real estate services, connecting buyers and sellers, and assisting our clients in making informed decisions. With our extensive knowledge of the market and a dedicated team of professionals, we strive to deliver outstanding results and exceed your expectations. Whether you are looking to buy, sell, or rent a property, Real Estate Company is here to guide you every step of the way.
    </section>
    </section>
    <footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
    </footer>
</body>
</html>
