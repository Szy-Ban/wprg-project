<?php
require 'config.php';
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (empty($email) || empty($password)) {
            $error_message = "None of the fields can be empty.";
        } else {
        $stmt = $conn->prepare("SELECT * FROM Clients WHERE Email = ?"); //zapytanie szukajace usera z danym emailem
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['Password'])) { //prawidlowe logowaie
            session_start(); //tworzenie potrzebnych sesji
            $_SESSION['login_user'] = true;
            $_SESSION['client_id'] = $user['Client_ID'];
            $_SESSION['first_name'] = $user['First_name'];
            $_SESSION['email'] = $email;
            header('location: index.php'); //przeniesienie do strony glownej
            exit;
        } else { //zle haslo
            $error_message = "Incorrect password!";
            }
        }
        } else { //puste pole
        $error_message = "Please enter both email and password!";
    }
}
   


?>
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
            echo '<li><h1>Hello, ' . $_SESSION['first_name'] . '!</h1></li><br><br>';
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
    <div class="form-container-login">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" class="form-field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-field">
            <input type="submit" value="Login" class="form-button">
        </form>
        <?php
        if ($error_message != "") {
            echo "<div class='error-message'><h3>$error_message</h3></div>";
        }
        ?>
    </div>
</div>
<footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</html>