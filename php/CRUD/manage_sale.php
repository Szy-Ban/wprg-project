<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_sale"])) { //dodawanie sprzedazy
        $property_id = $_POST['property_id'];
        $sale_price = $_POST['sale_price'];
        $date = $_POST['date'];
        $buyer_id = $_POST['buyer_id'];
        $seller_id = $_POST['seller_id'];

        $query = "INSERT INTO sale (Property_ID, Sale_price, Date, Buyer_ID, Seller_ID) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issii", $property_id, $sale_price, $date, $buyer_id, $seller_id);
        $stmt->execute();
        $stmt->close();
        
        header("Location: manage_sale.php");
        exit;

    } elseif (isset($_POST["edit_sale"])) { //edycja sprzedazy
        $sale_id = $_POST['sale_id'];
        $property_id = $_POST['property_id'];
        $sale_price = $_POST['sale_price'];
        $date = $_POST['date'];
        $buyer_id = $_POST['buyer_id'];
        $seller_id = $_POST['seller_id'];

        $query = "SELECT * FROM sale WHERE Sale_ID = ? AND Seller_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $sale_id, $_SESSION['login_user']);
        $stmt->execute();
        $result = $stmt->get_result();
        $sale = $result->fetch_assoc();
        $stmt->close();

        if ($sale) {
            $query = "UPDATE sale SET Property_ID = ?, Sale_price = ?, Date = ?, Buyer_ID = ?, Seller_ID = ? WHERE Sale_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("issiii", $property_id, $sale_price, $date, $buyer_id, $seller_id, $sale_id);
            $stmt->execute();
            $stmt->close();
            
            header("Location: manage_sale.php");
            exit;
        } else {
            $error_message = "No record in base.";
        }

    } elseif (isset($_POST["delete_sale"])) { // usuwanie sprzedazy
        $sale_id = $_POST['sale_id'];

        $query = "SELECT * FROM sale WHERE Sale_ID = ? AND Seller_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $sale_id, $_SESSION['login_user']);
        $stmt->execute();
        $result = $stmt->get_result();
        $sale = $result->fetch_assoc();
        $stmt->close();

        if ($sale) {
            $query = "DELETE FROM sale WHERE Sale_ID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $sale_id);
            $stmt->execute();
            $stmt->close();
            
            header("Location: manage_sale.php");
            exit;
        } else {
            $$error_message = "No record in base.";
        }

    } elseif (isset($_POST["search_sale"])) { // szukanie sprzedazy
        $searchSaleId = $_POST["sale_id"];
        $searchPropertyId = $_POST["property_id"];
        $searchSalePrice = $_POST["sale_price"];
        $searchDate = $_POST["date"];
        $searchBuyerId = $_POST["buyer_id"];
        $searchSellerId = $_POST["seller_id"];

        $query = "SELECT * FROM sale WHERE 1=1"; // Warunek, ktory zawsze jest prawdziwy

        if (!empty($searchSaleId)) {
            $query .= " AND Sale_ID = '$searchSaleId'";
        }
        if (!empty($searchPropertyId)) {
            $query .= " AND Property_ID = '$searchPropertyId'";
        }
        if (!empty($searchSalePrice)) {
            $query .= " AND Sale_price LIKE '%$searchSalePrice%'";
        }
        if (!empty($searchDate)) {
            $query .= " AND Date LIKE '%$searchDate%'";
        }
        if (!empty($searchBuyerId)) {
            $query .= " AND Buyer_ID = '$searchBuyerId'";
        }
        if (!empty($searchSellerId)) {
            $query .= " AND Seller_ID = '$searchSellerId'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $sales = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($sales)) {
            $error_message = "No record in base.";
        }
    }
}

// Pobranie listy sprzedazy z bazy danych, jesli nie wykonano wyszukiwania
if (!isset($_POST["search_sale"])) {
    $query = "SELECT * FROM sale";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $sales = $result->fetch_all(MYSQLI_ASSOC);
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
    <h1>Manage Sale</h1>
    <form method="POST" action="manage_sale.php">
        <input type="button" id="add-sale-button" value="Add Sale" class="form-button"><br><br>
        <input type="button" id="edit-sale-button" value="Edit Sale" class="form-button"><br><br>
        <input type="button" id="search-sale-button" value="Search Sale" class="form-button"><br><br>
        <input type="button" id="delete-sale-button" value="Delete Sale" class="form-button"><br><br><br>
    </form>

    <form id="add-sale-form" class="hidden" method="POST" action="manage_sale.php">
        <input type="hidden" name="add_sale">
        <h3> Add </h3>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" type="text" name="sale_price" placeholder="Sale Price" required>
        <input class="form-field" type="text" name="date" placeholder="Date" required>
        <input class="form-field" type="text" name="buyer_id" placeholder="Buyer ID" required>
        <input class="form-field" type="text" name="seller_id" placeholder="Seller ID" required>
        <input type="submit" class="form-button" value="Add Sale">
    </form>

    <form id="edit-sale-form" class="hidden" method="POST" action="manage_sale.php">
        <input type="hidden" name="edit_sale">
        <h3> Edit </h3>
        <input class="form-field" type="text" name="sale_id" placeholder="Sale ID" required>
        <input class="form-field" type="text" name="property_id" placeholder="Property ID" required>
        <input class="form-field" type="text" name="sale_price" placeholder="Sale Price" required>
        <input class="form-field" type="text" name="date" placeholder="Date" required>
        <input class="form-field" type="text" name="buyer_id" placeholder="Buyer ID" required>
        <input class="form-field" type="text" name="seller_id" placeholder="Seller ID" required>
        <input type="submit" class="form-button" value="Edit Sale">
    </form>

    <form id="search-sale-form" class="hidden" method="POST" action="manage_sale.php">
        <input type="hidden" name="search_sale">
        <h3> Search </h3>
        <input class="form-field" type="text" name="sale_id" placeholder="Sale ID">
        <input class="form-field" type="text" name="property_id" placeholder="Property ID">
        <input class="form-field" type="text" name="sale_price" placeholder="Sale Price">
        <input class="form-field" type="text" name="date" placeholder="Date">
        <input class="form-field" type="text" name="buyer_id" placeholder="Buyer ID">
        <input class="form-field" type="text" name="seller_id" placeholder="Seller ID">
        <input type="submit" class="form-button" value="Search Sale">
    </form>
    <form id="delete-sale-form" class="hidden" method="POST" action="manage_sale.php">
    <input type="hidden" name="delete_sale">
    <h3> Delete </h3>
    <input class="form-field" type="text" name="sale_id" placeholder="Sale ID" required>
    <input type="submit" class="form-button" value="Delete Sale">
    </form>
    <br><br>
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
    <div id='sale-list'>
    <table id="crud-table">
        <tr>
            <th>Sale ID</th>
            <th>Property ID</th>
            <th>Sale Price</th>
            <th>Date</th>
            <th>Buyer ID</th>
            <th>Seller ID</th>
        </tr>
        <?php
            foreach ($sales as $sale) {
                echo '<tr>';
                echo '<td>' . $sale["Sale_ID"] . '</td>';
                echo '<td>' . $sale["Property_ID"] . '</td>';
                echo '<td>' . $sale["Sale_price"] . '</td>';
                echo '<td>' . $sale["Date"] . '</td>';
                echo '<td>' . $sale["Buyer_ID"] . '</td>';
                echo '<td>' . $sale["Seller_ID"] . '</td>';
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


