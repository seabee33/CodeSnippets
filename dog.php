<?php
// Database connection and data fetching code remains the same
$host = "localhost";
$database = "abc";
$user = "abc";
$password = "abc";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch data
$stmt = $conn->query("SELECT time FROM dog ORDER BY time ASC");
$times_r = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Process times
$times = array_map(function($time) {
    return date("H:i", strtotime($time));
}, $times_r);

// Count occurrences
$time_counts = array_count_values($times);

// Determine full time range
$min_time = min($times);
$max_time = max($times);

$min_time_formatted = DateTime::createFromFormat('H:i', $min_time);
$max_time_formatted = DateTime::createFromFormat('H:i', $max_time);

$full_time_range = [];
$current_time = clone $min_time_formatted;

while ($current_time <= $max_time_formatted) {
    $full_time_range[] = $current_time->format('H:i');
    $current_time->modify('+1 minute');
}

// Prepare data for Chart.js
$labels = json_encode($full_time_range);
$counts = json_encode(array_map(function($time) use ($time_counts) {
    return isset($time_counts[$time]) ? $time_counts[$time] : 0;
}, $full_time_range));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Annoying Neighbour Annoys Me Every Morning</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .chart-container {
            width: 95%;
            height:90vh;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <canvas id="timeChart"></canvas>
    </div>

    <script>
    const ctx = document.getElementById('timeChart').getContext('2d');
    const labels = <?php echo $labels; ?>;
    const data = <?php echo $counts; ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Frequency',
                data: data,
                backgroundColor: 'green',
                borderColor: 'teal',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 90
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Time Annoying Neighbour Annoys Me Every Morning',
                    font: {
                        size: 18
                    }
                }
            }
        }
    });
    </script>
</body>
</html>
