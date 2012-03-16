<?php
/*
 * File: http.php
 * 
 * Encoding: UTF-8
 * Created on: Feb 19, 2011 9:34:40 PM
 *
 * @author: xiaolan
 *
 * License:
 *
 * 
 * 
 *
 * Description:
 *  Change this.
 *
 */

class HTTP {
    
    static public function E_404() {}

    static public function E_403($message = '') {
        header('HTTP/1.1 403 Forbidden');
        echo <<<EOF
        <html>
            <head>
                <title>403 Forbidden</title>
                <body>
                    <h1>HTTP 403 Forbidden</h1>
                    <p>{$message}</p>
                </body>
            </head>
        </html>
EOF;
    }

}

?>
