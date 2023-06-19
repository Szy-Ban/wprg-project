<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_property"])) { //dodawanie nieruchomości
        $type = $_POST['type'];
        $ptype = $_POST['ptype'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $zip_code = $_POST['zip_code'];
        $square_meters = $_POST['square_meters'];
        $nr_rooms = $_POST['nr_rooms'];
        $nr_bedrooms = $_POST['nr_bedrooms'];
        $nr_bathrooms = $_POST['nr_bathrooms'];
        $description = htmlspecialchars($_POST['description']);
        $price = $_POST['price'];

        $query = "INSERT INTO property (Type, PType, City, Address, ZIP_Code, Square_meters, nr_rooms, nr_bedrooms, nr_bathrooms, Description, Price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssdiiisi", $type, $ptype, $city, $address, $zip_code, $square_meters, $nr_rooms, $nr_bedrooms, $nr_bathrooms, $description, $price);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_property.php");
        exit;

    } elseif (isset($_POST["edit_property"])) { //edycja nieruchomości
        $property_id = $_POST['property_id'];
        $type = $_POST['type'];
        $ptype = $_POST['ptype'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $zip_code = $_POST['zip_code'];
        $square_meters = $_POST['square_meters'];
        $nr_rooms = $_POST['nr_rooms'];
        $nr_bedrooms = $_POST['nr_bedrooms'];
        $nr_bathrooms = $_POST['nr_bathrooms'];
        $description = htmlspecialchars($_POST['description']);
        $price = $_POST['price'];

        $query = "SELECT * FROM property WHERE Property_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $property_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $property = $result->fetch_assoc();
        $stmt->close();

        if ($property) {
            $query = "UPDATE property SET Type = ?, PType = ?, City = ?, Address = ?, ZIP_Code = ?, Square_meters = ?, nr_rooms = ?, nr_bedrooms = ?, nr_bathrooms = ?, Description = ?, Price = ? WHERE Property_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issssdiiisdi", $type, $ptype, $city, $address, $zip_code, $square_meters, $nr_rooms, $nr_bedrooms, $nr_bathrooms, $feature, $description, $price, $property_id);
            $stmt->execute();
            $stmt->close();


            header("Location: manage_property.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }

    } elseif (isset($_POST["delete_property"])) { // usuwanie nieruchomości
        $property_id = $_POST['property_id'];

        $query = "SELECT * FROM property WHERE Property_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $property_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $property = $result->fetch_assoc();
        $stmt->close();

        if ($property) {
            $query = "DELETE FROM property WHERE Property_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $property_id);
            $stmt->execute();
            $stmt->close();

            header("Location: manage_property.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }

    } elseif (isset($_POST["search_property"])) { // szukanie nieruchomości
        $searchPropertyId = $_POST["property_id"];
        $searchType = $_POST["type"];
        $searchPType = $_POST["ptype"];
        $searchCity = $_POST["city"];
        $searchAddress = $_POST["address"];
        $searchZipCode = $_POST["zip_code"];
        $searchSquareMetersMin = $_POST["square_meters_min"];
        $searchSquareMetersMax = $_POST["square_meters_max"];
        $searchNrRoomsMin = $_POST["nr_rooms_min"];
        $searchNrRoomsMax = $_POST["nr_rooms_max"];
        $searchNrBedroomsMin = $_POST["nr_bedrooms_min"];
        $searchNrBedroomsMax = $_POST["nr_bedrooms_max"];
        $searchNrBathroomsMin = $_POST["nr_bathrooms_min"];
        $searchNrBathroomsMax = $_POST["nr_bathrooms_max"];
        $searchDescription = $_POST["description"];
        $searchPriceMin = $_POST["price_min"];
        $searchPriceMax = $_POST["price_max"];

        $query = "SELECT * FROM property WHERE 1=1"; // Warunek, ktory zawsze jest prawdziwy

        if (!empty($searchPropertyId)) {
            $query .= " AND Property_ID = '$searchPropertyId'";
        }
        if (!empty($searchType)) {
            $query .= " AND Type = '$searchType'";
        }
        if (!empty($searchPType)) {
            $query .= " AND PType = '$searchPType'";
        }
        if (!empty($searchCity)) {
            $query .= " AND City = '$searchCity'";
        }
        if (!empty($searchAddress)) {
            $query .= " AND Address = '$searchAddress'";
        }
        if (!empty($searchZipCode)) {
            $query .= " AND ZIP_Code = '$searchZipCode'";
        }
        if (!empty($searchSquareMetersMin) && !empty($searchSquareMetersMax)) {
            $query .= " AND Square_meters BETWEEN '$searchSquareMetersMin' AND '$searchSquareMetersMax'";
        } elseif (!empty($searchSquareMetersMin)) {
            $query .= " AND Square_meters >= '$searchSquareMetersMin'";
        } elseif (!empty($searchSquareMetersMax)) {
            $query .= " AND Square_meters <= '$searchSquareMetersMax'";
        }
        if (!empty($searchNrRoomsMin) && !empty($searchNrRoomsMax)) {
            $query .= " AND nr_rooms BETWEEN '$searchNrRoomsMin' AND '$searchNrRoomsMax'";
        } elseif (!empty($searchNrRoomsMin)) {
            $query .= " AND nr_rooms >= '$searchNrRoomsMin'";
        } elseif (!empty($searchNrRoomsMax)) {
            $query .= " AND nr_rooms <= '$searchNrRoomsMax'";
        }
        if (!empty($searchNrBedroomsMin) && !empty($searchNrBedroomsMax)) {
            $query .= " AND nr_bedrooms BETWEEN '$searchNrBedroomsMin' AND '$searchNrBedroomsMax'";
        } elseif (!empty($searchNrBedroomsMin)) {
            $query .= " AND nr_bedrooms >= '$searchNrBedroomsMin'";
        } elseif (!empty($searchNrBedroomsMax)) {
            $query .= " AND nr_bedrooms <= '$searchNrBedroomsMax'";
        }
        if (!empty($searchNrBathroomsMin) && !empty($searchNrBathroomsMax)) {
            $query .= " AND nr_bathrooms BETWEEN '$searchNrBathroomsMin' AND '$searchNrBathroomsMax'";
        } elseif (!empty($searchNrBathroomsMin)) {
            $query .= " AND nr_bathrooms >= '$searchNrBathroomsMin'";
        } elseif (!empty($searchNrBathroomsMax)) {
            $query .= " AND nr_bathrooms <= '$searchNrBathroomsMax'";
        }
        if (!empty($searchDescription)) {
            $query .= " AND Description = '$searchDescription'";
        }
        if (!empty($searchPriceMin) && !empty($searchPriceMax)) {
            $query .= " AND Price BETWEEN '$searchPriceMin' AND '$searchPriceMax'";
        } elseif (!empty($searchPriceMin)) {
            $query .= " AND Price >= '$searchPriceMin'";
        } elseif (!empty($searchPriceMax)) {
            $query .= " AND Price <= '$searchPriceMax'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $properties = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($properties)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy nieruchomości z bazy danych, jesli nie wykonano wyszukiwania
if (!isset($_POST["search_property"])) {
    $query = "SELECT * FROM property";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <title>Real Estate Company - Profile</title>
    <script src="../../js/JavaScript.js"></script>
</head>
<body>
<header> <!-- nagłówek -->
    <div class="header-container">
        <div class="left-nav">
            <img src="../../img/logo.png">
            <nav>
                <ul>
                    <li><h1>Real Estate Company</h1></li><br><br>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../about.php">About</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                    <li><a href="../archive.php">Archive</a></li>
                </ul>
            </nav>
        </div>
        <?php
        if (isset($_SESSION['login_user'])) {
            echo '<div class="right-nav">';
            echo '<nav>';
            echo '<ul>';
            echo '<li><h1>Hello, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
            echo '<li><a href="../profile.php">Profile</a></li>';
            echo '<li><a href="../logout.php">Logout</a></li>';
            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        } else {
            header("location: ../login.php");
            exit;
        }
        ?>
    </div>
</header>
<div class="content-section">
<div class="form-container-profile"> <!-- wszystkie przyciski do CRUD -->
    <h1>Manage Property</h1>
    <form method="POST" action="manage_property.php">
        <input type="button" id="add-property-button" value="Add Property" class="form-button"><br><br>
        <input type="button" id="edit-property-button" value="Edit Property" class="form-button"><br><br>
        <input type="button" id="search-property-button" value="Search Property" class="form-button"><br><br>
        <input type="button" id="delete-property-button" value="Delete Property" class="form-button"><br><br><br>
    </form>

    <form id="add-property-form" class="hidden" method="POST" action="manage_property.php">
        <input type="hidden" name="add_property">
        <h3> Add </h3>
        <input class="form-field" maxlength="1" type="text" name="type" placeholder="Type" required>
        <input class="form-field" maxlength="25" type="text" name="ptype" placeholder="PType" required>
        <input class="form-field" maxlength="25" type="text" name="city" placeholder="City" required>
        <input class="form-field" maxlength="25" type="text" name="address" placeholder="Address" required>
        <input class="form-field" maxlength="10" type="text" name="zip_code" placeholder="ZIP Code" required>
        <input class="form-field" maxlength="5" type="text" name="square_meters" placeholder="Square Meters" required>
        <input class="form-field" maxlength="25" type="text" name="nr_rooms" placeholder="Number of Rooms" required>
        <input class="form-field" maxlength="3" type="text" name="nr_bedrooms" placeholder="Number of Bedrooms" required>
        <input class="form-field" maxlength="3" type="text" name="nr_bathrooms" placeholder="Number of Bathrooms" required>
        <input class="form-field" maxlength="50" type="text" name="description" placeholder="Description" required>
        <input class="form-field" maxlength="15" type="text" name="price" placeholder="Price" required>
        <input type="submit" class="form-button" value="Add Property">
    </form>

    <form id="edit-property-form" class="hidden" method="POST" action="manage_property.php">
        <input type="hidden" name="edit_property">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" maxlength="1" type="text" name="type" placeholder="Type" required>
        <input class="form-field" maxlength="25" type="text" name="ptype" placeholder="PType" required>
        <input class="form-field" maxlength="25" type="text" name="city" placeholder="City" required>
        <input class="form-field" maxlength="25" type="text" name="address" placeholder="Address" required>
        <input class="form-field" maxlength="10" type="text" name="zip_code" placeholder="ZIP Code" required>
        <input class="form-field" maxlength="5" type="text" name="square_meters" placeholder="Square Meters" required>
        <input class="form-field" maxlength="25" type="text" name="nr_rooms" placeholder="Number of Rooms" required>
        <input class="form-field" maxlength="3" type="text" name="nr_bedrooms" placeholder="Number of Bedrooms" required>
        <input class="form-field" maxlength="3" type="text" name="nr_bathrooms" placeholder="Number of Bathrooms" required>
        <input class="form-field" maxlength="50" type="text" name="description" placeholder="Description" required>
        <input class="form-field" maxlength="15" type="text" name="price" placeholder="Price" required>
        <input type="submit" class="form-button" value="Edit Property">
    </form>

    <form id="search-property-form" class="hidden" method="POST" action="manage_property.php">
        <input type="hidden" name="search_property">
        <h3> Search </h3>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID">
        <input class="form-field" maxlength="1" type="text" name="type" placeholder="Type">
        <input class="form-field" maxlength="25" type="text" name="ptype" placeholder="PType">
        <input class="form-field" maxlength="25" type="text" name="city" placeholder="City">
        <input class="form-field" maxlength="25" type="text" name="address" placeholder="Address">
        <input class="form-field" maxlength="10" type="text" name="zip_code" placeholder="ZIP Code">
        <input class="form-field" maxlength="5" type="text" name="square_meters_min" placeholder="Min Square Meters">
        <input class="form-field" maxlength="5" type="text" name="square_meters_max" placeholder="Max Square Meters">
        <input class="form-field" maxlength="5" type="text" name="nr_rooms_min" placeholder="Min Number of Rooms">
        <input class="form-field" maxlength="5" type="text" name="nr_rooms_max" placeholder="Max Number of Rooms">
        <input class="form-field" maxlength="5" type="text" name="nr_bedrooms_min" placeholder="Min Number of Bedrooms">
        <input class="form-field" maxlength="5" type="text" name="nr_bedrooms_max" placeholder="Max Number of Bedrooms">
        <input class="form-field" maxlength="5" type="text" name="nr_bathrooms_min" placeholder="Min Number of Bathrooms">
        <input class="form-field" maxlength="5" type="text" name="nr_bathrooms_max" placeholder="Max Number of Bathrooms">
        <input class="form-field" maxlength="50" type="text" name="description" placeholder="Description">
        <input class="form-field" maxlength="15" type="text" name="price_min" placeholder="Min Price">
        <input class="form-field" maxlength="15" type="text" name="price_max" placeholder="Max Price">
        <input type="submit" class="form-button" value="Search Property">
    </form>

    <form id="delete-property-form" class="hidden" method="POST" action="manage_property.php">
    <input type="hidden" name="delete_property">
    <h3> Delete </h3>
    <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
    <input type="submit" class="form-button" value="Delete Property">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='property-list'>
    <table id="crud-table">
        <tr>
            <th>Property ID</th>
            <th>Type</th>
            <th>PType</th>
            <th>City</th>
            <th>Address</th>
            <th>ZIP Code</th>
            <th>Square Meters</th>
            <th>Number of Rooms</th>
            <th>Number of Bedrooms</th>
            <th>Number of Bathrooms</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        <?php
            foreach ($properties as $property) {
                echo '<tr>';
                echo '<td>' . $property["Property_ID"] . '</td>';
                echo '<td>' . $property["Type"] . '</td>';
                echo '<td>' . $property["PType"] . '</td>';
                echo '<td>' . $property["City"] . '</td>';
                echo '<td>' . $property["Address"] . '</td>';
                echo '<td>' . $property["ZIP_Code"] . '</td>';
                echo '<td>' . $property["Square_meters"] . '</td>';
                echo '<td>' . $property["nr_rooms"] . '</td>';
                echo '<td>' . $property["nr_bedrooms"] . '</td>';
                echo '<td>' . $property["nr_bathrooms"] . '</td>';
                echo '<td>' . $property["Description"] . '</td>';
                echo '<td>' . $property["Price"] . '</td>';
                echo '</tr>';
            }
        ?>
    </table>
    </div>
    <?php } ?>
</div>
</div>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>
