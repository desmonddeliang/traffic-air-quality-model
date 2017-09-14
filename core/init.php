<?php 
	DEFINE(D_VERSION,"1.0.0 ALPHA");

	// Show warning if a PHP version below 5.4.0 is used
	if (version_compare(PHP_VERSION, '5.3.0') === -1) {
		echo 'This version of the program requires at least PHP 5.4.0'.PHP_EOL;
		echo 'You are currently running ' . PHP_VERSION . '. Please update your PHP version.'.PHP_EOL;
		return;
	}

	try {
		// main code here.
		session_start();

		if(!$_SESSION['startstep']){
			$_SESSION['startstep'] = 1;
		} else {
			$_SESSION['startstep'] = $_SESSION['startstep'] + 1;
		}




	} catch (Exception $ex) {
		echo "An unhandled exception has been thrown:" . PHP_EOL;
		echo $ex;
		exit(1);
	}
?>