<?php

/** Start of configurable settings */

/**
 * If you're self-hosting slidesharehtml ...
 * 1) Modify HOSTED_DOMAIN to the FQDN of your server root
 * 2) Modify HOSTED_PATH to the relative path where you're hosting the slidesharehtml files
*/

define('HOSTED_DOMAIN', 'http://www.garygale.com');

define('HOSTED_PATH', 'slidesharehtml');

/**
 * If you're not self-hosting slidesharehtml then move on, there's nothing to see, this should
 * work "out of the box"
 */

define('SLIDESHAREHTML_URL', HOSTED_DOMAIN . DIRECTORY_SEPARATOR . HOSTED_PATH);

?>