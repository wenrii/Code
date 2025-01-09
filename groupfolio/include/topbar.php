<?php
// Get the current page's filename (without extension)
$currentPage = basename($_SERVER['PHP_SELF'], ".php");
?>

<header class="mb-auto">
  <div>
    <h3 class="float-md-start mb-0">
      <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="60" height="45">
    </h3>
    <nav class="nav nav-masthead justify-content-center float-md-end">
      <a class="nav-link <?php if ($currentPage == 'index') echo 'active'; ?>" aria-current="page" href="../user/index.php">Home</a>
      <a class="nav-link <?php if ($currentPage == 'profile')  echo 'active'; ?>" href="../user/profile.php">Profile</a> <!-- Assuming you have a profile.php -->
      <a class="nav-link <?php if ($currentPage == 'user.settings') echo 'active'; ?>" href="../user/user.settings.php">Settings</a>
      <a class="nav-link" href="../account/logout.php">Logout</a>
    </nav>
  </div>
</header>