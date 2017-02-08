<?php
		$servername = "localhost";
		$username = "root";
		$password = "PlW6uqI1";
		$dbname = "LIBRARY";
		$ISBN  = $_POST['ISBN'];
		$CardNo  = $_POST['CardNo'];
		$Borrower = $_POST['Borrower'];

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "SELECT BL.*, concat(B.FName,' ',B.LName,' ') AS Name
				FROM BOOK_LOANS BL JOIN BORROWER B ON BL.Card_no = B.Card_no 
				WHERE BL.Isbn LIKE \"%$ISBN%\" 
				AND BL.Card_no LIKE \"%$CardNo%\" 
				AND (BL.Date_in IS NULL OR BL.Date_in = \"\") 
				AND concat(B.FName,' ',B.LName,' ') LIKE \"%$Borrower%\" ;";
		$result = $conn->query($sql);
		$rows = array();
		echo "["; 
		$first = true;

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	array_walk(
				    $row,
				    function (&$entry) {
				        $entry = iconv('Windows-1250', 'UTF-8', $entry);
				    }
				);
		    	if($row!=null){
		    	if ($first) {
					$first = false;
				} else {
					echo ",";
				}
		        echo json_encode($row);
		    }}
		}
		echo "]";
		$conn->close();
	?>