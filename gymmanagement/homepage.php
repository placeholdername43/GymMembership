<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Management System</title>
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
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';


    $stmt = $conn->prepare("INSERT INTO gymmembers (FirstName, lastname, dateofbirth, gender, membertomembership, phonenumber) VALUES (:FirstName, :lastname, :dateofbirth, :gender, :membertomembership, :phonenumber)");
    $stmt->bindParam(':FirstName', $_POST['FirstName'], PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
    $stmt->bindParam(':dateofbirth', $_POST['dateofbirth'], PDO::PARAM_STR);
    $stmt->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
    $stmt->bindParam(':membertomembership', $_POST['membertomembership'], PDO::PARAM_STR);
    $stmt->bindParam(':phonenumber', $_POST['phonenumber'], PDO::PARAM_INT);

    $stmt->execute();

    echo "New member added successfully";
    //close statment
    $stmt = null;
    //close connection
    $conn = null;
} else {
    echo null;
}


    ?>

    <div class="header">
        <h1>Welcome to the Gym Management System</h1>
    </div>

<form action="homepage.php" method="post">

    <label for="FirstName">First Name:</label>
    <input type="text" id="FirstName" name="FirstName" required><br>

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" required><br>

    <label for="dateofbirth">Date of Birth:</label>
    <input type="date" id="dateofbirth" name="dateofbirth" required><br>

    <label for="gender">Gender:</label>
    <input type="text" id="gender" name="gender" required><br>

    <label for="membertomembership">Membership Type:</label>
<select id="membertomembership" name="membertomembership" required>

    <option value="Basic">Basic</option>
    <option value="Premium">Premium</option>
</select>

    <label for="phonenumber">Phone Number:</label>
    <input type="number" id="phonenumber" name="phonenumber" required><br>

    <input type="submit" value="Add Member">
</form>

<form action="homepage.php" method="get">
    <label for="searchID">Member ID:</label>
    <input type="number" id="searchID" name="searchID" required>
    <input type="submit" value="Search">
</form>
<?php
ini_set('display_errors', 1);

error_reporting(E_ALL);

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchID'])) {
    $searchID = $_GET['searchID'];

    try {
        $stmt = $conn->prepare("SELECT * FROM gymmembers WHERE memberID = :searchID");
        $stmt->bindParam(':searchID', $searchID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "Member Found: <br>";
            echo "ID: " . $result['memberID'] . "<br>";
            echo "Name: " . $result['FirstName'] . " " . $result['lastname'] . "<br>";

        } else {
            echo "No member found with ID " . $searchID;
        }

    } catch(PDOException $e) {
        echo "Database query error: " . $e->getMessage();
    }
} else {
    echo null;
}

?>


<?php
    include 'db_connect.php';

    try {
        $stmt = $conn->prepare("SELECT * FROM gymmembers");
        $stmt->execute();

        //getig the results
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    ?>

    

<?php
include 'db_connect.php';

//ganle the update if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $memberID = $_POST['memberID'];
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $dateofbirth = $_POST['dateofbirth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $membertomembership = $_POST['membertomembership'] ?? '';
    $phonenumber = $_POST['phonenumber'] ?? '';

    //check if required fields are not empty
    if (empty($firstName) || empty($lastName)) {
        echo "First Name and Last Name are required.";
    } else {
        //update query
        $stmt = $conn->prepare("UPDATE gymmembers SET FirstName = :firstName, lastname = :lastName, dateofbirth = :dateofbirth, gender = :gender, membertomembership = :membertomembership, phonenumber = :phonenumber WHERE memberID = :memberID");
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':membertomembership', $membertomembership, PDO::PARAM_STR);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->execute();

        //redirect to prevent form resubmission
        header("Location: homepage.php");
        exit();
    }
}

?>


 <!-- displaying the members in a table -->
<h2>Gym Members</h2>
<table>
    <tr>
        <th>Member ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Date Of Birth</th>
        <th>Gender</th>
        <th>Membership</th>
        <th>Phone Number</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($members as $member): ?>
        <tr>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $member['memberID']): ?>
    
                <form method="post">
                    <td><?php echo htmlspecialchars($member['memberID']); ?></td>
                    <td><input type="text" name="firstName" value="<?php echo htmlspecialchars($member['FirstName']); ?>"></td>
                    <td><input type="text" name="lastName" value="<?php echo htmlspecialchars($member['lastname']); ?>"></td>
                    <td><input type="date" name="dateofbirth" value="<?php echo htmlspecialchars($member['dateofbirth']); ?>"></td>
                    <td><input type="text" name="gender" value="<?php echo htmlspecialchars($member['gender']); ?>"></td>
                    <td><input type="text" name="membertomembership" value="<?php echo htmlspecialchars($member['membertomembership']); ?>"></td>
                    <td><input type="number" name="phonenumber" value="<?php echo htmlspecialchars($member['phonenumber']); ?>"></td>
                    <td>
                        <input type="hidden" name="memberID" value="<?php echo $member['memberID']; ?>">
                        <input type="submit" name="update" value="Update">
                        <a href="homepage.php">Cancel</a>
                    </td>
                </form>
                
            <?php else: ?>
        
                <td><?php echo htmlspecialchars($member['memberID']); ?></td>
                <td><?php echo htmlspecialchars($member['FirstName']); ?></td>
                <td><?php echo htmlspecialchars($member['lastname']); ?></td>
                <td><?php echo htmlspecialchars($member['dateofbirth']); ?></td>
                <td><?php echo htmlspecialchars($member['gender']); ?></td>
                <td><?php echo htmlspecialchars($member['membertomembership']); ?></td>
                <td><?php echo htmlspecialchars($member['phonenumber']); ?></td>
                <td>
                    <a href="homepage.php?edit=<?php echo $member['memberID']; ?>">Edit</a>
                    <a href="delete_member.php?id=<?php echo $member['memberID']; ?>" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                    
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>









            </body>
</html>




