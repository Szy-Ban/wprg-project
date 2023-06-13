<?php
session_start();
require '../config.php';

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_agent"])) { // Operacja dodawania agenta
        // Kod do dodawania agenta
    } elseif (isset($_POST["edit_agent"])) { // Operacja edycji agenta
        // Kod do edycji agenta
    } elseif (isset($_POST["delete_agent"])) { // Operacja usuwania agenta
        // Kod do usuwania agenta
    }
}

// Pobranie listy agentow z bazy danych
$query = "SELECT * FROM agents";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$agents = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
<div class="form-container-profile"> <!-- edycja + wyswietlenie wartosci domyslnych -->
<h2> Manage Agents </h2>
<form method="POST" action="manage_agents.php">
    <input type="button" id="add-agent-button" value="Add Agent" class="form-button"><br><br>
    <input type="button" id="edit-agent-button" value="Edit Agent" class="form-button"><br><br>
    <input type="button" id="delete-agent-button" value="Delete Agent" class="form-button"><br><br><br>
</form>
<div class="agents-list">
    <table>
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
</div>
</div>
</div>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>

