<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_features_description"])) { // dodawanie opisu cechy-nieruchomości
        $property_id = $_POST['property_id'];
        $feature_id = $_POST['feature_id'];

        // Sprawdzenie, czy podane ID nieruchomości i ID cechy istnieją
        $property_query = "SELECT * FROM property WHERE Property_ID = ?";
        $property_stmt = $conn->prepare($property_query);
        $property_stmt->bind_param("i", $property_id);
        $property_stmt->execute();
        $property_result = $property_stmt->get_result();
        $property = $property_result->fetch_assoc();
        $property_stmt->close();

        $feature_query = "SELECT * FROM features WHERE Feature_ID = ?";
        $feature_stmt = $conn->prepare($feature_query);
        $feature_stmt->bind_param("i", $feature_id);
        $feature_stmt->execute();
        $feature_result = $feature_stmt->get_result();
        $feature = $feature_result->fetch_assoc();
        $feature_stmt->close();

        if ($property && $feature) {
            // Sprawdzenie, czy połączenie cechy-nieruchomości już istnieje
            $check_query = "SELECT * FROM features_description WHERE Property_Property_ID = ? AND Features_Feature_ID = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $property_id, $feature_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $existing_connection = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($existing_connection) {
                $error_message = "Feature-Property connection already exists.";
            } else {
                // Dodanie połączenia cechy-nieruchomości do tabeli features_description
                $insert_query = "INSERT INTO features_description (Property_Property_ID, Features_Feature_ID) VALUES (?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("ii", $property_id, $feature_id);
                $insert_stmt->execute();
                $insert_stmt->close();

                header("Location: manage_features_description.php");
                exit;
            }
        } else {
            $error_message = "Property or Feature does not exist.";
        }
    } elseif (isset($_POST["edit_features_description"])) { // edycja opisu cechy-nieruchomości
        $features_description_id = $_POST['features_description_id'];
        $property_id = $_POST['property_id'];
        $feature_id = $_POST['feature_id'];

        // Sprawdzenie, czy podane ID nieruchomości i ID cechy istnieją
        $property_query = "SELECT * FROM property WHERE Property_ID = ?";
        $property_stmt = $conn->prepare($property_query);
        $property_stmt->bind_param("i", $property_id);
        $property_stmt->execute();
        $property_result = $property_stmt->get_result();
        $property = $property_result->fetch_assoc();
        $property_stmt->close();

        $feature_query = "SELECT * FROM features WHERE Feature_ID = ?";
        $feature_stmt = $conn->prepare($feature_query);
        $feature_stmt->bind_param("i", $feature_id);
        $feature_stmt->execute();
        $feature_result = $feature_stmt->get_result();
        $feature = $feature_result->fetch_assoc();
        $feature_stmt->close();

        if ($property && $feature) {
            // Sprawdzenie, czy połączenie cechy-nieruchomości już istnieje
            $check_query = "SELECT * FROM features_description WHERE Property_Property_ID = ? AND Features_Feature_ID = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("ii", $property_id, $feature_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $existing_connection = $check_result->fetch_assoc();
            $check_stmt->close();

            if ($existing_connection && $existing_connection['ID'] != $features_description_id) {
                $error_message = "Feature-Property connection already exists.";
            } else {
                // Aktualizacja połączenia cechy-nieruchomości w tabeli features_description
                $update_query = "UPDATE features_description SET Property_Property_ID = ?, Features_Feature_ID = ? WHERE ID = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("iii", $property_id, $feature_id, $features_description_id);
                $update_stmt->execute();
                $update_stmt->close();

                header("Location: manage_features_description.php");
                exit;
            }
        } else {
            $error_message = "Property or Feature does not exist.";
        }
    } elseif (isset($_POST["delete_features_description"])) { // usuwanie opisu cechy-nieruchomości
        $features_description_id = $_POST['features_description_id'];

        // Sprawdzenie, czy podane ID połączenia cechy-nieruchomości istnieje
        $check_query = "SELECT * FROM features_description WHERE ID = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("i", $features_description_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $existing_connection = $check_result->fetch_assoc();
        $check_stmt->close();

        if ($existing_connection) {
            // Usunięcie połączenia cechy-nieruchomości z tabeli features_description
            $delete_query = "DELETE FROM features_description WHERE ID = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $features_description_id);
            $delete_stmt->execute();
            $delete_stmt->close();

            header("Location: manage_features_description.php");
            exit;
        } else {
            $error_message = "Feature-Property connection does not exist.";
        }
    } elseif (isset($_POST["search_features_description"])) { // szukanie opisu cechy-nieruchomości
        $searchFeaturesDescriptionId = $_POST["features_description_id"];
        $searchPropertyId = $_POST["property_id"];
        $searchFeatureId = $_POST["feature_id"];

        $query = "SELECT * FROM features_description WHERE 1=1";

        if (!empty($searchFeaturesDescriptionId)) {
            $query .= " AND ID = '$searchFeaturesDescriptionId'";
        }
        if (!empty($searchPropertyId)) {
            $query .= " AND Property_Property_ID = '$searchPropertyId'";
        }
        if (!empty($searchFeatureId)) {
            $query .= " AND Features_Feature_ID = '$searchFeatureId'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $features_descriptions = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($features_descriptions)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy opisów cech-nieruchomości z bazy danych, jeśli nie wykonano wyszukiwania
if (!isset($_POST["search_features_description"])) {
    $query = "SELECT * FROM features_description";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $features_descriptions = $result->fetch_all(MYSQLI_ASSOC);
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
    <h1>Manage Features Description</h1>
    <form method="POST" action="manage_features_description.php">
        <input type="button" id="add-features-description-button" value="Add Features Description" class="form-button"><br><br>
        <input type="button" id="edit-features-description-button" value="Edit Features Description" class="form-button"><br><br>
        <input type="button" id="search-features-description-button" value="Search Features Description" class="form-button"><br><br>
        <input type="button" id="delete-features-description-button" value="Delete Features Description" class="form-button"><br><br><br>
    </form>

    <form id="add-features-description-form" class="hidden" method="POST" action="manage_features_description.php">
        <input type="hidden" name="add_features_description">
        <h3> Add </h3>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" type="text" name="feature_id" placeholder="Feature ID" required>
        <input type="submit" class="form-button" value="Add Features Description">
    </form>

    <form id="edit-features-description-form" class="hidden" method="POST" action="manage_features_description.php">
        <input type="hidden" name="edit_features_description">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="features_description_id" placeholder="Features Description ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" type="text" name="feature_id" placeholder="Feature ID" required>
        <input type="submit" class="form-button" value="Edit Features Description">
    </form>

    <form id="search-features-description-form" class="hidden" method="POST" action="manage_features_description.php">
        <input type="hidden" name="search_features_description">
        <h3> Search </h3>
        <input class="form-field" type="text" name="features_description_id" placeholder="Features Description ID">
        <input class="form-field" type="text" name="property_id" placeholder="Property ID">
        <input class="form-field" type="text" name="feature_id" placeholder="Feature ID">
        <input type="submit" class="form-button" value="Search Features Description">
    </form>

    <form id="delete-features-description-form" class="hidden" method="POST" action="manage_features_description.php">
        <input type="hidden" name="delete_features_description">
        <h3> Delete </h3>
        <input class="form-field" type="text" name="features_description_id" placeholder="Features Description ID" required>
        <input type="submit" class="form-button" value="Delete Features Description">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='features-description-list'>
    <table id="crud-table">
        <tr>
            <th>Features Description ID</th>
            <th>Property ID</th>
            <th>Feature ID</th>
        </tr>
        <?php
            foreach ($features_descriptions as $features_description) {
                echo '<tr>';
                echo '<td>' . $features_description["ID"] . '</td>';
                echo '<td>' . $features_description["Property_Property_ID"] . '</td>';
                echo '<td>' . $features_description["Features_Feature_ID"] . '</td>';
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
