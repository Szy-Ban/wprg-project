<?php
session_start();
include('config.php');

if(isset($_GET['city']) && isset($_GET['type'])){ //sprawdzenie czy pole  lub typ jest puste
    $city = $_GET['city'];
    $type = $_GET['type'];

    $stmt = $conn->stmt_init();

    if(empty($city)) { //jezeli wybrane miasto jest puste, wyswietl wszystkie domy w wszystich miastach
        $sql = "SELECT * FROM property WHERE type = ?";
        $stmt->prepare($sql);
        $stmt->bind_param("i", $type);
    }
    else { //jezeli nie to szczegolne miasto
        $sql = "SELECT * FROM property WHERE city = ? AND type = ?";
        $stmt->prepare($sql);
        $stmt->bind_param("si", $city, $type);
    }

    $stmt->execute();
    $result = $stmt->get_result();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Real Estate Company - Search</title>
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
        if (isset($_SESSION['login_user'])) { //jezeli user zalogowany, wyswietlac mozliwosc wylogowania
            echo '<div class="right-nav">';
            echo '<nav>';
            echo '<ul>';
            echo '<li><h1>Hello, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
            echo '<li><a href="#">Profil</a></li>';
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
    <section class="search-container">
        <section class="search-section">
            <form action="search.php" method="GET">
                <div class="search-buttons">
                    <button id="buyButton" class="active" type="button" onclick="toggleButton('buyButton')">Buy</button>
                    <button id="rentButton" type="button" onclick="toggleButton('rentButton')">Rent</button>
                    <input id="type" type="hidden" name="type" value="0">
                </div>
                <div class="search-bar">
                    <input type="text" name="city" placeholder="Search for your dream property | Enter city">
                    <button type="submit">Search</button>
                </div>
            </form>
        </section>
    </section>
    <section class="content-section-houses">
        <?php
            while($row = $result->fetch_assoc()) {
                echo '<div class="property">';
                echo '<h3>City: '.$row['City'].'</h3>';
                echo '<p><b>'.$row['PType'].'</b></p>';
                echo '<p>Address: '.$row['Address'].'</p>';
                echo '<p>Square meters: '.$row['Square_meters'].'</p>';
                echo '<p>Number of rooms: '.$row['nr_rooms'].'</p>';
                echo '<p>Price: <b>'.$row['Price'].' ZŁ</b></p><br><br>';
                echo '<p> Check details</p>';
                echo '</div>';
            }
        ?>
    </section>
    <footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
    </footer>
</body>
</html>
