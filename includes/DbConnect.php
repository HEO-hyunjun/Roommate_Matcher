<?php 
 
class DbConnect
{
    //DB링크를 저장하는 변수
    private $con;
 
    //Constructor 클래스
    function __construct()
    {
 
    }
 
    //DB에 연결하는 메소드
    function connect()
    {
      
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', '');
        define('DB_NAME', 'roommating');
 
        //MySQL DB에 연결
        $this->con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
        //연결도중 오류가 발생하면 메세지 출력
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
 
        //연결링크 반환 
        return $this->con;
    } 
}
