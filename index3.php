<!DOCTYPE html>
<html>
    <head>
        <title>TIKKLE</title>
        <link rel="icon" href="rebbit.png" type="image/x-icon">
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <link href="css/js-mindmap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>

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

        <link href="bootstrap/css/bootstrap.min.css" media="screen" rel="stylesheet"/>
        <!-- Icon -->
        <link rel="stylesheet" href="awesome/css/font-awesome.min.css">
    </head>
    <?php
    session_start();
    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_SESSION['user_field'])) {
      echo "<meta http-equiv='refresh' content='0;url=login.php'>";
      exit;
    }
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_field = $_SESSION['user_field'];

    require_once("./database/database.php");
    $database = new Database("localhost");
    if(isset($_POST['enroll_but'])){
        $proj_field = $_POST['proj_field'];
        $proj_title = $_POST['proj_title'];
        $proj_short_content = $_POST['proj_short_content'];
        $proj_content = htmlspecialchars($_POST['content']);
        $proj_period = $_POST['proj_period'];
        $open_field = $_POST['open_field'];
        $proj_date = date("Y-m-d");
        $proj_modify_date = date("Y-m-d", strtotime($proj_date."+".$proj_period."day"));
        $enroll_node_result = $database->insert_node($proj_title,$user_id,$proj_short_content,0);
        try{
        if($enroll_node_result != NULL){
            $enroll_result = $database->insert_board($user_id,$proj_title,$proj_content,$proj_date,$proj_modify_date,$proj_field,$enroll_node_result,$open_field);
            if($enroll_result == 1){ // success
                echo "<meta http-equiv='refresh' content='0;url=index.php'>";
            }else{
        ?>
                <script>alert("등록 에러!!");</script>
        <?php
            }
         }
        }catch(Exception $e){
            print ($e->getMessage());
        }
     }
?>
<body>
    <div id= "header">
        <div class = "board">
            <a href="http://localhost:8080/TIKKLE/index.php"><span class="glyphicon glyphicon-user"></span> <?php echo $user_name ?> - <?php echo $user_field ?> <?php echo $user_id ?></a>
        </div>
        <div class = "title">
            <a href="http://localhost:8080/TIKKLE/index.php">티 끌</a>
        </div>
        <div class = "logout">
            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
        </div>
    </div>
     <div id="page">
        <div id = "enroll_content">
            <div id = "enroll_content_header">
                <h3>프로젝트 등록</br>
                <small>상세하게 작성해주시면 아이디어 확장에 유용합니다.</small></h3>
            </div>
            <div id = "enroll_content_info">
                <section>
                    <form action="index3.php" method="POST">
                        <div class = "enroll_input">
                            <label><span>*</span><b>카테고리</b></label>
                            <div class = "input-group">
                                <select id = "proj_field" name="proj_field" tabindex='5' required>
                                    <?php
                                      $result = $database->get_categories();
                                      $count = count($result);
                                      if($count > 0){
                                        for($i = 1; $i <=$count; $i++){
                                          print '<option value="'.$i.'">';
                                          print $result[$i-1]["name"];
                                          print "</option>";
                                        }
                                      }
                                    ?>
                                </select>
                                <p>프로젝트 카테고리를 선택해주세요.</p>
                            </div>
                        </div>
                        <div class = "enroll_input">
                            <label><span>*</span><b>프로젝트 제목</b></label>
                            <div class = "input-group">
                                <input type="text" placeholder="Enter Title" name="proj_title" tabindex='2' maxlength="30">
                                <p>프로젝트 제목을 입력해 주세요.(30자 이내)</p>
                            </div>
                        </div>
                        <div class = "enroll_input">
                            <label><span>*</span><b>내용 한줄 요약</b></label>
                            <div class = "input-group">
                                <input type="text" placeholder="Enter Content" name="proj_short_content" tabindex='2' required>
                                <p>마인드 맵에 간략하게 들어가 내용을 입력해 주세요.</p>
                            </div>
                        </div>
                        <div class = "enroll_input">
                            <div class = "input-group">
                                <label><span>*</span><b>프로젝트 내용</b></label>
                                <textarea rows="6" cols="60" name = "content" placeholder="Enter Content"></textarea>
                            </div>
                        </div>
                        <div class = "enroll_input">
                            <label><span>*</span><b>예상 기간</b></label>
                            <div class = "input-group">
                                <input id = "period" type="text" placeholder="Enter Period" name="proj_period" tabindex='2' required>
                                <span class = "proj_date">일</span>
                                <p>프로젝트를 진행할 기간을 일 단위로 입력해 주세요. (최대 3자리)</p>
                            </div>
                        </div>
                        <div class = "enroll_input">
                            <label><span>*</span><b>공개 범위</b></label>
                            <div class = "input-group">
                                <select id = "open_field" name="open_field" tabindex='5' required>
                                    <option value="0">전체 공개</option>
                                    <option value="1">비공개</option>
                                </select>
                                <p>공개 범위를 설정해 주세요.</p>
                            </div>
                        </div>
                        <div class = "enroll_button">
                            <button class ="btn btn-primary" type="submit" tabindex='3' name = "enroll_but">Enrollment</button>
                        </div>
                      </form>
                </section>

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
                             <address class = "address">
                               SMaSh방 / 두번째 방 / 대표 : 박지원</br>
                               경기도 안산시 상록구 한양대학교 4공 1층   (주) 티 끌</br>
                             <i class="fa fa-free-code-camp" aria-hidden="true"></i>
                             <span> 2016 TIKKLE, good</span>
                             </address></br>

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
                     <div class = "intro">
                        <ul>이용 방법
                             <li>1. 자신이 기획자가 되어 아이디어를 등록</li>
                             <li>2. 기획자의 아이디어를 마인드맵을 통해 확장</li>
                             <li>3. 자신이 원하는 분야의 아이디어 검색/선택</li>
                             <li>4. 함께 일하고 싶은 기획자에게 연락하기</li>
                         </ul>
                     </div>
                 </div>
             </div>
</body>
</html>
