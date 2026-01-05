<?php
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id   = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $pass = $_POST['password'];

    // Basic validation
    if (empty($id) || empty($name) || empty($pass)) {
        $error = "All fields are required.";
    } elseif (strlen($pass) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {

        $check = $pdo->prepare(
            "SELECT student_id FROM students WHERE student_id = ?"
        );
        $check->execute([$id]);

        if ($check->fetch()) {
            $error = "Student ID already exists.";
        } else {

            $hashed = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO students (student_id, full_name, password_hash)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([$id, $name, $hashed]);

            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <h1 class="welcome">Welcome to the Student Database!!!</h1>

<main>
<section>
    <h2>Register</h2>


    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</section>
</main>

</body>
</html>
