<?php 
/**
 * Table Exporter class helps to export thetable
 */
class TableExporter extends TableDb
{
    /**
     * 
     */
    public function __construct()
    {
        
    }

    public function exportToCsv(String $fileName, String $tableName)
    {
    	global $wpdb;

    	$query = "SELECT * FROM ".$tableName." WHERE 1 INTO OUTFILE '".$fileName."' FIELDS ENCLOSED BY '\"' TERMINATED BY ';' ESCAPED BY '\"' LINES TERMINATED BY '\n' ";

   		$queryResult = $wpdb->query($query);
   		if ($queryResult) {
   			return true;
   		}else{
   			return false;
   		}
    }

    public function exportTable(String $fileName, String $tableName)
    {
    	global $wpdb;

    	$query = "SELECT * INTO OUTFILE '".$backupFile."' FROM ".$tableName;

   		$queryResult = $wpdb->query($query);
   		if ($queryResult) {
   			return true;
   		}else{
   			return false;
   		}
    }

    public function importTable($filename,$tableName)
    {
    	global $wpdb;
    	$query = "LOAD DATA INFILE '".$filename."' INTO TABLE ".$tableName;
    	$queryResult = $wpdb->query($query);
    	if ($queryResult) {
    		
    	}
    }
}