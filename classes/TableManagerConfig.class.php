<?php 

/**
 * Table Manager Config helps to manage table from the wordpress. Rather than 
 * overviewing or going to database you have full control over it.
 */
class TableManagerConfig
{
	protected static $tables;
	protected static $devMode;
    protected static $options;
    protected static $dbconn;
    
    /**
     * summary
     */
    
    public function __construct()
    {
    	global $wpdb;
        $tableDb = new TableDb();
    }

    public function getDatabases()
    {
        $result = self::$dbconn->query('SHOW DATABASES');
        return $result->fetch_all();
    }
}