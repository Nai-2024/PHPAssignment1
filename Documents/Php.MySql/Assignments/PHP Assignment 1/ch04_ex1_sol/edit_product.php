<?php

// Bring in the code from database.php so I can use what's inside it
    require_once('database.php');


    // Get product ID  via post method
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    if($product_id == null || $product_id == false) {
            $error = "Missing or incorrect product ID.";
        
        include('error.php');
    }else{
        //Fetch the data (prdocts) from the database.
        $squery = 'SELECT * FROM categories ORDER BY categoryID'; // Get evrything from the categories, and sort them by categoryID.”
        $statement = $db -> prepare($squery); // db = db connection.  prepere the querry 
        $statement->execute(); // now execute the query
        $categories = $statement->fetchAll(); // fetch all data 
        $statement->closeCursor(); // JOb is done -cLose qerring.


        // Get product data
        $queryProduct = 'SELECT * FROM products WHERE productID = :product_id';
        $statement2 = $db->prepare($queryProduct);
        $statement2->bindValue(':product_id', $product_id);
        $statement2->execute();
        $product = $statement2->fetch();
        $statement2->closeCursor();
    }
?>

  <!--Display the existing data in a form for edition -->
  
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<main>
    <h1>Edit Product</h1>
    <form action="update_product.php" method="post" id="add_product_form">
        <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

        <label>Category:</label>
        <select name="category_id">
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['categoryID']; ?>" 
                <?php if ($category['categoryID'] == $product['categoryID']) echo 'selected'; ?>>
                <?php echo $category['categoryName']; ?>
            </option>
        <?php endforeach; ?>
        </select><br>

        <label>Category ID:</label>
        <input type="text" name="category_id" value="<?php echo $product['categoryID']; ?>"><br>

        <label>Code:</label>
        <input type="text" name="code" value="<?php echo $product['productCode']; ?>"><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $product['productName']; ?>"><br>

        <label>List Price:</label>
        <input type="text" name="price" value="<?php echo $product['listPrice']; ?>"><br>

        <label>&nbsp;</label>
        <input type="submit" value="Update Product"><br>
    </form>
    <p><a href="index.php">Cancel</a></p>
</main>
</body>
</html>