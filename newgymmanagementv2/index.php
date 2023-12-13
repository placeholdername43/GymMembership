<!DOCTYPE html>
<html>
<head>
    <title>Hub - Gym Management System</title>
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
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="class.php">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff.php">Staff</a>
                    </li>
                </ul>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
<div class="main-content">
    <div class="container mt-3">
        <div class="row">
            <?php
            include 'db_connect.php';

            // Fetch number of members
            $membersStmt = $conn->prepare("SELECT COUNT(*) AS memberCount FROM gymmembers");
            $membersStmt->execute();
            $memberCount = $membersStmt->fetch(PDO::FETCH_ASSOC)['memberCount'];

            // Fetch number of  staff
            $staffStmt = $conn->prepare("SELECT COUNT(*) AS staffCount FROM staff");
            $staffStmt->execute();
            $staffRow = $staffStmt->fetch(PDO::FETCH_ASSOC)['staffCount'];
    
        //Get number of active classes
        $classesStmt = $conn->prepare("SELECT COUNT(*) AS classCount FROM class");
        $classesStmt->execute();
        $classesRow = $classesStmt->fetch(PDO::FETCH_ASSOC)['classCount'];

        
        //Get members' names
        $membersNamesStmt = $conn->prepare("SELECT FirstName, lastname FROM gymmembers");
        $membersNamesStmt->execute();

        //Get staff names
        $staffNamesStmt = $conn->prepare("SELECT firstname, lastname FROM staff");
        $staffNamesStmt->execute();

            ?>

            <div class="col-md-4">
                <div class="stats-card p-3 mb-2 bg-primary text-white rounded shadow">
                    
                    <div class="stats-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
  <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
  <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96c.026-.163.04-.33.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1.006 1.006 0 0 1 1 12z"/>
</svg>
                    </div>
                    <div class="stats-info">
                        <span class="stats-number"><?php echo $memberCount; ?></span>
                        <span class="stats-category">Members</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card p-3 mb-2 bg-danger text-white rounded shadow">
                    
                    <div class="stats-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="currentColor" class="bi bi-person-exclamation" viewBox="0 0 16 16">
  <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
</svg>
                    </div>
                    <div class="stats-info">
                        <span class="stats-number"><?php echo $staffRow; ?></span>
                        <span class="stats-category">Staff</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card p-3 mb-2 bg-info text-white rounded shadow">
                    <div class="stats-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-journal-bookmark" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8"/>
  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
</svg>                    </div>
                    <div class="stats-info">
                        <span class="stats-number"><?php echo $classesRow; ?></span>
                        <span class="stats-category">Classes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="container mt-3">
        <div class="row justify-content-center">
            <!-- Members List -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-dark text-white shadow">
                        Members
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 shadow">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Surname</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'db_connect.php';   
                                try {
                                    $membersNamesStmt = $conn->prepare("SELECT FirstName, lastname FROM gymmembers");
                                    $membersNamesStmt->execute();
                                    while ($member = $membersNamesStmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr><td>" . htmlspecialchars($member['FirstName']) . "</td><td>" . htmlspecialchars($member['lastname']) . "</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Staff List -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-dark text-white shadow">
                        Staff
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 shadow">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Surname</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $staffNamesStmt = $conn->prepare("SELECT firstname, lastname FROM staff");
                                    $staffNamesStmt->execute();
                                    while ($staff = $staffNamesStmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr><td>" . htmlspecialchars($staff['firstname']) . "</td><td>" . htmlspecialchars($staff['lastname']) . "</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
