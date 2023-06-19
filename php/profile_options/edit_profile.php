<?php
session_start();
require '../config.php';

if (!isset($_SESSION['login_user'])) {
    header("location: ../login.php");
    exit;
}

$client_id = $_SESSION['client_id'];

// Kod do edycji profilu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["save_changes"])) { // Sprawdzamy, czy przycisk "Save Changes" został kliknięty
        $password = $_POST['password'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $notes = $_POST['notes'];

        // Sprawdzenie, czy hasło zostało zmienione
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Jesli haslo nie zostalo zmienione, pobieramy aktualne haslo z bazy danych
            $query = "SELECT Password FROM clients WHERE Client_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $client_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $hashed_password = $user['Password'];
            $stmt->close();
        }

        // Aktualizacja rekordu
        $query = "UPDATE clients SET Password = ?, First_name = ?, Last_name = ?, Email = ?, Phone_number = ?, Notes = ? WHERE Client_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssiss', $hashed_password, $first_name, $last_name, $email, $phone_number, $notes, $client_id);
        $stmt->execute();
        $stmt->close();
        header("location: ../profile.php");
        exit;
    }
}

// Kod do pobrania danych z bazy danych
$query = "SELECT * FROM clients WHERE Client_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $client_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="archive.php">Archive</a></li>
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
    <h2>Update your data - <?php echo $_SESSION['first_name']; ?> <?php echo $_SESSION['last_name']; ?></h2>
    <form method="POST" action="edit_profile.php">
        <label for="password">Password:</label><br>
        <input type="password" class="form-field" id="password" name="password" value="<?php echo $user['Password']; ?>" ><br><br>
        <label for="first_name">First Name:</label><br>
        <input type="text" class="form-field" id="first_name" name="first_name" value="<?php echo $user['First_name']; ?>" required><br><br>
        <label for="last_name">Last Name:</label><br>
        <input type="text" class="form-field" id="last_name" name="last_name" value="<?php echo $user['Last_name']; ?>" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" class="form-field" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required><br><br>
        <label for="phone_number">Phone Number:</label><br>
        <input type="number" class="form-field" id="phone_number" maxlength="11" name="phone_number" value="<?php echo $user['Phone_number']; ?>" required><br><br>
        <label for="notes">Notes:</label><br>
        <textarea id="notes" class="form-field" name="notes"><?php echo htmlspecialchars($user['Notes']); ?></textarea><br><br>
        <input type="submit" name="save_changes" value="Save Changes" class="form-button"><br><br>
    </form>
    <form method="POST" action="../profile.php">
        <input type="submit" name="cancel" value="Cancel" class="form-button">
    </form>
</div>
</div>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>
