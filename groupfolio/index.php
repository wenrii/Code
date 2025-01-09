<?php
require_once 'classes/profile.class.php';

$profile = new Profile();
$allProfiles = $profile->getAllProfiles();

if (!$allProfiles) {
    echo "Error retrieving profiles: " . $profile->getError();
    exit; // Stop further processing if there's an error
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Album example · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">



    <!-- Bootstrap core CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

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


</head>

<body>

    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">About</h4>
                        <p class="text-muted">A simple website where you can see the Teams profile who made this website. "para ingun"</p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Account</h4>
                        <ul class="list-unstyled">
                            <li><a href="account/login.php" class="text-white">Login</a></li>
                            <li><a href="account/signup.php" class="text-white">Sign-up</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <strong>Brofolio</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>

    <main>

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Welcome fellas</h1>
                    <p class="lead text-muted">This are our team of ACT-AD programmers that doesnt do anything</p>
                </div>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"> <!-- Re-added the row div -->
                    <?php foreach ($allProfiles as $profileData) : ?>
                        <div class="col"> <!-- Keep the col div inside the loop -->
                            <div class="card shadow-sm">
                                <?php
                                $imagePath = isset($profileData['profile_image']) ? 'uploads/profile_pictures/' . $profileData['profile_image'] : 'uploads/MaoMao _ Kusuriya no Hitorigoto.jpg'; // Use a default/placeholder image
                                $bio = $profileData['bio'] ?? 'No bio available.';
                                ?>
                                <img src="<?= $imagePath ?>" class="card-img-top" alt="Profile Image" width="100%" height="225" style="object-fit: cover;">

                                <div class="card-body">
                                    <h5><?= $profileData['lastname'] . ", " . $profileData['firstname'] ?></h5>
                                    <h6>Bio:</h6>
                                    <p class="card-text"><?= $bio ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="profile.php?personal_id=<?= $profileData['personal_id'] ?>"><button type="button" class="btn btn-sm btn-outline-secondary">Profile</button>
                                                <a href="<?= $profileData['link'] ?>"><button type="button" class="btn btn-sm btn-outline-secondary">Portfolio</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>
            </div>
        </div>

    </main>

    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Back to top</a>
            </p>
        </div>
    </footer>


    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>