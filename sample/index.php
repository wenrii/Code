<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <style>
        /* Style for Search result */
        p.search{
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Link to add product page -->
    <a href="addBook.php">Add Book</a>

    <?php
        // Include product class and get all product data
        require_once "class/book.class.php";
        // Calling Product class and using it by doing ->
        $productObj= new Product();
        // Calling the showAll fucntion to retrive all products from the database
        
        $keyword = $category = '';
        // $array = $productObj->showAll($keyword, $category);
        
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){
            $keyword = htmlentities($_POST['keyword']); // Get keyword from search bar
            $category = htmlentities($_POST['category']); // Get category from dropdown menu
            $array = $productObj->showAll($keyword, $category); // Call searchProduct function with keyword
        }
    ?>

    <!-- Search Bar -->
    <form action="" method="post">
        <!-- Search for Category -->
        <label for="">Category</label>
        <select name="category" id="category">
            <option value="">Select Category</option>
            <option value="fiction" <?= (isset($category) && $category == 'fiction')? 'selected-true' : '' ?>>Fiction</option>
            <option value="non-fiction" <?= (isset($category) && $category == 'non-fiction')? 'selected-true' : '' ?>>Non-Fiction</option>
            <option value="biography" <?= (isset($category) && $category == 'biography')? 'selected-true' : '' ?>>Biography</option>
        </select>
        <!-- Search for keywords -->
        <label for="">Search:</label>
        <input type="text" id="keyword" name="keyword" value="<?= $keyword ?>"> 
        <input type="submit" value="Search" name="search" id="search"> <!-- Search Button -->
    </form>

    <!-- Display product in HTML table -->
    <table border="1"> <!-- Adding border to separate cells -->
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        <?php
            $i = 1; //Counter for ID in Frontend
            // If product is empty, will display No Product Found
            if (empty($array)){
        ?>        
            <tr>
                <td colspan="7">  <!-- Colspan for error code to combine all cells -->
                <p class="search">No Product Found</p>
                </td>
            </tr>
        <?php
            }
        // Loop through all product data and print each row
        foreach ($array as $arr) {
        ?> 
            <tr>
                <!-- Row Number -->
                <td><?= $i ?></td>
                <!-- Product Name -->
                <td><?= $arr['name'] ?></td>
                <!-- Product Category -->
                <td><?= $arr['category'] ?></td>
                <!-- Product Price -->
                <td><?= $arr['price'] ?></td>
                <!-- Product Availability -->
                <td><?= $arr['availability']?></td>
                <td>
                    <!-- Link to Edit Product page -->
                    <a href="editBook.php?id=<?= $arr['id']?>">Edit</a>
                    <!-- Link to Delete Product -->
                    <a href="deleteBook.php?id=<?= $arr['id'] ?>" class="deleteBtn" data-id="<?= $arr['id'] ?>" data-name="<?= $arr['name'] ?>">Delete</a>
                </td>
            </tr>
        <?php
            $i++;   // Increment ID in frontend
        }
        ?>
    </table>
    <script src="./index.js"></script>
</body>
</html>