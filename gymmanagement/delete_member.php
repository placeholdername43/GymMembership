<?php
include 'db_connect.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $memberID = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM gymmembers WHERE memberID = :memberID");
        $stmt->bindParam(':memberID', $memberID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: homepage.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid ID.";
    exit();
}
?>
