<?php
    try{
        session_start();
        if(!isset($_SESSION['user_id'])) {
          echo "<meta http-equiv='refresh' content='0;url=login.php'>";
          exit;
        }
        $publisher = null;
        if (isset($_SESSION["board_publisher_id"])){
            $publisher = $_SESSION["board_publisher_id"];
        }
        $user_id = $_SESSION['user_id'];

        require_once("./database.php");
        $database = new Database("localhost");
        if ($_POST["what"] == 0){
            $id = $_POST["id"];
            switch($_POST["funcname"]){
              case "get_content_from_node":
                print $database->get_content_from_node($id);
                break;
            }
        } else if ($_POST["what"] == 1){
            $database->insert_node($_POST["title"], $user_id, $_POST["content"], $_POST["parent_node_id"]);
        } else if ($_POST["what"] == 2){
            $database->make_mind_map($_POST["root_node_id"]);
        } else if ($_POST["what"] == 3){
            print $database->remove_node_using_id($_POST["node_id"]);
        } else if ($_POST["what"] == 4){
            print $database->get_root_node($_POST["board_id"]);
        } else if ($_POST["what"] == 5){
          $page = 1;
          $token = "";
          if($_POST["page"] != NULL)
          {
            $page = $_POST["page"];
          }
          if($_POST["token"] != ""){
            $token = $_POST["token"];
          }
          $json_data = array();

          header("Content-type : application/json");
          $value = $database->get_board_list($_POST["checkbit"],$page, $token);
          $result = $value["result"];
          $count = count($result);
          $data = array();

          for($i = 0 ; $i < $count ; $i ++){
            $category_name = $database->get_categories_name($result[$i]["category_id"]);
            $publisher_name = $database->get_member_name_from_board($result[$i]["board_id"]);

            $data[]= '<section>';
            $data[]= '<form action = "http://localhost:8080/TIKKLE/index2.php" method = "post">';
            $data[]= '<a href = "#" onclick="$(this).closest(\'form\').submit()">'.$result[$i]["title"].'</a>';
            $data[]= '<div class = "info">';
            $data[]= '<span>등록일자 '.$result[$i]["start_date"].'</span>';
            $data[]= '<span>마감일자 '.$result[$i]["end_date"].'</span>';
            $data[]= '</div>';
            $data[]= '<div class = "description">';
            $data[]= '<p class = "board_content">'.$result[$i]["content"].'</p>';
            $data[]= '<div class = "outer-info">';
            $data[]= '<div class = "outer-info-upper-data">';
            $data[]= '<span>분야 <strong>'.$category_name.'</strong></span>';
            $data[]= '</div>';
            $data[]= '<div class = "outer-info-upper-data">';
            $data[]= '<span>등록자 : <strong>'.$publisher_name.'</strong></span>';
            $data[]= '</div>';
            $data[]= '</div>';
            $data[]= '</div>';
            $data[]= '<div class = "add-info">';
            $data[]= '<span>게시판 번호 > '.$result[$i]["board_id"].'</span>';
            $data[]= '</div>';
            $category_name_tmp = str_replace(" ","&nbsp;",$category_name);
            $data[]= '<textarea name = "category_name" style="display:none;">'.$category_name_tmp.'</textarea>';
            $data[]= '<input name = "publisher_name" type = "hidden" value ='.$publisher_name.'></input>';
            $data[]= '<input name = "start_date" type = "hidden" value ='.$result[$i]["start_date"].'></input>';
            $data[]= '<input name = "end_date" type = "hidden" value ='.$result[$i]["end_date"].'></input>';
            $board_title = str_replace(" ","&nbsp;",$result[$i]["title"]);
            $data[]= '<textarea name = "board_title" style="display:none;" >'.$board_title.'</textarea>';
            $board_content = str_replace("\n","<br>",$result[$i]["content"]);
            $data[]= '<textarea name = "board_content" style="display:none;" >'.$board_content.'</textarea>';
            $data[]= '<input name = "board_publisher_id" type = "hidden" value ='.$result[$i]["publisher_id"].'></input>';
            $data[]= '<input name = "board_id" type = "hidden" value ='.$result[$i]["board_id"].'></input>';
            $data[]= '</form>';
            $data[]= '</section>';
          }
          $json_data["boardHTML"] = implode(" ",$data);

          $index_array = $database->get_index_array_custom($page, $value["count"]);
          $index_array_size = count($index_array);

          $data = array();
          $data[] = '<li>';
          $data[] =   '<a href=\'#\' onClick = "get_board_function(\'prev\', '.($index_array[0] - 1).');return false;">';
          $data[] =     '<span aria-hidden="true">&laquo;</span>';
          $data[] =     '<span class="sr-only">Previous</span>';
          $data[] =   '</a>';
          $data[] = '</li>';

          for($i = 0 ; $i < $index_array_size ; $i++)
          {
            $data[] = '<li><a href=\'#\' onclick="get_board_function(\' \','.$index_array[$i].');"> '.$index_array[$i].' </a></li>';
          }

          $data[] = '<li>';
          $data[] =   '<a href=\'#\' onClick="get_board_function(\'next\', '.($index_array[$index_array_size - 1] + 1).');return false;">';
          $data[] =     '<span aria-hidden="true">&raquo;</span>';
          $data[] =     '<span class="sr-only">Next</span>';
          $data[] =   '</a>';
          $data[] = '</li>';
          $json_data["indexHTML"] = implode(" ",$data);

          print json_encode($json_data);

      } else if ($_POST["what"] == 6){
        $publisher_id = $database->get_publisher($_POST["node_id"]);
        if ($publisher == $user_id){
            print 1;
        }
        else if (!strcmp($user_id,$publisher_id)){
            print 1;
        } else {
            $board_id = $database->get_board_id($_POST["node_id"]);
            if ($board_id != null){
                print 1;
            } else {
                print 0;
            }
        }
      }
    }catch(Exception $e){
        print($e -> getMessage);
    }
?>
