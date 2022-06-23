<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";


$conn = new mysqli($servername, $username, $password, $dbname);


 $isAlready = 0;

    if(isset($_POST['KakaoID1'], $_POST['KakaoID2'])){
     
        $inputKakaoIDMe = $_POST['KakaoID1'];
        $inputKakaoIDOther = $_POST['KakaoID2'];

        $stmt = $conn->prepare("SELECT kakaoid2 FROM chatroom_tbl where KakaoId1 = ?");
            $stmt->bind_param("i",$inputKakaoIDMe);
            $stmt->execute();
            $stmt->bind_result($kakaoid2);
    }
    while($stmt->fetch()){
        if($kakaoid2 == $inputKakaoIDOther)
            $isAlready = 1;
    }
     
   
   if($isAlready){
        $response['error'] = true;
        $response['message'] = "Already Matched!";
   }
   else{
    $stmt = $conn->prepare("INSERT INTO chatroom_tbl(KakaoId1, KakaoId2, Matched) values(?, ?, 1)");
   $stmt->bind_param("ii", $inputKakaoIDMe, $inputKakaoIDOther);
   $result = $stmt->execute();

   $stmt = $conn->prepare("INSERT INTO chatroom_tbl(KakaoId1, KakaoId2, Matched) values(?, ?, 1)");
   $stmt->bind_param("ii",$inputKakaoIDOther, $inputKakaoIDMe);
   $result = $stmt->execute();
  

   if($result == TRUE){
       
         $response['error'] = false;
         $response['message'] = "save Successful!";
            }
   else{
         
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    }


 echo json_encode($response);
?>
