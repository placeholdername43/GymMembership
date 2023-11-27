<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <link rel="stylesheet" href="stylingfile.css"> 
</head>


<header>    
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="classes.php">Classes</a></li>
                <li><a href="members.php">Members</a></li>
                <li><a href="staff.php">Staff</a></li>
    
            </ul>
        </nav>
    </header>
<body>
    <h1>Class Management</h1>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    try {
        $stmt = $conn->prepare("INSERT INTO class (ID, class, staff, member) VALUES (:ID, :class, :staff, :member)");

        $stmt->bindParam(':ID', $_POST['ID'], PDO::PARAM_STR);
        $stmt->bindParam(':class', $_POST['class'], PDO::PARAM_STR);
        $stmt->bindParam(':staff', $_POST['staff'], PDO::PARAM_STR);
        $stmt->bindParam(':member', $_POST['member'], PDO::PARAM_STR);

        $stmt->execute();

        header('Location: classes.php?status=success');
        exit();

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
    <form action="classes.php" method="post">
        <label for="ID">Class ID:</label>
        <input type="text" id="ID" name="ID" required><br>

        <label for="class">Class:</label>
        <input type="text" id="class" name="class" required><br>

        <label for="staff">Staff:</label>
        <input type="text" id="staff" name="staff" required><br>

        <label for="member">member:</label>
        <input type= "text" id="member" name="member">
    </input><br>

        <input type="submit" value="Add Class">
    </form>

    <form action="classes.php" method="get">
        <label for="searchClassName">Class Name:</label>
        <input type="text" id="searchClassName" name="searchClassName">
        <input type="submit" value="Search">
    </form>

    <?php


include 'db_connect.php';

if (isset($_GET['searchClassName'])) {
    $searchClassName = $_GET['searchClassName'];

        try {
            //SQL statement to search classes by name
            $stmt = $conn->prepare("SELECT * FROM class WHERE ID LIKE :searchClassName");
            $searchTerm = "%" . $searchClassName . "%";
            $stmt->bindParam(':searchClassName', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();



   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultsFound = true;
    echo "ID: " . $row['ID'] . "<br>";
    echo "Class: " . $row['class'] . "<br>";
    echo "Staff: " . $row['staff'] . "<br>";
    echo "Member: " . $row['member'] . "<br>";

    echo "<a href='edit_class.php?id=" . $row['ID'] . "'>Edit</a> | ";
    echo "<a href='delete_class.php?id=" . $row['ID'] . "' onclick='return confirm(\"Are you sure you want to delete this class?\");'>Delete</a>";
    echo "<hr>";
}

if (!$resultsFound) {
    echo "No classes found matching '" . htmlspecialchars($searchClassName) . "'";
}



            if (!$resultsFound) {
                echo "No classes found matching '" . htmlspecialchars($searchClassName) . "'";
            }

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();

            
        }
    
    }


    ?>




    </body>
    </html>
