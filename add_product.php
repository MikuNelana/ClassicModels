<?php
// Get the product data
$line_name = filter_input(INPUT_POST, 'line_name', 
            FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, 'line_description',
			FILTER_SANITIZE_STRING);
		if ($line_name == NULL || $line_name == FALSE || $description == NULL || 
            $description == FALSE) {
			$error = "Invalid product line data. Check all fields and try again.";
			include('../errors/error.php');
} else {
    require_once('database.php');

    // Add the product to the database  
    $query = 'INSERT INTO productlines
                 (productLine, textDescription)
              VALUES
                 (:line, :description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':line', $line);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();

    // Display the Product List page
    include('index.php');
}
?>