<?php

// A script to easily check disk space on a server

session_start();

$password = "epic password here";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['password']) && $_POST['password'] === $password) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "Incorrect password.";
    }
}

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true):
?>
<!DOCTYPE html>
<html>
<head>
    <title>Authentication Required</title>
</head>
<body>
    <h1>Authentication Required</h1>
    <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
exit;
endif;

// Function to get disk usage for a specific directory
function getDiskUsage($directory) {
    $totalSpace = @disk_total_space($directory);
    $freeSpace = @disk_free_space($directory);
    $usedSpace = $totalSpace - $freeSpace;

    return [
        'total' => $totalSpace,
        'free' => $freeSpace,
        'used' => $usedSpace
    ];
}

// Function to format bytes into a more readable format
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

// Define the specific directories to check
$directories = [
    '/',
    '/other/example/directory/or/harddrive'
];

// Create an array to hold the results
$diskUsages = [];

// Check each directory
foreach ($directories as $directory) {
    $usage = getDiskUsage($directory);
    if ($usage['total'] !== false && $usage['free'] !== false) {
        $diskUsages[$directory] = $usage;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Disk Usage</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Disk Usage</h1>
    <table>
        <tr>
            <th>Directory</th>
            <th>Total Space</th>
            <th>Used Space</th>
            <th>Free Space</th>
        </tr>
        <?php foreach ($diskUsages as $directory => $usage): ?>
        <tr>
            <td><?php echo htmlspecialchars($directory); ?></td>
            <td><?php echo formatBytes($usage['total']); ?></td>
            <td><?php echo formatBytes($usage['used']); ?></td>
            <td><?php echo formatBytes($usage['free']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
