<!DOCTYPE html>
<html>
<head>
    <title>Classes - Gym Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="styling.css" rel="stylesheet">
    <meta name="viewport" content="width=500px, initial-scale=1">

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand custom-font" href="index.php">
            <img src="logo.png" alt="Gym Logo" class="logo">
            MNSIN'S GYM
        </a>
    </nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="class.php">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff.php">Staff</a>
                    </li>
                </ul>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

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
        $stmt = $conn->prepare("SELECT ID, class, staff FROM class");
        $stmt->execute();

        echo "<ul class='list-group'>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='list-group-item'>" . htmlspecialchars($row['class'] . " " . htmlspecialchars($row['staff']));
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
</main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
