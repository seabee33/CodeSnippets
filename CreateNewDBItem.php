<?php
	$createNewUserSQL = "INSERT INTO users (name, username, password) VALUES (?,?,?)";
	$createNewUserSTMT = $conn->prepare($createNewUserSQL);
	$createNewUserSTMT->bind_param("sss", $newName, $newUsername, $newHashedPassword);
	$createNewUserSTMT->execute();
?>
