<?php
session_start();
require '../php/database.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT id, todo FROM todos WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($todo_id, $todo);

    $todos = [];
    while ($stmt->fetch()) {
        $todos[] = ['id' => $todo_id, 'todo' => $todo];
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: html/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - To-Do List App</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body class="dashboard-page">
    <header>
        <nav>
            <ul>
              
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="todo-section">
            <h1>Your To-Do List</h1>
            <ul>
                <?php foreach ($todos as $todo): ?>
                    <li>
                        <?php echo htmlspecialchars($todo['todo']); ?>
                        <div class="actions">
                            <a href="../php/edit.php?id=<?php echo $todo['id']; ?>" class="edit">Edit</a>
                            <a href="../php/delete.php?id=<?php echo $todo['id']; ?>" class="delete">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <form action="../php/add.php" method="POST">
                <input type="text" class="input_field" name="todo" placeholder="New to-do item">
                <button type="submit" class="btn">Add</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 To-Do List App. All rights reserved.</p>
        <p><a href="contact.html">Contact Us</a> | <a href="privacy.html">Privacy Policy</a></p>
    </footer>
</body>
</html>
