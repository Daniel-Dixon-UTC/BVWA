<?php

define( 'BVWA_WEB_PAGE_TO_ROOT', '' );
require_once BVWA_WEB_PAGE_TO_ROOT. 'bvwa/includes/bvwaPage.inc.php';

bvwaPageStartUp( array( 'phpids' ) );

$page = bvwaPageNewGrab();
$page[ 'title' ]   = 'About' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'about';

$page[ 'body' ] .= "

<div class=\"body_padded\">
	<h2>About</h2>
	<p>Version " . bvwaVersionGet() . " (Release Date: " . bvwaReleaseDateGet() . ")</p>
	<p>Big Vulnerable Web Application (BVWA) is a PHP/MySQL web application that is vulnerable. Based and inspired by the 'Damn Vulnerable Web Application (DVWA)' project, BVWA's main goals are to be an aid to students in computer securityto learn web application security, to be able to practise their newfound skills in a safe enviroment, and to give a better understanding on how to secure their own applications.</p>
	<p>BVWA was created by a team of people for use of the UTC Sheffield Olympic Legacy Park school, and the Sherlock Security website.<br />It was created by students, for students.</p>
	<p>All DVWA content is copyright 2008-2015 RandomStorm & Ryan Dewhurst.</p>

	<h2>Links</h2>
	<ul>
		<li>The DVWA Project: " . bvwaExternalLinkUrlGet( 'http://dvwa.co.uk/' ) . "</li>
		<li>UTC Sheffield: " . bvwaExternalLinkUrlGet( 'http://utcsheffield.org.uk/' ) . "</li>
		<li>Sherlock Security: " . bvwaExternalLinkUrlGet( 'https://sherlock-security.com/' ) . "</li>
		<li>Tom's Home: " . bvwaExternalLinkUrlGet( 'https://toms-home.co.uk/' ) . "</li>
		<!--Add Github-->
	</ul>

	<h2>Credits</h2>
	<ul>
		<li>The Original DVWA Team: " . bvwaExternalLinkUrlGet( 'http://dvwa.co.uk/' ) . "</li>
		<li>Daniel Dixon (DigitalSherlock) - @SherlockSec: " . bvwaExternalLinkUrlGet( 'https://sherlock-security.com/' ) . "</li>
		<li>Thomas Fairey - @MyNameIsTommo: " . bvwaExternalLinkUrlGet( 'http://toms-home.com/' ) . "</li>
		<li>Matthew Taylor</li>
	</ul>
	<ul>
		<li>PHPIDS - Copyright (c) 2007 " . bvwaExternalLinkUrlGet( 'https://github.com/PHPIDS/PHPIDS', 'PHPIDS group' ) ."</li>
	</ul>

	<h2>License</h2>
	<p>As per DVWA's license:</p>
	<p>Damn Vulnerable Web Application (DVWA) is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.</p>
	<p>The PHPIDS library is included, in good faith, with this DVWA distribution. The operation of PHPIDS is provided without support from the DVWA team. It is licensed under <a href=\"" . DVWA_WEB_PAGE_TO_ROOT . "instructions.php?doc=PHPIDS-license\">separate terms</a> to the DVWA code.</p>

	<h2>Development</h2>
	<p>If you would like to contribute, we recommend contributing straight to the DVWA project.</p>
</div\n";


bvwaHtmlEcho( $page );

exit;

?>