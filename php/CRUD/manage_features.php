<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_feature"])) { // dodawanie
        $feature_type = $_POST['feature_type'];

        $query = "INSERT INTO features (Feature_type) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $feature_type);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_features.php");
        exit;
    } elseif (isset($_POST["edit_feature"])) { // edycja
        $feature_id = $_POST['feature_id'];
        $feature_type = $_POST['feature_type'];

        $query = "SELECT * FROM features WHERE Feature_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $feature_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $feature = $result->fetch_assoc();
        $stmt->close();

        if ($feature) {
            $query = "UPDATE features SET Feature_type = ? WHERE Feature_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $feature_type, $feature_id);
            $stmt->execute();
            $stmt->close();

            header("Location: manage_features.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }
    } elseif (isset($_POST["delete_feature"])) { //usuwanie
        $feature_id = $_POST['feature_id'];

        $query = "SELECT * FROM features WHERE Feature_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $feature_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $feature = $result->fetch_assoc();
        $stmt->close();

        if ($feature) {
            $query = "DELETE FROM features WHERE Feature_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $feature_id);
            $stmt->execute();
            $stmt->close();

            header("Location: manage_features.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }
    } elseif (isset($_POST["search_feature"])) { // wyszukiwanie
        $searchFeatureId = $_POST["feature_id"];
        $searchFeatureType = $_POST["feature_type"];

        $query = "SELECT * FROM features WHERE 1=1";

        if (!empty($searchFeatureId)) {
            $query .= " AND Feature_ID = '$searchFeatureId'";
        }
        if (!empty($searchFeatureType)) {
            $query .= " AND Feature_type LIKE '%$searchFeatureType%'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $features = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($features)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy cech z bazy danych, jesli nie wykonano wyszukiwania
if (!isset($_POST["search_feature"])) {
    $query = "SELECT * FROM features";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $features = $result->fetch_all(MYSQLI_ASSOC);
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
<h2> Manage Features </h2>
<form method="POST" action="manage_features.php">
    <input type="button" id="add-feature-button" value="Add Feature" class="form-button"><br><br>
    <input type="button" id="edit-feature-button" value="Edit Feature" class="form-button"><br><br>
    <input type="button" id="search-feature-button" value="Search Feature" class="form-button"><br><br>
    <input type="button" id="delete-feature-button" value="Delete Feature" class="form-button"><br><br><br>
</form>

<form id="add-feature-form" class="hidden" method="POST" action="manage_features.php">
    <input type="hidden" name="add_feature">
    <h3> Add </h3>
    <input class="form-field" type="text" name="feature_type" placeholder="Feature Type" required>
    <input type="submit" class="form-button" value="Add Feature">
</form>

<form id="edit-feature-form" class="hidden" method="POST" action="manage_features.php">
    <input type="hidden" name="edit_feature">
    <h3> Edit </h3>
    <input class="form-field" type="text" name="feature_id" placeholder="Feature ID" required>
    <input class="form-field" type="text" name="feature_type" placeholder="Feature Type" required>
    <input type="submit" class="form-button" value="Edit Feature">
</form>

<form id="search-feature-form" class="hidden" method="POST" action="manage_features.php">
    <input type="hidden" name="search_feature">
    <h3> Search </h3>
    <input class="form-field" type="text" name="feature_id" placeholder="Feature ID">
    <input class="form-field" type="text" name="feature_type" placeholder="Feature Type">
    <input type="submit" class="form-button" value="Search Feature">
</form>

<form id="delete-feature-form" class="hidden" method="POST" action="manage_features.php">
    <input type="hidden" name="delete_feature">
    <h3> Delete </h3>
    <input class="form-field" type="text" name="feature_id" placeholder="Feature ID" required>
    <input type="submit" class="form-button" value="Delete Feature">
</form>

<br><br>
<?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
<div class="features-list">
    <table id="crud-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Feature Type</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($features as $feature) {
                echo '<tr>';
                echo '<td>' . $feature['Feature_ID'] . '</td>';
                echo '<td>' . $feature['Feature_type'] . '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
    <?php } ?>
</div>
</div>
</div>
<footer>
    <p>&copy; 2023 Szymon Baniewicz - WPRG Project.</p>
</footer>
</body>
</html>
