<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:01.
 * | Site: teslex.tech
 * | ------------------------------
 * | utils.php
 * | ---
 */


function IS_GET()
{
	return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function IS_POST()
{
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function IS_PUT()
{
	return $_SERVER['REQUEST_METHOD'] == 'PUT';
}

function IS_DELETE()
{
	return $_SERVER['REQUEST_METHOD'] == 'DELETE';
}

function GET_METHOD()
{
	$method = $_SERVER['REQUEST_METHOD'];

	if (IS_POST()) {
		if (isset($_SERVER['X-HTTP-METHOD-OVERRIDE'])) {
			$method = strtoupper($_SERVER['X-HTTP-METHOD-OVERRIDE']);
		}
	}

	return $method;
}

function GET_CLIENT_IP()
{
	return $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
}

function DATA() {
	return file_get_contents("php://input");
}


function require_all($dir, $depth = 0)
{
	$scan = glob("$dir/*");
	foreach ($scan as $path) {
		if (preg_match('/\.php$/', $path)) {
			require $path;
		} elseif (is_dir($path)) {
			require_all($path, $depth + 1);
		}
	}
}

function debug(...$s)
{
	echo('<pre>');
	foreach ($s as $item) {
		var_dump($item);
	}
	echo('</pre>');
}

function o2o($instance, $className)
{
	return unserialize(sprintf(
		'O:%d:"%s"%s',
		strlen($className),
		$className,
		strstr(strstr(serialize($instance), '"'), ':')
	));
}

function a2o(array $array, $className)
{
	return unserialize(sprintf(
		'O:%d:"%s"%s',
		strlen($className),
		$className,
		strstr(serialize($array), ':')
	));
}

function o2a($object)
{
	$a = [];
	$reflection = new ReflectionClass($object);
	foreach ($reflection->getProperties() as $property) {
		$property->setAccessible(true);
		$a[$property->getName()] = $property->getValue($object);
	}
	return $a;
}

function checkRecaptcha($secret = null, $g_recaptcha_response = null, $remote = null)
{
	if (!isset($remote)) $remote = GET_CLIENT_IP();
	if (!isset($secret)) $secret = TOOLS['recaptcha_secret'];
	if (!isset($remote)) $remote = $_REQUEST['g_recaptcha_response'];

	$re_data = http_build_query(
		array(
			'secret' => $secret,
			'response' => $g_recaptcha_response,
			'remoteip' => $remote
		)
	);

	$opts = array('http' =>
		array(
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => $re_data
		)
	);

	$result = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, stream_context_create($opts)));

	return $result->success;
}

function startsWith($haystack, $needle)
{
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
	$length = strlen($needle);

	return $length === 0 ||
		(substr($haystack, -$length) === $needle);
}

function get_mime_type($filename)
{
	$idx = explode('.', $filename);
	$count_explode = count($idx);
	$idx = strtolower($idx[$count_explode - 1]);

	$mimet = array(
		'txt' => 'text/plain',
		'htm' => 'text/html',
		'html' => 'text/html',
		'php' => 'text/html',
		'css' => 'text/css',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'xml' => 'application/xml',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv',

		// images
		'png' => 'image/png',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'ico' => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif' => 'image/tiff',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',

		// archives
		'zip' => 'application/zip',
		'rar' => 'application/x-rar-compressed',
		'exe' => 'application/x-msdownload',
		'msi' => 'application/x-msdownload',
		'cab' => 'application/vnd.ms-cab-compressed',

		// audio/video
		'mp3' => 'audio/mpeg',
		'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',

		// adobe
		'pdf' => 'application/pdf',
		'psd' => 'image/vnd.adobe.photoshop',
		'ai' => 'application/postscript',
		'eps' => 'application/postscript',
		'ps' => 'application/postscript',

		// ms office
		'doc' => 'application/msword',
		'rtf' => 'application/rtf',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',
		'docx' => 'application/msword',
		'xlsx' => 'application/vnd.ms-excel',
		'pptx' => 'application/vnd.ms-powerpoint',


		// open office
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	);

	if (isset($mimet[$idx])) {
		return $mimet[$idx];
	} else {
		return 'application/octet-stream';
	}
}

function unbind($s)
{
	return "solovey_database_unbind($s)";
}

function startApplication($app = 'app')
{
	spl_autoload_register(function ($class) use ($app) {
		$path = $_SERVER['DOCUMENT_ROOT'] . '/' . $app . '/' . str_replace('\\', '/', $class) . '.php';

		if (is_file($path)) {
			require_once $path;
		}
	}, true);
}

function render($path, array $vars = array())
{
	$templatePath = $path . '.php';

	if (!is_file($templatePath)) {
		throw new \InvalidArgumentException(sprintf('Template "%s" not found in "%s"', $path, $templatePath));
	}

	extract($vars);

	try {
		require $templatePath;
	} catch (Exception $e) {
		throw $e;
	}
}