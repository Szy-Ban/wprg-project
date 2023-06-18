<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_client"])) { // dodawanie klienta
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $role = $_POST['role'];
        $notes = $_POST['notes'];

        $query = "INSERT INTO clients (Password, First_name, Last_name, Email, Phone_number, role, Notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssiss", $hashed_password, $first_name, $last_name, $email, $phone_number, $role, $notes);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_clients.php");
        exit;

    } elseif (isset($_POST["edit_client"])) { // edycja klienta
        $client_id = $_POST['client_id'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $role = $_POST['role'];
        $notes = $_POST['notes'];

        $query = "SELECT * FROM clients WHERE Client_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $client = $result->fetch_assoc();
        $stmt->close();

        if ($client) {
            $query = "UPDATE clients SET Password = ?, First_name = ?, Last_name = ?, Email = ?, Phone_number = ?, role = ?, Notes = ? WHERE Client_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssissi", $hashed_password, $first_name, $last_name, $email, $phone_number, $role, $notes, $client_id);
            $stmt->execute();
            $stmt->close();

            header("Location: manage_clients.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }

    } elseif (isset($_POST["delete_client"])) { // usuwanie klienta
        $client_id = $_POST['client_id'];

        // czy istnieje
        $checkQuery = "SELECT * FROM clients WHERE Client_ID = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("i", $client_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $clientExists = $checkResult->num_rows > 0;
        $checkStmt->close();

        if (!$clientExists) {
            
        } else {
            // czy w client_property table
            $checkAssociatedQuery = "SELECT * FROM client_property WHERE Client_ID = ?";
            $checkAssociatedStmt = $conn->prepare($checkAssociatedQuery);
            $checkAssociatedStmt->bind_param("i", $client_id);
            $checkAssociatedStmt->execute();
            $checkAssociatedResult = $checkAssociatedStmt->get_result();
            $associatedRecords = $checkAssociatedResult->num_rows;
            $checkAssociatedStmt->close();

            // czy w rent table
            $checkRentQuery = "SELECT * FROM rent WHERE Tenant_ID = ?";
            $checkRentStmt = $conn->prepare($checkRentQuery);
            $checkRentStmt->bind_param("i", $client_id);
            $checkRentStmt->execute();
            $checkRentResult = $checkRentStmt->get_result();
            $rentRecords = $checkRentResult->num_rows;
            $checkRentStmt->close();

            // czy w sale table
            $checkSaleQuery = "SELECT * FROM sale WHERE Buyer_ID = ? OR Seller_ID = ?";
            $checkSaleStmt = $conn->prepare($checkSaleQuery);
            $checkSaleStmt->bind_param("ii", $client_id, $client_id);
            $checkSaleStmt->execute();
            $checkSaleResult = $checkSaleStmt->get_result();
            $saleRecords = $checkSaleResult->num_rows;
            $checkSaleStmt->close();

            if ($associatedRecords > 0 || $rentRecords > 0 || $saleRecords > 0) {
                $error_message = "Cannot delete the client. Associated records exist in the client_property, rent, or sale tables.";
            } else {
                $deleteQuery = "DELETE FROM clients WHERE Client_ID = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("i", $client_id);
                $deleteStmt->execute();
                $deleteStmt->close();

                header("Location: manage_clients.php");
                exit;
            }
        }

    } elseif (isset($_POST["search_client"])) { // szukanie klienta
        $searchClientId = $_POST["client_id"];
        $searchFirstName = $_POST["first_name"];
        $searchLastName = $_POST["last_name"];
        $searchEmail = $_POST["email"];
        $searchPhoneNumber = $_POST["phone_number"];
        $searchRole = $_POST["role"];

        $query = "SELECT * FROM clients WHERE 1=1";

        if (!empty($searchClientId)) {
            $query .= " AND Client_ID = '$searchClientId'";
        }
        if (!empty($searchFirstName)) {
            $query .= " AND First_name LIKE '%$searchFirstName%'";
        }
        if (!empty($searchLastName)) {
            $query .= " AND Last_name LIKE '%$searchLastName%'";
        }
        if (!empty($searchEmail)) {
            $query .= " AND Email LIKE '%$searchEmail%'";
        }
        if (!empty($searchPhoneNumber)) {
            $query .= " AND Phone_number = '$searchPhoneNumber'";
        }
        if (!empty($searchRole)) {
            $query .= " AND role = '$searchRole'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $clients = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($clients)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy klientów z bazy danych, jeśli nie wykonano wyszukiwania
if (!isset($_POST["search_client"])) {
    $query = "SELECT * FROM clients";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $clients = $result->fetch_all(MYSQLI_ASSOC);
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
    <h1>Manage Client</h1>
    <form method="POST" action="manage_clients.php">
        <input type="button" id="add-client-button" value="Add Client" class="form-button"><br><br>
        <input type="button" id="edit-client-button" value="Edit Client" class="form-button"><br><br>
        <input type="button" id="search-client-button" value="Search Client" class="form-button"><br><br>
        <input type="button" id="delete-client-button" value="Delete Client" class="form-button"><br><br><br>
    </form>

    <form id="add-client-form" class="hidden" method="POST" action="manage_clients.php">
        <input type="hidden" name="add_client">
        <h3> Add </h3>
        <input class="form-field" type="password" name="password" placeholder="Password" required>
        <input class="form-field" type="text" name="first_name" placeholder="First Name" required>
        <input class="form-field" type="text" name="last_name" placeholder="Last Name" required>
        <input class="form-field" type="text" name="email" placeholder="Email" required>
        <input class="form-field" type="text" name="phone_number" placeholder="Phone Number" required>
        <input class="form-field" type="text" name="role" placeholder="Role" required>
        <textarea class="form-field" name="notes" placeholder="Notes" required></textarea>
        <input type="submit" class="form-button" value="Add Client">
    </form>

    <form id="edit-client-form" class="hidden" method="POST" action="manage_clients.php">
        <input type="hidden" name="edit_client">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="client_id" placeholder="Client ID" required>
        <input class="form-field" type="password" name="password" placeholder="Password" required>
        <input class="form-field" type="text" name="first_name" placeholder="First Name" required>
        <input class="form-field" type="text" name="last_name" placeholder="Last Name" required>
        <input class="form-field" type="text" name="email" placeholder="Email" required>
        <input class="form-field" type="text" name="phone_number" placeholder="Phone Number" required>
        <input class="form-field" type="text" name="role" placeholder="Role" required>
        <textarea class="form-field" name="notes" placeholder="Notes" required></textarea>
        <input type="submit" class="form-button" value="Edit Client">
    </form>

    <form id="search-client-form" class="hidden" method="POST" action="manage_clients.php">
        <input type="hidden" name="search_client">
        <h3> Search </h3>
        <input class="form-field" type="text" name="client_id" placeholder="Client ID">
        <input class="form-field" type="text" name="first_name" placeholder="First Name">
        <input class="form-field" type="text" name="last_name" placeholder="Last Name">
        <input class="form-field" type="text" name="email" placeholder="Email">
        <input class="form-field" type="text" name="phone_number" placeholder="Phone Number">
        <input class="form-field" type="text" name="role" placeholder="Role">
        <input type="submit" class="form-button" value="Search Client">
    </form>

    <form id="delete-client-form" class="hidden" method="POST" action="manage_clients.php">
        <input type="hidden" name="delete_client">
        <h3> Delete </h3>
        <input class="form-field" type="text" name="client_id" placeholder="Client ID" required>
        <input type="submit" class="form-button" value="Delete Client">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='client-list'>
    <table id="crud-table">
        <tr>
            <th>Client ID</th>
            <th>Password</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>Notes</th>
        </tr>
        <?php
            foreach ($clients as $client) {
                echo '<tr>';
                echo '<td>' . $client["Client_ID"] . '</td>';
                echo '<td>******</td>'; // pominięcie wyswietlenia hasla
                echo '<td>' . $client["First_name"] . '</td>';
                echo '<td>' . $client["Last_name"] . '</td>';
                echo '<td>' . $client["Email"] . '</td>';
                echo '<td>' . $client["Phone_number"] . '</td>';
                echo '<td>' . $client["role"] . '</td>';
                echo '<td>' . $client["Notes"] . '</td>';
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
