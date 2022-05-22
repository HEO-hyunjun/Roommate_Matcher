<?php
 
class DbOperation
{
    //DB 연결 링크
    private $con;
 
    //Constructor 클래스
    function __construct()
    {
        //DbConnect.php 파일 참조
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //DB에 연결하는 DbConnect 객체 생성
        $db = new DbConnect();
 
        //connect 메소드를 호출해 연결 링크 초기화
        $this->con = $db->connect();
    }
     
    
	
    //profiles 테이블에 새로운 레코드를 생성하는 메소드
    function createProfile($KakaoID, $Name, $Grade, $Introduce, 
			   $Personality, $WakeupTime, $SleepTime, $Snoring, 
			   $Noise, $Hygiene, $Smoking, $Language){
	    
    	$stmt = $this->con->prepare("INSERT INTO profiles (KakaoID, Name, Grade, Introduce, 
							   Personality, WakeupTime, SleepTime, Snoring, 
							   Noise, Hygiene, Smoking, Language)
				    			   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    
 	$stmt->bind_param("ssisiiiiiiii", $KakaoID, $Name, $Grade, $Introduce, 
			  		  $Personality, $WakeupTime, $SleepTime, $Snoring, 
			  		  $Noise, $Hygiene, $Smoking, $Language);
 	if($stmt->execute())
 		return true; 
 	return false; 
    }
 
    
     
     
     //profiles 테이블에 존재하는 모든 레코드 출력하는 메소드
     function getProfiles(){
     	$stmt = $this->con->prepare("SELECT KakaoID, Name, Grade, Introduce, 
					    Personality, WakeupTime, SleepTime, Snoring, 
					    Noise, Hygiene, Smoking, Language FROM profiles");
 	$stmt->execute();
 	$stmt->bind_result($KakaoID, $Name, $Grade, $Introduce, 
			   $Personality, $WakeupTime, $SleepTime, $Snoring, 
			   $Noise, $Hygiene, $Smoking, $Language);
 
 	$profiles = array(); 
 
 	while($stmt->fetch()){
 		$profile  = array();
 		$profile['KakaoID'] = $KakaoID; 
 		$profile['Name'] = $Name; 
 		$profile['Grade'] = $Grade; 
 		$profile['Introduce'] = $Introduce; 
 		$profile['Personality'] = $Personality;
 		$profile['WakeupTime'] = $WakeupTime;
 		$profile['SleepTime'] = $SleepTime; 
 		$profile['Snoring'] = $Snoring;
 		$profile['Noise'] = $Noise;
 		$profile['Hygiene'] = $Hygiene;
 		$profile['Smoking'] = $Smoking;
 		$profile['Language'] = $Language; 

 		array_push($profiles, $profile); 
     }
 
     return $profiles; 
 }
 
 
 
 
 //메소드 호출 시 주어진 KakaoID에 해당하는 레코드를 새로운 입력값으로 변경
 function updateProfile($KakaoID, $Name, $Grade, $Introduce, 
			$Personality, $WakeupTime, $SleepTime, $Snoring, 
			$Noise, $Hygiene, $Smoking, $Language){
	 
 	$stmt = $this->con->prepare("UPDATE profiles SET Name = ?, Grade = ?, Introduce = ?, Personality = ?, 
							 WakeupTime = ?, SleepTime = ?, Snoring = ?, Noise = ?, 
							 Hygiene = ?, Smoking = ?, Language = ? WHERE KakaoID = ?");
	 
 	$stmt->bind_param("sisiiiiiiiis", $Name, $Grade, $Introduce, $Personality, 
			  		  $WakeupTime, $SleepTime, $Snoring, $Noise, 
			  		  $Hygiene, $Smoking, $Language, $KakaoID);
 	if($stmt->execute())
 		return true; 
 	return false; 
 }
 
 
 
 
  
 //주어진 KakaoID에 해당하는 레코드를 삭제하는 메소드
 function deleteProfile($KakaoID){
 	$stmt = $this->con->prepare("DELETE FROM profiles WHERE KakaoID = ? ");
 	$stmt->bind_param("s", $KakaoID);
 	if($stmt->execute())
 		return true; 
 
 	return false; 
 }	
}
