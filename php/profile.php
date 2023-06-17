<?php
session_start();
require 'config.php';

if(!isset($_SESSION['login_user']) || !$_SESSION['login_user']){ //zabepieczenie do nie wchodzenia na strone bez bycia zalogowanym
    header("location: login.php");
    exit;
}

$client_id = $_SESSION['client_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) { //usuwanie konta
    $stmt = $conn->prepare("DELETE FROM Clients WHERE Client_ID = ?");
    $stmt->bind_param("i", $client_id);
    if ($stmt->execute()) {
        session_destroy();
        header("location: login.php");
        exit;
    }
}

// pobieranie roli użytkownika
$stmt = $conn->prepare("SELECT role FROM Clients WHERE Client_ID = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$role = $user['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Real Estate Company - Profile</title>
    <script src="../js/JavaScript.js"></script>
</head>
<body>
<header> <!-- naglowek -->
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
            header("location: login.php");
            exit;
        }
        ?>
    </div>
</header>
<div class="content-section">
    <div class="form-container-profile"> <!-- wszystkie przyciski do edycji konta, CRUDS itd -->
        <h2>Manage your account - <?php echo $_SESSION['first_name']; ?> <?php echo $_SESSION['last_name']; ?></h2>
        <form method="POST" action="../php/profile_options/edit_profile.php">
            <input type="submit" name="edit_profile" value="Edit Profile" class="form-button"><br><br>
        </form>
        <form method="POST" action="profile.php">
            <input type="submit" name="delete_account" value="Delete Account" class="form-button" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');"><br>
        </form>
        <?php if ($role == 'admin') { ?>
        <h2> Manage tables [CRUD] </h2>
        <form method="POST" action="../php/CRUD/manage_agents.php">
            <input type="submit" name="manage_agents" value="Manage Agents" class="form-button"><br><br>
        </form>
        <form method="POST" action="../php/CRUD/manage_features.php">
            <input type="submit" name="manage_features" value="Manage Features" class="form-button"><br><br>
        </form>
        <form method="POST" action="../php/CRUD/manage_commissions_sale.php">
            <input type="submit" name="manage_features" value="Manage Commisions - Sales" class="form-button"><br><br>
        </form>
        <form method="POST" action="../php/CRUD/manage_commissions_rent.php">
            <input type="submit" name="manage_features" value="Manage Commisions - Rents" class="form-button"><br><br>
        </form>
        <form method="POST" action="../php/CRUD/manage_rent.php">
            <input type="submit" name="manage_rent" value="Manage Rent" class="form-button"><br><br>
        </form>
        <form method="POST" action="../php/CRUD/manage_sale.php">
            <input type="submit" name="manage_sale" value="Manage Sale" class="form-button"><br><br>
        </form>
        <form method="POST" action="../php/CRUD/manage_property.php">
            <input type="submit" name="manage_property" value="Manage Property" class="form-button"><br><br>
        </form>
        <?php } ?>
        <?php if ($role == 'user') { 
        echo '<h2>User Information</h2>';
        $stmt = $conn->prepare("SELECT * FROM Clients WHERE Client_ID = ?");
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        echo '<p><b>First Name</b>: '.$user['First_name'].'</p>';
        echo '<p><b>Last Name</b>: '.$user['Last_name'].'</p>';
        echo '<p><b>Email</b>: '.$user['Email'].'</p>';
        echo '<p><b>Notes</b>: '.$user['Notes'].'</p>';
        }?>
    </div>
</div>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>
