<?php
$host = $_SERVER['HTTP_HOST'];
        
            $hostname = 'localhost';
            $database = 'maalgaadi_db';
            $username = 'maalgaadi_db';
            $password = 'maalgaadi_db';
       
class connect {

    private $host;
    private $connection;
    private $result;
    private $obj;
    private $con;
    private $arr;
	
    public function __construct() {
        $host = $_SERVER['HTTP_HOST'];

       /* $hostname = 'localhost';
        $database = 'maalgaad_maalgaadinew';
        $username = 'maalgaad_vipul';
        $password = 'newtest@123';*/

            $hostname = 'localhost';
            $database = 'maalgaadi_db';
            $username = 'maalgaadi_db';
            $password = 'maalgaadi_db';
        
        $this->connection = mysql_connect($hostname, $username, $password) or die("Error : ".mysql_error());
        $select_db = mysql_select_db($database, $this->connection);
        if (!$select_db) {
            die("Cannot access database: " . mysql_error());
        }
    }
	
	public function dbConnect() {

        $host = $_SERVER['HTTP_HOST'];

         $hostname = 'localhost';
         $database = 'maalgaadi_db';
         $username = 'maalgaadi_db';
         $password = 'maalgaadi_db';
            
        $connection = mysql_connect($hostname, $username, $password) or die("Error test : ".mysql_error());
        $select_db = mysql_select_db($database, $connection);
        if (!$select_db) { die("Cannot access database: " . mysql_error());  }
		return $connection;
    }
    public function connParameter() {
        return $this->connection;
    }

    public function execute($query) {
		$this->dbConnect();
        $this->result = mysql_query($query) or die(mysql_error()); mysql_close();
        return $this->result;
    }

    public function select($table) {
        $query = "select * from `$table`";
        return $this->execute($query);
    }

    public function selectSpecific($table, $column) {
        $query = "select $column from `$table`";
        return $this->execute($query);
    }

    public function selectWhere($table, $where) {
        $query = "select * from `$table` where $where";
		// echo $query."<br>";
        return $this->execute($query);
    }

    public function selectSpecificWhere($table, $where, $column) {
		$this->dbConnect();
        $query = "select $column from `$table` where $where";
        return $this->execute($query);
    }

    public function getcount($table, $where) {
		$this->dbConnect();
        $query = "select count(*) as `totalCount` from $table where $where";
        //echo $sql;
        $result = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        return $row['totalCount'];
    }

    public function insert($table, $data) {
        $tabIndex = array();
        $tabData = array();
        foreach ($data as $key => $value) {
            $tabIndex[$key] = $key;
            $tabData[$key] = mysql_real_escape_string($value);
        }
        $index = "`" . implode("`,`", $tabIndex) . "`";
        $data = "'" . implode("','", $tabData) . "'";
        $query = "insert into `$table` ($index) values ($data)";
        // echo $query."<br>";
        $result = $this->execute($query);
        return $this->rows_id();

        echo "record inserted success fully....";
    }

    public function update($table, $data, $where) {
        $tabIndex = array();

        foreach ($data as $key => $value) {

            $tabData[$key] = "`" . $key . "`='" . mysql_real_escape_string($value) . "'";
        }
        $data = implode(",", $tabData);

         $query = "update `$table` set  $data where $where"; 
        // echo $query."<br>";
        $result = $this->execute($query);
        return $result;
    }

    public function deleteRow($table, $where) {
        $query = "delete from `$table` where $where";
        $result = $this->execute($query);
        return $result;
    }

    public function fetch_object() {
		$this->dbConnect();
        return mysql_fetch_object($this->result);
    }

    public function fetch_row() {
		$this->dbConnect();
        return mysql_fetch_row($this->result);
    }

    public function fetch_array() {
		$this->dbConnect();
        return mysql_fetch_array($this->result);
    }

    public function fetch_assoc() {
		$this->dbConnect();
        return mysql_fetch_assoc($this->result);
    }

    public function result_free() {
		$this->dbConnect();
        return mysql_free_result($this->result);
    }

    public function total_rows() {
		$this->dbConnect();
        return mysql_num_rows($this->result);
    }

    public function affected_rows() {
		$this->dbConnect();
        return mysql_affected_rows();
    }

    public function rows_id() {
		$this->dbConnect();
        return mysql_insert_id();
    }

    public function lock($tablename) {
		$this->dbConnect();
        mysql_query("LOCK TABLES $tablename WRITE") or die(mysql_error());
    }

    public function unlock($tablename) {
		$this->dbConnect();
        mysql_query("UNLOCK TABLES");
    }

    public function insertImageApi($image, $filename, $folder) {
		$this->dbConnect();
        $sr = base64_decode($image);
        //echo "<br/>";
        $file_name = '';
        if ($sr != '') {
            /* file_put_contents($folder.$filename.'.png', $sr); */
            $file_name = $folder . $filename . '.png';
            imagepng(imagecreatefromstring($sr), $file_name);
        }
        return $file_name;
    }

    public function resizeImage($width = 120, $height = 120, $img_name, $image_source) {
        /* Get original file size */
        list($w, $h) = getimagesize($image_source);
        //echo "<img src='".$image_source."' />";
        /* Calculate new image size */
        $ratio = max($width / $w, $height / $h);
        $h = ceil($height / $ratio);
        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
        /* set new file name */
        $path = $img_name;
        /* Save image */
        $image = imagecreatefrompng($image_source);
        $tmp = imagecreatetruecolor($width, $height);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $image, 0, 0, 0, 0, $width, $height, $width, $height);
        imagepng($tmp, $path, 0);
        imagedestroy($image);
        imagedestroy($tmp);
    }

}

?>