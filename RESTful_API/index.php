<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

$databaseHost = 'localhost:3960';
$databaseUser = 'root'; 
$databasePassword = '12341234'; 
$databaseName = 'shopping_list_database';

$dbConnection = new mysqli($databaseHost, $databaseUser, $databasePassword, $databaseName);

if ($dbConnection->connect_errno) {
    die("Failed to connect to MySQL: " . $dbConnection->connect_error);
}

// Process the request
$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $dbConnection->real_escape_string($_GET['id']);
            $query = "SELECT * FROM shopping_list WHERE id='$id'";

            $result = $dbConnection->query($query);
            $item = $result->fetch_assoc();

            echo json_encode($item);
        } else if (isset($_GET['name'])) {
            $name = $dbConnection->real_escape_string($_GET['name']);
            $query = "SELECT * FROM shopping_list WHERE item_name='$name'";

            $result = $dbConnection->query($query);
            $items = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode($items);
        } else {
            $query = "SELECT * FROM shopping_list";

            $result = $dbConnection->query($query);
            $items = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode($items);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $itemName = $dbConnection->real_escape_string($data['item_name']);
        $quantity = intval($data['quantity']);
        $unit = $dbConnection->real_escape_string($data['unit']);
        $notes = $dbConnection->real_escape_string($data['notes']);
        $isPurchased = intval($data['is_purchased']);

        $query = "INSERT INTO shopping_list (item_name, quantity, unit, notes, is_purchased) 
                  VALUES ('$itemName', $quantity, '$unit', '$notes', $isPurchased)";
        $dbConnection->query($query);

        echo json_encode(['status' => 'success']);
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $id = $dbConnection->real_escape_string($_GET['id']);
            $data = json_decode(file_get_contents('php://input'), true);

            $setClauses = [];
            if (isset($data['item_name'])) {
                $itemName = $dbConnection->real_escape_string($data['item_name']);
                $setClauses[] = "item_name='$itemName'";
            }
            if (isset($data['quantity'])) {
                $quantity = intval($data['quantity']);
                $setClauses[] = "quantity=$quantity";
            }
            if (isset($data['unit'])) {
                $unit = $dbConnection->real_escape_string($data['unit']);
                $setClauses[] = "unit='$unit'";
            }
            if (isset($data['notes'])) {
                $notes = $dbConnection->real_escape_string($data['notes']);
                $setClauses[] = "notes='$notes'";
            }
            if (isset($data['is_purchased'])) {
                $isPurchased = intval($data['is_purchased']);
                $setClauses[] = "is_purchased=$isPurchased";
            }

            if ($setClauses) {
                $setClause = implode(', ', $setClauses);
                $dbConnection->query("UPDATE shopping_list SET $setClause WHERE id='$id'");
            }

            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $dbConnection->real_escape_string($_GET['id']);

            $query = "DELETE FROM shopping_list WHERE id='$id'";
            $dbConnection->query($query);

            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id parameter']);
        }
        break;
}

// Close the database connection
$dbConnection->close();
?>
