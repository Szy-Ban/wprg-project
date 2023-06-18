<?php
session_start();
include('config.php');

if(isset($_GET['city']) && isset($_GET['type'])){
    $city = $_GET['city'];
    $type = $_GET['type'];
    $ptype = isset($_GET['ptype']) ? $_GET['ptype'] : null;
    $min_nr_rooms = isset($_GET['min_nr_rooms']) ? $_GET['min_nr_rooms'] : null;
    $max_nr_rooms = isset($_GET['max_nr_rooms']) ? $_GET['max_nr_rooms'] : null;
    $min_nr_bedrooms = isset($_GET['min_nr_bedrooms']) ? $_GET['min_nr_bedrooms'] : null;
    $max_nr_bedrooms = isset($_GET['max_nr_bedrooms']) ? $_GET['max_nr_bedrooms'] : null;
    $min_nr_bathrooms = isset($_GET['min_nr_bathrooms']) ? $_GET['min_nr_bathrooms'] : null;
    $max_nr_bathrooms = isset($_GET['max_nr_bathrooms']) ? $_GET['max_nr_bathrooms'] : null;
    $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
    $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;
    $min_square_meters = isset($_GET['min_square_meters']) ? $_GET['min_square_meters'] : null;
    $max_square_meters = isset($_GET['max_square_meters']) ? $_GET['max_square_meters'] : null;

    $stmt = $conn->stmt_init();
    $params = array();

    $sql = "SELECT * FROM property WHERE type = ?";
    $params[] = $type;

    if(!empty($city)) {
        $sql .= " AND city = ?";
        $params[] = $city;
    }

    if(!empty($ptype)) {
        $sql .= " AND PType = ?";
        $params[] = $ptype;
    }

    if(!empty($min_nr_rooms)) {
        $sql .= " AND nr_rooms >= ?";
        $params[] = $min_nr_rooms;
    }

    if(!empty($max_nr_rooms)) {
        $sql .= " AND nr_rooms <= ?";
        $params[] = $max_nr_rooms;
    }

    if(!empty($min_nr_bedrooms)) {
        $sql .= " AND nr_bedrooms >= ?";
        $params[] = $min_nr_bedrooms;
    }

    if(!empty($max_nr_bedrooms)) {
        $sql .= " AND nr_bedrooms <= ?";
        $params[] = $max_nr_bedrooms;
    }

    if(!empty($min_nr_bathrooms)) {
        $sql .= " AND nr_bathrooms >= ?";
        $params[] = $min_nr_bathrooms;
    }

    if(!empty($max_nr_bathrooms)) {
        $sql .= " AND nr_bathrooms <= ?";
        $params[] = $max_nr_bathrooms;
    }

    if(!empty($min_price)) {
        $sql .= " AND Price >= ?";
        $params[] = $min_price;
    }

    if(!empty($max_price)) {
        $sql .= " AND Price <= ?";
        $params[] = $max_price;
    }

    if(!empty($min_square_meters)) {
        $sql .= " AND Square_meters >= ?";
        $params[] = $min_square_meters;
    }

    if(!empty($max_square_meters)) {
        $sql .= " AND Square_meters <= ?";
        $params[] = $max_square_meters;
    }

    $stmt->prepare($sql);

    //dynamiczna ilosc parametrow
    $paramTypes = str_repeat("s", count($params));
    $stmt->bind_param($paramTypes, ...$params);

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    header("Location: index.php");
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
<header>
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
        if (isset($_SESSION['login_user'])) {
            echo '<div class="right-nav">';
            echo '<nav>';
            echo '<ul>';
            echo '<li><h1>Hello, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
            echo '<li><a href="profile.php">Profile</a></li>';
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
<section class="search-container" id="searchContainer">
    <section class="search-section">
        <form action="search.php" method="GET">
            <div class="search-buttons">
                <button id="buyButton" class="active" type="button" onclick="toggleButton('buyButton')">Buy</button>
                <button id="rentButton" type="button" onclick="toggleButton('rentButton')">Rent</button>
                <input id="type" type="hidden" name="type" value="0">
            </div>
            <div class="search-bar">
                <br><label><b>Type<b></label><br>
                <select name="ptype" class="select-style">
                    <option value="">Any Type</option>
                    <option value="apartment">Apartment</option>
                    <option value="house">House</option>
                </select>
                <br><br><label><b>City<b></label><br>
                <input type="text" name="city" placeholder="Enter city">
                <br><label><b>Number of Rooms<b></label><br>
                <input type="number" name="min_nr_rooms" placeholder="Min Number of Rooms" min="0">
                <input type="number" name="max_nr_rooms" placeholder="Max Number of Rooms" min="0">
                <br><label><b>Number of Bedrooms<b></label><br>
                <input type="number" name="min_nr_bedrooms" placeholder="Min Number of Bedrooms" min="0">
                <input type="number" name="max_nr_bedrooms" placeholder="Max Number of Bedrooms" min="0">
                <br><label><b>Number of Bathrooms<b></label><br>
                <input type="number" name="min_nr_bathrooms" placeholder="Min Number of Bathrooms" min="0">
                <input type="number" name="max_nr_bathrooms" placeholder="Max Number of Bathrooms" min="0">
                <br><label><b>Square Meters<b></label><br>
                <input type="number" name="min_square_meters" placeholder="Min Square Meters" min="0">
                <input type="number" name="max_square_meters" placeholder="Max Square Meters" min="0">
                <br><label><b>Price<b></label><br>
                <input type="number" name="min_price" placeholder="Min Price" min="0">
                <input type="number" name="max_price" placeholder="Max Price" min="0">
                

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
        echo '<p>Price: <b>'.$row['Price'].' ZŁ</b></p>';
        echo '<a href="property_details.php?id='.$row['Property_ID'].'"><button class="detail-button">Check Details</button></a>';
        echo '</div>';
    }
    ?>
</section>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>
