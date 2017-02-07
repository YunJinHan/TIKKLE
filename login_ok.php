
<?php
	require_once("./database/database.php");
    $database = new Database("localhost");
    session_start();
    $_SESSION['user_id'] = null;
    $user_id = null;
    if(isset($_GET["az"])){
	   	$data = $database->auth_check($_GET["az"]);
		$_SESSION['user_id'] = $data;
		$user_id = $data;
	}else{
		if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
		$user_id = $_POST['user_id'];
		$user_pw = $_POST['user_pw'];

		if(!($database->login($user_id, $user_pw))){
			echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
			exit;
		}
		$_SESSION['user_id'] = $user_id;
	}

	$array = $database->login_get_name_and_field($user_id);


	$_SESSION['user_name'] = $array[0];
	$_SESSION['user_field'] = ($array[1] == 1 ? "개발" : ($array[1] == 2 ? "기획" : "디자인") );
?>
<meta http-equiv='refresh' content='0;url=index.php'>
