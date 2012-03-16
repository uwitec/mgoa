<?php
/**
 * Description of forms
 *
 * @author Nemo.xiaolan
 * @created 2011-1-30 11:03:41
 */

class BaseForm {

    /*
     * @variable boolean $is_bound
     * is the form bound or not
     */
    public $is_bound = false;

    /*
     * @variable boolean $is_valid
     * is the form valid or not
     */
    public $is_valid = null;

    /*
     * @variable boolean $is_cleaned
     * is the form data cleaned or not
     */
    public $is_cleaned = false;

    /*
     * @variable array $messages
     * the error message
     */
    public $messages = array();

    /*
     * @variable array $fields
     * the form fields
     */
    protected $fields = array();

    /*
     * @variable array $data
     * form bound data
     */
    protected $data   = array();
    
    
    /*
     * BaseForm::__construct()
     * @param string $form
     * @param string $application
     * @param array  $data
     * @return void
     */
    public function __construct($form, $application, array $data = null) {
        $application = $application ? $application : ini('runtime/application');
        $this->fields = YamlBackend::load(sprintf('applications/%s/forms/%s.yml',
                                            $application, $form));

        if($data) {
            $this->data = $data;
            $this->is_bound = true;
        }

        $this->clean();
    }
    
    /*
     * BaseForm::output()
     * @return array Fields HTML
     *
     * return the fields html
     */
    public function output() {
        import('system/share/web/forms/fields');
        $fields_html = array();
        foreach($this->fields as $field_name=>$property) {
            $fields_html['content'][$field_name]
                        = BaseFields::get($field_name, $property, $this->data);
            $label = $this->fields[$field_name]['label']
                    ? $this->fields[$field_name]['label']
                    : $field_name;
            $fields_html['label'][$field_name] = _($label);
        }
        $fields_html['fields']  = $this->fields;

        if($this->is_bound) {
            $fields_html['messages']= $this->messages;
            $fields_html['data']    = $this->data;
        }
        
        return $fields_html;
    }

    /*
     * BaseForm::clean()
     * @return array
     */
    public function clean() {
        if(!$this->is_bound || !$this->data) {
            return array();
        }
        foreach($this->data as $key=>$value) {
            if($this->fields[$key]['rule'] != 'editor' && !is_array($value)) {
                $this->data[$key] = trim(htmlspecialchars($this->data[$key]));
            }
        }
        $this->is_cleaned = true;
        return $this->data;
    }

    /*
     * BaseForm::cleaned()
     * @return array
     *
     * return the form cleaned data
     */
    public function cleaned() {
        if($this->is_cleaned) {
            return $this->data;
        } else {
            return $this->clean();
        }
    }

    /*
     * BaseForm::is_valid()
     * @return boolean
     *
     * is the form validationed or not
     */
    public function is_valid() {
        if($this->is_valid === null) {
            return $this->validation($this->data);
        } else {
            return $this->is_valid;
        }
    }

    

    /*
     * BaseForm::validation()
     * @param array $data
     * @return boolean
     *
     * Validate the form with Form.yml by Validation class
     */
    protected function validation() {
        import('system/share/security/validation');
        $validation_instance = new Validation();

        foreach($this->fields as $name=> $field) {
            if(!$validation_instance->check($name, $field, $this->data[$name])) {
                $this->is_valid = false;
            }
        }

        if($this->is_valid === null) {
            $this->is_valid = true;
        }

        $this->messages = $validation_instance->errors;

        return $this->is_valid;

    }

}

?>
