<?php

    // filter_input() is a built-in function in PHP that’s used to get external data.
	$product_description = filter_input(INPUT_POST, 'product_description');
	$list_price = filter_input(INPUT_POST, 'list_price');
	$discount_percent = filter_input(INPUT_POST, 'discount_percent');
	
        //Discount logic
        $discount = $list_price * $discount_percent * .01; // 1000 * 10% = 100
        $discount_price = $list_price - $discount; // 1000 - 100 =  900

        // Sales Tax logic
        $sales_tax_rate = 0.13;
        $sales_tax_amount = $discount_price * $sales_tax_rate; // 900 * 13% = 117
        $total_price = $discount_price + $sales_tax_amount;
        
        // Format all values
        //Formats the numeric $list_price value to a string with exactly two decimal places and also append $ sign. Example --> $100.00
        $list_price_f = "$".number_format($list_price, 2);
        $discount_percent_f =  $discount_percent . "%";
        $discount_f = "$".number_format($discount, 2);
        $discount_price_f = "$".number_format($discount_price, 2);
        $sales_tax_amount_f = "$".number_format($sales_tax_amount, 2);
        $total_price_f = "$".number_format($total_price, 2);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
    <main>
        <h1>Product Discount Calculator</h1>

        <label>Product Description:</label>
        <span><?php echo htmlspecialchars($product_description); ?></span><br>

        <label>List Price:</label>
        <span><?php echo $list_price_f; ?></span><br>

        <label>Standard Discount:</label>
        <span><?php echo htmlspecialchars($discount_percent_f); ?></span><br>

        <label>Discount Amount:</label>
        <span><?php echo $discount_f; ?></span><br>

        <label>Price After Discount:</label>
        <span><?php echo $discount_price_f; ?></span><br>

        <label>Sales Tax (<?php echo $sales_tax_rate * 100; ?>%):</label>
        <span><?php echo $sales_tax_amount_f; ?></span><br>

          <label>Total Price (after tax):</label>
    <span><?php echo $total_price_f; ?></span><br>
    
    </main>
</body>
</html>