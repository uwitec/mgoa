<?php
/**
 * Description of plugins
 *
 * @author Nemo.xiaolan
 * @created 2011-3-1 10:25:47
 */

class KindEditor {
    
    static public function create($application, $name, $property = null) {
        $upload_url = BaseUrlParser::get_url('editor/upload');
        $filemanager_url = BaseUrlParser::get_url('editor/filemanager');

        $allow_upload = $property['allow_upload'] ? 'true' : 'false';
        $allow_filemanager = $property['allow_filemanager'] ? 'true' : 'false';
        return <<<EOF
            <script type="text/javascript">
                KE.show({
                    id : '{$name}',
                    width: '{$property['width']}px',
                    height: '{$property['height']}px',
                    allowUpload: {$allow_upload},
                    imageUploadJson: '{$upload_url}',
                    allowFileManager: {$allow_filemanager},
                    fileManagerJson: '{$filemanager_url}',
                    urlType: 'domain',
                    afterCreate : function(id) {
                        KE.event.ctrl(document, 13, function() {
                            KE.util.setData(id);
                            $('#{$name}').parents('form').submit();
                        });
                        KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
                            KE.util.setData(id);
                            $('#{$name}').parents('form').submit();
                        });
                    }
                });
           </script>
EOF;
    }

}

?>
