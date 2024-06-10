<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temperature";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startIndex = isset($_GET['startIndex']) ? intval($_GET['startIndex']) : 0;
$rowsPerPage = isset($_GET['rowsPerPage']) ? intval($_GET['rowsPerPage']) : 15;

// Fetch total number of rows
$totalRowsResult = $conn->query("SELECT COUNT(*) AS totalRows FROM sensor_data");
$totalRows = $totalRowsResult->fetch_assoc()['totalRows'];

// Fetch current page data
$sql = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT $startIndex, $rowsPerPage";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Return both the data and the total row count
$response = array('data' => $data, 'totalRows' => $totalRows);
echo json_encode($response);

$conn->close();
?>
