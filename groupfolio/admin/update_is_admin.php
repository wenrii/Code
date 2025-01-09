<?php
session_start();
if ($_SESSION["user"]["is_admin"] != 1) {
    header("Location: ../user/index.php"); // Redirect to login page if not logged in
    exit(); // Stop further processing if the user is not an admin
}
require_once '../classes/profile.class.php'; // Include your profile class

// Check if both 'user_id' and 'current_is_admin' are passed
if (isset($_GET['user_id']) && isset($_GET['current_is_admin'])) {
    $user_id = $_GET['user_id'];  // Get the user ID
    $current_is_admin = $_GET['current_is_admin'];  // Get the current admin status

    // Create an instance of the Profile class
    $profile = new Profile();

    // Toggle the is_admin value (if 1, set to 0; if 0, set to 1)
    $new_is_admin = ($current_is_admin == 1) ? 0 : 1;

    // Prepare the data array for the update
    $data = ['is_admin' => $new_is_admin];

    // Call a method to update the user's admin status in the database
    $updateSuccess = $profile->updateIsAdmin($user_id, $new_is_admin);

    // Check if the update was successful
    if ($updateSuccess) {
        // Redirect back to the staff page or another page
        header("Location: staff.php");
        exit();
    } else {
        // Display an error message if the update failed
        echo "Failed to update user status.";
    }
} else {
    // Display an error message if the parameters are missing
    echo "Invalid parameters.";
}
