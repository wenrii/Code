<?php
$page_title = "CodeLuck - Login";
require_once '../tools/function.php';
require_once '../classes/auth.class.php';

session_start();

$username = $password = ''; // Initialize variables
$accountObj = new Auth();
$loginErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']); // Now correctly receives username
    $password = $_POST['password'];  // Receives the password

    $loginResult = $accountObj->login($username, $password);

    if ($loginResult && $loginResult['is_admin'] == 1) {
        $_SESSION['user'] = $loginResult;
        header('Location: ../admin/index.php'); // Correct redirect location
        exit;
    } elseif ($loginResult) {
        $_SESSION['user'] = $loginResult;
        header('Location: ../user/index.php'); // Correct redirect location
        exit;
    } else {
        $loginErr = 'Invalid username or password.'; // Clearer message
    }
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
    <title>Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



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
    <link href="../css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form method="post" action="">  <!-- Added method="post" and action="" -->
            <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Signin to Brofolio</h1>

            <?php if (!empty($loginErr)): ?>  <!-- Display error message -->
               <div class="alert alert-danger"><?= $loginErr ?></div>
            <?php endif; ?>


            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?= htmlspecialchars($username) ?>">  <!-- Added name="username" and value -->
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">  <!-- Added name="password" -->
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me" name="remember"> Remember me  </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

            <p class="mt-3 mb-3 text-muted">Don't have an account? <a href="signup.php">Register</a></p>

        </form>
    </main>



</body>

</html>