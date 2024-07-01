<?php
function login($conn, $submittedUsername, $submittedPassword) {
    if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == TRUE){
        // Already logged in
        return ['status' => 1, 'message' => 'You are already logged in'];
    }

    $loginProcessor = $conn->prepare("SELECT username, password, id, accountName FROM users WHERE username=?");
    $loginProcessor->bind_param('s', $submittedUsername);
    $loginProcessor->execute();
    $loginResult = $loginProcessor->get_result();

    if($loginResult->num_rows == 1){
        // Username found
        $tableData = $loginProcessor->fetch_assoc();
        
        if(password_verify($submittedPassword, $tableData['password'])){
            // Password correct
            $_SESSION['accountName'] = $tableData['accountName'];
            $_SESSION['loggedInStatus'] = TRUE;
            $_SESSION['accountID'] = $tableData['id'];
            return ['status' => 2, 'message' => 'User now logged in'];
        }

    } else {
        // No username found
        return ['status' => 3, 'message' => 'Username or password incorrect'];
    }
}

?>
