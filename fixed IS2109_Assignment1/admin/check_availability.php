<?php 
require_once("includes/config.php");
if (isset($_POST["regno"]) && !empty($_POST["regno"])) {
	
	$regno = filter_input(INPUT_POST, 'regno', FILTER_SANITIZE_STRING);
	
	// establish secure database connection
	$con = mysqli_connect("localhost", "username", "password", "database");
	if (mysqli_connect_errno()) {
		die("Failed to connect to MySQL: " . mysqli_connect_error());
	}
	
	// use prepared statement to prevent SQL injection
	$stmt = mysqli_prepare($con, "SELECT StudentRegno FROM students WHERE StudentRegno = ?");
	mysqli_stmt_bind_param($stmt, 's', $regno);
	mysqli_stmt_execute($stmt);
	
	// bind result variables
	mysqli_stmt_bind_result($stmt, $studentRegno);
	
	// fetch value and check if row exists
	if (mysqli_stmt_fetch($stmt)) {
		// student already exists in database
		echo "<span style='color:red'> Student with this Regno Already Registered.</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else {
		// student doesn't exist in database, proceed with registration
		// ...
	}
	
	// close prepared statement and database connection
	mysqli_stmt_close($stmt);
	mysqli_close($con);
}


?>

