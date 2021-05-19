<?php
error_reporting(0);

require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/User.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/Service.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/File.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/UserRole.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/Orders.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/Item.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/OrderStatus.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/TaskStatus.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/TaskType.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/Task.php");
require_once($_SERVER['DOCUMENT_ROOT']."/VLT-backend/database/entities/Review.php");

class DAO{
    
    protected $connection;
    private $host = "localhost";
    // private $database = "dovalnet_spu";

    // private $username = "dovalnet_spuuser";
    // private $password = "SPU2020$GH%^";

    private $database = "vlt-laundry";

    private $username = "root";
    private $password = "root";
    private $goldenKey = 'blueseaandsun';

    private $encryptedEntities = array( 
        'User'=>array('password')
        );

    function __construct(){
        if(strcmp("C:/xampp/htdocs", $_SERVER['DOCUMENT_ROOT']) == 0){
            $this->connection = mysqli_connect($this->host, "root", "", $this->database);
        }else if(strcmp("/Applications/MAMP/htdocs", $_SERVER['DOCUMENT_ROOT']) == 0){
            $this->connection = mysqli_connect($this->host, "root", "root", $this->database, 3306, "/Applications/MAMP/tmp/mysql/mysql.sock");
        }else{
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        }
        $this->connection->set_charset('utf8');
        // var_dump($this->connection);
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
    
    public function next($entityName, $idName){
        $count = 0;
        $sql = "SELECT COUNT(`$idName`) FROM `$entityName`";
        $result = mysqli_query($this->connection, $sql);
        if($result){
            $row = mysqli_fetch_assoc($result);
            $count = $row["COUNT(`$idName`)"] + 1;
        }
        $result->free_result();
        return $count;
    }
    
    public function add($entity, $test = 0){
        
        $array = json_decode(json_encode($entity), true);
        $className = get_class($entity);
        $sql = "INSERT INTO `$className` ";
        $columns = "(";
        $values = "(";
        $mainId = lcfirst($className."Id");
       
        if($className == "inClass")
        {
            $mainId="classId";
        }
        
        $encryptedColumns = array();
        if( in_array($className, array_keys($this->encryptedEntities)) )
        {
            $encryptedEntities = $this->encryptedEntities;
            $encryptedColumns = $encryptedEntities[$className];
        } 

        foreach($array as $propertyName => $propertyValue){
            if(strcmp($mainId, $propertyName) != 0){
                if( !is_null($propertyValue) )
                {
                    $columns .= "`$propertyName`,";
                    if( in_array($propertyName, $encryptedColumns) )
                    {
                        $values  .= "AES_ENCRYPT(\"$propertyValue\", UNHEX(SHA2('$this->goldenKey',512))),";
                    }
                    else
                    {
                        $values  .= (is_int($propertyValue) ) ? "$propertyValue," : "\"$propertyValue\",";
                    }
                }
            }  
        }
        $columns = substr($columns, 0, strlen($columns)-1) . ")";
        $values = substr($values, 0, strlen($values)-1) . ")";
        $sql .= $columns . " VALUES " . $values . ";";

        if($test == 1){
            return $sql;
        }

        $this->connection->query($sql);
        
        $sql = "SELECT `$mainId` FROM `$className` ORDER BY `$mainId` DESC LIMIT 1;";
        $result = mysqli_query($this->connection, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row[$mainId];
        $result->free_result();
        return $id;
    }
    
    public function replace($entityName, $column, $oldValue, $newValue)
    {       
        $sql = "UPDATE ".$entityName." SET ".$column."= REPLACE(".$column.", '".$oldValue."', '".$newValue."');";
        $this->connection->query($sql);
    }
    
    public function get($entityName, $value, $column, $test = 1) {

        $encryptedColumns = array();
        $entityNameString = $entityName;
        if( in_array($entityName, array_keys($this->encryptedEntities)) )
        {
            $encryptedEntities = $this->encryptedEntities;
            $encryptedColumns = $encryptedEntities[$entityName];
            //This entity has encrypted columns which I need to get
            $anEntity = new $entityName();
            $array = json_decode(json_encode($anEntity), true);
            $sql = '';
            foreach($array as $aField => $aValue)
            {
                if( in_array($aField, $encryptedColumns) )
                {   //This column has to be decrptypted has encrypted columns which I need to get
                     $sql .= ",AES_DECRYPT(`$aField`, UNHEX(SHA2('$this->goldenKey',512)))";
                }
                else
                {
                    $sql .= ",".$aField;
                }
            }
            //remove the first comma
            $sql = ltrim($sql, ',');
            $sql = "SELECT ".$sql." FROM `$entityName` WHERE ";
            if( in_array($column, $encryptedColumns)  )
            {
                $sql .= "AES_DECRYPT(`$column`, UNHEX(SHA2('$this->goldenKey',512))) = '$value'"; 
            }
            else
            {
                $sql .= "`$column`= '$value'";
            }
        }
        else
        {
            $sql = (is_int($value)) ? "SELECT * FROM `$entityName` WHERE `$column` = $value" : "SELECT * FROM `$entityName` WHERE `$column` = '$value'";
        }
        $result = mysqli_query($this->connection, $sql);
        if($result){
            $entityName = new $entityName();
            $array = json_decode(json_encode($entityName), true);
            $row = mysqli_fetch_assoc($result);
            foreach($array as $property => $value){
                $aColumn = ""; 
                if( in_array($property, $encryptedColumns) )
                {
                    $aColumn = "AES_DECRYPT(`".$property."`, UNHEX(SHA2('$this->goldenKey',512)))";
                }
                else
                {
                    $aColumn = $property;
                }
                if($entityNameString=='inClass' && $property =='classLabel')
                    $entityName->$property = stripslashes($row[$aColumn]);
                else
                    $entityName->$property = $row[$aColumn];
            }
        }
        return ($test == 1) ? $entityName : $sql;
    }
    
    public function getWhere($entityName, $where, $test = 1){
        $entityNameString = $entityName;
        $sql =  "SELECT * FROM `$entityName` $where";
        $result = mysqli_query($this->connection, $sql);
        if($result){
            $entityName = new $entityName();
            $array = json_decode(json_encode($entityName), true);
            $row = mysqli_fetch_assoc($result);
            foreach($array as $property => $value){
                if($entityNameString=='inClass' && $property =='classLabel')
                    $entityName->$property = stripslashes($row[$property]);
                else
                    $entityName->$property = $row[$property];
            }
        }
        return ($test == 1) ? $entityName : $sql;
    }

    public function listAll($entityName, $whereColumn = "", $whereValue="", $sort="", $sortColoumn="") {
        $entityNameString = $entityName;
        $entityName = $entityName;
        $sql = "SELECT * FROM `$entityName`";
        if(strlen($whereColumn) != 0 && strlen($whereValue) != 0){
            $sql .= " WHERE `$whereColumn` = ";
            $sql .= (is_int($whereValue)) ? $whereValue : "\"$whereValue\"";
        }
        
        if(strlen($sort) != 0){
            $sql .= " ORDER BY ".$sortColoumn." ".$sort;
        }
        
        $list = [];
        $result = $this->connection->query($sql);
        while($row = $result->fetch_assoc()) {
            $entityName = new $entityName();
            $array = json_decode(json_encode($entityName), true);
            foreach($array as $property => $value){
                if($entityNameString=='inClass' && $property =='classLabel')
                    $entityName->$property = stripslashes($row[$property]);
                else
                    $entityName->$property = $row[$property];
            }
            array_push($list, $entityName);
        }
        $result->free_result();
        return $list;
    }

    public function search($entityName, $whereColumn = "", $whereValue="", $test = 0) {
        $entityName = $entityName;

        $encryptedColumns = array();

        if( in_array($entityName, array_keys($this->encryptedEntities)) )
        {
            $encryptedEntities = $this->encryptedEntities;
            $encryptedColumns = $encryptedEntities[$entityName];
            //This entity has encrypted columns which I need to get
            $anEntity = new $entityName();
            $array = json_decode(json_encode($anEntity), true);
            $sql = '';
            foreach($array as $aField => $aValue)
            {
                if( in_array($aField, $encryptedColumns) )
                {   //This column has to be decrptypted has encrypted columns which I need to get
                     $sql .= ",AES_DECRYPT(`$aField`, UNHEX(SHA2('$this->goldenKey',512)))";
                }
                else
                {
                    $sql .= ",".$aField;
                }
            }
            //remove the first comma
            $sql = ltrim($sql, ',');
            $sql = "SELECT ".$sql." FROM `$entityName` WHERE ";
            if( in_array($whereColumn, $encryptedColumns)  )
            {
                $sql .= "AES_DECRYPT(`$whereColumn`, UNHEX(SHA2('$this->goldenKey',512))) LIKE \"%$whereValue%\" "; 
            }
            else
            {
                $sql .= "`$whereColumn` LIKE ";
                $sql .= (is_int($whereValue)) ? $whereValue : "\"%$whereValue%\"";
            }
        }
        else
        {
            $sql = "SELECT * FROM `$entityName`";
            if(strlen($whereColumn) != 0 && strlen($whereValue) != 0)
            {
                $sql .= " WHERE `$whereColumn` LIKE ";
                $sql .= (is_int($whereValue)) ? $whereValue : "\"%$whereValue%\"";
            }
        }
                
        if($test === 1){
            return $sql;
        }
        
        $list = [];
        $result = $this->connection->query($sql);
        while($row = $result->fetch_assoc()) {
            $entityName = new $entityName();
            $array = json_decode(json_encode($entityName), true);

            foreach($array as $property => $value){
                $aColumn = ""; 
                if( in_array($property, $encryptedColumns) )
                {
                    $aColumn = "AES_DECRYPT(`".$property."`, UNHEX(SHA2('$this->goldenKey',512)))";
                }
                else
                {
                    $aColumn = $property;
                }
                $entityName->$property = $row[$aColumn];
            }
            array_push($list, $entityName);
        }
        $result->free_result();
        return $list;
    }

    public function getDistinct($entityName, $columnName, $whereColumn = "", $whereValue="") {
        $entityName = $entityName;
        $sql = "SELECT DISTINCT `$columnName` FROM `$entityName`";
        
        if(strlen($whereColumn) != 0 && strlen($whereValue) != 0){
            $sql .= " WHERE `$whereColumn` = ";
            $sql .= (is_int($whereValue)) ? $whereValue : "\"$whereValue\"";
        }
        $list = [];
        $result = $this->connection->query($sql);
        
        $numberOfDistinct = mysqli_num_rows($result);
        $result->free_result();
        return $numberOfDistinct;
    }
    

    public function listAllWhere($entityName, $where, $test = 0){
        $entityName = $entityName;
        $entityNameString = $entityName;
        $encryptedColumns = array();
        if( in_array($entityName, array_keys($this->encryptedEntities)) )
        {
            $encryptedEntities = $this->encryptedEntities;
            $encryptedColumns = $encryptedEntities[$entityName];
            //This entity has encrypted columns which I need to get
            $anEntity = new $entityName();
            $array = json_decode(json_encode($anEntity), true);
            $sql = '';
            foreach($array as $aField => $aValue)
            {
                if( in_array($aField, $encryptedColumns) )
                {   //This column has to be decrptypted has encrypted columns which I need to get
                     $sql .= ",AES_DECRYPT(`$aField`, UNHEX(SHA2('$this->goldenKey',512)))";
                }
                else
                {
                    $sql .= ",".$aField;
                }
            }
            //remove the first comma
            $sql = ltrim($sql, ',');
            $sql = "SELECT ".$sql." FROM `$entityName` ". " $where";
        }
        else
        {
            $sql = "SELECT * FROM `$entityName`". " $where";
        }
        
        if($test === 1){
            return $sql;
        }
        
        $list = [];
        $result = $this->connection->query($sql);
        if($result){
            while($row = $result->fetch_assoc()) {
                $entityName = new $entityName();
                $array = json_decode(json_encode($entityName), true);
                foreach($array as $property => $value){
                    $aColumn = ""; 
                    if( in_array($property, $encryptedColumns) )
                    {
                        $aColumn = "AES_DECRYPT(`".$property."`, UNHEX(SHA2('$this->goldenKey',512)))";
                    }
                    else
                    {
                        $aColumn = $property;
                    }
                    if($entityNameString=='inClass' && $property =='classLabel')
                        $entityName->$property = stripslashes($row[$aColumn]);
                    else
                        $entityName->$property = $row[$aColumn];
                }
                array_push($list, $entityName);
            }
        $result->free_result();
        }
        return $list;
    }

    public function update($entity) {
        $encryptedColumns = array();
        
        if( in_array(get_class($entity), array_keys($this->encryptedEntities)) )
        {
            $encryptedEntities = $this->encryptedEntities;
            $encryptedColumns = $encryptedEntities[get_class($entity)];
        }

        $sql = "UPDATE `". get_class($entity)."` SET ";
        $array = json_decode(json_encode($entity), true);
        foreach($array as $propertyName => $propertyValue){
            if(!is_null($propertyValue))
            {
                if( in_array($propertyName, $encryptedColumns) )
                {
                    $sql .= "`$propertyName`=AES_ENCRYPT('".addslashes($propertyValue)."', UNHEX(SHA2('$this->goldenKey',512))), ";
                }
                else
                {
                    $sql .= (is_int($propertyValue)) ? "`$propertyName`='".addslashes($propertyValue)."', " :"`$propertyName`='".addslashes($propertyValue)."', ";
                }
            }
        }
        $sql = substr($sql, 0, strlen($sql)-2);
        reset($array);
        $sql .= " WHERE ".key($array)." = '".reset($array)."';";
        return $this->connection->query($sql);
    }
    
    public final function delete($entityName, $whereColumn = "", $whereValue=""){
        $sql = (is_int($whereValue))? "DELETE FROM `".$entityName."` WHERE `".$whereColumn."` = \"".$whereValue."\";" :"DELETE FROM `".$entityName."` WHERE `".$whereColumn."` = ".$whereValue.";";
        $this->connection->query($sql);
    }
    
    public final function deleteWhere($entityName, $where){
        $sql = 'DELETE FROM `'.$entityName.'` '.$where.';';
        $this->connection->query($sql);
    }
    
    public final function close(){
        $this->connection->close();
    }
}