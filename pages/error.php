<?php
/**
 * | -----------------------------
 * | Created by exp on 1/27/18/5:51 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | error.php
 * | ---
 */
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title><?= $code ?> <?= $title ?></title>

	<style>
		body {
			color: whitesmoke;

			background-color: #333;

			padding: 0;
			margin: 0;
		}

		.container {
			max-width: 100%;
			max-height: 100%;

			font-family: sans-serif;

			background-color: lightcoral;
			/*border-radius: 2px;*/

			align-items: center;
			justify-content: center;
			text-align: center;
		}

		.code {
			padding-top: 10px;
		}

		.back-btn {
			background-color: whitesmoke;
			color: lightcoral;

			padding: 10px 20px;

			border-radius: 25em;

			cursor: pointer;

			transition: all .2s ease-in-out;
			-moz-user-select: none;
			-khtml-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		.back-btn:hover {
			box-shadow: 0 1px 1px #333;
		}

		.solution {
			padding-bottom: 10px;
		}
	</style>
</head>
<body>

<div class="container">

	<h1 class="code">
		<?= $title ?> <?= $code ?>
	</h1>
	<p class="description">
		<?= $description ?>
	</p>
	<p class="solution">
		<?= $solution ?>
	</p>

	<a onclick="history.back()" class="back-btn">Back</a>
</div>

</body>
</html>