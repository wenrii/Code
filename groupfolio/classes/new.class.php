<?php
require_once 'database.class.php';
require_once 'profile.class.php'; // Assuming the provided class is saved as profile.class.php

// Initialize the Profile class
$profile = new Profile();

// User ID (in a real application, retrieve this from session or authentication context)
$user_id = 1;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Upload the image
    $uploadResult = $profile->uploadImage($user_id);

    if ($uploadResult) {
        echo "<p>Image uploaded successfully! <a href='$uploadResult'>View Image</a></p>";
    } else {
        echo "<p>Error: " . htmlspecialchars($profile->getError()) . "</p>";
    }
}

// Get the current profile image path
$imagePath = $profile->getImagePath($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Show Profile Image</title>
</head>

<body>
    <h1>Upload Profile Image</h1>

    <?php if ($imagePath): ?>
        <h2>Current Profile Image:</h2>
        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Image" style="max-width: 200px; height: auto;">
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="profile_image">Choose a profile image:</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</body>

</html>