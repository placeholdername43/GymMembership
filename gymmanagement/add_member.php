<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    $stmt = $conn->prepare("INSERT INTO gymmembers (memberID, FirstName, lastname, dateofbirth, gender, membertomembership, phonenumber) VALUES (:memberID, :FirstName, :lastname, :dateofbirth, :gender, :membertomembership, :phonenumber)");

    $stmt->bindParam(':memberID', $_POST['memberID'], PDO::PARAM_INT);
    $stmt->bindParam(':FirstName', $_POST['FirstName'], PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
    $stmt->bindParam(':dateofbirth', $_POST['dateofbirth'], PDO::PARAM_STR);
    $stmt->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);
    $stmt->bindParam(':membertomembership', $_POST['membertomembership'], PDO::PARAM_STR);
    $stmt->bindParam(':phonenumber', $_POST['phonenumber'], PDO::PARAM_INT);

  
    $stmt->execute();

    echo "New member added successfully";

    //close statement
    $stmt = null;
    //close connection
    $conn = null;
} else {
    echo "Invalid request method";
}
?>
