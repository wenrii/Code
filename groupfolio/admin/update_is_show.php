<?php
session_start();
if ($_SESSION["user"]["is_admin"] != 1) {
    header("Location: ../user/index.php"); // Redirect to login page if not logged in
    exit(); // Stop further processing if the user is not an admin
}

require_once '../classes/profile.class.php';

$profile = new Profile();

if (isset($_GET['personal_id']) && isset($_GET['current_status'])) {
    $personalId = intval($_GET['personal_id']);  // Sanitize
    $currentStatus = $_GET['current_status'];

    $newStatus = ($currentStatus == 'Accepted') ? 'Decline' : 'Accepted';

    if ($profile->updateIsShow($personalId, $newStatus)) {  // Correct: Using $personalId
        header("Location: user.php");
        exit();
    } else {
        echo "Error updating is_show: " . $profile->getError();
        echo "<br><a href='user.php'>Go Back</a>";
    }
} else {
    echo "Invalid request.";
    echo "<br><a href='user.php'>Go Back</a>";
}
