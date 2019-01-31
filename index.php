<?php
require_once('database.php');

// Get product line 
if (!isset($product_line)) {
    $product_line = filter_input(INPUT_GET, 'product_line', 
            FILTER_SANITIZE_STRING);
    if ($product_line == NULL || $product_line == FALSE) {
        $product_line = 'Classic Cars;
    }
}
// Get name for selected productline
$queryLine = 'SELECT productLine FROM productLines
                  WHERE productLine = :productLine';
$statement1 = $db->prepare($queryLine);
$statement1->bindValue(':productLine', $product_line);
$statement1->execute();
$line = $statement1->fetch();
$line_name = $line['productLine'];
$statement1->closeCursor();


// Get all lines
$query = 'SELECT * FROM productlines
              ORDER BY productLine';
    $statement = $db->prepare($query);
    $statement->execute();
    $lines = $statement->fetchAll();
    $statement->closeCursor();

// Get products for selected product line
$query = 'SELECT p.productCode, p.productName, 
			  p.productScale, p.buyPrice, COUNT(o.productCode) as total 
			  FROM products p, orderdetails o
              WHERE p.productLine = :line
			  AND p.productCode = o.productCode
			  GROUP BY p.productCode
              ORDER BY p.productName';
    $statement = $db->prepare($query);
    $statement->bindValue(":line", $line);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->
<body>
<header><h1>Product Manager</h1></header>
<main>
    <h1>Classic Models Product List</h1>

    <aside>
        <!-- display a list of categories -->
        <h2><u>Product Lines</u></h2>
        <nav>
        <ul>
        <?php foreach ($lines as $line) : ?>
            <li>
            <a href="?productLine=<?php echo $line['productLine']; ?>">
                <?php echo $line['productLine']; ?>
            </a>
            </li>
        <?php endforeach; ?>
        </ul>
        </nav>
    </aside>

    <section>
        <!-- display a table of products -->
        <h2><?php echo $line_name; ?></h2>
        <table>
            <tr>
                <th>Code</th>
                <th>Name</th>
				<th>Scale</th>
                <th class="right">Price</th>
				<th class = "center">Total Sold</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['productCode']; ?></td>
                <td><?php echo $product['productName']; ?></td>
				<td><?php echo $product['productScale']; ?></td>
                <td class="right"><?php echo $product['buyPrice']; ?></td>
				<td class="center"><?php echo $product['total']; ?></td>
                <td><form action="update_product_form" method="post">
                    <input type="hidden" name="productCode"
                           value="<?php echo $product['productCode']; ?>">
                    <input type="submit" value="Update">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p class="last_paragraph">
            <a href="add_productLine_form">Add New Product Line</a>
        </p>
    </section>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> ClassicModels Online</p>
</footer>
</body>
</html>