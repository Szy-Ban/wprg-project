<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_client_property"])) { // dodawanie klienta-nieruchomości
        $client_id = $_POST['client_id'];
        $property_id = $_POST['property_id'];

        // Sprawdzenie, czy podane ID klienta i ID nieruchomości istnieją
        $client_query = "SELECT * FROM clients WHERE Client_ID = ?";
        $client_stmt = $conn->prepare($client_query);
        $client_stmt->bind_param("i", $client_id);
        $client_stmt->execute();
        $client_result = $client_stmt->get_result();
        $client = $client_result->fetch_assoc();
        $client_stmt->close();

        $property_query = "SELECT * FROM property WHERE Property_ID = ?";
        $property_stmt = $conn->prepare($property_query);
        $property_stmt->bind_param("i", $property_id);
        $property_stmt->execute();
        $property_result = $property_stmt->get_result();
        $property = $property_result->fetch_assoc();
        $property_stmt->close();

        if ($client && $property) {
            // Sprawdzenie, czy połączenie klienta-nieruchomości już istnieje
            $check_query = "SELECT * FROM client_property WHERE Client_ID = ? AND Property_ID = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $client_id, $property_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $existing_connection = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($existing_connection) {
                $error_message = "Client-Property connection already exists.";
            } else {
                // Dodanie połączenia klienta-nieruchomości do tabeli client_property
                $insert_query = "INSERT INTO client_property (Client_ID, Property_ID) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("ii", $client_id, $property_id);
                $insert_stmt->execute();
                $insert_stmt->close();

                header("Location: manage_client_property.php");
                exit;
            }
        } else {
            $error_message = "Client or Property does not exist.";
        }
    } elseif (isset($_POST["edit_client_property"])) { // edycja klienta-nieruchomości
        $client_property_id = $_POST['client_property_id'];
        $client_id = $_POST['client_id'];
        $property_id = $_POST['property_id'];

        // Sprawdzenie, czy podane ID klienta i ID nieruchomości istnieją
        $client_query = "SELECT * FROM clients WHERE Client_ID = ?";
        $client_stmt = $conn->prepare($client_query);
        $client_stmt->bind_param("i", $client_id);
        $client_stmt->execute();
        $client_result = $client_stmt->get_result();
        $client = $client_result->fetch_assoc();
        $client_stmt->close();

        $property_query = "SELECT * FROM property WHERE Property_ID = ?";
        $property_stmt = $conn->prepare($property_query);
        $property_stmt->bind_param("i", $property_id);
        $property_stmt->execute();
        $property_result = $property_stmt->get_result();
        $property = $property_result->fetch_assoc();
        $property_stmt->close();

        if ($client && $property) {
            // Sprawdzenie, czy połączenie klienta-nieruchomości już istnieje
            $check_query = "SELECT * FROM client_property WHERE Client_ID = ? AND Property_ID = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $client_id, $property_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $existing_connection = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($existing_connection && $existing_connection['client_property_ID'] != $client_property_id) {
                $error_message = "Client-Property connection already exists.";
            } else {
                // Aktualizacja połączenia klienta-nieruchomości w tabeli client_property
                $update_query = "UPDATE client_property SET Client_ID = ?, Property_ID = ? WHERE client_property_ID = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("iii", $client_id, $property_id, $client_property_id);
                $update_stmt->execute();
                $update_stmt->close();

                header("Location: manage_client_property.php");
                exit;
            }
        } else {
            $error_message = "Client or Property does not exist.";
        }
    } elseif (isset($_POST["delete_client_property"])) { // usuwanie klienta-nieruchomości
        $client_property_id = $_POST['client_property_id'];

        // Sprawdzenie, czy podane ID połączenia klienta-nieruchomości istnieje
        $check_query = "SELECT * FROM client_property WHERE client_property_ID = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("i", $client_property_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $existing_connection = $check_result->fetch_assoc();
        $check_stmt->close();

        if ($existing_connection) {
            // Usunięcie połączenia klienta-nieruchomości z tabeli client_property
            $delete_query = "DELETE FROM client_property WHERE client_property_ID = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $client_property_id);
            $delete_stmt->execute();
            $delete_stmt->close();

            header("Location: manage_client_property.php");
            exit;
        } else {
            $error_message = "Client-Property connection does not exist.";
        }
    } elseif (isset($_POST["search_client_property"])) { // szukanie klienta-nieruchomości
        $searchClientPropertyId = $_POST["client_property_id"];
        $searchClientId = $_POST["client_id"];
        $searchPropertyId = $_POST["property_id"];

        $query = "SELECT * FROM client_property WHERE 1=1";

        if (!empty($searchClientPropertyId)) {
            $query .= " AND client_property_ID = '$searchClientPropertyId'";
        }
        if (!empty($searchClientId)) {
            $query .= " AND Client_ID = '$searchClientId'";
        }
        if (!empty($searchPropertyId)) {
            $query .= " AND Property_ID = '$searchPropertyId'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $client_properties = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($client_properties)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy klientów i nieruchomości z bazy danych, jeśli nie wykonano wyszukiwania
if (!isset($_POST["search_client_property"])) {
    $query = "SELECT * FROM client_property";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $client_properties = $result->fetch_all(MYSQLI_ASSOC);
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
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
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
    <h1>Manage Client Property</h1>
    <form method="POST" action="manage_client_property.php">
        <input type="button" id="add-client-property-button" value="Add Client Property" class="form-button"><br><br>
        <input type="button" id="edit-client-property-button" value="Edit Client Property" class="form-button"><br><br>
        <input type="button" id="search-client-property-button" value="Search Client Property" class="form-button"><br><br>
        <input type="button" id="delete-client-property-button" value="Delete Client Property" class="form-button"><br><br><br>
    </form>

    <form id="add-client-property-form" class="hidden" method="POST" action="manage_client_property.php">
        <input type="hidden" name="add_client_property">
        <h3> Add </h3>
        <input class="form-field" type="text" name="client_id" placeholder="Client ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input type="submit" class="form-button" value="Add Client Property">
    </form>

    <form id="edit-client-property-form" class="hidden" method="POST" action="manage_client_property.php">
        <input type="hidden" name="edit_client_property">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="client_property_id" placeholder="Client Property ID" required>
        <input class="form-field" type="text" name="client_id" placeholder="Client ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input type="submit" class="form-button" value="Edit Client Property">
    </form>

    <form id="search-client-property-form" class="hidden" method="POST" action="manage_client_property.php">
        <input type="hidden" name="search_client_property">
        <h3> Search </h3>
        <input class="form-field" type="text" name="client_property_id" placeholder="Client Property ID">
        <input class="form-field" type="text" name="client_id" placeholder="Client ID">
        <input class="form-field" type="text" name="property_id" placeholder="Property ID">
        <input type="submit" class="form-button" value="Search Client Property">
    </form>

    <form id="delete-client-property-form" class="hidden" method="POST" action="manage_client_property.php">
        <input type="hidden" name="delete_client_property">
        <h3> Delete </h3>
        <input class="form-field" type="text" name="client_property_id" placeholder="Client Property ID" required>
        <input type="submit" class="form-button" value="Delete Client Property">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='client-property-list'>
    <table id="crud-table">
        <tr>
            <th>Client Property ID</th>
            <th>Client ID</th>
            <th>Property ID</th>
        </tr>
        <?php
            foreach ($client_properties as $client_property) {
                echo '<tr>';
                echo '<td>' . $client_property["client_property_ID"] . '</td>';
                echo '<td>' . $client_property["Client_ID"] . '</td>';
                echo '<td>' . $client_property["Property_ID"] . '</td>';
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
