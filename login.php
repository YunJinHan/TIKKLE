<!DOCTYPE html>
<html>
    <head>
        <title>TIKKLE</title>
        <link rel="icon" href="rebbit.png" type="image/x-icon">
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <link href="css/js-mindmap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="css/style2.css" rel="stylesheet" type="text/css"/>

        <!-- jQuery -->
        <script
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"
            type="text/javascript"></script>
        <script
            src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"
            type="text/javascript"></script>
        <!-- UI, for draggable nodes -->
        <script
            src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"
            type="text/javascript"></script>

        <!-- Raphael for SVG support (won't work on android) -->
        <script src="js/raphael-min.js" type="text/javascript"></script>

        <!-- Mindmap -->
        <script src="js/js-mindmap.js" type="text/javascript"></script>

        <!-- Kick everything off -->
        <script src="js/script.js" type="text/javascript"></script>

        <!-- Bootstrap -->
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="bootstrap/css/bootstrap.min.css" media="screen" rel="stylesheet"/>
        <!-- Icon -->
        <link rel="stylesheet" href="awesome/css/font-awesome.min.css">
    </head>
<?php
	if(isset($_POST["sign_up_button"])){
		echo "<meta http-equiv='refresh' content='0;url=signup.php'>";
	}

?>
<body>
	<div id= "header">
        <div class = "board"></div>
            <div class = "title">
            <a href="http://localhost:8080/TIKKLE/login.php">티 끌</a>
            </div>
            <div class = "logout">
                <a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                <a href="http://localhost:8080/TIKKLE/signup.php"><span class="glyphicon glyphicon-plus"></span> Sign up</a>
            </div>
     </div>
     <div id="page">
        <div id = "login_content">
            <div id = "login_content_header">
                <h3>로그인</br>
                <small>티끌에 오신 것을 환영합니다.</small></h3>
            </div>
            <div id = "login_content_info">
                <section>
                    <form action="login_ok.php" method="POST">
                        <div class = "login_input">
                            <label><span>*</span><b>이메일</b></label>
                            <input type="text" placeholder="Enter Username" name="user_id" tabindex='1' required>
                        </div>
                        <div class = "login_input">
                            <label><span>*</span><b> 비밀번호</b></label>
                            <input type="password" placeholder="Enter Password" name="user_pw" tabindex='2' required>
                        </div>
                        <div class = "login_button">
                            <button class ="btn btn-primary" type="submit" tabindex='3'>Login</button>
                        </div>
                      </form>
                </section>
                <aside>
                    <div>
                        <p>아직 회원이 아니신가요? <a href="http://localhost:8080/TIKKLE/signup.php"> Sign up</a></p>
                    </div>

                </aside>
            </div>
        </div>
     </div>
    <div id = "footer">
        <div class = "foot-inner">
            <div class = "infoma">
                <div class = "logo">
                    <img class = "rebbit" src="rebbit.png" alt="rebbit">
                        티 끌
                </div>
                <div class = "content">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    010-3024-7034</br>
                    <i class= "fa fa-envelope" aria-hidden="true"></i>
                    jinhan234@naver.com</br>
                </div>
            </div>
            <div class = "member">
                <ul>팀원 소개
                    <li>윤 진 한</li>
                    <li>박 지 원</li>
                    <li>박 승 호</li>
                    <li>이 태 식</li>
                    <li>박 진 혁</li>
                </ul>
            </div>
        </div>
        </div>
</body>

</html>
