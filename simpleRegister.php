<?php
function register($conn, $username, $password, $accountName, $email){
    $checkIfUsernameAlreadyExists = $conn->prepare("SELECT username FROM users WHERE username=?");
    $registerProcessor->bind_param('s', $username);
    $registerProcessor->execute();
    $registerResult = $registerProcessor->get_result();
    if($registerResult->num_rows == 1){
        // Username already exists
        return 0;
    } else {
        $addUserToTable = $conn->prepare('INSERT INTO users (username, password, account_name, email) VALUES (?, ?, ?, ?)');
        $addUserToTable->bind_param('ssss', $username, password_hash($password, PASSWORD_DEFAULT), $accountName, $email);
        $addUserToTable->execute();
        return 1;
    }
}
?>
