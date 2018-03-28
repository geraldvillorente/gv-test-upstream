<?php
/**
 * A dirty workaround to copy simplesaml config to simplesaml vendor directory.
 */
copy('config.php', $_ENV['DOCROOT']/vendor/simplesamlphp/simplesamlphp/config/config.php');
