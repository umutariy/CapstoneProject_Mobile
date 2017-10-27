<?php
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
include_once('users.php');

  if(isset($_POST['Login'])){
    $user_default= new users();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $user_default->login($username,$password);

    if($result == false){
    echo 0;
    }else{
      if ($result['LEVEL'] == 4) {
        $user_data = array('uid' => $result['UID'],'uname' => $result['USERNAME'],'fname' => $result['FNAME'],'lname' => $result['LNAME'],'schoolid' => $result['SCHOOLID'],'level' => $result['LEVEL'],'photo' => $result['photo'],'children' => $result['children'],'phone' => $result['phone'],'email' => $result['email']);
      } elseif ($result['LEVEL'] == 3){
        $user_data = array('uid' => $result['UID'],'uname' => $result['USERNAME'],'fname' => $result['FNAME'],'lname' => $result['LNAME'],'schoolid' => $result['SCHOOLID'],'level' => $result['LEVEL'],'grade' => $result['grade'],'photo' => $result['photo'],'children' => $result['children'],'phone' => $result['phone'],'email' => $result['email']);
      } elseif ($result['LEVEL'] == 2) {
        $user_data = array('uid' => $result['UID'],'uname' => $result['USERNAME'],'fname' => $result['FNAME'],'lname' => $result['LNAME'],'schoolid' => $result['SCHOOLID'],'level' => $result['LEVEL'],'grade' => $result['grade'],'photo' => $result['photo'],'parents' => $result['parents'],'phone' => $result['phone'],'email' => $result['email']);
      } elseif ($result['LEVEL'] == 1) {
        $user_data = array('uid' => $result['UID'],'uname' => $result['USERNAME'],'fname' => $result['FNAME'],'lname' => $result['LNAME'],'schoolid' => $result['SCHOOLID'],'level' => $result['LEVEL'],'photo' => $result['photo'],'phone' => $result['phone'],'email' => $result['email']);
      }
      $json_data = $user_data;
      echo json_encode($json_data);
    }
    
  }elseif(isset($_POST['Signup'])) {
    $user_create = new users();
    //$username = $_POST['username'];
    $username = $_POST['fname'].".".$_POST['lname'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $usertype = $_POST['utype'];
    $sch = $_POST['sch'];
    $clss = $_POST['clss'];

    /*if(isset($_FILES['photo'])){
      $root = getcwd()."/";
      $username = $_POST['username'];
      $new_name = $username;

      //File upload into the server location
      $target_dir = "profileimages/";
      $new_file_name = $target_dir.$new_name;
      $target_file = $target_dir . basename($_FILES["photo"]["name"]);
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

      // Check if file already exists
      if (file_exists($target_file)) {
        echo "File already exists.";
        $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $root.$new_file_name)) {
            echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
      }
    }else{
      $target_file = "Error";
    }*/

    $result = $user_create->adduser($fname,$lname,$username,$password,$sch,$usertype,$clss,$phone,$email);
    echo json_encode("success");

  }
?>