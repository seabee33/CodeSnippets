<?php
	$firstSQLQuery = "DELETE FROM ________TABLE_NAME_HERE________ WHERE id=?";
	$firstSQLSTMT = $conn->prepare($firstSQLQuery);
	$firstSQLSTMT->bind_param("i", $reviewDBID);
	if($firstSQLSTMT->execute()){
		header("Location: PAGE_TO_REDIRECT_TO");
		exit();
	}

?>
