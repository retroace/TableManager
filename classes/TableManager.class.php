<?php 
/**
 * Table Manager class helps to manage table. You can view the schema of the table and 
 * other things. This plugin is useful for viewing data on your tables.
 */
class TableManager extends TableManagerConfig
{
	protected $tabs;
	protected $defaultTab;
	protected $slug = 'managetable';
    protected $db;	
    
    public function __construct()
	{
		add_action('admin_init', [&$this , 'setTabs']);
        add_action('admin_menu', [&$this , 'addMenu']);
        
        add_action("wp_ajax_get_table_details_table_manager",[&$this , 'getAjaxTableDetails']);
        add_action("wp_ajax_get_table_table_manager",[&$this , 'getAjaxTable']);
        add_action("wp_ajax_get_table_schema_table_manager",[&$this , 'getAjaxTableSchema']);
        add_action("wp_ajax_get_database_schema_table_manager",[&$this , 'getAjaxDatabaseSchema']);
        $this->db = new TableDb();
    }

    public function getTables()
    {
    	global $wpdb;
    	return $this->db->getTables();
        
    }

    // Function to run on plugin initialization
    public function pluginInit()
    {
		add_action('admin_enqueue_scripts', array(&$this, 'addStylesAndScripts'), 9);
		add_action('wp_head', array(&$this, 'pluginname_ajaxurl'));
    }

    public function addStylesAndScripts()
    {
        wp_register_style('file_bootstrap_css', TABLE_PLUGIN_PATH_URL.'css/style.min.css');
    	wp_enqueue_style('file_bootstrap_css');
    }


    function setTabs()
    {
        // $_GET[tab] => fileName
    	$this->tabs = [
    		'tables' => "tables",
            'exportsandimport' => "exportImport",
            'records' => "Records",
            'column' => "Column",
            'detail' => "Detail"
    	];

    	$this->defaultTab = 'tables';
    }

    
    public function addMenu()
    {
    	add_menu_page('Table Manager', "Table Manager", 'manage_options', $this->slug, [&$this, 'adminPage']);
        add_submenu_page( $this->slug, 'Detail!', 'Plugin Details', 'manage_options', $this->slug.'&tab=detail', array(&$this, 'adminPage') );
    }


    function includeTabContent()
    {
    	global $wpdb;
    	
    	$tab =  isset($_GET['tab']) ? $_GET['tab'] : $this->defaultTab;
        if ($tab != $this->defaultTab) {
            $tab = $this->tabs[$tab];
        }
    	if (file_exists(TABLE_PLUGIN_PATH. 'admin/tabs/'.$tab.'.php')) {
            require_once(TABLE_PLUGIN_PATH. 'admin/tabs/'.$tab.'.php');
        }else{
            require_once(require_once(TABLE_PLUGIN_PATH. 'admin/tabs/404.php'));
        }

    }

    public function pluginname_ajaxurl() 
	{
		echo '<script type="text/javascript">var ajaxurl = "'. admin_url("admin-ajax.php") .'";</script>';
	}


    function adminPage()
    {
		echo $this->includeTabContent();
    }

    function getAjaxTableDetails()
    {
        $table = $_POST['table'];
        $tableDescription = $this->db->getTableDesc($table);
        print_r($tableDescription);
        die();
    }

    function getAjaxTable()
    {
        $databaseName = $_POST['database'];
        $tableDescription = $this->db->getTables($databaseName);
        print_r(json_encode([$tableDescription,"database" => $databaseName]));
        die();
    }

    function getAjaxDatabaseSchema($dbName){
        $dbName = $_POST['database'];

        $result = $this->db->getDbSchema($dbName);
        // print_r($result);
        // die();
        $db = [];
        $tableArray = [];
        $dbArray = [];

        for ($i = 0; $i < count($result); $i++) {
            // Getting db name from schema
            if (!in_array($result[$i]['TABLE_SCHEMA'], $dbArray)) {
                array_push($dbArray,$result[$i]['TABLE_SCHEMA']);
                $db["dbName"] = $result[$i]['TABLE_SCHEMA'];
            }
            
            
            // Common variables in the array

            $tableName = $result[$i]['TABLE_NAME'];
            $columnName = $result[$i]['COLUMN_NAME'];
            $type  = $result[$i]['COLUMN_TYPE'];
            $name  = $result[$i]['COLUMN_NAME'];
            $nullable  = $result[$i]['IS_NULLABLE'];
            $comment  = $result[$i]['COLUMN_COMMENT'];
            $collationName = $result[$i]['COLLATION_NAME'];
            $key = $result[$i]['COLUMN_KEY'];
            $extra = $result[$i]['EXTRA'];
            
            if (!isset($db["table"][$tableName])) {
                $db["table"][$tableName] = [];
            }

            if (!in_array($tableName, $tableArray)) {
                array_push($db["table"][$tableName],[
                    "name" =>$result[$i]['TABLE_NAME'],
                    "column" =>[] 
                ]);
            }

            if (!isset($db["table"][$tableName])) {
            }
            
            if (!isset($db["table"][$tableName]["column"])) {
                $db["table"][$tableName]["column"] = [];   
            }

            $columns = [
                "name" => $columnName,
                "type" => $type,
                "nullable" => $nullable,
                "comment" => $comment,
                "collationName"=> $collationName,
                "extra"=> $extra,
                "key"=> $collationName
            ];

            array_push($db["table"][$tableName]['column'],$columns);
            
        }
        print_r(json_encode($db));
        die();


    }
}

