<?php include '../view/header.php'; 
$query = 'SELECT * FROM productlines
              ORDER BY productLine';
    $statement = $db->prepare($query);
    $statement->execute();
    $lines = $statement->fetchAll();
    $statement->closeCursor();
?>
<main>

    <!-- display a table of customer information -->
    <h2>View/Update Product</h2>
    <form action="update_product.php" method="post" id="aligned">
        				
		<label>Name:</label>
		<input type="text" name="product_name" size="40" readonly
				value="<?php echo htmlspecialchars($name); ?>">
		<br>
		
		<label>Product Line:</label>
        <select name="product_line">
            <?php foreach ($lines as $line) : 
                if ($prod_line == $line['productLine']) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
            ?>
            <option value="<?php echo htmlspecialchars($line['productLine']); ?>" 
                <?php echo $selected; ?>>
                <?php echo htmlspecialchars($line['productLine']); ?>
            </option>
            <?php endforeach; ?>
        </select>
        <br>
			
		<label>Scale:</label>
		<input type="text" name="product_scale" readonly
			value="<?php echo htmlspecialchars($scale); ?>" >
		<br>
        
        <label>Vendor:</label>
        <input type="text" name="product_vendor" size="30" readonly
               value="<?php echo htmlspecialchars($vendor); ?>">
        <br>

        <label>Description:</label>
        <textarea readonly name="product_description"><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8')?></textarea>
        <br>

        <label>QTY in Stock:</label>
        <input type="text" name="quantity" 
               value="<?php echo htmlspecialchars($qis); ?>">
        <br>

        <label>Selling Price:</label>
        <input type="text" name="selling_price" 
               value="<?php echo htmlspecialchars($price); ?>">
        <br>

        <label>Manufacturer Price:</label>
        <input type="text" name="msrp" 
               value="<?php echo htmlspecialchars($msrp); ?>" >
        <br>
	</table>
         <label>&nbsp;</label>
        <input type="submit" value="Update Product">
        <br>
    </form>

</main>
<?php include '../view/footer.php'; ?>