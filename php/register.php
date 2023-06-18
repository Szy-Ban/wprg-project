<?php
include('config.php');
$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $password = $_POST['password'];
    $notes = $_POST['notes'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // sprawdzanie czy pola nie sa puste
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber) || empty($password) || empty($notes)) {
        $error_message = "None of the fields can be empty.";
    }else{
    //sprawdzenie unikanlnosci maila 
    $stmt = $conn->prepare("SELECT * FROM Clients WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { //sprawdzenie czy mail istnieje
        $error_message = "Email already exists!";
    } else if(strlen($password) < 4) { //czy haslo ma minimum 4 znaki
        $error_message = "Password must be at least 4 characters long!";
    } else {
    //utworzenie konta jezeli nie ma problemow
    $stmt = $conn->prepare("INSERT INTO Clients (Password, First_name, Last_name, Email, Phone_number, Notes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $hashed_password, $firstName, $lastName, $email, $phoneNumber, $notes);

    if ($stmt->execute() === TRUE) {
        header("Location: login.php"); // przeniesienie do login.php
        exit();
    } else { //jezeli nie uda sie uruchomic
        echo "Error: " . $stmt->error;
    }
    }
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
    <div class="form-container-register">
    <h2>Register</h2>
        <form method="POST" action="register.php">
            <label for="first_name">First name:</label>
            <input type="text" id="first_name" name="first_name" class="form-field">
            <label for="last_name">Last name:</label>
            <input type="text" id="last_name" name="last_name" class="form-field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-field">
            <label for="phone_number">Phone number:</label>
            <input type="tel" id="phone_number" name="phone_number" class="form-field">
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" class="form-field"></textarea>
            <input type="submit" value="Register" class="form-button">
        </form>
        <?php
        if ($error_message != '') {
            echo "<div class='error-message'><h3>$error_message</h3></div>";
        }
        ?>
    </div>
</div>
<footer> <!-- Stopka -->
        <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</html>