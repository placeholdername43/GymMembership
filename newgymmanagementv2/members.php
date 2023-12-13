<!DOCTYPE html>
<html>
<head>
    <title>Members - Gym Management System</title>
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
                        <a class="nav-link" href="class.php">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff.php">Staff</a>
                    </li>
                </ul>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
<div class="main-content">
    <h1>Our Members</h1>
    <?php
    include 'db_connect.php';

    //Handle POST request for adding/updating members
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Check if we're adding a new member
        if (isset($_POST['add'])) {
            //Prepare an insert statement
            $stmt = $conn->prepare("INSERT INTO gymmembers (FirstName, lastname, dateofbirth, gender, membertomembership, phonenumber) VALUES (?, ?, ?, ?, ?, ?)");
            
                $stmt->bindParam(1, $_POST['firstname']);
                $stmt->bindParam(2, $_POST['lastname']);
                $stmt->bindParam(3, $_POST['dateofbirth']);
                $stmt->bindParam(4, $_POST['gender']);
                $stmt->bindParam(5, $_POST['membertomembership']);
                $stmt->bindParam(6, $_POST['phonenumber']);
                 
                if ($stmt->execute()) {
                    echo "New member added successfully.";
                } else {
                    echo "Error adding member.";
                }
            }
        } elseif (isset($_POST['update'])) {
            //Prepare an update statement
            $stmt = $conn->prepare("UPDATE gymmembers SET FirstName = ?, lastname = ?, dateofbirth = ?, gender = ?, membertomembership = ?, phonenumber = ? WHERE memberID = ?");
            
            //Bind parameters from the form
            $stmt->bindParam(1, $_POST['firstname']);
            $stmt->bindParam(2, $_POST['lastname']);
            $stmt->bindParam(3, $_POST['dateofbirth']);
            $stmt->bindParam(4, $_POST['gender']);
            $stmt->bindParam(5, $_POST['membertomembership']);
            $stmt->bindParam(6, $_POST['phonenumber']);
            $stmt->bindParam(7, $_POST['memberID']); 
        
            //Execute the statement
            if ($stmt->execute()) {
                echo "Member updated successfully.";
            } else {    
                echo "Error updating member.";
            }
        }
    

//Handle GET request for deleting members
if (isset($_GET['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM gymmembers WHERE memberID = ?");
    $stmt->bindParam(1, $_GET['delete_id']);

    //Execute the delete statement
    if ($stmt->execute()) {
        echo "Member deleted successfully.";
        //Redirect to the members page
        header('Location: members.php');
        exit;
    } else {
        echo "Error deleting member.";
    }
}


    //Fetch all members to display in the list and dropdown menu
    $stmt = $conn->prepare("SELECT memberID, FirstName, lastname FROM gymmembers");
    $stmt->execute();
    
    //Store members for dropdown selection
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<ul class='list-group'>";
    foreach ($members as $member) {
        echo "<li class='list-group-item'>" . htmlspecialchars($member['FirstName']) . " " . htmlspecialchars($member['lastname']);
        echo " <a href='members.php?delete_id=".$member['memberID']."' onclick='return confirm(\"Are you sure?\")'>Delete</a>"; // Link to delete script
        echo "</li>";
    }
    echo "</ul>";
    ?>

    <!-- Dropdown for selecting a member to update -->
    <form action="members.php" method="post">
        <select name="selected_member" onchange="this.form.submit()">
            <option value="">Select a member to edit</option>
            <?php foreach ($members as $member): ?>
                <option value="<?php echo $member['memberID']; ?>">
                    <?php echo htmlspecialchars($member['FirstName'] . " " . $member['lastname']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php
    //If a member is selected, fetch their data for editing
    if (isset($_POST['selected_member'])) {
        $stmt = $conn->prepare("SELECT * FROM gymmembers WHERE memberID = ?");
        $stmt->bindParam(1, $_POST['selected_member']);
        $stmt->execute();
        $member_to_edit = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <?php if (isset($member_to_edit)): ?>
        <!-- Form to update selected member -->
        <form action="members.php" method="post">
            <input type="hidden" name="memberID" value="<?php echo $member_to_edit['memberID']; ?>">
            <input type="text" name="firstname" value="<?php echo $member_to_edit['FirstName']; ?>" required>
            <input type="text" name="lastname" value="<?php echo $member_to_edit['lastname']; ?>" required>
            <input type="date" name="dateofbirth" value="<?php echo $member_to_edit['dateofbirth']; ?>" required>
            <input type="text" name="gender" value="<?php echo $member_to_edit['gender']; ?>" required>
            <input type="text" name="membertomembership" value="<?php echo $member_to_edit['membertomembership']; ?>" required> 
            <input type="text" name="phonenumber" value="<?php echo $member_to_edit['phonenumber']; ?>" required>

            <!-- Include other fields as necessary -->
            <input type="submit" name="update" value="Update Member">
        </form>
    <?php endif; ?>

    <!-- Add Member Form -->
    <form action="members.php" method="post">
        <input type="text" name="firstname" placeholder="First Name" required>
        <input type="text" name="lastname" placeholder="Last Name" required>
        <input type="date" name="dateofbirth" placeholder="Date of Birth" required>
        <input type="text" name="gender" placeholder="Gender" required>
        <input type="text" name="membertomembership" placeholder="Membership" required>
        <input type="text" name="phonenumber" placeholder="Phone Number" required>
        <input type="submit" name="add" value="Add Member">
    </form>

    </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</div>
</body>
</html>
