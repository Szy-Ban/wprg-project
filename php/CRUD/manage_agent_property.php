<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_agent_property"])) { // dodawanie agenta-nieruchomości
        $agent_id = $_POST['agent_id'];
        $property_id = $_POST['property_id'];

        // Sprawdzenie, czy podane ID agenta i ID nieruchomości istnieją
        $agent_query = "SELECT * FROM agents WHERE Agent_ID = ?";
        $agent_stmt = $conn->prepare($agent_query);
        $agent_stmt->bind_param("i", $agent_id);
        $agent_stmt->execute();
        $agent_result = $agent_stmt->get_result();
        $agent = $agent_result->fetch_assoc();
        $agent_stmt->close();

        $property_query = "SELECT * FROM property WHERE Property_ID = ?";
        $property_stmt = $conn->prepare($property_query);
        $property_stmt->bind_param("i", $property_id);
        $property_stmt->execute();
        $property_result = $property_stmt->get_result();
        $property = $property_result->fetch_assoc();
        $property_stmt->close();

        if ($agent && $property) {
            // Sprawdzenie, czy połączenie agenta-nieruchomości już istnieje
            $check_query = "SELECT * FROM agent_property WHERE Agent_ID = ? AND Property_ID = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $agent_id, $property_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $existing_connection = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($existing_connection) {
                $error_message = "Agent-Property connection already exists.";
            } else {
                // Dodanie połączenia agenta-nieruchomości do tabeli agent_property
                $insert_query = "INSERT INTO agent_property (Agent_ID, Property_ID) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("ii", $agent_id, $property_id);
                $insert_stmt->execute();
                $insert_stmt->close();

                header("Location: manage_agent_property.php");
                exit;
            }
        } else {
            $error_message = "Agent or Property does not exist.";
        }
    } elseif (isset($_POST["edit_agent_property"])) { // edycja agenta-nieruchomości
        $agent_property_id = $_POST['agent_property_id'];
        $agent_id = $_POST['agent_id'];
        $property_id = $_POST['property_id'];

        // Sprawdzenie, czy podane ID agenta i ID nieruchomości istnieją
        $agent_query = "SELECT * FROM agents WHERE Agent_ID = ?";
        $agent_stmt = $conn->prepare($agent_query);
        $agent_stmt->bind_param("i", $agent_id);
        $agent_stmt->execute();
        $agent_result = $agent_stmt->get_result();
        $agent = $agent_result->fetch_assoc();
        $agent_stmt->close();

        $property_query = "SELECT * FROM property WHERE Property_ID = ?";
        $property_stmt = $conn->prepare($property_query);
        $property_stmt->bind_param("i", $property_id);
        $property_stmt->execute();
        $property_result = $property_stmt->get_result();
        $property = $property_result->fetch_assoc();
        $property_stmt->close();

        if ($agent && $property) {
            // Sprawdzenie, czy połączenie agenta-nieruchomości już istnieje
            $check_query = "SELECT * FROM agent_property WHERE Agent_ID = ? AND Property_ID = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $agent_id, $property_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $existing_connection = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($existing_connection && $existing_connection['agents_property_ID'] != $agent_property_id) {
                $error_message = "Agent-Property connection already exists.";
            } else {
                // Aktualizacja połączenia agenta-nieruchomości w tabeli agent_property
                $update_query = "UPDATE agent_property SET Agent_ID = ?, Property_ID = ? WHERE agents_property_ID = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("iii", $agent_id, $property_id, $agent_property_id);
                $update_stmt->execute();
                $update_stmt->close();

                header("Location: manage_agent_property.php");
                exit;
            }
        } else {
            $error_message = "Agent or Property does not exist.";
        }
    } elseif (isset($_POST["delete_agent_property"])) { // usuwanie agenta-nieruchomości
        $agent_property_id = $_POST['agent_property_id'];

        // Sprawdzenie, czy podane ID połączenia agenta-nieruchomości istnieje
        $check_query = "SELECT * FROM agent_property WHERE agents_property_ID = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("i", $agent_property_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $existing_connection = $check_result->fetch_assoc();
        $check_stmt->close();

        if ($existing_connection) {
            // Usunięcie połączenia agenta-nieruchomości z tabeli agent_property
            $delete_query = "DELETE FROM agent_property WHERE agents_property_ID = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $agent_property_id);
            $delete_stmt->execute();
            $delete_stmt->close();

            header("Location: manage_agent_property.php");
            exit;
        } else {
            $error_message = "Agent-Property connection does not exist.";
        }
    } elseif (isset($_POST["search_agent_property"])) { // szukanie agenta-nieruchomości
        $searchAgentPropertyId = $_POST["agent_property_id"];
        $searchAgentId = $_POST["agent_id"];
        $searchPropertyId = $_POST["property_id"];

        $query = "SELECT * FROM agent_property WHERE 1=1";

        if (!empty($searchAgentPropertyId)) {
            $query .= " AND agents_property_ID = '$searchAgentPropertyId'";
        }
        if (!empty($searchAgentId)) {
            $query .= " AND Agent_ID = '$searchAgentId'";
        }
        if (!empty($searchPropertyId)) {
            $query .= " AND Property_ID = '$searchPropertyId'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $agent_properties = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($agent_properties)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy agentów i nieruchomości z bazy danych, jeśli nie wykonano wyszukiwania
if (!isset($_POST["search_agent_property"])) {
    $query = "SELECT * FROM agent_property";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $agent_properties = $result->fetch_all(MYSQLI_ASSOC);
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
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
    <h1>Manage Agent Property</h1>
    <form method="POST" action="manage_agent_property.php">
        <input type="button" id="add-agent-property-button" value="Add Agent Property" class="form-button"><br><br>
        <input type="button" id="edit-agent-property-button" value="Edit Agent Property" class="form-button"><br><br>
        <input type="button" id="search-agent-property-button" value="Search Agent Property" class="form-button"><br><br>
        <input type="button" id="delete-agent-property-button" value="Delete Agent Property" class="form-button"><br><br><br>
    </form>

    <form id="add-agent-property-form" class="hidden" method="POST" action="manage_agent_property.php">
        <input type="hidden" name="add_agent_property">
        <h3> Add </h3>
        <input class="form-field" type="text" name="agent_id" placeholder="Agent ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input type="submit" class="form-button" value="Add Agent Property">
    </form>

    <form id="edit-agent-property-form" class="hidden" method="POST" action="manage_agent_property.php">
        <input type="hidden" name="edit_agent_property">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="agent_property_id" placeholder="Agent Property ID" required>
        <input class="form-field" type="text" name="agent_id" placeholder="Agent ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input type="submit" class="form-button" value="Edit Agent Property">
    </form>

    <form id="search-agent-property-form" class="hidden" method="POST" action="manage_agent_property.php">
        <input type="hidden" name="search_agent_property">
        <h3> Search </h3>
        <input class="form-field" type="text" name="agent_property_id" placeholder="Agent Property ID">
        <input class="form-field" type="text" name="agent_id" placeholder="Agent ID">
        <input class="form-field" type="text" name="property_id" placeholder="Property ID">
        <input type="submit" class="form-button" value="Search Agent Property">
    </form>

    <form id="delete-agent-property-form" class="hidden" method="POST" action="manage_agent_property.php">
        <input type="hidden" name="delete_agent_property">
        <h3> Delete </h3>
        <input class="form-field" type="text" name="agent_property_id" placeholder="Agent Property ID" required>
        <input type="submit" class="form-button" value="Delete Agent Property">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='agent-property-list'>
    <table id="crud-table">
        <tr>
            <th>Agent Property ID</th>
            <th>Agent ID</th>
            <th>Property ID</th>
        </tr>
        <?php
            foreach ($agent_properties as $agent_property) {
                echo '<tr>';
                echo '<td>' . $agent_property["agents_property_ID"] . '</td>';
                echo '<td>' . $agent_property["Agent_ID"] . '</td>';
                echo '<td>' . $agent_property["Property_ID"] . '</td>';
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