<?php
/**
 * Description of BaseException
 *
 * @author Nemo.xiaolan
 * @created 2011-1-20 14:30:09
 */

class BaseException extends Exception {

    public $exception_messages = array();

    public $code;
    
    public $message;

    public $file;

    public $line;


    public function __construct($code='', $message='', $previous='') {

        BaseConfig::load(Package::get_file('system/config/exception.yml'));

        $this->exception_messages = ini('exception/messages');

        if($this->exception_messages[$code]) {
            $message = '('.$code.') '.
                            sprintf(_($this->exception_messages[$code]), $message);
        }


        $this->message = $message;
        $this->code = $code;

    }

    static public function handler(Exception $exception) {
        $message = $exception->getMessage();
        if(RUN_MODE == 'deploy') {
            exit(0);
        } else if(RUN_MODE == 'devel') {
            
            echo $message;
            if(ini('runtime/xdebug/enable')) {
                return;
            } else {
                echo <<<EOF
                    <table>
                        <tr>
                            <td>{$message}</td>
                        </tr>
                    </table>
EOF;
                exit(0);
            }
        }
    }

}

?>
