<?php
session_start();

require_once '../tools/function.php';
require_once '../classes/auth.class.php';
require_once '../classes/profile.class.php';

if (!isset($_SESSION["user"])) {
  header("Location: login.php"); // Redirect to login page if not logged in
  exit();
}

$about = new Profile();
$userId = $_SESSION["user"]["user_id"];

$profile = $about->getProfile($userId);

// Uppercase the username for display
$uppercaseText = strtoupper($_SESSION["user"]["username"]);

// Set profile image path, use default if not set
$imagePath = isset($profile['profile_image']) ? '../uploads/profile_pictures/' . $profile['profile_image'] : '../uploads/MaoMao _ Kusuriya no Hitorigoto.jpg';

?>
<!doctype html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Profile · Bootstrap</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">


  <!-- Bootstrap core CSS -->
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <!-- Custom styles for this template -->
  <link href="../css/cover.css" rel="stylesheet">
</head>

<body class="d-flex h-100 text-center text-white bg-dark">

  <div class="cover-container d-flex w-100 h-1000 p-3 mx-auto flex-column">

    <?php include_once '../include/topbar.php' ?>

    <main class="px-3">
      <!-- Display Profile Image -->
      <img src="<?php echo $imagePath; ?>" alt="Profile Image" class="img-thumbnail rounded-circle" style="width: 140px; height: 140px; object-fit: cover;" id="profileImageDisplay">

      <!-- Display Username -->
      <h2><?= $uppercaseText ?></h2>

      <?php if ($profile): ?>
        <!-- Display Bio -->
        <h6>Bio:</h6>
        <p><?= htmlspecialchars($profile['bio']) ?></p>

        <!-- Display Link -->
        <h6>Link:</h6>
        <p><a href="<?= htmlspecialchars($profile['link']) ?>"><?= htmlspecialchars($profile['link']) ?></a></p>
      <?php else: ?>
        <!-- No profile information yet -->
        <p>No profile information yet.</p>
        <p class="lead">
          <a href="user.settings.php" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Set-up Account</a>
        </p>
      <?php endif; ?>
    </main>

    <footer class="mt-auto text-white-50">
      <p>Profile template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
    </footer>
  </div>

</body>

</html>