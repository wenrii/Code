<?php
session_start();

require_once '../classes/profile.class.php'; // Include your Profile class

// Ensure the user is logged in before uploading
if (!isset($_SESSION["user"])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}

$userId = $_SESSION["user"]["user_id"];
$targetDir = "../uploads/profile_pictures/"; // Directory where images are stored

// Check if a file was uploaded without errors
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_image']['tmp_name'];
    $fileName = basename($_FILES['profile_image']['name']);
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    // Validate file extension
    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        $newFileName = $userId . "_profile." . $fileExtension; // Ensure a unique name for the file
        $destPath = $targetDir . $newFileName;

        // Check if the target directory exists, and create it if not
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true); // Create directory with proper permissions
        }

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profile = new Profile(); // Create an instance of your Profile class

            // Update the database with the new file name (not the full path)
            if ($profile->updateProfileImage($userId, $newFileName)) {
                echo json_encode(['status' => 'success', 'message' => 'Profile image updated successfully.', 'imagePath' => $destPath]);  // Return the full path for display
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update database: ' . $profile->getError()]);
                // Consider removing the uploaded file if database update fails
                // unlink($destPath); 
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move the uploaded file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded or an error occurred during upload.']);
}
