<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $password = $_POST['password'];
    $notes = $_POST['notes'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //utworzenie konta
    $stmt = $conn->prepare("INSERT INTO Clients (Password, First_name, Last_name, Email, Phone_number, Notes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $hashed_password, $firstName, $lastName, $email, $phoneNumber, $notes);

    if ($stmt->execute() === TRUE) {
        header("Location: login.php"); // przeniesienie do login.php
        exit();
    } else { //jezeli nie uda sie uruchomic
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Real Estate Company</title>
    <script src="../js/JavaScript.js"></script>
</head>
<body>
<header>  <!-- naglowek -->
<div class="header-container">
        <div class="left-nav">
        <img src="../img/logo.png">
            <nav>
                <ul>
                <li><h1>Real Estate Company</h1></li><br><br>
                    <li><a href="index.php">Home</a></li>
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
            echo '<li><h1>Witaj, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
            echo '<li><a href="#">Profil</a></li>';
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
    <div class="content-section">
    <form method="POST" action="register.php">
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name"><br>
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name"><br>
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br>
        <label for="phone_number">Phone Number:</label><br>
        <input type="text" id="phone_number" name="phone_number"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <label for="notes">Notes:</label><br>
        <input type="text" id="notes" name="notes"><br>
        <input type="submit" value="Register">
    </form>
</div>
<footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</html>