<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap CRUD Data Table for Database with Modal Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Employees</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i
                                class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
            <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <?php
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

                        // Fetch column names from the database table
                        $tableName = "almacen"; // Change this to your table name
                        $result = $conn->query("SHOW COLUMNS FROM $tableName");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<th>" . ucfirst($row['Field']) . "</th>";
                            }
                        }
                        $conn->close();
                        ?>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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

                    // Fetch data from the database
                    $sql = "SELECT * FROM almacen";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>
                                    <span class='custom-checkbox'>
                                        <input type='checkbox' id='checkbox1' name='options[]' value='1'>
                                        <label for='checkbox1'></label>
                                    </span>
                                </td>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['descripcion'] . "</td>";
                            echo "<td>" . $row['minimo'] . "</td>";
                            echo "<td>" . $row['maximo'] . "</td>";
                            echo "<td>" . $row['stock'] . "</td>";
                            echo "<td>
                                    <a href='#editEmployeeModal' class='edit' data-toggle='modal'><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></a>
                                    <a href='#deleteEmployeeModal' class='delete' data-toggle='modal' data-id='" . $row['id'] . "' onclick='editEmployee(" . $row['id'] . ")'><i class='material-icons' data-toggle='tooltip' title='Delete'>&#xE872;</i></a>
                                </td>";
                            echo "</tr>";
                        }
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                <ul class="pagination">
                    <!-- Pagination links can be added here based on the number of records -->
                </ul>
            </div>
        </div>
    </div>
    <!-- Add/Edit/Delete Modals can be added here with appropriate PHP code -->
    <div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="insert_employee.php"> <!-- Assuming you have a separate PHP file for inserting data -->
                <div class="modal-header">						
                    <h4 class="modal-title">Add Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">					
                    <?php
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

                    // Fetch column names from the database table
                    $tableName = "almacen"; // Change this to your table name
                    $result = $conn->query("SHOW COLUMNS FROM $tableName");

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $fieldName = $row['Field'];
                            echo "<div class='form-group'>
                                    <label>$fieldName</label>
                                    <input type='text' name='$fieldName' class='form-control' required>
                                  </div>";
                        }
                    }
                    $conn->close();
                    ?>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Handle the form submission to update the record
                include 'edit_employee.php'; // Include the file with the update logic
            } else {
                // Fetch the record data for editing
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

                // Get the record ID from the URL
                $recordId = $_GET['id'];

                // Fetch record data
                $tableName = "almacen"; // Change this to your table name
                $result = $conn->query("SELECT * FROM $tableName WHERE id = $recordId");

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Form
                    echo "<form method='post' action='edit_employee.php'>";

                    // Modal Header
                    echo "<div class='modal-header'>
                            <h4 class='modal-title'>Edit Employee</h4>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        </div>";

                    // Modal Body
                    echo "<div class='modal-body'>";

                    // Fetch column names from the database table
                    $resultColumns = $conn->query("SHOW COLUMNS FROM $tableName");

                    if ($resultColumns->num_rows > 0) {
                        while ($column = $resultColumns->fetch_assoc()) {
                            $columnName = $column['Field'];
                            $columnValue = $row[$columnName];

                            echo "<div class='form-group'>
                                    <label>$columnName</label>
                                    <input type='text' name='$columnName' class='form-control' value='$columnValue' required>
                                </div>";
                        }
                    }

                    echo "</div>";

                    // Hidden input for record ID
                    echo "<input type='hidden' name='id' value='$recordId'>";

                    // Modal Footer
                    echo "<div class='modal-footer'>
                            <input type='button' class='btn btn-default' data-dismiss='modal' value='Cancel'>
                            <input type='submit' class='btn btn-info' name='submit' value='Save'>
                        </div>";

                    // Close form
                    echo "</form>";
                } else {
                    echo "Record not found.";
                }

                $conn->close();
            }
            ?>
        </div>
    </div>
</div>


	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
<script>
    function editEmployee(id) {
        var editModal = $('#editEmployeeModal');
        var editForm = editModal.find('form');

        // Set the action attribute of the form to include the ID
        var actionUrl = 'edit_employee.php?id=' + id;
        editForm.attr('action', actionUrl);

        // Open the modal
        editModal.modal('show');
    }
</script>

</html>
