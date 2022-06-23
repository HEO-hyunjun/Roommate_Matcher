<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";


$conn = new mysqli($servername, $username, $password, $dbname);

 
    if(isset($_POST['KakaoID1'], $_POST['KakaoID2'])){
     

        $inputKakaoIDMe = $_POST['KakaoID1'];
        $inputKakaoIDOther = $_POST['KakaoID2'];

        $stmt = $conn->prepare("SELECT Matched FROM chatroom_tbl where (KakaoId1 = ? and KakaoId2 = ?)");
            $stmt->bind_param("ii",$inputKakaoIDMe, $inputKakaoIDOther);
	    $result = $stmt->execute();
	    $stmt->bind_result($Matched);
         
    

    if($result == TRUE){
   
         $response['error'] = false;
         $response['message'] = "Successful!";
         $response['matched'] = $Matched;  
        }
   else{
     
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    }


 echo json_encode($response);
?>
