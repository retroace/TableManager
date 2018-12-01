<?php 
/**
 * TableDb is a personal database connection for tableManager which helps to get
 * the different contants and values of the table
 */
class TableDb extends TableManagerConfig
{
    /**
     * Establish connection on the class instanciation
     */
    public function __construct()
    {
    	if (!parent::$dbconn) {
			parent::$dbconn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD);   
    	}
    }

    public function getTableDesc($tableName,$database=null)
    {
    	if (empty($database)) {
    		$database = DB_NAME;
    	}

    	$db = parent::$dbconn->select_db($database);
    	$query = " DESCRIBE `".$tableName."`;";
    	$result = parent::$dbconn->query($query);
    	if (!$result) {
    		return parent::$dbconn->error;
    	}
    	
    	return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTables($database=null)
    {
    	if (empty($database)) {
    		$database = DB_NAME;
    	}
    	$db = parent::$dbconn->select_db($database);
    	$query = "SHOW TABLES;";
    	$result = parent::$dbconn->query($query);

    	if (!$result) {
    		return parent::$dbconn->error;
    	}
    	
    	return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch database schema from information_schema
    public function getDbSchema($dbName)
    {

    	$db = parent::$dbconn->select_db('information_schema');
    	$query = "SELECT * FROM `COLUMNS` WHERE TABLE_SCHEMA='".$dbName."';";
    	$result = parent::$dbconn->query($query);

    	if (!$result) {
    		print_r($query);
    		return parent::$dbconn->error;
    	}
    	
    	return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTableSchema($tableName, $dbName)
    {

        $db = parent::$dbconn->select_db('information_schema');
        $query = "SELECT * FROM `COLUMNS` WHERE TABLE_SCHEMA='".$dbName."' AND TABLE_NAME='.$tableName.';";
        $result = parent::$dbconn->query($query);

        if (!$result) {
            print_r($query);
            return parent::$dbconn->error;
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTableRows($tableName,$limit = 20)
    {

        $db = parent::$dbconn->select_db('information_schema');
        $query = "SELECT * FROM `".$tableName."` LIMIT ".$limit.";";
        $result = parent::$dbconn->query($query);

        if (!$result) {
            print_r($query);
            return parent::$dbconn->error;
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}