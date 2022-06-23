<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 

$conn = new mysqli($servername, $username, $password, $dbname);
 
 $response = array();

 if(isset($_POST['KakaoID'],
    $_POST['Name'],
	$_POST['Grade'],
	$_POST['Gender'],
	$_POST['Dormitory'],
	$_POST['Introduce'],
	$_POST['Profileimage'])){
    
    
     
     $inputName = $_POST['Name'];
     $inputGrade = $_POST['Grade'];
     $inputGender = $_POST['Gender'];
     $inputDormitory = $_POST['Dormitory'];
     $inputIntroduce = $_POST['Introduce'];
     $inputProfileimage = $_POST['Profileimage'];
     $inputKakaoID = $_POST['KakaoID'];

     

    }
 
    $stmt = $conn->prepare("UPDATE profiles SET  Name = ?, Grade = ?, Gender = ?, Dormitory = ?, Introduce = ?, Profileimage = ? WHERE KakaoID = ?");
	$stmt->bind_param("sssssss", $inputName, $inputGrade, $inputGender, $inputDormitory, $inputIntroduce, $inputProfileimage, $inputKakaoID);
    $result = $stmt->execute();
  
   if($result == TRUE){
     
         $response['error'] = false;
         $response['message'] = "Retrieval Successful!";
     
        

     } else{
  
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    
  /*else{

      $response['error'] = true; */
     
 

 echo json_encode($response);
?>
