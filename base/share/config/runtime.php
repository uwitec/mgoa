<?php
/**
 * Description of runtime_config
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 15:15:24
 */

class RuntimeConfig extends BaseConfig {

    static public function __init__($run_mode) {
        self::$config['runtime'] =
                    YamlBackend::load('etc/environment.d/'.$run_mode.'.yml');
    }
}


?>
