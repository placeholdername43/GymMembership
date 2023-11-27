<?php
include 'db_connect.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $classID = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM class WHERE ID = :ID");
        $stmt->bindParam(':ID', $classID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: classes.php");
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
