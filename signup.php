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
    include "mailtest.php";
    require_once("./database/database.php");
    $database = new Database("localhost");
    if(isset($_POST['join_button'])){
        $name = $_POST['user_name'];
        $id = $_POST['user_id'];
        $password = $_POST['user_pw'];
        $password_check = $_POST['user_pw_check'];
        $field = $_POST['user_field'];
        $auth = mt_rand();
        $signup_result = $database->regs_auth($id, $name, $password, $password_check, $field, $auth);
        /* field id 1-개발, 2-기획, 3-디자인 */
        if($signup_result == 1){ // success
            $config=array(
            'host'=>'ssl://smtp.mail.nate.com',
            'smtp_id'=>'am520@nate.com',
            'smtp_pw'=>'tikkle2016',
            'debug'=>1,
            'charset'=>'utf-8',
            'ctype'=>'text/plain'
            );
            $sendmail = new Sendmail($config);

            $to=$id;
            $from="TIKKLE";
            $subject="test";
            $body="http://localhost:8080/TIKKLE/login_ok.php?az=$auth";

            /* 메일 보내기 */
            $sendmail->send_mail($to, $from, $subject, $body);
            echo "<script>alert('인증메일을 확인하세요!');</script>";
            echo "<meta http-equiv='refresh' content='0;url=http://localhost:8080/TIKKLE/login.php'>";
    ?><?php
        }else if($signup_result == -1){ // 아이디 중복
    ?>
        <script>alert("이미 사용중인 메일 주소입니다.");</script>
    <?php
        }else{ // 비밀번호 불일치
    ?>
        <script>alert("비밀번호가 일치하지 않습니다.");</script>
    <?php
        }
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
        <div id = "sign_content">
            <div id = "sign_content_header">
                <h3>회원가입</br>
                <small> - 가입을 위해 이메일 인증이 필요합니다.</small></h3>
            </div>
            <div id = "sign_content_info">
                <section>
                    <form action="signup.php" method="POST">
                        <div class = "sign_input">
                            <label><span>*</span><b> 이름</b></label>
                            <input type="text" placeholder="Enter Username" name="user_name" tabindex='1'required>
                        </div>
                        <div class = "sign_input">
                            <label><span>*</span><b> 이메일</b></label>
                            <input type="text" placeholder="Enter Email" name="user_id" tabindex='2' required>
                        </div>
                        <div class = "sign_input">

                        </div>
                        <div class = "sign_input">
                            <label><span>*</span><b> 비밀번호</b></label>
                            <input type="password" placeholder="Enter Password" name="user_pw" tabindex='3' required>
                        </div>
                        <div class = "sign_input">
                            <label><span>*</span><b> 비밀번호 확인</b></label>
                            <input type="password" placeholder="Enter Password" name="user_pw_check" tabindex='4' required>
                        </div>
                        <div class = "sign_input">
                            <label><span>*</span><b> 해당 필드 선택</b></label>
                            <select id = "user_field" name="user_field" tabindex='5' required>
                                <option value="1">개발</option>
                                <option value="2">기획</option>
                                <option value="3">디자인</option>
                            </select>
                        </div>
                        <div class = "sign_button">
                            <button class ="btn btn-primary" type="submit" name="join_button">인증 후 회원가입</button>
                        </div>
                      </form>
                </section>
                <aside>
                    <div>
                        <p>이미 회원이신가요? <a href="http://localhost:8080/TIKKLE/login.php"> Login</a></p>
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
