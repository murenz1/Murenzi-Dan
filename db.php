<?php
// db.php
$host = 'localhost';
$db   = 'books_db'; // Change to your DB name
$user = 'root';
$pass = '';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable exceptions for mysqli
try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Database connection error: ' . $e->getMessage());
    echo '<div style="color: #fff; background: #c00; padding: 1em; border-radius: 5px; font-family: Arial, sans-serif;">';
    echo 'Database connection failed. Please try again later.';
    echo '</div>';
    exit();
}
?>
