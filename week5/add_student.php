<?php
require "header.php";

$error = "";
$success = "";

function formatName($name) {
    return ucwords(trim($name));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function cleanSkills($string) {
    $skills = explode(",", $string);
    return array_map("trim", $skills);
}

function saveStudent($name, $email, $skillsArray) {
    $file = fopen("students.txt", "a");
    if (!$file) {
        throw new Exception("Unable to open file.");
    }
    $skills = implode("|", $skillsArray);
    fwrite($file, "$name,$email,$skills\n");
    fclose($file);
}

if (isset($_POST['submit'])) {
    try {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['skills'])) {
            throw new Exception("All fields are required.");
        }

        $name = formatName($_POST['name']);
        $email = $_POST['email'];
        $skillsArray = cleanSkills($_POST['skills']);

        if (!validateEmail($email)) {
            throw new Exception("Invalid email format.");
        }

        saveStudent($name, $email, $skillsArray);
        $success = "Student information saved successfully.";

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<h3>Add Student Information</h3>

<?php
if ($error) {
    if (is_array($error)) {
        echo "<p style='color:red;'>" . implode(", ", $error) . "</p>";
    } else {
        echo "<p style='color:red;'>$error</p>";
    }
}

if ($success) {
    echo "<p style='color:green;'>$success</p>";
}
?>

<form method="post">
    Name:
    <input type="text" name="name"><br><br>

    Email:
    <input type="text" name="email"><br><br>

    Skills (comma separated):
    <input type="text" name="skills"><br><br>

    <input type="submit" name="submit" value="Save Student">
</form>

<?php
require "footer.php";
?>