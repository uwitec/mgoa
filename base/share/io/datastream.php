<?php
/**
 * Description of datastream
 *
 * @author Nemo.xiaolan
 * @created 2011-1-28 14:41:04
 */

class Datastream {

    /*
     * Datastream::$content_type
     *
     * All support content-type
     */
    static private $content_type = array(
        'xml' => 'text/xml',
        'html'=> 'text/html',
        
        'json'=> 'text/json',

        'css' => 'text/css',
        'js'  => 'text/javascript',

        'pdf' => '',
        'jpg' => 'image/jpeg',
    );

    /*
     * Datastream::get();
     *
     * @param $content_type string
     * @param $data mixed
     * @return mixed
     *
     * return some datastream with the defined content-type
     * <code>
     *  Datastream::output('json', $array);
     * </code>
     */
    static public function get($content_type, $data) {
        $func_name = 'get_'.$content_type;
        if(method_exists('Datastream', $func_name)) {
            return self::$func_name($data);
        } else {
            return $data;
        }
    }

    /*
     * Datastream::output()
     *
     * @param $content_type string
     * @param $data mixed
     * @return mixed
     *
     * output some datastream with the defined content-type
     * <code>
     *  Datastream::output('json', $array);
     * </code>
     *
     */
    static public function output($content_type, $data, $charset='utf-8') {
        header('ContentType:'.self::$content_type[$content_type].';charset='.$charset);
        return self::get($content_type, $data);
    }

    /*
     * Datastream::convert()
     *
     * @param $from string
     * @param $to string
     * @param $data mixed
     * @return mixed
     *
     * convert the $data from $from to $to
     *
     * <code>
     *  Datastream::convert('xml', 'array', $xml_string);
     * </code>
     *
     */
    static public function convert($from, $to, $data) {
        $func_name = sprintf('convert_%s_to_%s', $from, $to);
        if(method_exists('Datastream', $func_name)) {
            return self::$func_name($data);
        }

        return $data;
    }

    static private function get_json($data) {
        if(function_exists('json_encode')) {
            return json_encode($data);
        }

        $json = new Services_JSON();
        return $json->encode($data);
    }

    static private function convert_xml_to_array($data) {
        return true;
    }

}


?>
