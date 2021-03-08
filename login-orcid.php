<?php namespace ProcessWire;

/**
 * Template file for LoginOrcid module
 *
 * Place this file in /site/templates/login-orcid.php and modify as needed
 *
 */

/** @var User $user */
/** @var Config $config */
/** @var Modules $modules */
/** @var Sanitizer $sanitizer */
/** @var LoginOrcid $loginOrcid */

$orcid = $modules->get('LoginOrcid');
if(!$orcid) throw new WireException('LoginOrcid module is not available');
	try {
		$orcid->execute();
	} catch(WireException $e) {
		if(wireClassName($e) != 'LoginOrcidException') throw $e;
	}



