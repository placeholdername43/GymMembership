<!DOCTYPE html>
<html>
<head>
    <title>Gym Management System</title>
    <link href="styling.css" rel="stylesheet">
</head>
<div class="sidebar">
    <a href="index.php">Home</a>
    <a href="class.php">Classes</a>
    <a href="members.php">Members</a>
    <a href="staff.php">Staff</a>
</div>
<div class="main-content">
    


<body>
    <div class="top-banner">
        <a href="index.php">
        <img src="logo.png" alt="Gym Logo" class="logo">
        </a>
        Hello Kittys Gym
    </div>

    <?php
    include 'db_connect.php';   

    try {
        //Get number of members
        $membersStmt = $conn->prepare("SELECT COUNT(*) AS memberCount FROM gymmembers");
        $membersStmt->execute();
        $membersRow = $membersStmt->fetch();

        //Get number of staff
        $staffStmt = $conn->prepare("SELECT COUNT(*) AS staffCount FROM staff");
        $staffStmt->execute();
        $staffRow = $staffStmt->fetch();

        //Get number of active classes
        $classesStmt = $conn->prepare("SELECT COUNT(*) AS classCount FROM class");
        $classesStmt->execute();
        $classesRow = $classesStmt->fetch();

        //Display counts
        echo "<p>Number of Members: " . $membersRow['memberCount'] . "</p>";
        echo "<p>Number of Staff: " . $staffRow['staffCount'] . "</p>";
        echo "<p>Number of Active Classes: " . $classesRow['classCount'] . "</p>";

        //Get members' names
        $membersNamesStmt = $conn->prepare("SELECT FirstName, lastname FROM gymmembers");
        $membersNamesStmt->execute();

        //Get staff names
        $staffNamesStmt = $conn->prepare("SELECT firstname, lastname FROM staff");
        $staffNamesStmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

    <div class="container">
        <div class="list">
            <h2>Members</h2>
            <ul>
            <?php
            while($row = $membersNamesStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['lastname']) . "</li>";
            }
            ?>
            </ul>
        </div>

        <div class="list">
            <h2>Staff</h2>
            <ul>
            <?php
            while($row = $staffNamesStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']) . "</li>";
            }
            ?>
            </ul>
        </div>
    </div>

</body>
</html>
