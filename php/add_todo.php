
<?php
session_start();
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $todo = $_POST['todo'];

    $sql = "INSERT INTO todos (user_id, todo) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $todo);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to the dashboard
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
