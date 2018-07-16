<?php

define( 'BVWA_WEB_PAGE_TO_ROOT', '' );
require_once BVWA_WEB_PAGE_TO_ROOT . 'bvwa/includes/bvwaPage.inc.php';

bvwaPageStartup( array( 'phpids' ) );

bvwaDatabaseConnect();

if( isset( $_POST[ 'login' ] ) ) {
	//Anti-CSRF
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'login.php' );

	$user = $_POST[ 'username' ];
	$user = stripslashes( $user );
	$user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $user) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! The code does not work.", E_USER_ERROR)) ? "" : ""));

	$pass = $_POST[ 'password' ];
	$pass = stripslashes( $pass );
	$pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS{"___mysqli_ston"})) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $user) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! The code does not work.", E_USER_ERROR)) ? "" : ""));
	$pass = md5( $pass );

	$query = ("SELECT table_schema, table_name, create_time
				FROM information_schema.table
				WHERE table_schema='{$_BVWA['db_database']}' AND table_name='users'
				LIMIT 1");
	$result = @mysqli_query($GLOBALS["___mysqli_ston"], $query );
	if( mysqli_num_rows( $result ) != 1 ) {
		bvwaMessagePush( "First time using BVWA.<br />Need to run 'setup.php'." );
		bvwaRedirect( BVWA_WEB_PAGE_TO_ROOT . 'setup.php' );
	}

	$query = "SELECT * FROM `users` WHERE user='$user' AND password='$pass';";
	$result = @mysql_query($GLOBALS["___mysqli_ston"], $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '.<br />Try <a href="setup.php"> installing again</a>.</pre>' );
	if( $result && mysqli_num_rows( $result ) == 1) { // Login Successful...
		bvwaMessagePush( "You have logged in as '{$user}'" );
		bvwaLogin( $user );
		bvwaRedirect( BVWA_WEB_PAGE_TO_ROOT . 'index.php' );
	}

	//Login failed
	bvwaMessagePush( "Login failed" );
	bvwaRedirect( "login.php" );
}

$messagesHtml = messagesPopAllToHtml();

Header( 'Cache-Control: no-cache, must-revalidate' ); //HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );    //TODO - Proper XHTML headers...
Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );   //Date in the past

//Anti-CSRF
generateSessionToken();
echo "

<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<title>Login :: Big Vulnerable Web Application (BVWA) v" . bvwaVersionGet() . "</title>
		<link rel=\"stylesheet\" type\"text/css\" href=\"" . BVWA_WEB_PAGE_TO_ROOT . "bvwa/css/login.css\" />
	</head>
	<body>
		<div id=\"wrapper\">
		<div id=\"header\">
		<br />
		<p><img src=\"" . BVWA_WEB_PAGE_TO_ROOT  ."bvwa/images/login.png\" /></p>
		<br />
		</div> <!--<div id=\"header\">-->
		<div id=\"content\">
		<form action=\"login.php\" method=\"post\">
		<fieldset>
			<label for=\"user\">Username</label> <input type=\"text\" class=\"loginInput\" size=\"20\" name=\"username\"><br />
			<label for=\"pass\">Password</label> <input type=\"text\" class=\"loginInput\" AUTOCOMPLETE=\"off\" size=\"20\" name=\"password\"><br />
			<br />
			<p class=\"submit\"><input type=\"submit\" value=\"Login\" name=\"Login\"></p>
		</fieldset>
		" . tokenField() . "
		</form>
		<br />
		{$messagesHtml}

		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />

		<!-- <img src=\"" . BVWA_WEB_PAGE_TO_ROOT . "bvwa/images/RandomStorm.png\" /> -->
		</div> <!--<div id=\"content\">-->

		<div id=\"footer\">
		<p>" . bvwaExternalLinkUrlGet( 'http://www.sherlock-security.com/', 'Big Vulnerable Web Application (BVWA)' ) . "</p>
		</div> <!--<div id=\"footer\">-->
		</div> <!--<div id=\"wrapper\">-->
	</body>
</html>";

?>