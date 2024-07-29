<?php
session_start();
require '../php/database.php';

if (isset($_SESSION['user_id']) && isset($_POST['todo'])) {
    $user_id = $_SESSION['user_id'];
    $todo = $_POST['todo'];

    $sql = "INSERT INTO todos (user_id, todo) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $todo);

    if ($stmt->execute()) {
        header("Location: ../html/dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../html/login.html");
    exit();
}
?>
