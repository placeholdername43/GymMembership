<!DOCTYPE html>
<html>
<head>
    <title>Classes - Gym Management System</title>
    <link href="styling.css" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <a href="index.php">Home</a>
    <a href="class.php">Classes</a>
    <a href="members.php">Members</a>
    <a href="staff.php">Staff</a>
</div>
<div class="main-content">
    <h1>Classes</h1>

    <?php
    include 'db_connect.php';

    //Handle POST request for adding or updating classes
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['add'])) {
            //Add class code
            $classname = $_POST['classname'];
            $staff = $_POST['staff'];
            $member = $_POST['member'];

            $stmt = $conn->prepare("INSERT INTO class (class, staff, member) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $classname);
            $stmt->bindParam(2, $staff);
            $stmt->bindParam(3, $member);

            if ($stmt->execute()) {
                echo "New class added successfully.";
            } else {
                echo "Error adding new class.";
            }
        } elseif (isset($_POST['update'])) {
            //Update class code
            $classID = $_POST['classID'];
            $classname = $_POST['classname'];
            $staff = $_POST['staff'];
            $member = $_POST['member'];

            $stmt = $conn->prepare("UPDATE class SET class = ?, staff = ?, member = ? WHERE ID = ?");
            $stmt->bindParam(1, $classname);
            $stmt->bindParam(2, $staff);
            $stmt->bindParam(3, $member);
            $stmt->bindParam(4, $classID);

            if ($stmt->execute()) {
                echo "Class updated successfully.";
            } else {
                echo "Error updating class.";
            }
        }
    }

    //Handle GET request for deleting a class
    if (isset($_GET['delete_id'])) {
        $classID = $_GET['delete_id'];

        $stmt = $conn->prepare("DELETE FROM class WHERE ID = ?");
        $stmt->bindParam(1, $classID);

        if ($stmt->execute()) {
            echo "Class deleted successfully.";
        } else {
            echo "Error deleting class.";
        }
    }

    //Fetch all classes to display
    try {
        $stmt = $conn->prepare("SELECT ID, class, staff, member FROM class");
        $stmt->execute();

        echo "<ul class='list-group'>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='list-group-item'>" . htmlspecialchars($row['class']) . 
                 " - <a href='class.php?delete_id=" . $row['ID'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a></li>";
        }
        echo "</ul>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <!-- Add Class Form -->
    <form action="class.php" method="post">
        <input type="text" name="classname" placeholder="Class Name" required>
        <input type="text" name="staff" placeholder="Staff" required>
        <input type="text" name="member" placeholder="Member" required>
        <input type="submit" name="add" value="Add Class">
    </form>

    <!-- Update Class Form -->
    <form action="class.php" method="post">
        <input type="hidden" name="classID" value="ID of the class to update">
        <input type="text" name="classname" placeholder="New Class Name">
        <input type="text" name="staff" placeholder="New Staff">
        <input type="text" name="member" placeholder="New Member">
        <input type="submit" name="update" value="Update Class">
    </form>
</div>
</body>
</html>
