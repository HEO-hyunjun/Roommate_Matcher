<?php
 
class DbOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }
 
    /*
    * The create operation
    * When this method is called a new record is created in the database
    */
    function createHero($name, $realname, $rating, $teamaffiliation){
        $stmt = $this->con->prepare("INSERT INTO heroes (name, realname, rating, teamaffiliation) VALUES (?, ?, ?, ?)"); //value ?로 처리후 나중에 바인딩(보안을 위해)
        $stmt->bind_param("ssis", $name, $realname, $rating, $teamaffiliation); //"ssis" -> 문자열, 문자열, 정수, 문자열
        if($stmt->execute()) //객체가 가진 쿼리문 실행
        return true; //성공시 true
        return false; //실패시 false
    }
    
    /*
    * The read operation
    * When this method is called it is returning all the existing record of the database
    */
    function getHeroes(){
        $stmt = $this->con->prepare("SELECT id, name, realname, rating, teamaffiliation FROM heroes");
        $stmt->execute();
        $stmt->bind_result($id, $name, $realname, $rating, $teamaffiliation);
        
        $heroes = array(); 
        
        while($stmt->fetch()){ //쿼리의 결과값 받아오기
            $hero  = array();
            $hero['id'] = $id; 
            $hero['name'] = $name; 
            $hero['realname'] = $realname; 
            $hero['rating'] = $rating; 
            $hero['teamaffiliation'] = $teamaffiliation; 
            
            array_push($heroes, $hero); 
        }
        
        return $heroes; 
    }
    
    /*
    * The update operation
    * When this method is called the record with the given id is updated with the new given values
    */
    function updateHero($id, $name, $realname, $rating, $teamaffiliation){
        $stmt = $this->con->prepare("UPDATE heroes SET name = ?, realname = ?, rating = ?, teamaffiliation = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $name, $realname, $rating, $teamaffiliation, $id);
        if($stmt->execute())
        return true; 
        return false; 
    }
    
    
    /*
    * The delete operation
    * When this method is called record is deleted for the given id 
    */
    function deleteHero($id){
        $stmt = $this->con->prepare("DELETE FROM heroes WHERE id = ? ");
        $stmt->bind_param("i", $id);
        if($stmt->execute())
        return true; 
        
        return false; 
    }
}
?>