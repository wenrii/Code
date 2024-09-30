<?php
    // Calling Classes for its Functions to be use
    require_once("class/function.class.php");
    require_once("class/book.class.php");

    // Initializing variables to hold input values and error messages
    $name = $category = $price = $availability = '';
    $nameErr = $categoryErr = $priceErr = $availabilityErr = '';

    // Creating a new object of the Product class to use its methods
    $productObj = new Product();

    // Cheacking if the form was submitted using POST method
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty("ddd")) {
        // Cleaning input values to prevent SQL injection
        $name = clean($_POST["name"]);
        $category = clean($_POST["category"]);
        $price = clean($_POST["price"]);
        $availability = isset($_POST["availability"]) ? clean($_POST["availability"]) : ''; // Set to isset for Radio

        // Validating if name is empty
        if (empty($name)) {
            $nameErr = "Name is required"; // Call if name is empty
        }
        // Validate if category is empty
        if (empty($category)) {
            $categoryErr = "Category is required";  // Call if category is empty
        }
        // Validate if price is empty
        if (empty($price)){
            $priceErr = "Price is required"; // Call if price is empty
        } elseif (!is_numeric($price)){ // Validating if price is not a number
            $priceErr = "Price must be a number"; // Call if price is not a number
        } elseif ($price < 1){ // Validating if price is less than one
            $priceErr = "Price must be greater than zero"; // Call if price is less than
        }
        // Validate if availability is empty
        if (empty($availability)) {
            $availabilityErr = "Availability is required";  // Call if availability is empty
        }

        // IF error message is empty
        if (empty($codeErr) && empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($availabilityErr)){
            // Assigning the clean inputs to the product object
            $productObj->name = $name;
            $productObj->category = $category;
            $productObj->price = $price;
            $productObj->availability = $availability;

            // If all validations passed, add the product to the database
            if ($productObj->add()) {
                // Redirect to the Location: after successful insertion
                header('Location: index.php');
            } else {
                // Display an error message if something went wrong during insertion
                echo 'Something went wrong when adding the new product. ';
            }
        }
    }
?>

<!-- HTML form is similar to Edit -->
<!-- HTML form for adding the product details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        /* Error message style */
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Form to collect product details -->
    <form action="" method="post">
        <!-- Span is for ERROR indication -->
        <!-- Label is for NOTE whats in the Field -->
        <!-- Input is for INPUTING -->
        <span class="error">* are required field</span>
        <br>
        <label for="name">Name</label><span class="error">*</span>
        <br>
        <input type="text" name="name" id="name" value="<?= $name ?>">
        <br>
        <!-- If nameErr is not Empty -->
        <?php if (!empty($nameErr)): ?>
            <span class="error"><?= $nameErr ?></span><br>
        <?php endif; ?>

        <!-- Category Dropdown with Validation error -->
        <label for="category">Category</label><span class="error">*</span>
        <br>
        <select name="category" id="category">
            <option value="">Select Category</option>
            <option value="fiction" <?= (isset($category) && $category == 'fiction') ? 'selected=true' : ''?>>Fiction</option>
            <option value="non-fiction" <?= (isset($category) && $category == 'non-fiction') ? 'selected=true' : ''?>>Non-Fiction</option>
            <option value="biography" <?= (isset($category) && $category == 'biography') ? 'selected=true' : ''?>>Biography</option>
        </select>
        <br>
        <?php if (!empty($categoryErr)): ?>
            <span class="error"><?= $categoryErr ?></span>
            <br>
        <?php endif; ?>

        <!-- Price Field with Validation error -->
        <label for="price">Price</label><span class="error">*</span>
        <br>
        <input type="number" name="price" id="price" value="<?= $price?>">
        <br>
        <?php if (!empty($priceErr)):?>
            <span class="error"><?= $priceErr ?></span>
            <br>
        <?php endif;?>

        <!-- Availability Radio with Validation error -->
        <label for="availability">Availability</label><span class="error">*</span>
        <br>
        <input type="radio" name="availability" id="instock" value='In Stock' <?=($availability == 'In Stock') ? 'checked' : ''?>> 
        <label for="instock">In Stock</label>
        <input type="radio" name="availability" id="nostock" value='No Stock'<?=($availability == 'No Stock') ? 'checked' : ''?>>
        <label for="nostock">No Stock</label>
        <br>
        <?php if (!empty($availabilityErr)):?>
            <span class="error"><?= $availabilityErr?></span><br>
        <?php endif;?>

        <!-- Submit Button -->
        <input type="submit" value="Add Book">
    </form>
</body>
</html>
