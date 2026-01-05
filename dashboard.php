<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
<section>
    <h2>Hello <?= htmlspecialchars($_SESSION['username']) ?></h2>
    <p>Welcome</p>

    <form method="post">
        <button name="logout">Logout</button>
    </form>
</section>
</main>

</body>
</html>