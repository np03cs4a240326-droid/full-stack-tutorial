<?php
require 'db.php';
require 'preference.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['student_id'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($pass, $user['password_hash'])) {
        $error = "Invalid login";
    } else {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['full_name'];
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
<section>
    <h2>Login</h2>

    <?php if (!empty($error)) echo "<p>$error</p>"; ?>

    <form method="post">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</section>
</main>

</body>
</html>