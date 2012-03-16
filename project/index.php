<?php
/**
 * Description of index
 *
 * @author Nemo.xiaolan
 * @created 2011-1-19 18:56:43
 */

$start_time = microtime(true);

//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(1);

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__));
define('FM_DIR', dirname(dirname(__FILE__)).DS.'base');

require FM_DIR.DS.'bin'.DS.'shortcuts.php';

import('system/boot');
Boot::poweron();


?>
