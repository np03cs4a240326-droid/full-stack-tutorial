<?php
require "header.php";

echo "<h3>Student List</h3>";

if (file_exists("students.txt")) {
    $students = file("students.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($students as $student) {
        list($name, $email, $skills) = explode(",", $student);

        // Convert skills string back to array
        $skillsArray = explode("|", $skills);

        echo "<p>";
        echo "<strong>Name:</strong> $name <br>";
        echo "<strong>Email:</strong> $email <br>";
        echo "<strong>Skills:</strong> " . implode(", ", $skillsArray);
        echo "</p><hr>";
    }
} else {
    echo "<p>No student data found.</p>";
}

require "footer.php";
?>