<?php
include 'db_connect.php';
if (isset($_GET['edit'])) {
    echo "Edit ID received: " . $_GET['edit'] . "<br>";
}
// Check if the update form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $classID = $_POST['ID'];
    $className = $_POST['class'];
    $staff = $_POST['staff'];
    $member = $_POST['member'];

    // Update query
    $stmt = $conn->prepare("UPDATE class SET class = :class, staff = :staff, member = :member WHERE ID = :ID");
    $stmt->bindParam(':ID', $classID, PDO::PARAM_STR);
    $stmt->bindParam(':class', $className, PDO::PARAM_STR);
    $stmt->bindParam(':staff', $staff, PDO::PARAM_STR);
    $stmt->bindParam(':member', $member, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect back to classes page
    header("Location: classes.php");
    exit();
}

// Check if the class ID is provided for editing
if (isset($_GET['edit']) && ctype_digit((string) $_GET['edit'])) { // Cast to string for ctype_digit
    $classID = $_GET['edit'];

    // Fetch class data for editing
    $stmt = $conn->prepare("SELECT * FROM class WHERE ID = :ID");
    $stmt->bindParam(':ID', $classID, PDO::PARAM_STR);
    $stmt->execute();
    $class = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$class) {
        echo "Class not found.";
        exit();
    }
} else {
    echo "invalid ID.";  //CODE STOPS HERE----------------------------- I THINK IT IS NOT GETTING VARIABLE FROM THE CLASSES FUNCTION THE ONE YOU INSERT IN TEXT BOX
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Class</title>
    <link rel="stylesheet" href="stylingfile.css"> 
</head>
<body>
    <h2>Edit Class</h2>
    <form action="edit_class.php" method="post">
        <input type="hidden" name="ID" value="<?php echo htmlspecialchars($class['ID']); ?>">
        
        <label for="class">Class:</label>
        <input type="text" id="class" name="class" value="<?php echo htmlspecialchars($class['class']); ?>" required><br>

        <label for="staff">Staff:</label>
        <input type="text" id="staff" name="staff" value="<?php echo htmlspecialchars($class['staff']); ?>" required><br>

        <label for="member">Member:</label>
        <input type="text" id="member" name="member" value="<?php echo htmlspecialchars($class['member']); ?>"><br>

        <input type="submit" name="update" value="Update Class">
    </form>
</body>
</html>

?>
