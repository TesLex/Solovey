const xhttp = new XMLHttpRequest();

let API = function (method, callback) {
	GET('/api/' + method, e => callback(e))
};

function getUsers(callback) {
	API('users', e => {
		if (e.status === 200)
			callback(JSON.parse(e.responseText));
		else
			alert('ERROR')
	})
}

function getUser(id, callback) {
	API('users/' + id, e => {
		if (e.status === 200)
			callback(JSON.parse(e.responseText));
		else
			alert('ERROR')
	})
}

function GET(url, callback) {
	xhttp.onreadystatechange = function () {
		if (this.readyState === 4)
			callback(this)
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}