include 'db_connect.php';

// Handle the update if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve and validate form data
    $memberID = $_POST['memberID'];
    $firstName = $_POST['firstName'] ?? ''; // Using null coalescing operator
    $lastName = $_POST['lastName'] ?? '';
    $dateofbirth = $_POST['dateofbirth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $membertomembership = $_POST['membertomembership'] ?? '';
    $phonenumber = $_POST['phonenumber'] ?? '';

    // Check if required fields are not empty
    if (empty($firstName) || empty($lastName)) {
        echo "First Name and Last Name are required.";
    } else {
        // Update query
        $stmt = $conn->prepare("UPDATE gymmembers SET FirstName = :firstName, lastname = :lastName, dateofbirth = :dateofbirth, gender = :gender, membertomembership = :membertomembership, phonenumber = :phonenumber WHERE memberID = :memberID");
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':dateofbirth', $dateofbirth, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':membertomembership', $membertomembership, PDO::PARAM_STR);
        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect to prevent form resubmission
        header("Location: homepage.php");
        exit();
    }
}

?>

 <!-- Displaying the members in a table -->
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
                <!-- Editable fields wrapped in form -->
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
                