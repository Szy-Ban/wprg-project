<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_agent"])) { //dodawanie agenta
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];

        $query = "INSERT INTO agents (First_name, Last_name, Email, Phone_number) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone_number);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_agents.php");
        exit;

    } elseif (isset($_POST["edit_agent"])) { //edycja  agenta
        $agent_id = $_POST['agent_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];

        $query = "UPDATE agents SET First_name = ?, Last_name = ?, Email = ?, Phone_number = ? WHERE Agent_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $phone_number, $agent_id);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_agents.php");
        exit;

    } elseif (isset($_POST["delete_agent"])) { // usuwanie agenta
        $agent_id = $_POST['agent_id'];

        $query = "DELETE FROM agents WHERE Agent_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $agent_id);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_agents.php");
        exit;

    } elseif (isset($_POST["search_agent"])) { // szukanie agenta
        $searchAgentId = $_POST["agent_id"];
        $searchFirstName = $_POST["first_name"];
        $searchLastName = $_POST["last_name"];
        $searchEmail = $_POST["email"];
        $searchPhoneNumber = $_POST["phone_number"];

        $query = "SELECT * FROM agents WHERE 1=1"; // Warunek, ktory zawsze jest prawdziwy

        if (!empty($searchAgentId)) {
            $query .= " AND Agent_ID = '$searchAgentId'";
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
            $query .= " AND Phone_number LIKE '%$searchPhoneNumber%'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $agents = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

    }
}

// Pobranie listy agentow z bazy danych, jesli nie wykonano wyszukiwania
if (!isset($_POST["search_agent"])) {
    $query = "SELECT * FROM agents";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $agents = $result->fetch_all(MYSQLI_ASSOC);
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
<h2> Manage Agents </h2>
<form method="POST" action="manage_agents.php">
    <input type="button" id="add-agent-button" value="Add Agent" class="form-button"><br><br>
    <input type="button" id="edit-agent-button" value="Edit Agent" class="form-button"><br><br>
    <input type="button" id="search-agent-button" value="Search Agent" class="form-button"><br><br>
    <input type="button" id="delete-agent-button" value="Delete Agent" class="form-button"><br><br><br>
</form>

<form id="add-agent-form" class="hidden" method="POST" action="manage_agents.php">
    <input type="hidden" name="add_agent">
    <h3> Add </h3>
    <input class="form-field" type="text" name="first_name" placeholder="First Name" required>
    <input class="form-field" type="text" name="last_name" placeholder="Last Name" required>
    <input class="form-field" type="email" name="email" placeholder="Email" required>
    <input class="form-field" type="text" name="phone_number" placeholder="Phone Number" required>
    <input type="submit" class="form-button" value="Add Agent">
</form>

<form id="edit-agent-form" class="hidden" method="POST" action="manage_agents.php">
    <input type="hidden" name="edit_agent">
    <h3> Edit </h3>
    <input class="form-field" type="text" name="agent_id" placeholder="Agent ID" required>
    <input class="form-field" type="text" name="first_name" placeholder="First Name" required>
    <input class="form-field" type="text" name="last_name" placeholder="Last Name" required>
    <input class="form-field" type="email" name="email" placeholder="Email" required>
    <input class="form-field" type="text" name="phone_number" placeholder="Phone Number" required>
    <input type="submit" class="form-button" value="Edit Agent">
</form>

<form id="search-agent-form" class="hidden" method="POST" action="manage_agents.php">
    <input type="hidden" name="search_agent">
    <h3> Search </h3>
    <input class="form-field" type="text" name="agent_id" placeholder="Agent ID">
    <input class="form-field" type="text" name="first_name" placeholder="First Name">
    <input class="form-field" type="text" name="last_name" placeholder="Last Name">
    <input class="form-field" type="email" name="email" placeholder="Email">
    <input class="form-field" type="text" name="phone_number" placeholder="Phone Number">
    <input type="submit" class="form-button" value="Search Agent">
</form>

<form id="delete-agent-form" class="hidden" method="POST" action="manage_agents.php">
    <input type="hidden" name="delete_agent">
    <h3> Delete </h3>
    <input class="form-field" type="text" name="agent_id" placeholder="Agent ID" required>
    <input type="submit" class="form-button" value="Delete Agent">
</form>

<br><br>
<div class="agents-list">
    <table id="crud-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($agents as $agent) {
                echo '<tr>';
                echo '<td>' . $agent['Agent_ID'] . '</td>';
                echo '<td>' . $agent['First_name'] . '</td>';
                echo '<td>' . $agent['Last_name'] . '</td>';
                echo '<td>' . $agent['Email'] . '</td>';
                echo '<td>' . $agent['Phone_number'] . '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
    <?php
        if ($error_message != "") {
            echo "<div class='error-message'><h3>$error_message</h3></div>";
        }
    ?>
</div>
</div>
</div>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>

