<?php
/**
 * Packaged the DocTrine ORM
 *
 * @author Nemo.xiaolan
 * @created 2011-1-21 16:43:41
 */

class DatabaseBackend {

    /*
     * The Doctrine connections;
     */
    static public $connections = array();

    /*
     * Is this class initalized
     */
    static public $inited = false;

    /*
     * Data source name;
     */
    static public $dsn;

    /*
     * DatabaseBackend::$_generate_options array
     * The options for generate models
     */
    static public $_generate_options =
                       array('packagesPrefix'       =>  'Package',
                            'packagesPath'          =>  '',
                            'packagesFolderName'    =>  '',
                            'suffix'                =>  '.php',
                            'generateBaseClasses'   =>  true,
                            'generateTableClasses'  =>  true,
                            'generateAccessors'     =>  false,
                            'baseClassPrefix'       =>  'Base',
                            'baseClassesDirectory'  =>  'generated',
                            'baseClassName'         =>  'Doctrine_Record');
    
    /*
     * DatabaseBackend::init()
     *
     * @param $dsn string
     * @return void
     *
     * Initalize the database connection
     */
    static public function init($dsn = null, $init_connect = true) {
        
        BaseConfig::load(Package::get_file('etc/conf.d/database.yml'));
        
        self::$dsn = sprintf('%s://%s:%s@%s:%s/%s',
                ini('database/'.RUN_MODE.'/adapter'),
                ini('database/'.RUN_MODE.'/user'),
                ini('database/'.RUN_MODE.'/passwd'),
                ini('database/'.RUN_MODE.'/host'),
                ini('database/'.RUN_MODE.'/port'),
                ini('database/'.RUN_MODE.'/name')
            );

        if(self::$inited !== true) {
            import('system/vendors/Doctrine/Doctrine');
            spl_autoload_register(array('Doctrine', 'autoload'));
            self::$inited = true;
        }
        

        if($dsn) {
            self::$dsn = $dsn;
        }

        if($init_connect) {
            self::create_connection(null, self::$dsn, ini('database/'.RUN_MODE.'/charset'));
        }

        spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));

        
    }

    /*
     * DatabaseBackend::create_connection();
     * @param $name string
     * @param $dsn string
     * @param $charset string | default utf8
     * @return object | database connection object
     */
    static public function create_connection($name = null, $dsn = null, $charset = 'utf8') {

        if(self::$connections) {
            return self::$connections[0];
        }

        $dsn = $dsn ? $dsn : self::$dsn;

        $manager = Doctrine_Manager::getInstance();
        $conn = $manager->connection($dsn,
                sprintf('DoctrineConnection %d', count(self::$connections)));
        $conn->setCharset($charset);

        if(count(self::$connections) == 0) {
            self::$connections[] = $conn;
        } else {
            foreach(self::$connections as $k=>$v) {
                if($v !== $conn) {
                    self::$connections[] = $conn;
                }
            }
        }

        return $conn;
    }

    /*
     * DatabaseBackend::syncdb()
     *
     * @param $apps array
     * @return void
     *
     * Sync the schemas to database, and insert the fixture data.
     * <code>
     *  DatabaseBackend::syncdb();
     * </code>
     */
    static public function syncdb($apps = null, $drop_database = false, $append = true) {

        
        if(!self::$inited || !self::$connections) {
            self::init();
        }
        
        if(!$apps) {
            $apps = ini('base/INSTALLED_APPS');
        }

        if(!$apps) {
            return true;
        }

        if($drop_database) {
            Doctrine_Core::dropDatabases();
            Doctrine_Core::createDatabases();
        }

        foreach((array)$apps as $k=> $app) {
        	
        	$app = str_replace('.', '/', $app);

            try{
                /*
                 * Generate the models
                 */
                if(isset($_GET['use_yaml'])) {
                    $schemas = Package::get_file(sprintf('applications/%s/%s', $app,
                                                 'schemas.yml'));
                    if(!is_file($schemas)) {
                        continue;
                    }
                    Doctrine_Core::generateModelsFromYaml(
                        $schemas,
                        Package::get_folder(sprintf('applications/%s/models', $app)),
                        self::$_generate_options
                    );
                } else {
                    try {
                        import(sprintf('applications/%s/models/generated/*', $app));
                    } catch(DoesNotExistsException $e) {
                        continue;
                    }
                }

                /*
                 * syncdb
                 */
                Doctrine_Core::createTablesFromModels(
                    Package::get_folder(sprintf('applications/%s/models', $app)),
                    self::$_generate_options
                );

                /*
                 * Insert test data
                 */
                $dir = Package::get_folder(sprintf('applications/%s/fixtures', $app));
                if(is_dir($dir)) {
                    Doctrine_Core::loadData($dir, $append);
                }
                
            } catch (PDOException $e) {
                continue;
            }
        }
    }


    /*
     * DatabaseBackend::load_model()
     *
     * @param $app_name string
     * @param $model_name string
     * @return void
     *
     * Load the model file, just like: require()
     * <code>
     *  DatabaseBackend::load_model('auth');
     * </code>
     */
    static public function load_model($app_name, $model_name = null) {
        //Doctrine_Core::loadModels('applications/'.$appname.'/models');
        if($model_name) {
            import(sprintf('applications/%s/models/%s/%s', $app_name,
                    self::$_generate_options['baseClassesDirectory'],
                    'Base'.$model_name));
            import(sprintf('applications/%s/models/%s', $app_name, $model_name));
            import(sprintf('applications/%s/models/%s',
                    $app_name, $model_name.'Table'));
        } else {
            import(sprintf('applications/%s/models/%s/*', $app_name,
                    self::$_generate_options['baseClassesDirectory']));
            import(sprintf('applications/%s/models/*', $app_name));
        }

    }


}


?>