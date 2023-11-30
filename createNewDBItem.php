<?php
	$firstSQLQuery = "INSERT INTO _____TABLE_NAME_HERE_____ (col1, col2) VALUES (?,?)";
	$firstSQLSTMT = $conn->prepare($firstSQLQuery);
	$firstSQLSTMT->bind_param("si", $stringSpecificValue, $integerSpecificValue);
	$firstSQLSTMT->execute();
?>
