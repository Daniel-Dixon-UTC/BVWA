<?php

define( 'BVWA_WEB_PAGE_TO_ROOT', '' );
require_once BVWA_WEB_PAGE_TO_ROOT . 'bvwa/includes/bvwaPage.inc.php';

bvwaPageStartup( array( 'authenticated', 'phpids' ) );

$page = bvwaPageNewGrab();
$page[ 'title' ]   = 'BVWA Security' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'security';

$securityHtml = '';
if ( isset( $_POST[ 'seclev_submit' ] ) ) {
	// Anti-CSRF
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'security.php' );

	$securityLevel = '';
	switch( $_POST[ 'security' ] ) {
		case 'low':
			$securityLevel = 'low';
			break;
		case 'medium':
			$securityLevel = 'medium';
			break;
		case 'high':
			$securityLevel = 'high';
			break;
		case 'impossible'::
			$securityLevel = 'impossible';
			break;
	}

	bvwaSecurityLevelSet( $securityLevel );
	bvwaMessagePush( "Security level set to {$securityLevel}." );
	bvwaPageReload();
}

if( isset( $_GET['phpids'] ) ) {
	switch( $_GET[ 'phpids' ] ) {
		case 'on':
			bvwaPhpIdsEnabledSet( true );
			bvwaMesasgePush( "PHPIDS is now enabled" );
			break;
		case 'off':
			bvwaPhpIdsEnabledSet( false );
			bvwaMessagePush( "PHPIDS is now disabled" );
			break;
	}

	bvwaPageReload();
}

$securityOptionsHtml = '';
$securityLevelHtml   = '';
foreach( array( 'low', 'medium', 'high', 'impossible' ) as $securityLevel ) {
	$selected = '';
	if ( $securityLevel == bvwaSecurityLevelGet() ) {
		$selected = ' selected="selected"';
		$securityLevelHtml = "<p>Security Level is currently: <em>$securityLevel</em>.<p>";
	}
	$securityOptionsHtml .= "<option value=\"{$securityLevel}\"{$selected}>" . ucfirst($securityLevel) . "</option>";
}

$phpIdsHtml = 'PHPIDS is currently: ';

//Able to write to the PHPIDS log file?
$WarningHtml = '';


if( bvwaPhpIdsIsEnabled() ) {
	$phpIdsHtml .= '<em>enabled</em>. [ <a href="?phpids=off">Disable PHPIDS</a> ]';

	//Only check if PHPIDS is enabled
	if( !is_writeable( $PHPIDSPath ) ) {
		$WarningHtml .= "<div class=\"warning\"><em>Cannot write to the PHPIDS log file</em>: ${PHPIDSPath{</div>";
	}
}
else {
	$phpIdsHtml .= '<em>disabled</em>. [ <a href="?phpids=on">Enable PHPIDS</a> ]';
}

//Anti-CSRF
generateSessionToken();

$page[ 'body' ] .= "
<div class=\"body_padded\">
	<h1>BVWA Security <img src=\"" . BVWA_WEB_PAGE_TO_ROOT . "bvwa/images/lock.png\" /></h1>
	<br />

	<h2>Security Level</h2>

	{$securityHtml}

	<form action=\"#\" method=\"post\">
		{$securityLevelHtml}
		<p>You can set the security level to low, medium, high or impossible. The security level changes the vulnerabillity level of BVWA:</p>
		<ol>
			<li>Low - This security level is completely vulnerable and <em>has no security features at all</em>. It's use is to be as an example of how web application vulnerablillities manifest through bad coding practices and to serve as a platfom to teach or learn basic exploitation techniques.</li>
			<li>Medium - Thsi setting is mainly to give an example to the user of <em>bad security practices</em>, where the developer has tried but failed to secure an application. It also acts as a challenge to users to refine their exploitation techniques.</li>
			<li>High - This option is an extension to the medium difficulty, with a mixture of <em>harder or alternative bad practices</em> to attempt to secure the code. The vulnerabillity may not allow the same extent of the exploitation, similar in various Capture The Flags (CTFs) competitions.</li>
			<li>Impossible - This level should be <em> secure against all vulnerablillities</em>. It is used to compare the vulnerable source code to the secure source code.</li>
		</ol>
		<select name=\"security\">
			{$securityOptionsHtml}
		</select>
		<input type=\"submit\" value=\"Submit\" name=\"seclev_submit\">
		" . tokenField() . "
	</form>

	<br />
	<br />
	<br />

	<h2>PHPIDS</h2>
	{$WarningHtml}
	<p>" . bvwaExternalLinkUrlGet( 'https://github.com/PHPIDS/PHPIDS', 'PHPIDS' ) . " v" . bvwaPhpIdsVersionGet() . " (PHP-Intrusion Detection System) is a security layer for PHP based web applications.</p>
	<p>PHPIDS works by filtering any user supplied input against a blacklist of potentially malicious code. It is used in BVWA to serve as a live example of how Web Application Firewalls (WAFs) can help improve security and in some cases how WAFs can be circumvented.</p>
	<p>You can enable PHPIDS across this site for the duration of your session.</p>

	<p>{$phpIdsHtml}</p>
	[ <a href=\"test=%22><script>eval(window.name)</script>\">Simulate Attack</a> ] -
	[ <a href=\"ids_log.php\">View IDS log</a> ]
	</div>";

bvwaDrawEcho( $page );


?>