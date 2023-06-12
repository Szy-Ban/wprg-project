<?php
session_start();
include('config.php');

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Pobranie szczegolow domu z bazy danych
    $stmt = $conn->prepare("SELECT * FROM property WHERE Property_ID = ?");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();

    // Pobranie cech domu
    $stmt = $conn->prepare("SELECT Feature_type FROM features_description fd INNER JOIN features f ON fd.Features_Feature_ID = f.Feature_ID 
                            WHERE Property_Property_ID = ?");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $features = $result->fetch_all(MYSQLI_ASSOC);
} else {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Real Estate Company - Property Details</title>
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
<div class="content-section">
    <div class="property-details">  <!-- szczegoly o domu -->
        <h2><?php echo $property['PType']; ?></h2>
        <p>City: <?php echo $property['City']; ?></p>
        <p>Address: <?php echo $property['Address']; ?></p>
        <p>Square meters: <?php echo $property['Square_meters']; ?></p>
        <p>Number of rooms: <?php echo $property['nr_rooms']; ?></p>
        <p>Number of bedrooms: <?php echo $property['nr_bedrooms']; ?></p>
        <p>Number of bathrooms: <?php echo $property['nr_bathrooms']; ?></p>
        <p>Description: <?php echo $property['Description']; ?></p>
        <p>Price: <?php echo $property['Price']; ?> ZŁ</p>
        <p>Features:</p>
        <ul>
            <?php //dodatkowe udogodnienia jako lista
                foreach($features as $feature) {
                    echo '<li>'.$feature['Feature_type'].'</li>';
                }
            ?>
        </ul>
    </div>
    </div>
    <footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
    </footer>
</html>
