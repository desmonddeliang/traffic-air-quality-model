<?php
/**
 * ---------------------------------------------------------
 * @author Desmond Liang <me@desliang.com>
 * @copyright Copyright (c) 2016, Desmond Liang
 * @version 1.0.0 Alpha
 * @link https://app.desliang.com
 * @license Open source software: free uses
 * ---------------------------------------------------------
 * This is the core functions of DeStagram
 * ---------------------------------------------------------
 */

/**
* ------------------------------------------------------
* this rwConfig class is used to r/w config files
* ------------------------------------------------------
*/
class rwConfig{
	public static function read($filename)
	{
		$config = include $filename;
		return $config;
	}
	public static function write($filename, array $config)
	{
		$config = var_export($config, true);
		file_put_contents($filename, "<?php return $config ;?>");
	}
}



/**
* ------------------------------------------------------
* this DB class groups all database actions together
* ------------------------------------------------------
*/
class DB{
	// Database Class for database read and write
	var $db_hostname;
	var $db_username;
	var $ds_passwd;
	var $db_dbname;

	/**
	* --------------------------------------------------
	* database initialization function
	* @param configuration array
	* --------------------------------------------------
	*/
	public function init($configs){
		$this->ds_hostname = $configs["dbhost"];
		$this->db_username = $configs["dbusername"];
		$this->ds_passwd = $configs["dbpassword"];
		$this->db_dbname = $configs["db_name"];
		$this->connect();
	}


	/**
	* --------------------------------------------------
	* database connect
	* --------------------------------------------------
	*/
	private function connect(){
		if(!mysql_connect($this->db_hostname,$this->db_username,$this->ds_passwd))
			die('oops connection problem ->'.mysql_error());
		if(!mysql_select_db($this->db_dbname))
			die('oops database selection problem ->'.mysql_error());
	}


	/**
	* --------------------------------------------------
	* database query
	* @param mysql query
	* @return array of the first row
	* --------------------------------------------------
	*/
	public function getRow($query){
		$result=mysql_query($query);
		return mysql_fetch_array($result, MYSQL_ASSOC);
	}



	/**
	* --------------------------------------------------
	* database initialization
	* @param N/A
	* @return N/A
	* --------------------------------------------------
	*/
	public function initDB(){
		$sql="SELECT * FROM data WHERE id=1";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		if($count==0){
			//If data table is empty, initialize installation
			echo "<center>";
			echo "<br>Welcome! <br>Installing Destagram......<br>";	
			//Create table for posts
			$sql = "CREATE TABLE $this->db_dbname.`data` ( `id` INT NOT NULL AUTO_INCREMENT , 
					`type` VARCHAR(30), `caption` VARCHAR(50), 
					`date` VARCHAR(30) NOT NULL, `url` VARCHAR(100),
					`description` VARCHAR(1000),
					PRIMARY KEY(id));";
			$result=mysql_query($sql);
			if(!$result){
				echo "Something went wrong when creating the table for destagram! <br>";
			} else {
				echo "Table for DeStagram created! <br>";	
			}

			//Create admin
			$time = time();
			$sql = "INSERT into `data` (type, caption, date, description) 
			VALUES ('admin', 'desmond' ,'$time', 'e10adc3949ba59abbe56e057f20f883e')";
			$result=mysql_query($sql);
			if(!$result){
				echo "Something went wrong when creating the admin user! <br>";
			} else {
				echo "Administrator: desmond created! Default password: 123456<br>";	
			}

			echo "Refresh to finish Destagram installation!";
			echo "</center>";
			exit();
		}
	}

}

?>