<?php

if (isset($_POST['submit']))
{

	try
	{

		require "../config.php";
		require "../common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$sql = "SELECT *
						FROM users
						WHERE address = :address";

		$address = $_POST['address'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':address', $address, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit']))
{
	if ($result && $statement->rowCount() > 0)
	{ ?>
		<h2>Results</h2>

		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Email</th>
					<th>Id_type</th>
					<th>Id_number</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
				<td><?php echo escape($row["id"]); ?></td>
				<td><?php echo escape($row["firstname"]); ?></td>
				<td><?php echo escape($row["lastname"]); ?></td>
				<td><?php echo escape($row["phone"]); ?></td>
				<td><?php echo escape($row["address"]); ?></td>
				<td><?php echo escape($row["email"]); ?></td>
				<td><?php echo escape($row["id_type"]); ?></td>
				<td><?php echo escape($row["id_number"]); ?></td>
				<td><?php echo escape($row["date"]); ?> </td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>
	<?php
	}
	else
	{ ?>
		<blockquote>No results found for <?php echo escape($_POST['address']); ?>.</blockquote>
	<?php
	}
}?>

<h2>Find user based on Address</h2>

<form method="post">
	<label for="address">Address</label>
	<input type="text" id="address" name="address">
	<input type="submit" name="submit" value="View Results">
</form>
<br>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
