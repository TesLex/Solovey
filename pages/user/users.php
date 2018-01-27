<?php
/**
 * | -----------------------------
 * | Created by exp on 1/27/18/8:41 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | users.php
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
	<title>Users</title>

	<link rel="stylesheet" href="/static/app/app.css">
</head>
<body>

<ul id="users">
</ul>


<script src="/static/app/app.js"></script>
<script>
	let usersEl = document.querySelector('#users');

	function fillUsers(users) {
		users.map(function (u) {
			usersEl.innerHTML = usersEl.innerHTML + ('<li><a href="/users/' + u.id + '">' + u.username + '</a></li>')
		})
	}

	getUsers(fillUsers);
</script>
</body>
</html>
