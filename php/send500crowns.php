<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}

// Assuming you have received GET parameters
// Update the key to match your JavaScript code
$username = $_GET['username'];
$crownsToAdd = 500;

$server = 'wildclaw.ddns.net';
$database = 'ArchaicDatabase';
$username_db = 'ArchaicUser';
$password_db = 'abc123456';

try {
    $conn = new PDO("sqlsrv:Server=$server;Database=$database", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Use the SQL UPDATE statement to add to the existing value
    $sql = "UPDATE ArchaicTable1 SET Crowns = Crowns + :CrownsToAdd WHERE Username = :Username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Username', $username);
    $stmt->bindParam(':CrownsToAdd', $crownsToAdd, PDO::PARAM_INT); // Make sure to bind as an integer

    $stmt->execute();

    $rowsAffected = $stmt->rowCount();

    // Provide a JSON response for success
    echo json_encode(['success' => true, 'rowsAffected' => $rowsAffected]);
} catch (PDOException $e) {
    // Log the error
    error_log('Failed: ' . $e->getMessage());

    // Provide a JSON response for error
    echo json_encode(['success' => false, 'error' => 'Failed: ' . $e->getMessage()]);
}
?>
