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

    // Get column names and values from the form submission
    $columns = array();
    $values = array();

    foreach ($_POST as $key => $value) {
        // Skip the submit button
        if ($key != "submit") {
            $columns[] = $key;
            $values[] = $conn->real_escape_string($value);
        }
    }

    $columnString = implode(", ", $columns);
    $valueString = "'" . implode("', '", $values) . "'";

    // Insert data into the database
    $sql = "INSERT INTO almacen ($columnString) VALUES ($valueString)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
