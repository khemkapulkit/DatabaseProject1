


	<?php
		$servername = "localhost";
		$username = "root";
		$password = "PlW6uqI1";
		$dbname = "LIBRARY";
		$ISBN  = $_POST['ISBN'];
		$Title  = $_POST['Title'];
		$Authors = $_POST['Authors'];

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "SELECT BO.ISBN, BO.Title, BO.Authors, BC.Branch_id, LB.Branch_name, BC.No_of_copies
				FROM (SELECT B.ISBN, B.Title, GROUP_CONCAT(A.Fullname ) AS Authors
				FROM BOOK B 
				JOIN BOOK_AUTHORS BA ON B.ISBN = BA.ISBN 
				JOIN AUTHORS A ON BA.Author_id = A.Author_id
				WHERE B.Title LIKE \"%$Title%\" AND
				B.ISBN LIKE \"%$ISBN%\" AND
				A.Fullname LIKE \"%$Authors%\"
				GROUP BY ISBN)  BO
				LEFT JOIN BOOK_COPIES BC ON BO.ISBN = BC.Book_id
				LEFT JOIN LIBRARY_BRANCH LB ON BC.Branch_id = LB.Branch_id;";
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
				$row["Available"]="0";
		        echo json_encode($row);
		    }}
		}
		echo "]";
		$conn->close();
	?>