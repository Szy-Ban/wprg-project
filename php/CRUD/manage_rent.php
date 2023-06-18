<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_rent"])) { //dodawanie najmu
        $property_id = $_POST['property_id'];
        $renter_id = $_POST['renter_id'];
        $tenant_id = $_POST['tenant_id'];
        $monthly_rent = $_POST['monthly_rent'];
        $lease_term = $_POST['lease_term'];

        $query = "INSERT INTO rent (Property_ID, Renter_ID, Tenant_ID, Monthly_rent, Lease_term) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiss", $property_id, $renter_id, $tenant_id, $monthly_rent, $lease_term);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_rent.php");
        exit;

    } elseif (isset($_POST["edit_rent"])) { //edycja  najmu
        $rent_id = $_POST['rent_id'];
        $property_id = $_POST['property_id'];
        $renter_id = $_POST['renter_id'];
        $tenant_id = $_POST['tenant_id'];
        $monthly_rent = $_POST['monthly_rent'];
        $lease_term = $_POST['lease_term'];

        $query = "SELECT * FROM rent WHERE Rent_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $rent_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rent = $result->fetch_assoc();
        $stmt->close();

        if ($rent) {
            $query = "UPDATE rent SET Property_ID = ?, Renter_ID = ?, Tenant_ID = ?, Monthly_rent = ?, Lease_term = ? WHERE Rent_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiissi", $property_id, $renter_id, $tenant_id, $monthly_rent, $lease_term, $rent_id);
            $stmt->execute();
            $stmt->close();
            
            header("Location: manage_rent.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }

    } elseif (isset($_POST["delete_rent"])) { // usuwanie najmu
        $rent_id = $_POST['rent_id'];

        $query = "SELECT * FROM rent WHERE Rent_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $rent_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rent = $result->fetch_assoc();
        $stmt->close();

        if ($rent) {
            $query = "DELETE FROM rent WHERE Rent_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $rent_id);
            $stmt->execute();
            $stmt->close();
            
            header("Location: manage_rent.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }

    } elseif (isset($_POST["search_rent"])) { // szukanie najmu
        $searchRentId = $_POST["rent_id"];
        $searchPropertyId = $_POST["property_id"];
        $searchRenterId = $_POST["renter_id"];
        $searchTenantId = $_POST["tenant_id"];
        $searchMonthlyRent = $_POST["monthly_rent"];
        $searchLeaseTerm = $_POST["lease_term"];

        $query = "SELECT * FROM rent WHERE 1=1"; // Warunek, ktory zawsze jest prawdziwy

        if (!empty($searchRentId)) {
            $query .= " AND Rent_ID = '$searchRentId'";
        }
        if (!empty($searchPropertyId)) {
            $query .= " AND Property_ID = '$searchPropertyId'";
        }
        if (!empty($searchRenterId)) {
            $query .= " AND Renter_ID = '$searchRenterId'";
        }
        if (!empty($searchTenantId)) {
            $query .= " AND Tenant_ID = '$searchTenantId'";
        }
        if (!empty($searchMonthlyRent)) {
            $query .= " AND Monthly_rent LIKE '%$searchMonthlyRent%'";
        }
        if (!empty($searchLeaseTerm)) {
            $query .= " AND Lease_term LIKE '%$searchLeaseTerm%'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $rents = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($rents)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy najmow z bazy danych, jesli nie wykonano wyszukiwania
if (!isset($_POST["search_rent"])) {
    $query = "SELECT * FROM rent";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $rents = $result->fetch_all(MYSQLI_ASSOC);
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
<header> <!-- naglowek -->
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
    <h1>Manage Rent</h1>
    <form method="POST" action="manage_rent.php">
        <input type="button" id="add-rent-button" value="Add Rent" class="form-button"><br><br>
        <input type="button" id="edit-rent-button" value="Edit Rent" class="form-button"><br><br>
        <input type="button" id="search-rent-button" value="Search Rent" class="form-button"><br><br>
        <input type="button" id="delete-rent-button" value="Delete Rent" class="form-button"><br><br><br>
    </form>

    <form id="add-rent-form" class="hidden" method="POST" action="manage_rent.php">
        <input type="hidden" name="add_rent">
        <h3> Add </h3>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" type="text" name="renter_id" placeholder="Renter ID" required>
        <input class="form-field" type="text" name="tenant_id" placeholder="Tenant ID" required>
        <input class="form-field" type="text" name="monthly_rent" placeholder="Monthly Rent" required>
        <input class="form-field" type="text" name="lease_term" placeholder="Lease Term" required>
        <input type="submit" class="form-button" value="Add Rent">
    </form>

    <form id="edit-rent-form" class="hidden" method="POST" action="manage_rent.php">
        <input type="hidden" name="edit_rent">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="rent_id" placeholder="Rent ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" type="text" name="renter_id" placeholder="Renter ID" required>
        <input class="form-field" type="text" name="tenant_id" placeholder="Tenant ID" required>
        <input class="form-field" type="text" name="monthly_rent" placeholder="Monthly Rent" required>
        <input class="form-field" type="text" name="lease_term" placeholder="Lease Term" required>
        <input type="submit" class="form-button" value="Edit Rent">
    </form>

    <form id="search-rent-form" class="hidden" method="POST" action="manage_rent.php">
        <input type="hidden" name="search_rent">
        <h3> Search </h3>
        <input class="form-field" type="text" name="rent_id" placeholder="Rent ID">
        <input class="form-field" type="text" name="property_id" placeholder="Property ID">
        <input class="form-field" type="text" name="renter_id" placeholder="Renter ID">
        <input class="form-field" type="text" name="tenant_id" placeholder="Tenant ID">
        <input class="form-field" type="text" name="monthly_rent" placeholder="Monthly Rent">
        <input class="form-field" type="text" name="lease_term" placeholder="Lease Term">
        <input type="submit" class="form-button" value="Search Rent">
    </form>
    <form id="delete-rent-form" class="hidden" method="POST" action="manage_rent.php">
    <input type="hidden" name="delete_rent">
    <h3> Delete </h3>
    <input class="form-field" type="text" name="rent_id" placeholder="Rent ID" required>
    <input type="submit" class="form-button" value="Delete Rent">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='rent-list'>
    <table id="crud-table">
        <tr>
            <th>Rent ID</th>
            <th>Property ID</th>
            <th>Renter ID</th>
            <th>Tenant ID</th>
            <th>Monthly Rent</th>
            <th>Lease Term</th>
        </tr>
        <?php
            foreach ($rents as $rent) {
                echo '<tr>';
                echo '<td>' . $rent["Rent_ID"] . '</td>';
                echo '<td>' . $rent["Property_ID"] . '</td>';
                echo '<td>' . $rent["Renter_ID"] . '</td>';
                echo '<td>' . $rent["Tenant_ID"] . '</td>';
                echo '<td>' . $rent["Monthly_rent"] . '</td>';
                echo '<td>' . $rent["Lease_term"] . '</td>';
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
