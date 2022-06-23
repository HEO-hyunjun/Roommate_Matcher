<?php
 
class DbOperation
{
    
    private $con;
 
    
    function __construct()
    {
        
        require_once dirname(__FILE__) . '/DbConnect.php';
        
        $db = new DbConnect(); 
        
        $this->con = $db->connect();
    }
 


 

 

 //profiles 데이터베이스 전체 읽기
  function geteveryProfiles(){
    $stmt = $this->con->prepare("SELECT KakaoID, Name, Grade, Gender, Dormitory, Introduce, Personality, WakeupTime, SleepTime, Snoring, Noise, Hygiene, Smoking FROM profiles ");
 	$stmt->execute();
 	$stmt->bind_result($KakaoID, $Name, $Gender, $Dormitory, $Grade, $Introduce, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking);
 
 	$profiles = array(); 
 
 	while($stmt->fetch()){
 		$profile  = array();
		$profile['Name'] = $KakaoID; 
 		$profile['Name'] = $Name; 
 		$profile['Grade'] = $Grade; 
		$profile['Name'] = $Gender; 
		$profile['Name'] = $Dormitory; 
 		$profile['Introduce'] = $Introduce; 
 		$profile['Personality'] = $Personality;
 		$profile['WakeupTime'] = $WakeupTime;
 		$profile['SleepTime'] = $SleepTime; 
 		$profile['Snoring'] = $Snoring;
 		$profile['Noise'] = $Noise;
 		$profile['Hygiene'] = $Hygiene;
 		$profile['Smoking'] = $Smoking;

 		array_push($profiles, $profile); 
     }
 
     return $profiles; 
 }



  //한명의 프로필을 볼 때 작동
  function getProfiles($KakaoID){
    $stmt = $this->con->prepare("SELECT Name, Grade, Introduce, Personality, WakeupTime, SleepTime, Snoring, Noise, Hygiene, Smoking FROM profiles WHERE KakaoID = ?");
	$stmt->bind_param("i", $KakaoID);
 	$stmt->execute();
 	$stmt->bind_result($Name, $Grade, $Introduce, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking);
 
 	$profiles = array(); 
 
 	while($stmt->fetch()){
 		$profile  = array();
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

 		array_push($profiles, $profile); 
     }
 
     return $profiles; 
 }

 // UI#8 자신의 프로필에서 학년, 기숙사 자기소개등 변경
function writeProfile($KakaoID, $Name, $Grade, $Gender, $Dormitory, $Introduce, $Profileimage){
	$stmt = $this->con->prepare("UPDATE profiles SET  Name = ?, Grade = ?, Gender = ?, Dormitory = ?, Introduce = ?, Profileimage = ?WHERE KakaoID = ?");
	$stmt->bind_param("siIssiii", $Name, $Grade, $Gender, $Dormitory, $Introduce, $Profileimage, $KakaoID);
	if($stmt->execute())
	return true;
	return false;
}

//UI#11 나의 프로필 작성
function pickProfile($KakaoID, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking){
	$stmt = $this->con->prepare("UPDATE profiles SET Personality = ?, WakeupTime = ?, SleepTime = ?, Snoring = ?,Noise = ?, Hygiene = ?, Smoking = ?, WHERE KakaoID = ?");
	$stmt->bind_param("iiiiiiiii", $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking, $KakaoID);
	if($stmt->execute())
	return true;
	return false;


}
//정렬기능
function sort($KakaoID, $Gender, $Dormitory){
    $stmt = $this->con->prepare("SELECT bot.Name, bot.Grade, bot.Introduce, bot.Profileimage, bot.Personality, bot.WakeupTime, bot.SleepTime, bot.Snoring, bot.Noise, bot.Hygiene, bot.Smoking,
	((2*pow((top.Personality-bot.Personality),2))+
	(2*pow((top.WakeupTime-bot.WakeupTime),2))+
	(2*pow((top.SleepTime-bot.SleepTime),2))+
	(2*pow((top.Snoring-bot.Snoring),2))+
	(2*pow((top.Noise-bot.Noise),2))+
	(2*pow((top.Hygiene-bot.Hygiene),2))+
	(2*pow((top.Smoking-bot.Smoking),2))) as weighted
	FROM profiles top, profiles bot WHERE top.KakaoID = ? and top.KakaoID != bot.KakaoID and bot.Gender = ? and bot.Dormitory = ? order by weighted");
	$stmt->bind_param("iis", $KakaoID, $Gender, $Dormitory);
	$stmt->execute();
 	$stmt->bind_result($Name, $Grade, $Introduce, $Profileimage, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking, $weighted);

 	$result = array();

 	while($stmt->fetch()){
 		$profile  = array();
 		$profile['Name'] = $Name;
 		$profile['Grade'] = $Grade;
 		$profile['Introduce'] = $Introduce;
		$profile['Profileimage'] = $Profileimage;
 		$profile['Personality'] = $Personality;
 		$profile['WakeupTime'] = $WakeupTime;
 		$profile['SleepTime'] = $SleepTime;
 		$profile['Snoring'] = $Snoring;
 		$profile['Noise'] = $Noise;
 		$profile['Hygiene'] = $Hygiene;
 		$profile['Smoking'] = $Smoking;
		$profile['weighted'] = $weighted;

 		array_push($result, $profile);
     }

     return $result;
 }

 function deleteProfile($KakaoID){
 	$stmt = $this->con->prepare("DELETE FROM profiles WHERE KakaoID = ? ");
 	$stmt->bind_param("s", $KakaoID);
 	if($stmt->execute())
 		return true; 
 
 	return false;
 }

function filterp($KakaoID, $Gender, $Dormitory, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking) {
		
		$sql = "SELECT bot.Name, bot.Grade, bot.Introduce, bot.Profileimage, bot.Personality, bot.WakeupTime, bot.SleepTime, bot.Snoring, bot.Noise, bot.Hygiene, bot.Smoking,
		((2*pow((top.Personality-bot.Personality),2))+ 
		(2*pow((top.WakeupTime-bot.WakeupTime),2))+ 
		(2*pow((top.SleepTime-bot.SleepTime),2))+
		(2*pow((top.Snoring-bot.Snoring),2))+ 
		(2*pow((top.Noise-bot.Noise),2))+
		(2*pow((top.Hygiene-bot.Hygiene),2))+ 
		(2*pow((top.Smoking-bot.Smoking),2))) as weighted
		FROM profiles top, profiles bot WHERE top.KakaoID = ? and top.KakaoID != bot.KakaoID and bot.Gender = ? and bot.Dormitory = ? and bot.Personality regexp CONCAT('[',?,']') and 
		bot.WakeupTime regexp CONCAT('[',?,']') and bot.SleepTime regexp CONCAT('[',?,']') and bot.Snoring regexp CONCAT('[',?,']') and bot.Noise regexp CONCAT('[',?,']') and 
		bot.Hygiene regexp CONCAT('[',?,']') and bot.Smoking regexp CONCAT('[',?,']') order by weighted";
		$stmt = $this->con->prepare($sql);
		$stmt->bind_param("iisiiiiiii",$KakaoID, $Gender, $Dormitory, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking);
		$stmt->execute();
		$stmt->bind_result($Name, $Grade, $Introduce, $Profileimage, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking, $weighted);

		$result = array(); 
 
		while($stmt->fetch()){
			$profile  = array();
			$profile['Name'] = $Name; 
			$profile['Grade'] = $Grade;
			$profile['Introduce'] = $Introduce; 
			$profile['Profileimage'] = $Profileimage;
			$profile['Personality'] = $Personality;
			$profile['WakeupTime'] = $WakeupTime;
			$profile['SleepTime'] = $SleepTime; 
			$profile['Snoring'] = $Snoring;
			$profile['Noise'] = $Noise;
			$profile['Hygiene'] = $Hygiene;
			$profile['Smoking'] = $Smoking;
		   $profile['weighted'] = $weighted;  
   
			array_push($result, $profile); 
		}
	
		return $result; 

	
		}


}
