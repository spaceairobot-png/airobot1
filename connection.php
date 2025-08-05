<?php
class DBConnection {
    private $_url = null;
    private $_userName = null;
    private $_password = null;
    private $_databaseName = null;
    private $_singletonInstaneDB = null;
    
    function __construct($url, $userName, $password, $databaseName){
        $this->_url = $url;
        $this->_userName = $userName;
        $this->_password = $password;
        $this->_databaseName = $databaseName;
    }

    function getConnectDB(){
        if($this->_singletonInstaneDB == null){
            $this->_singletonInstaneDB = mysqli_connect($this->_url, $this->_userName, $this->_password);
            mysqli_select_db($this->_singletonInstaneDB, $this->_databaseName);     
        }
        return $this->_singletonInstaneDB;
    }
	
	 public function select($query, $paramType = "", $paramArray = array())
    {
        $stmt = $this->conn->prepare($query);

        if (! empty($paramType) && ! empty($paramArray)) {

            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }

        if (! empty($resultset)) {
            return $resultset;
        }
    }
}

try{

     $myConn = new DBConnection("localhost","root","", "airobot");

	//server
	//$myConn = new DBConnection("localhost","root","xx", $_SESSION["dbCompany"]);
	$conn = $myConn->getConnectDB();
	
	
	
}catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
?>