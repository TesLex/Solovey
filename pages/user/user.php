<?php
/**
 * | -----------------------------
 * | Created by exp on 1/27/18/9:15 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | user.php
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
	<title>User</title>

	<link rel="stylesheet" href="/static/app/app.css">
</head>
<body>

<h3 id="username"></h3>
ID: <a id="id"></a>
<br>
IMG: <a id="img"></a>

<script src="/static/app/app.js"></script>
<script>
	let username = document.querySelector('#username');
	let id = document.querySelector('#id');
	let img = document.querySelector('#img');

	function setUser(user) {
		username.innerHTML = user.username;
		id.innerHTML = user.id;
		img.innerHTML = user.img
	}

	getUser(<?= $id ?>, setUser);
</script>
</body>
</html>
