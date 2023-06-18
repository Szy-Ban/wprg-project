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

    // Pobranie danych agenta, jeśli istnieje powiązanie z daną nieruchomością
    $stmt = $conn->prepare("SELECT a.Agent_ID, a.First_name, a.Last_name, a.Email, a.Phone_number 
                            FROM agents a 
                            INNER JOIN agent_property ap ON a.Agent_ID = ap.Agent_ID 
                            WHERE ap.Property_ID = ?");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $agent = $result->fetch_assoc();
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
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
        <div class="property-field">
            <span>City:</span> 
            <span><?php echo $property['City']; ?></span>
        </div>
        <div class="property-field">
            <span>Address:</span> 
            <span><?php echo $property['Address']; ?></span>
        </div>
        <div class="property-field">
            <span>Square meters:</span> 
            <span><?php echo $property['Square_meters']; ?></span>
        </div>
        <div class="property-field">
            <span>Number of rooms:</span> 
            <span><?php echo $property['nr_rooms']; ?></span>
        </div>
        <div class="property-field">
            <span>Number of bedrooms:</span> 
            <span><?php echo $property['nr_bedrooms']; ?></span>
        </div>
        <div class="property-field">
            <span>Number of bathrooms:</span> 
            <span><?php echo $property['nr_bathrooms']; ?></span>
        </div>
        <div class="property-field">
            <span>Description:</span> 
            <span><?php echo $property['Description']; ?></span>
        </div>
        <div class="property-field">
            <span>Price:</span> 
            <span><?php echo $property['Price']; ?> ZŁ</span>
        </div>
        <div class="property-field">
            <span>Features:</span> 
            <ul>
                <?php
                    if(!$features){
                        echo '<li> No additional features</li>';
                    }
                    foreach($features as $feature) { // dodatkowe udogodnienia jako lista
                        echo '<li>'.$feature['Feature_type'].'</li>';
                    }
                ?>
            </ul>
        </div>
        <div class="property-field">
            <?php if ($agent) { ?>
                <span>Interested? Contact Agent:</span>
                <ul>
                    <li>Name: <?php echo $agent['First_name'] . ' ' . $agent['Last_name']; ?></li>
                    <li>Email: <?php echo $agent['Email']; ?></li>
                    <li>Phone: <?php echo $agent['Phone_number']; ?></li>
                </ul>
            <?php } else { ?>
                <span>Interested? Contact us:</span>
                <a href="contact.php">contact@szy.bani</a>
            <?php } ?>
        </div>
    </div>
</div>
    <footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
    </footer>
</html>
