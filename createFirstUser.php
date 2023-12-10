<?php

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(isset($_POST["action"])){
	$action = $_POST["action"];
	if($action == "createNewUser"){
		$username = $_POST["username"];
		$rawPassword = $_POST["password"];

		$securePassword = password_hash($rawPassword, PASSWORD_DEFAULT);

		$checkForUserExistSQL = "SELECT username FROM users";
		$checkForUserExistSTMT = $conn->prepare($checkForUserExistSQL);
		$checkForUserExistSTMT->execute();
		$checkForUserExistResult = $checkForUserExistSTMT->get_result();

		if($checkForUserExistResult->num_rows == 0){
			$createNewUserSQL = "INSERT INTO users (name, username, password)";
			$createNewUserSTMT = $conn->prepare($createNewUserSQL);
			$createNewUserSTMT->bind_param("s", $username);
			$createNewUserSTMT->execute();
		} else {
			$registerResponse = ["success" => true, "message" => $registerMsgPasswordAlreadySet];
		}
		} 


	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		*{
			font-family: sans-serif;
		}
	</style>
</head>
<body>
	<form action="" method="POST">
		<label for="createName">Name: </label>
		<input id="createName" type="text" placeholder="name" required name="createName"><br>

		<label for="createName">Username: </label>
		<input id="createUsername" type="text" placeholder="username" required name="createUsername"><br>

		<label for="createName">Password: </label>
		<input id="createPassword" type="password" placeholder="password" required onkeyup="checkPassword()" name="createPassword"><br>

		<label style="display: none;" id="createPasswordVerifyLabel" for="createName">Repeat Password: </label>
		<input style="display: none;" id="createPasswordVerify" type="password" placeholder="repeat password" required  onkeyup="checkPassword()"><br><br>

		<p id="messageBox"></p>

		<button id="submitButton" type="submit" disabled>Create New User</button>
	</form>
</body>

<script>
function checkPassword(){
	const originalPasswordInput = document.getElementById("createPassword");
	const passwordVerifyLabel = document.getElementById("createPasswordVerifyLabel");
	const passwordVerifyInput = document.getElementById("createPasswordVerify");

	const submitButton = document.getElementById("submitButton");

	const messageBox = document.getElementById("messageBox");


	passwordVerifyLabel.style.display = "inline";
	passwordVerifyInput.style.display = "inline";


	if(originalPasswordInput.value == passwordVerifyInput.value){
		messageBox.innerHTML="<span style='color:green;'>Both passwords are the same, please click create new user</span>";
		submitButton.removeAttribute("disabled");
	} else {
		messageBox.innerHTML="<span style='color:red;'>passwords are different, please make sure they are both the same</span>";
		submitButton.setAttribute("disabled","");
	}
}
</script>


</html>
