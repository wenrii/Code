<?php
$page_title = "Sign up";
require_once '../tools/function.php';
require_once '../classes/auth.class.php';

session_start();

$accountObj = new Auth();

$username = $password = $confirm_password = '';
$usernameErr = $passwordErr = $confirm_passwordErr = $genericErr = ''; // Initialize $genericErr


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);

    // Validation
    $isValid = true; // Use a flag for overall validation

    if (empty($username)) {
        $usernameErr = "Username is Required!";
        $isValid = false;
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {  // Alphanumeric and underscore only
        $usernameErr = "Username can only contain letters, numbers, and underscores.";
        $isValid = false;
    } elseif ($accountObj->usernameExist($username)) {
        $usernameErr = "Username already taken!";
        $isValid = false;
    }

    if (empty($password)) {
        $passwordErr = "Password is Required!";
        $isValid = false;
    } elseif (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters long.";
        $isValid = false;
    }  // Add more password complexity checks here if needed (e.g., at least one uppercase, one number, etc.)

    if (empty($confirm_password)) {
        $confirm_passwordErr = 'Confirm password is required!';
        $isValid = false;
    } elseif ($confirm_password != $password) {
        $confirm_passwordErr = 'Confirm password does not match!';
        $isValid = false;
    }

    if ($isValid) {
        $accountObj->username = $username;
        $accountObj->password = $password;

        if ($accountObj->register()) {
            // Set a success message in the session so the login page can display it
            $_SESSION['registration_success'] = "Account created successfully! You can now log in."; // Better UX
            header("Location: login.php");
            exit();
        } else {
            $genericErr = "Error creating account. Please try again later.";
            if (!empty($accountObj->lastError)) { // Check if lastError is set
                error_log("Registration error: " . $accountObj->lastError);  // Now this will work!
            } else {
                error_log("Registration error: Unknown error."); // Log a generic message if lastError is not set
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create an Account</title>




    <!-- Bootstrap core CSS -->

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
    <link href="../css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="" method="post">
            <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Create an Account</h1>

            <div class="form-floating mb-3">
                <input type="username" class="form-control <?= !empty($usernameErr) ? 'is-invalid' : ''; ?>" id="floatingInput" name="username" placeholder="name@example.com" value="<?= $username ?>">
                <label for="floatingInput">Username</label>
                <div class="invalid-feedback"><?= $usernameErr ?></div>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control <?= !empty($passwordErr) ? 'is-invalid' : ''; ?>" id="floatingPassword" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <div class="invalid-feedback"><?= $passwordErr ?></div>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control <?= !empty($confirm_passwordErr) ? 'is-invalid' : ''; ?>" id="floatingPassword" name="confirm_password" placeholder="Confirm Password">
                <label for="floatingPassword">Confirm Password</label>
                <div class="invalid-feedback"><?= $confirm_passwordErr ?></div>
            </div>
            <button class="mt-3 w-100 btn btn-lg btn-primary" type="submit" value="Sign up">Sign up</button>
            <!-- <p class="mt-3 mb-3 text-muted">&copy; 2017–2021</p> -->
            <?php if (!empty($genericErr)): ?>
                <div class="alert alert-danger"><?= $genericErr ?></div>
            <?php endif; ?>

        </form>
        <p class="mt-3 mb-3 text-muted">Already have an Account? <a href="login.php">Log In</a></p>

    </main>



</body>

</html>