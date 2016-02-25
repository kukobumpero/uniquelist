<?php
/**
 * uniquelist
 *
 * Date: 2/25/16
 * License: See LICENSE file @root_folder.
 */

/*
* Set error reporting to the correct level.
*/
error_reporting(E_ALL | E_STRICT);
if (class_exists('PHPUnit_Runner_Version', true)) {
    $phpUnitVersion = PHPUnit_Runner_Version::id();
    if ('@package_version@' !== $phpUnitVersion && version_compare($phpUnitVersion, '5.2.0', '<')) {
        echo 'This version of PHPUnit (' . PHPUnit_Runner_Version::id() . ') is not supported.'
            . 'Version supported is 5.2.0 or higher.' . PHP_EOL;
        exit(1);
    }
    unset($phpUnitVersion);
}
/**
 * Setup autoloading
 */
require __DIR__ . '/../vendor/autoload.php';