<?php
    // Calling Classes for its Functions to be use
    require_once('class/function.class.php');
    require_once('class/book.class.php');

    // Initializing variables to hold input values and error messages
    $name = $category = $price = $availability = '';
    $nameErr = $categoryErr = $priceErr = $availabilityErr = '';

    // Creating a new object of the Product class to use its methods
    $productObj = new Product();

    // Checking if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Handle GET requests to fetch and display the product for editing
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Fetch the product information
            $record = $productObj->fetchRecord($id);
            if (!empty($record)) {
                // Store $record for each container
                $name = $record['name'];
                $category = $record['category'];
                $price = $record['price'];
                $availability = $record['availability'];
        } else {
            echo "No Product found";
            die;
        }
    } else {
        echo "No Product found";
        die;
    }
    // Handle POST request to update the product details
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Clean and assign the input using clean
        $id = clean($_POST['id']);
        $name = clean($_POST['name']);
        $category = clean($_POST['category']);
        $price = clean($_POST['price']);
        $availability = isset($_POST['availability'])? clean($_POST['availability']) : ''; // Set to Isset for Radio

        // Validate the name
        if (empty($name)) {
            $nameErr = "Name is required";
        }

        // Validate the category
        if (empty($category)) {
            $categoryErr = "Category is required";
        }

        // Validate the price
        if (empty($price)){
            $priceErr = "Price is required";
        } elseif (!is_numeric($price)){
            $priceErr = "Price must be a number";
        } elseif ($price < 1){
            $priceErr = "Price must be greater than zero";
        }

        // Validate the availability
        if (empty($availability)) {
            $availabilityErr = "Availability is required";
        }

        // If there are no errors, update the product
        if (empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($availabilityErr)) {
        // if (empty($codeErr) && empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($availabilityErr)) {
            $productObj->id = $id;
            $productObj->name = $name;
            $productObj->category = $category;
            $productObj->price = $price;
            $productObj->availability = $availability;

            // Try to update the product in the database
            if ($productObj->edit()) {
                // If successful, redirect to the Location: url
                header('Location: index.php');
            } else {
                // Else will display error message
                echo 'Something went wrong when updating the product. ';
            }
        }
    
    }
?>
<!-- HTML form is similar to Add -->
<!-- HTML form for editing the product details -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        /* Error message style */
       .error {
           color: red;
       }
   </style>
</head>
<body>
    <!-- Form for Edit -->
    <!-- Action is different from Add -->
    <form action="?id=<?= $id ?>" method="post">
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
        <input type="submit" value="Update Book">
    </form>
    
</body>
</html>