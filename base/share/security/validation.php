<?php
/**
 * Description of validation
 *
 * @author Nemo.xiaolan
 * @created 2011-2-13 10:50:14
 *
 * Validation the data use php function or regex
 */

class Validation {

    /*
     * @variable array $errors
     * The error message
     */
    public $errors = array();

    /*
     * @variable array $message
     * Defined message template
     */
    private $messages = array();

    private $supported = array(
        'rule', 'minlength', 'maxlength'
    );

    private $is_valid = true;

    public function __construct() {
        $this->messages = array(
            'rule'=> _('%s can not be valid'),
            'minlength'=> _("%s length must more than %s"),
            'maxlength'=> _("%s length must less than %s"),
        );
    }

    /*
     * Validation::check()
     * @param $name string | the field name
     * @param $type string | the type will be checked
     * @param $rule string
     * @param $data mixed
     * @return boolean
     *
     * <code>
     *  $validation->check('username', 'max_length', '255', 'John');
     * </code>
     */
    public function check($name, $field, $data) {
        foreach($field as $k=>$v) {
            if(!in_array($k, $this->supported) || !method_exists($this, $k)) {
                continue;
            }
            
            if(!$this->$k($v, $data)) {
                $label = $field['label'] ? $field['label'] : $name;
                $message = sprintf($this->messages[$k], _($label), $v);
                array_push($this->errors, $message);
                /*
                $this->errors[$name] = is_array($this->errors[$name])
                                        ? $this->errors[$name]
                                        : array();
                array_push($this->errors[$name], $message);
                 * 
                 */
                $this->is_valid = false;
            }
        }

        return $this->is_valid;
    }

    private function rule($type, $string) {
        if(in_array($type, array('string', 'int'))) {
            $func_name = 'is_'.$type;
            if(!function_exists($func_name)) {
                return true;
            }
            return $func_name($string);
        } else {
            return preg_match($type, $string) ? true : false;
        }
    }

    private function minlength($min, $string) {
        if(strlen($string) < $min) {
            return false;
        }
        return true;
    }

    private function maxlength($max, $string) {
        if(strlen($string) > $max) {
            return false;
        }
        return true;
    }

}


?>
