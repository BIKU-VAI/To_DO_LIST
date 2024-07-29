<?php
session_start();
require '../php/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $todo_id = $_GET['id'];

    $sql = "SELECT todo FROM todos WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $todo_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($current_todo);
    $stmt->fetch();
    $stmt->close();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_POST['todo'])) {
    $todo_id = $_GET['id'];
    $todo = $_POST['todo'];

    $sql = "UPDATE todos SET todo = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $todo, $todo_id, $user_id);

    if ($stmt->execute()) {
        header("Location: ../html/dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../html/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit To-Do - To-Do List App</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body class="edit-page">
    <header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="todo-section">
            <h1>Edit To-Do</h1>
            <form action="edit.php?id=<?php echo htmlspecialchars($_GET['id']); ?>" method="POST">
                <input type="text" name="todo" value="<?php echo htmlspecialchars($current_todo); ?>" placeholder="Edit to-do item" required>
                <button type="submit" class="btn">Save</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 To-Do List App. All rights reserved.</p>
        <p><a href="contact.html">Contact Us</a> | <a href="privacy.html">Privacy Policy</a></p>
    </footer>
</body>
</html>
