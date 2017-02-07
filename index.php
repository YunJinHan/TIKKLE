<!DOCTYPE html>
<html>
    <head>
        <title>TIKKLE</title>
        <link rel="icon" href="rebbit.png" type="image/x-icon">
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <link href="css/js-mindmap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="css/style2.css" rel="stylesheet" type="text/css"/>

        <script
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"
            type="text/javascript"></script>
        <script
            src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"
            type="text/javascript"></script>

        <script
            src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"
            type="text/javascript"></script>


        <script src="js/raphael-min.js" type="text/javascript"></script>


        <script src="js/js-mindmap.js" type="text/javascript"></script>


        <script src="js/script.js" type="text/javascript"></script>


        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>

        <link href="bootstrap/css/bootstrap.min.css" media="screen" rel="stylesheet"/>

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
    $current_page = 1;
    if(isset($_GET["page"])){
      $current_page = $_GET["page"];
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
           <aside>
               <div id = "func">
                   <p>프로젝트 등록 / 검색</p>
                   <div>
                       <a href="index3.php">프로젝트 등록</a>
                   </div>
                   <div>
                     <input type="text" name = "search" id = "search_field" size="14" maxlength="10" />
                     <button class = "btn btn-primary" type="submit" onclick = "get_board_function()" >프로젝트 검색</button>
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
                              print '<input class = "design" name="designs[]" type="checkbox" value="'.$i.'" onchange="get_board_function() ">';
                              print '<label for = "design[]">'.$result[$i-1]["name"]."</label>";
                              print "</li>";
                            }
                          }
                        ?>
                        </ul>
                    </form>
                </div>
            </aside>

            <div id="board">
              <?php
                $value = $database->get_board_list(127,$current_page, "");
                $result = $value["result"];

                $count = count($result);
                for($i = 0 ; $i < $count ; $i ++){
                  $category_name = $database->get_categories_name($result[$i]["category_id"]);
                  $publisher_name = $database->get_member_name_from_board($result[$i]["board_id"]);
                  print '<section>';
                  print '<form action = "http://localhost:8080/TIKKLE/index2.php" method = "post">';
                  print '<a href = "#" onclick="$(this).closest(\'form\').submit()">'.$result[$i]["title"].'</a>';
                  print '<div class = "info">';
                  print '<span>등록일자 '.$result[$i]["start_date"].'</span>';
                  print '<span>마감일자 '.$result[$i]["end_date"].'</span>';
                  print '</div>';
                  print '<div class = "description">';
                  print '<p class = "board_content">'.$result[$i]["content"].'</p>';
                  print '<div class = "outer-info">';
                  print '<div class = "outer-info-upper-data">';
                  print '<span>분야 <strong>'.$category_name.'</strong></span>';
                  print '</div>';
                  print '<div class = "outer-info-upper-data">';
                  print '<span>등록자 : <strong>'.$publisher_name.'</strong></span>';
                  print '</div>';
                  print '</div>';
                  print '</div>';
                  print '<div class = "add-info">';
                  print '<span>게시판 번호 > '.$result[$i]["board_id"].'</span>';
                  print '</div>';
                  $category_name_tmp = str_replace(" ","&nbsp;",$category_name);
                  print '<textarea name = "category_name" style="display:none;">'.$category_name_tmp.'</textarea>';
                  print '<input name = "publisher_name" type = "hidden" value ='.$publisher_name.'></input>';
                  print '<input name = "start_date" type = "hidden" value ='.$result[$i]["start_date"].'></input>';
                  print '<input name = "end_date" type = "hidden" value ='.$result[$i]["end_date"].'></input>';
                  $board_title = str_replace(" ","&nbsp;",$result[$i]["title"]);
                  print '<textarea name = "board_title" style="display:none;" >'.$board_title.'</textarea>';
                  $board_content = str_replace("\n","<br>",$result[$i]["content"]);
                  print '<textarea name = "board_content" style="display:none;" >'.$board_content.'</textarea>';
                  print '<input name = "board_publisher_id" type = "hidden" value ='.$result[$i]["publisher_id"].'></input>';
                  print '<input name = "board_id" type = "hidden" value ='.$result[$i]["board_id"].'></input>';
                  print '</form>';
                  print '</section>';
                }
              ?>
            </div>

            <?php
                $index_array = $database -> get_index_array($current_page);
                $index_array_size = count($index_array);
            ?>

            <div id = "bottom_side">
                  <ul class="pagination">
                    <li>
                      <a href='#' onClick = "get_board_function('prev', <?php echo $index_array[0] - 1;?>);return false;">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
                    <?php
                    for($i = 0 ; $i < $index_array_size ; $i++){
                      print("<li><a href=\"#\" onclick=\"get_board_function(' ',$index_array[$i]);\"> $index_array[$i] </a></li>");
                    }
                    ?>
                    <li>
                      <a href='#' onClick="get_board_function('next', <?php echo $index_array[$index_array_size - 1] + 1; ?>);return false;">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                  </ul>
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


        <script src="bootstrap/js/bootstrap.min.js"></script>

    </body>

</html>
