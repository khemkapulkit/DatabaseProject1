
	<?php
	

		$servername = "localhost";
		$username = "root";
		$password = "PlW6uqI1";
		$dbname = "LIBRARY";


	   $SSN = $_POST['SSN'];
	   $Fname = $_POST['Fname'];
	   $Lname = $_POST['Lname'];
	   $Email = $_POST['Email'];
	   $Address = $_POST['Address'];
	   $City = $_POST['City'];
	   $State = $_POST['State'];
	   $Phone = $_POST['Phone'];

	   // echo $SSN;
	   // echo $Phone;

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "SELECT * FROM  BORROWER WHERE Ssn = \"$SSN\";";
		$result = $conn->query($sql);
		if(mysqli_num_rows($result) != 0){
			echo "SSN Already Exists";
		}
		else
		{
			
			$sql4 = "INSERT INTO BORROWER (Ssn, Fname, Lname, Email, Address, City, State, Phone) VALUES('$SSN', '$Fname', '$Lname', '$Email', '$Address', '$City', '$State', '$Phone');";
			$result4 = $conn->query($sql4);
			if($result4){
				echo "Borrower Added Successfully";
			}
			else{
				echo "Borrower not Added. Please try again.";
			}
		
				
			
		}
		
		$conn->close();
	?>