<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";


$conn = new mysqli($servername, $username, $password, $dbname);


 $response = array();

 
 if(isset($_POST['KakaoID'])){
 

     $arr = [1,2,3,4,5,0];

     $inputKakaoID = $_POST['KakaoID'];
 }
       
    $stmt = $conn->prepare("SELECT P.KakaoId, P.Introduce, P.Profileimage, P.Name from chatroom_tbl R inner join profiles P on P.KakaoId = R.KakaoId2 where R.kakaoId1 = ?");
        $stmt->bind_param("i", $inputKakaoID);
        $result = $stmt->execute();
 

   if($result == TRUE){
         
         $response['error'] = false;
         $response['message'] = "Retrieval Successful!";
        
         $stmt->store_result();
         
         $stmt->bind_result($KakaoID, $Introduce, $Profileimage, $Name);    

    
         while ($stmt->fetch()) {
            $profile  = array();
            $profile['KakaoID'] = $KakaoID;
            $profile['Name'] = $Name;
            $profile['Introduce'] = $Introduce;
            $profile['Profileimage'] = $Profileimage;
            array_push($response, $profile);
       }
     } 
     else{
         
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }

  /*else{
    
      $response['error'] = true; */



 echo json_encode($response);
?>
