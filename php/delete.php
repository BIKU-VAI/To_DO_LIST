<?php
session_start();
require '../php/database.php';

if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $todo_id = $_GET['id'];

    $sql = "DELETE FROM todos WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $todo_id, $user_id);

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
