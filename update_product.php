<?php
// Get the product data
$product_code = filter_input(INPUT_POST, 'productCode', 
			FILTER_SANITIZE_STRING);
$product_line = filter_input(INPUT_POST, 'product_line');
$qis = filter_input(INPUT_POST, 'quantity');
$price = filter_input(INPUT_POST, 'selling_price');
$msrp = filter_input(INPUT_POST, 'msrp');

require_once('database.php');

    // Update the product to the database  
    $query = 'UPDATE products
              SET productLine = :line,
                  quantityInStock = :qty,
                  buyPrice = :price,
				  MSRP = :msrp
              WHERE productCode = :product_code';
    $statement = $db->prepare($query);
    $statement->bindValue(':line', $line);
    $statement->bindValue(':qty', $qty);
    $statement->bindValue(':price', $price);
	$statement->bindValue(':msrp', $msrp);
    $statement->bindValue(':product_code', $code);
    $statement->execute();
    $statement->closeCursor();

    // Display the Product List page
    include('index.php');
}
?>