<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temperature";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the POST data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from POST request
    $temperature = $_POST["temperature"];
    $humidity = $_POST["humidity"];
    
    // Insert data into the database
    $sql = "INSERT INTO sensor_data (temperature, humidity) VALUES ('$temperature', '$humidity')";
    
    if ($conn->query($sql) === TRUE) {
     //   echo "New record created successfully";
    } else {
      //  echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
   // Fetch latest temperature and humidity data from database
$sql = "SELECT temperature, humidity FROM sensor_data ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as associative array
    $row = $result->fetch_assoc();
    $data = array("temperature" => $row['temperature'], "humidity" => $row['humidity']);
} else {
    // If no data available, set default values
    $data = array("temperature" => "N/A", "humidity" => "N/A");
}
}

$conn->close();
?>

