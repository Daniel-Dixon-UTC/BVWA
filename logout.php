<?php

define( 'BVWA_WEB_PAGE_TO_ROOT', '' );
require_once BVWA_WEB_PAGE_TO_ROOT . 'bvwa/includes/bvwaPage.inc.php';

bvwaPageStartup( array( 'phpids' ) );

if( !bvwaIsLoggedIn() ) { //User should not be on this page
	// bvwaMessagePush( "You were not logged in" );
	bvwaRedirect( 'login.php' );
}

bvwaLogout();
bvwaMessagePush( "!You have been logged out" );
bvwaRedirect( 'login.php' )

?>