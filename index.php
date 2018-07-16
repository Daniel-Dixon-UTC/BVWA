<?php

define( 'BVWA_WEB_PAGE_TO_ROOT', '' );
require_once BVWA_WEB_PAGE_TO_ROOT . 'bvwa/includes/bvwaPage.inc.php';

bvwaPageStartup( array( 'authenticated', 'phpids' ) );

$page = bvwaPageNewGrab();
$page[ 'title' ]   = 'Welcome' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'home';

$page[ 'body' ] .= "

<div class=\"body_padded\">
	<h1>Welcome to the Big Vulnerable Web Application!</h1>
	<p>Big Vulnerable Web Application (BVWA) is a PHP/MySQL web application that is deliberatly vulnerable. It is based of the successful project Damn Vulnerable Web Application (DVWA). BVWA's main goals are to aid students to learn about web application security, create a safe place to practise these skills, and to help understand how to better secure web applications.</p>
	<p>The aim of BVWA is to <em>practise some of the most common web vulnerablilities</em with <em>various levels of difficulty</em>, with a simple straightforward interface.</p>
	<hr />
	<br />

	<h2>General Instructions</h2>

"

?>