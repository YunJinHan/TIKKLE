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

        if (isset($_POST["board_publisher_id"]))
        {
            $_SESSION["board_publisher_id"] = $_POST["board_publisher_id"];
        }

        require_once("./database/database.php");
        $database = new Database("localhost");
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
           <aside>
               <div id = "func">
                   <p>프로젝트 등록 / 검색</p>
                   <div>
                       <a href="index3.php">프로젝트 등록</a>
                   </div>
                   <div>
                     <input type="text" name = "search" size="14" maxlength="10" />
                     <button class = "btn btn-primary" type="submit">프로젝트 검색</button>
                   </div>
               </div>
               <div id="sort">
                   <p>프로젝트 정렬</p>
                   <input type="radio" name="sort_method" value="1" onclick= "get_board_function()" checked = "checked" > 최신 등록 순 </input> &nbsp;
                   <input type="radio" name="sort_method" value="2" onclick= "get_board_function()" > 마감 임박 수 </input>
               </div>
                <div id="category">
                    <p>프로젝트 카테고리</p>
                    <form action="http://localhost:8080/TIKKLE/index.php" method="post">
                        <ul>
                        <input id = "dev" type="checkbox" onClick="toggle(this)" /><label>개발</label><br/>
                        <?php
                          $result = $database->get_categories();
                          $count = count($result);
                          if($count > 0){
                            for($i = 1; $i <=$count; $i++){
                              print "<li>";
                              print '<input class = "design" name="designs[]" type="checkbox" value="'.$i.'">';
                              print '<label for = "design[]">'.$result[$i-1]["name"]."</label>";
                              print "</li>";
                            }
                          }
                        ?>
                        </ul>
                    </form>
                </div>
            </aside>

            <article>
                <?php
                    if (isset($_POST["category_name"],$_POST["publisher_name"],$_POST["start_date"],$_POST["end_date"],$_POST["board_title"],$_POST["board_content"],$_POST["board_publisher_id"],$_POST["board_id"])){
                        $board_category = $_POST["category_name"];
                        $board_publisher_name = $_POST["publisher_name"];
                        $start_date = $_POST["start_date"];
                        $end_date = $_POST["end_date"];
                        $board_title = $_POST["board_title"];
                        $board_content = $_POST["board_content"];
                        $board_publisher_id = $_POST["board_publisher_id"];
                        $board_id = $_POST["board_id"];
                    }
                 ?>

                <div class = "project_info">

                    <div class="article_title">
                        <?= $board_title ?>
                    </div>

                    <div class="article_outer_info">
                        <div>
                            <span><strong>글쓴이</strong> <?= $board_publisher_name  ?></span><br>
                            <span><strong>연락처</strong> <?= $board_publisher_id  ?></span><br>
                        </div>
                    </div>

                    <div class="article_category">
                        <span><strong>분야</strong> <?= $board_category ?></span>
                    </div>

                    <div class="article_date">
                        <span><strong>등록일자</strong> <?= $start_date ?> / </span>
                        <span><strong>마감일자</strong> <?= $end_date ?></span>
                    </div>

                    <div class="article_number">
                        <span><strong>게시판 번호 ></strong> <?= $board_id ?></span>
                    </div>

                </div>

                <div class = "art">
                    <h2><프로젝트 예상 개발 과제></h2>
                    <ul>
                        <?php
                            echo("<script language='javascript'>find_root_node_id(\"$board_id\");</script>");
                            $database->make_mind_map( $database->get_root_node($board_id));
                        ?>
                    </ul>
                </div>

                <div class="article_content">
                    <h2><프로젝트 내용></h2>
                    <span>자세한 내용은 글쓴이에게 문의해주세요.</span>
                    <p><?= $board_content ?></p>
                </div>


            </article>
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

        <script src="bootstrap/js/bootstrap.min.js"></script>

    </body>

</html>
