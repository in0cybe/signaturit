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
		<table border="1" cellspacing="0" cellpadding="">
			<tbody>
				<tr>
					<td>
						<h1>Plaintiff vs Defendant First phase</h1>
						</br>
						You can choose several options at once
						<?php
						helper('form');

						$optionsP = [
							'5'  => 'King',
							'2'    => 'Notary',
							'1'  => 'Validator',
						];

						$optionsD = [
							'5'  => 'King',
							'2'    => 'Notary',
							'1'  => 'Validator',
						];

						$attributes = ['plaintiff', 'defendant'];
						echo form_open('http://localhost/Home/firstCase', $attributes);

						echo form_label('The plaintiff ', 'plaintiff');
						echo '</br>';
						echo form_multiselect('plaintiff', $optionsP);

						echo '</br>';
						echo form_label('The defendant ', 'defendant ');
						echo '</br>';
						echo form_multiselect('defendant', $optionsD);

						echo '</br></br>';
						echo form_submit('mysubmit', 'Winner!');
						echo form_close();
						?>
					</td>
					<td>
						<h1>Plaintiff vs Defendant Second stage</h1>
						</br>
						You can choose several options at once
						<?php
						helper('form');

						$optionsP = [
							'5'  => 'King',
							'2'    => 'Notary',
							'1'  => 'Validator',
						];

						$optionsD = [
							'5'  => 'King',
							'2'    => 'Notary',
							'1'  => 'Validator',
						];

						$attributes = ['plaintiff', 'defendant'];
						echo form_open('http://localhost/Home/secondCase', $attributes);

						echo form_label('The plaintiff ', 'plaintiff');
						echo '</br>';
						echo form_multiselect('plaintiff', $optionsP);

						echo '</br>';
						echo form_label('The defendant ', 'defendant ');
						echo '</br>';
						echo form_multiselect('defendant', $optionsD);

						echo '</br></br>';
						echo form_submit('mysubmit', 'Winner!');
						echo form_close();
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</section>


	<!-- FOOTER: DEBUG INFO + COPYRIGHTS -->


</body>

</html>