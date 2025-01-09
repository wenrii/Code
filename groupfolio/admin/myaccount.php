<?php
session_start();
require_once '../tools/function.php';
require_once '../classes/profile.class.php';

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$about = new Profile();
$userId = $_SESSION["user"]["user_id"];

// Get profile information from the database
$profile = $about->getProfile($userId);

// Set profile image path, use default if not set
$imagePath = isset($profile['profile_image']) ? '../uploads/profile_pictures/' . $profile['profile_image'] : '../uploads/MaoMao _ Kusuriya no Hitorigoto.jpg';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Profile Page">
    <meta name="author" content="User">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Profile Styles -->
    <style>
        /* Profile Page Styles Scoped to .profile-page */
        .profile-page body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .profile-page .card {
            margin-top: 30px;
        }

        .profile-page .profile-img {
            margin-bottom: 20px;
        }

        .profile-page #profileImageDisplay {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #ddd;
        }

        .profile-page .profile-info {
            padding-top: 20px;
        }

        .profile-page .profile-info ul {
            list-style-type: none;
            padding: 0;
        }

        .profile-page .profile-info li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .profile-page .profile-info li:last-child {
            border-bottom: none;
        }

        .profile-page .profile-info strong {
            font-weight: bold;
        }

        .profile-page .card-header {
            background-color: #343a40;
            color: white;
            padding: 15px;
        }

        .profile-page .card-body {
            padding: 20px;
        }

        .profile-page .card-body a {
            color: #007bff;
            text-decoration: none;
        }

        .profile-page .card-body a:hover {
            text-decoration: underline;
        }
    </style>
    <link href="../css/cover.css" rel="stylesheet">
</head>

<body class="profile-page d-flex h-100 text-center text-white bg-dark">
    <div class="cover-container d-flex w-100 h-1000 p-3 mx-auto flex-column">
        <?php include_once '../include/test.php'; ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                </div>
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body">
                        <!-- Profile Image -->
                        <div class="profile-img text-center">
                            <img src="<?php echo $imagePath; ?>" alt="Profile Image" class="img-thumbnail rounded-circle" style="width: 140px; height: 140px; object-fit: cover;" id="profileImageDisplay">
                        </div>

                        <div class="profile-info mt-4">
                            <h5 class="mb-3" style="color: black;">Personal Information</h5>
                            <?php if ($profile): ?>
                                <div class="row">
                                    <div class="col-md-6"> <!-- First column -->
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>First Name:</strong> <?= htmlspecialchars($profile['firstname']) ?></li>
                                            <li class="list-group-item"><strong>Last Name:</strong> <?= htmlspecialchars($profile['lastname']) ?></li>
                                            <li class="list-group-item"><strong>Course:</strong> <?= strtoupper(htmlspecialchars($profile['course'])) ?></li>
                                            <li class="list-group-item"><strong>Year:</strong> <?= htmlspecialchars($profile['year']) ?></li>
                                            <li class="list-group-item"><strong>Birthday:</strong> <?= htmlspecialchars($profile['birthday']) ?></li>

                                        </ul>
                                    </div>
                                    <div class="col-md-6"> <!-- Second column -->
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($profile['address']) ?></li>
                                            <li class="list-group-item"><strong>Contact:</strong> <?= htmlspecialchars($profile['contact']) ?></li>
                                            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></li>
                                            <li class="list-group-item"><strong>Bio:</strong> <?= htmlspecialchars($profile['bio']) ?></li>
                                            <li class="list-group-item"><strong>Link:</strong> <?= htmlspecialchars($profile['link']) ?></li>
                                        </ul>
                                    </div>
                                </div>

                            <?php else: ?>
                                <p style="color: black;">No profile information yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>