<?php
session_start();

require_once '../tools/function.php';
require_once '../classes/profile.class.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$about = new Profile();
$userId = $_SESSION["user"]["user_id"];

$profile = $about->getProfile($userId);  // Fetch profile data
$targetDir = "../uploads/profile_pictures/"; // Folder to save uploaded images


$imagePath = isset($profile['profile_image']) ? '../uploads/profile_pictures/' . $profile['profile_image'] : '../uploads/MaoMao _ Kusuriya no Hitorigoto.jpg';

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_image']['tmp_name'];
    $fileName = basename($_FILES['profile_image']['name']);
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($fileExtension), $allowedExtensions)) {
        $newFileName = $userId . "_profile." . $fileExtension;
        $destPath = $targetDir . $newFileName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Update the profile image path in the database
            if ($about->updateProfileImage($userId, $newFileName)) {
                echo json_encode(['status' => 'success', 'message' => 'Profile image updated successfully.', 'imagePath' => $destPath]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update profile image in database.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save the uploaded file.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Handle profile data update
    $firstname = clean_input($_POST['firstname']);
    $lastname = clean_input($_POST['lastname']);
    $course = clean_input($_POST['course']);
    $year = clean_input($_POST['year']);
    $birthday = clean_input($_POST['birthday']);
    $address = clean_input($_POST['address']);
    $contact = clean_input($_POST['contact']);
    $email = clean_input($_POST['email']);
    $bio = clean_input($_POST['bio']);
    $link = clean_input($_POST['link']);

    $updateData = compact('firstname', 'lastname', 'course', 'year', 'birthday', 'address', 'contact', 'email', 'bio', 'link');

    if ($profile) { // Update existing profile
        if ($about->updateProfile($userId, $updateData)) {
            $profile = $about->getProfile($userId);  // Refresh profile data
            echo "<div class='alert alert-success alert-dismissible fade show fixed-top' role='alert'>Profile updated successfully!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show fixed-top' role='alert'>Error updating profile: " . $about->getError() . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    } else { // Insert new profile
        if ($about->insertProfile($userId, $updateData)) {
            $profile = $about->getProfile($userId); // Fetch newly created profile
            echo "<div class='alert alert-primary alert-dismissible fade show fixed-top' role='alert'>Profile created successfully!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show fixed-top' role='alert'>Error creating profile: " . $about->getError() . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    }
}
?>


<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Cover Template · Bootstrap v5.0</title>

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

        .alert-fixed-top {
            position: fixed;
            top: 20px;
            /* Adjust as needed */
            left: 50%;
            transform: translateX(-50%);
            /* Center horizontally */
            z-index: 1050;
            /* Ensure it's above other elements */
            width: auto;
            /* Allow the alert to adjust width based on content */
            max-width: 80%;
            /* Set max-width for larger screens*/
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;

        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/cover.css" rel="stylesheet">
</head>

<body class="d-flex h-1000 text-center text-white bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <?php include_once '../include/topbar.php' ?>


        <main class="px-3">
            <div class="py-5 d-flex justify-content-center">
                <div>
                    <div class="position-relative">
                        <form id="imageUploadForm" method="post" enctype="multipart/form-data">
                            <label for="profile_image" style="cursor: pointer;">
                                <img src="<?php echo $imagePath; ?>" alt="Profile Image" class="img-thumbnail rounded-circle" style="width: 140px; height: 140px; object-fit: cover;" id="profileImageDisplay">
                            </label>
                            <input type="file" name="profile_image" id="profile_image" style="display:none" accept="image/*">
                        </form>

                        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                        <div id="upload-progress" class="progress mt-2" style="height: 5px; display: none;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="alert alert-danger mt-2" id="upload-error" style="display: none"></div>
                        </form>
                        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                        <div id="upload-progress" class="progress mt-2" style="height: 5px; display: none;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="alert alert-danger mt-2" id="upload-error" style="display: none"></div>

                    </div>
                </div>
            </div>

            <div class="row g-5 justify-content-center">
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Settings</h4>
                    <form class="needs-validation" method="POST" novalidate> <!-- Added novalidate -->
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label">First name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo isset($profile['firstname']) ? htmlspecialchars($profile['firstname']) : ''; ?>" required> <!-- Added htmlspecialchars -->
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo isset($profile['lastname']) ? htmlspecialchars($profile['lastname']) : ''; ?>" required> <!-- Added htmlspecialchars -->
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="course" class="form-label">Course</label>
                                <select name="course" id="course" class="form-select" required>
                                    <option value="">Choose your course</option>
                                    <option value="bscs" <?php if (isset($profile['course']) && $profile['course'] == 'bscs') echo 'selected'; ?>>BSCS</option>
                                    <option value="bsit" <?php if (isset($profile['course']) && $profile['course'] == 'bsit') echo 'selected'; ?>>BSIT</option>
                                    <option value="act-ad" <?php if (isset($profile['course']) && $profile['course'] == 'act-ad') echo 'selected'; ?>>ACT-AD</option>
                                    <option value="act-nt" <?php if (isset($profile['course']) && $profile['course'] == 'act-nt') echo 'selected'; ?>>ACT-NT</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid course.
                                </div>
                            </div>



                            <div class="col-12">
                                <label for="year" class="form-label">Year</label>
                                <select name="year" id="year" class="form-select" required>
                                    <option value="">Choose your year</option>
                                    <option value="1" <?php if (isset($profile['year']) && $profile['year'] == '1') echo 'selected'; ?>>1st Year</option>
                                    <option value="2" <?php if (isset($profile['year']) && $profile['year'] == '2') echo 'selected'; ?>>2nd Year</option>
                                    <option value="3" <?php if (isset($profile['year']) && $profile['year'] == '3') echo 'selected'; ?>>3rd Year</option>
                                    <option value="4" <?php if (isset($profile['year']) && $profile['year'] == '4') echo 'selected'; ?>>4th Year</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid year.
                                </div>
                            </div>


                            <div class="col-12">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo isset($profile['birthday']) ? htmlspecialchars($profile['birthday']) : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Valid birthday is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($profile['address']) ? htmlspecialchars($profile['address']) : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Valid address is required.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact"
                                    value="<?php echo isset($profile['contact']) ? htmlspecialchars($profile['contact']) : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Please enter a valid 11-digit contact number.
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($profile['email']) ? htmlspecialchars($profile['email']) : ''; ?>" required>
                                <div class="invalid-feedback">
                                    Valid Email is required.
                                </div>

                            </div>
                            <div class="col-12">
                                <label for="bio" class="form-label">Bio <span class="text-muted">(Personal Info)</span></label>
                                <textarea class="form-control" id="bio" name="bio" placeholder="Input interesting info"><?php echo isset($profile['bio']) ? htmlspecialchars($profile['bio']) : ''; ?></textarea>
                            </div>

                            <div class="col-12">
                                <label for="link" class="form-label">Link</label>
                                <input type="url" class="form-control" id="link" name="link" value="<?php echo isset($profile['link']) ? htmlspecialchars($profile['link']) : ''; ?>" placeholder="Enter your portfolio link" required>
                                <div class="invalid-feedback">
                                    Please provide a valid link.
                                </div>
                            </div>
                        </div>


                        <hr class="my-4">
                        <button class="w-100 btn btn-primary btn-lg my-3" name="submit" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </main>

    </div>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('profile_image').addEventListener('change', function(event) {
            const fileInput = this;
            const formData = new FormData(document.getElementById('imageUploadForm'));
            const progressBar = document.querySelector('.progress-bar');
            const progressContainer = document.getElementById('upload-progress');
            const errorContainer = document.getElementById('upload-error');

            progressContainer.style.display = 'block';
            errorContainer.style.display = 'none';

            fetch('../upload/upload_image.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('profileImageDisplay').src = data.imagePath;
                        progressBar.style.width = '100%';
                        progressBar.setAttribute('aria-valuenow', '100');
                    } else {
                        errorContainer.textContent = data.message;
                        errorContainer.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorContainer.textContent = 'An unexpected error occurred.';
                    errorContainer.style.display = 'block';
                })
                .finally(() => {
                    setTimeout(() => {
                        progressContainer.style.display = 'none';
                    }, 3000);
                });
        });


        document.getElementById('imageUploadForm').addEventListener('submit', function() {
            document.getElementById('upload-progress').style.display = 'block'; // Show progress bar
        })
        const contactInput = document.getElementById('contact');
        const form = document.querySelector('.needs-validation');

        form.addEventListener('submit', function(event) {
            if (!/^[0-9]{11}$/.test(contactInput.value)) { // Check pattern using JavaScript before submission
                event.preventDefault();
                event.stopPropagation();
                contactInput.classList.add('is-invalid'); // Show invalid feedback
            } else {
                contactInput.classList.remove('is-invalid');
            }

            form.classList.add('was-validated');
        });
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>