<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Welcome to Signaturit Test!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />
</head>

<body>

	<!-- CONTENT -->

	<section>
		<h1>THE WINNER IS</h1>
		<?php if ($result) : ?>
			<?php echo $result; ?>
		<?php endif; ?>
	</section>
</body>

</html>