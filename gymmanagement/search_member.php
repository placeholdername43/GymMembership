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
    echo "Invalid request";
}
?>
