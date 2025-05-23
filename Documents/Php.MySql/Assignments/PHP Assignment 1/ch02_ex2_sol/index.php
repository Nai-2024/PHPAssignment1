<?php

// Set Default Values for form fields and results- to ensure that investemen_amount variable exists when the form load for the first time
$investment_amount = '';
$interest_rate = '';
$years = '';
$future_value_f = '';
$error_message = '';

// Check if Form was submitted using POST method
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and validate the input - 
    $investment_amount = filter_input(INPUT_POST, 'investment_amount', FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);


    // Input validation
    if ($investment_amount === false || $investment_amount <= 0) { // checks if the input is abc for example not number or it is <=0.
        $error_message = 'Investment must be a valid number greater than 0.';
    } else if ($interest_rate === false || $interest_rate <= 0 || $interest_rate > 15) { // checks if inoput is abc, or interest rate is <=0 or >15, 
        $error_message = 'Interest rate must be between 0 and 15.';
    } else if ($years === false || $years <= 0 || $years > 30) { // checks if years is abc, or <= 0 or >= 30
        $error_message = 'Years must be between 1 and 30.';
    } else {
        // No errors, do the calculation
        $future_value = $investment_amount; // Setting the initial investement. the base amount on which interest will be added.($1000)
        for ($i = 1; $i <= $years; $i++) { // year =1, 
            // future_value = 1000 +(1000 * 10 *%) 
            $future_value += $future_value * $interest_rate * 0.01; 
            
        }

     // Format for display - Converts the numbers into a string with 2 decimal. ex- 1000.00, append $ sign to it.
    $investment_amount_f = '$' . number_format($investment_amount, 2); 
    $interest_rate_f = $interest_rate . '%'; // Appends a percent sign to the interest rate. 10%
    $future_value_f = '$' . number_format($future_value, 2); // Convert numbers to decimal plus appending $ sign to it.

    // Clear inputs after calculation is done.
    $investment_amount = '';
    $interest_rate = '';
    $years = '';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <main>
    <h1>Future Value Calculator</h1>
    <!-- Check for error_message and then display it at the top.  -->
    <?php if (!empty($error_message)) { ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php } ?>

    <form action=" " method="post">

        <div id="data">
            <label>Investment Amount:</label>
            <input type="text" name="investment_amount"
                   value="<?php echo htmlspecialchars($investment_amount); ?>"><br>

            <label>Yearly Interest Rate:</label>
            <input type="text" name="interest_rate"
                   value="<?php echo htmlspecialchars($interest_rate); ?>"><br>

            <label>Number of Years:</label>
            <input type="text" name="years"
                   value="<?php echo htmlspecialchars($years); ?>">
<br>
        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Calculate"><br>
        </div>

    </form>

      <!-- Check if the fture_value is not empty and then display it.  -->
    <?php if (!empty($future_value_f)) : ?>
            <h2>Results</h2>
            <label>Investment Amount:</label>
            <span><?php echo htmlspecialchars($investment_amount_f); ?></span><br>

            <label>Yearly Interest Rate:</label>
            <span><?php echo htmlspecialchars($interest_rate_f); ?></span><br>

            <label>Years:</label>
            <span><?php echo htmlspecialchars($_POST['years']); ?></span><br>

            <label>Future Value:</label>
            <span><?php echo htmlspecialchars($future_value_f); ?></span><br>

            <p>This calculation was done on <?php echo date('m/d/Y'); ?>.</p>
        <?php endif; ?>
    </main>
</body>
</html>
