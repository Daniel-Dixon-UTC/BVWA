<?php

define( 'BVWA_WEB_PAGE_TO_ROOT', '' );
require_once BVWA_WEB_PAGE_TO_ROOT . 'bvwa/includes/bvwaPage.inc.php';

define( 'BVWA_WEB_ROOT_TO_PHPIDS_LOG', 'external/phpids/' . bvwaPhpIdsVersionGet() . 'lib/IDS/tmp/phpids_log.txt' );
define( 'BVWA_WEB_PAGE_TO_PHPIDS_LOG', BVWA_WEB_PAGE_TO_ROOT.BVWA_WEB_ROOT_TO_PHPIDS_LOG );

bvwaPageStartup( array( 'authenticated', 'phpids' ) );

$page = bvwaPageNewGrab();
$page[ 'title' ]   = 'PHPIDS Log' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'log';

$page[ 'body' ] .= "

<div class=\"body_padded\">
	<h1>PHPIDS Log</h1>

	<p>" . bvwaReadIdsLog() . "</p>
	<br /><br />

	<form action=\"#\" method=\"GET\">
		<input type\"submit\" value=\"Clear Log\" name=\"clear_log\">
	</form>

	" . bvwaClearIdsLog() . "
</div>";

bvwaHtmlEcho( $page );

?>