<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace the database connection details with your own
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "practica";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get record ID from the form submission
    $recordId = $_POST['id']; // Adjust this based on how you're passing the record ID

    // Get column names and values from the form submission
    $updates = array();

    foreach ($_POST as $key => $value) {
        // Skip the submit button and ID
        if ($key != "submit" && $key != "id") {
            $updates[] = "$key = '" . $conn->real_escape_string($value) . "'";
        }
    }

    // Construct the UPDATE query
    $updateString = implode(", ", $updates);
    $sql = "UPDATE almacen SET $updateString WHERE id = $recordId";

    // Execute the update query
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
