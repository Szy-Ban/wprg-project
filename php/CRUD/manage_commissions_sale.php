<?php
session_start();
require '../config.php';

$error_message = "";

if (!isset($_SESSION['login_user']) || !$_SESSION['login_user']) { 
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_commission"])) { //dodawanie
        $sale_id = $_POST['sale_id'];
        $commission_rate = $_POST['commission_rate'];
        $profit = $_POST['profit'];
        $agent_id = $_POST['agent_id'];

        $query = "INSERT INTO commissions_sale (Sale_ID, Comission_rate, Profit, Agent_ID) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iddi", $sale_id, $commission_rate, $profit, $agent_id);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_commissions_sale.php");
        exit;
    } elseif (isset($_POST["edit_commission"])) { // edytowanie
        $commission_id = $_POST['commission_id'];
        $sale_id = $_POST['sale_id'];
        $commission_rate = $_POST['commission_rate'];
        $profit = $_POST['profit'];
        $agent_id = $_POST['agent_id'];

        $query = "UPDATE commissions_sale SET Sale_ID = ?, Comission_rate = ?, Profit = ?, Agent_ID = ? WHERE Comission_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idddi", $sale_id, $commission_rate, $profit, $agent_id, $commission_id);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_commissions_sale.php");
        exit;
    } elseif (isset($_POST["delete_commission"])) { //usuwanie
        $commission_id = $_POST['commission_id'];

        $query = "DELETE FROM commissions_sale WHERE Comission_ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $commission_id);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_commissions_sale.php");
        exit;
    } elseif (isset($_POST["search_commission"])) { // szukanie
        $searchCommissionId = $_POST["commission_id"];
        $searchSaleId = $_POST["sale_id"];
        $searchAgentId = $_POST["agent_id"];

        $query = "SELECT * FROM commissions_sale WHERE 1=1";

        if (!empty($searchCommissionId)) {
            $query .= " AND Comission_ID = '$searchCommissionId'";
        }
        if (!empty($searchSaleId)) {
            $query .= " AND Sale_ID = '$searchSaleId'";
        }
        if (!empty($searchAgentId)) {
            $query .= " AND Agent_ID = '$searchAgentId'";
        }

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $commissions = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (empty($commissions)) {
            $error_message = "No record in base.";
        }
    }
}

if (!isset($_POST["search_commission"])) { // Pobranie listy prowizji z bazy danych, jesli nie wykonano wyszukiwania
    $query = "SELECT * FROM commissions_sale";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $commissions = $result->fetch_all(MYSQLI_ASSOC);
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
<h2> Manage Commissions </h2>
<form method="POST" action="manage_commissions_sale.php">
    <input type="button" id="add-commission-button" value="Add Commission" class="form-button"><br><br>
    <input type="button" id="edit-commission-button" value="Edit Commission" class="form-button"><br><br>
    <input type="button" id="search-commission-button" value="Search Commission" class="form-button"><br><br>
    <input type="button" id="delete-commission-button" value="Delete Commission" class="form-button"><br><br><br>
</form>

<form id="add-commission-form" class="hidden" method="POST" action="manage_commissions_sale.php">
    <input type="hidden" name="add_commission">
    <h3> Add </h3>
    <input class="form-field" type="text" name="sale_id" placeholder="Sale ID" required>
    <input class="form-field" type="text" name="commission_rate" placeholder="Commission Rate" required>
    <input class="form-field" type="text" name="profit" placeholder="Profit" required>
    <input class="form-field" type="text" name="agent_id" placeholder="Agent ID" required>
    <input type="submit" class="form-button" value="Add Commission">
</form>

<form id="edit-commission-form" class="hidden" method="POST" action="manage_commissions_sale.php">
    <input type="hidden" name="edit_commission">
    <h3> Edit </h3>
    <input class="form-field" type="text" name="commission_id" placeholder="Commission ID" required>
    <input class="form-field" type="text" name="sale_id" placeholder="Sale ID" required>
    <input class="form-field" type="text" name="commission_rate" placeholder="Commission Rate" required>
    <input class="form-field" type="text" name="profit" placeholder="Profit" required>
    <input class="form-field" type="text" name="agent_id" placeholder="Agent ID" required>
    <input type="submit" class="form-button" value="Edit Commission">
</form>

<form id="search-commission-form" class="hidden" method="POST" action="manage_commissions_sale.php">
    <input type="hidden" name="search_commission">
    <h3> Search </h3>
    <input class="form-field" type="text" name="commission_id" placeholder="Commission ID">
    <input class="form-field" type="text" name="sale_id" placeholder="Sale ID">
    <input class="form-field" type="text" name="agent_id" placeholder="Agent ID">
    <input type="submit" class="form-button" value="Search Commission">
</form>

<form id="delete-commission-form" class="hidden" method="POST" action="manage_commissions_sale.php">
    <input type="hidden" name="delete_commission">
    <h3> Delete </h3>
    <input class="form-field" type="text" name="commission_id" placeholder="Commission ID" required>
    <input type="submit" class="form-button" value="Delete Commission">
</form>

<br><br>
<?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo "<div class='error-message'><h3>$error_message</h3></div>"; ?></p>
    <?php } else { ?>
<div class="commissions-list">
    <table id="crud-table">
        <thead>
            <tr>
                <th>Commission ID</th>
                <th>Sale ID</th>
                <th>Commission Rate</th>
                <th>Profit</th>
                <th>Agent ID</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($commissions as $commission) {
                echo '<tr>';
                echo '<td>' . $commission['Comission_ID'] . '</td>';
                echo '<td>' . $commission['Sale_ID'] . '</td>';
                echo '<td>' . $commission['Comission_rate'] . '</td>';
                echo '<td>' . $commission['Profit'] . '</td>';
                echo '<td>' . $commission['Agent_ID'] . '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
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
