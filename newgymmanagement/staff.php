<!DOCTYPE html>
<html>
<head>
    <title>Staff List - Gym Management System</title>
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
    <h1>Our Staff</h1>

    <?php
include 'db_connect.php';

//Handle POST request for updating staff
if (isset($_POST['update'])) {
    $staffid = $_POST['staffid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $startdate = $_POST['startdate'];
    $role = $_POST['role'];


    //Prepare an update statement
    $stmt = $conn->prepare("UPDATE staff SET firstname = ?, lastname = ?, email = ?, phonenumber = ?, startdate = ?, role = ? WHERE staffid = ?");
    $stmt->bindParam(1, $firstname);
    $stmt->bindParam(2, $lastname);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $phonenumber);
    $stmt->bindParam(5, $startdate);
    $stmt->bindParam(6, $role);
    $stmt->bindParam(7, $staffid);

    //Execute the statement
    if ($stmt->execute()) {
        echo "Staff member updated successfully.";
    } else {
        echo "Error updating staff member.";
    }
}

//Handle GET request for deleting staff
if (isset($_GET['delete_id'])) {
    $staffid = $_GET['delete_id'];

    //Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM staff WHERE staffid = ?");
    $stmt->bindParam(1, $staffid);

    //Execute the delete statement
    if ($stmt->execute()) {
        echo "Staff member deleted successfully.";
    } else {
        echo "Error deleting staff member.";
    }
}

    try {
        $stmt = $conn->prepare("SELECT staffid, firstname, lastname FROM staff");
        $stmt->execute();

        echo "<ul class='list-group'>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='list-group-item'>" . htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']);
            echo "</li>";
        }
        echo "</ul>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    //If a staff member is selected for editing, fetch their data
    if (isset($_GET['edit_id'])) {
        $stmt = $conn->prepare("SELECT * FROM staff WHERE staffid = ?");
        $stmt->bindParam(1, $_GET['edit_id']);
        $stmt->execute();
        $staff_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Form for editing staff
    if (isset($staff_to_edit)): ?>
        <form action="staff.php" method="post">
            <input type="hidden" name="staffid" value="<?php echo $staff_to_edit['staffid']; ?>">
            <input type="text" name="firstname" value="<?php echo $staff_to_edit['firstname']; ?>" required>
            <input type="text" name="lastname" value="<?php echo $staff_to_edit['lastname']; ?>" required>
            <input type="email" name="email" value="<?php echo $staff_to_edit['email']; ?>" required>
            <input type="text" name="phonenumber" value="<?php echo $staff_to_edit['phonenumber']; ?>" required>
            <input type="date" name="startdate" value="<?php echo $staff_to_edit['startdate']; ?>" required>
            <input type="text" name="lastname" value="<?php echo $staff_to_edit['lastname']; ?>" required>
            <select name="role">
                <option value="Instructor">Instructor</option>
                <option value="Trainer">Trainer</option>
                <option value="Aider">Aider</option>
         </select>
            <input type="submit" name="update" value="Update Staff">
        </form>
    <?php endif; ?>


    <!-- Dropdown for selecting a staff member to edit -->
<form action="staff.php" method="post">
    <select name="selected_staff" onchange="this.form.submit()">
        <option value="">Select a staff member to edit</option>
        <?php
        //Fetch all staff
        $stmt = $conn->prepare("SELECT staffid, firstname, lastname FROM staff");
        $stmt->execute();
        $staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($staff_members as $staff_member): ?>
            <option value="<?php echo $staff_member['staffid']; ?>">
                <?php echo htmlspecialchars($staff_member['firstname'] . " " . $staff_member['lastname']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php
//If a staff member is selected for editing, fetch their data
if (isset($_POST['selected_staff']) && $_POST['selected_staff'] != '') {
    $stmt = $conn->prepare("SELECT * FROM staff WHERE staffid = ?");
    $stmt->bindParam(1, $_POST['selected_staff']);
    $stmt->execute();
    $staff_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);

    //Display the edit form
    if (isset($staff_to_edit)): ?>
        <form action="staff.php" method="post">
            <input type="hidden" name="staffid" value="<?php echo htmlspecialchars($staff_to_edit['staffid']); ?>">
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($staff_to_edit['firstname']); ?>" required>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($staff_to_edit['lastname']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($staff_to_edit['email']); ?>" required>
            <input type="text" name="phonenumber" value="<?php echo htmlspecialchars($staff_to_edit['phonenumber']); ?>" required>
            <input type="date" name="startdate" value="<?php echo htmlspecialchars($staff_to_edit['startdate']); ?>" required>
            <select name="role">
                <option value="Instructor" <?php echo ($staff_to_edit['role'] == 'Instructor') ? 'selected' : ''; ?>>Instructor</option>
                <option value="Trainer" <?php echo ($staff_to_edit['role'] == 'Trainer') ? 'selected' : ''; ?>>Trainer</option>
                <option value="Aider" <?php echo ($staff_to_edit['role'] == 'Aider') ? 'selected' : ''; ?>>Aider</option>
            </select>
            <input type="submit" name="update" value="Update Staff">
            <a href="staff.php?delete_id=<?php echo htmlspecialchars($staff_to_edit['staffid']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </form>
    <?php endif; 
    
}
?>

<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $startdate = $_POST['startdate'];
    $role = $_POST['role'];

    //Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO staff (firstname, lastname, email, phonenumber, startdate, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $firstname);
    $stmt->bindParam(2, $lastname);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $phonenumber);
    $stmt->bindParam(5, $startdate);
    $stmt->bindParam(6, $role);

    //Execute the statement
    if ($stmt->execute()) {
        echo "New staff member added successfully.";
        header("Location: staff.php");

    } else {
        echo "Error adding new staff member.";
    }
}
?>


  
<form action="staff.php" method="post">
    <input type="text" name="firstname" placeholder="First Name" required>
    <input type="text" name="lastname" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phonenumber" placeholder="Phone Number" required>
    <input type="date" name="startdate" placeholder="Start Date" required>
    <select name="role">
        <option value="Instructor">Instructor</option>
        <option value="Trainer">Trainer</option>
        <option value="Aider">Aider</option>
    </select>
    <input type="submit" name="add" value="Add Staff">
</form>


</div>
</body>
</html>
