<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="stylingfile.css"> 
</head>
    <div class = navbar>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="classes.php">Classes</a></li>
                <li><a href="members.php">Members</a></li>
                <li><a href="staff.php">Staff</a></li>
            </ul>
        </nav>
    </div>

    
<body>
    <h1>Staff Management</h1>
    
    <!-- ading new staff form -->
    <form action="staff.php" method="post">
        
    <div class = "staffform">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phonenumber">Phone Number:</label>
        <input type="text" id="phonenumber" name="phonenumber" required><br>

        <label for="startdate">Start Date:</label>
        <input type="date" id="startdate" name="startdate" required><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required><br>

        <input type="submit" value="Add Staff">
</div>
    </form>

    <?php
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $startdate = $_POST['startdate'];
    $role = $_POST['role'];

    try {

        $stmt = $conn->prepare("INSERT INTO staff (firstname, lastname, email, phonenumber, startdate, role) VALUES (:firstname, :lastname, :email, :phonenumber, :startdate, :role)");
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':startdate', $startdate, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        $stmt->execute();

        echo "Staff member added successfully.";

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<?php
    include 'db_connect.php';

    $stmt = $conn->prepare("SELECT * FROM staff");
    $stmt->execute();
    $staffMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table>
        <tr>
            <th>Staff ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Start Date</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($staffMembers as $member): ?>
            <tr>
                <td><?php echo htmlspecialchars($member['staffid']); ?></td>
                <td><?php echo htmlspecialchars($member['firstname']); ?></td>
                <td><?php echo htmlspecialchars($member['lastname']); ?></td>
                <td><?php echo htmlspecialchars($member['email']); ?></td>
                <td><?php echo htmlspecialchars($member['phonenumber']); ?></td>
                <td><?php echo htmlspecialchars($member['startdate']); ?></td>
                <td><?php echo htmlspecialchars($member['role']); ?></td>
                <td>
                <td>
    <a href="staff.php?edit=<?php echo $member['staffid']; ?>">Edit</a> |
    <a href="staff.php?delete=<?php echo $member['staffid']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
</td>

                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
include 'db_connect.php';

if (isset($_GET['delete']) && ctype_digit($_GET['delete'])) {
    $staffID = $_GET['delete'];

    //delete query
    $stmt = $conn->prepare("DELETE FROM staff WHERE staffid = :staffid");
    $stmt->bindParam(':staffid', $staffID, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: staff.php");
    exit();
}

?>
<!--EDIT FUNCTION BELOW -->
<?php
include 'db_connect.php'; 

//Handle staff update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $staffID = $_POST['staffid'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $startDate = $_POST['startDate'];
    $role = $_POST['role'];

    //update query
    $stmt = $conn->prepare("UPDATE staff SET firstname = :firstName, lastname = :lastName, email = :email, phonenumber = :phoneNumber, startdate = :startDate, role = :role WHERE staffid = :staffid");
    $stmt->bindParam(':staffid', $staffID, PDO::PARAM_INT);
    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
    $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: staff.php");
    exit();
}

//geting staff data for editing
if (isset($_GET['edit']) && ctype_digit($_GET['edit'])) {
    $staffID = $_GET['edit'];

    $stmt = $conn->prepare("SELECT * FROM staff WHERE staffid = :staffid");
    $stmt->bindParam(':staffid', $staffID, PDO::PARAM_INT);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        echo "Staff member not found.";
        exit();
    }
} else {
    echo null;
    exit();
}
?>
</head>
<body>
    <h2>Edit Staff Member</h2>
    <form action="staff.php" method="post">
        <input type="hidden" name="staffid" value="<?php echo htmlspecialchars($staff['staffid']); ?>">

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($staff['firstname']); ?>" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($staff['lastname']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required><br>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($staff['phonenumber']); ?>" required><br>

        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" value="<?php echo htmlspecialchars($staff['startdate']); ?>" required><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($staff['role']); ?>" required><br>

        <input type="submit" name="update" value="Update Staff Member">
    </form>
</body>
</html>



</body>
</html> 


