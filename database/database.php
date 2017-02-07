<?php

Class Database{
  private $connection;

  public function __construct($host){
    $this->connection = new PDO("mysql:host=$host;dbname=TIKKLE", "root", "0000");
    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->connection->exec("USE TIKKLE");
  }
  public function insert_member($member_id, $password, $name, $field_id){
    $this->connection->exec("INSERT INTO member VALUES(\"$member_id\", \"$password\", \"$name\", \"$field_id\")");
  }
  public function insert_board($publisher_id, $title, $content, $start_date, $end_date, $category_id, $node_id,$privacy_bound){
      $this->connection->exec("INSERT INTO board(publisher_id, title, content, start_date, end_date, category_id, privacy_bound) VALUES(\"$publisher_id\",\"$title\",\"$content\", \"$start_date\", \"$end_date\", \"$category_id\",\"$privacy_bound\")");
      $result = $this->connection->query("SELECT MAX(board_id) FROM board");
      $board_id = $result->fetch(PDO::FETCH_ASSOC)["MAX(board_id)"];
      $this->connection->exec("INSERT INTO board_to_node VALUES(\"$board_id\",\"$node_id\")");
      return 1;
  }
  public function insert_node($title, $publisher_id, $content, $parent_node_id){
    $this->connection->exec("INSERT INTO node(title, publisher_id, content) VALUES (\"$title\", \"$publisher_id\", \"$content\")");
    if($parent_node_id > 0){ // the node is child node
      $result = $this->connection->query("SELECT MAX(node_id) FROM node");
      $node_id = $result->fetch(PDO::FETCH_ASSOC)["MAX(node_id)"];
      $this->connection->exec("INSERT INTO node_to_node VALUES(\"$parent_node_id\",\"$node_id\")");
    }
    $query = "SELECT MAX(node_id) FROM node";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result["MAX(node_id)"];
  }
  public function remove_node_using_id($node_id){
    $query = "SELECT count(*) FROM node_to_node WHERE parent_id = \"".$node_id."\"";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);

    if($result["count(*)"] == 0){

      $this->connection->exec("DELETE FROM node_to_node WHERE child_id = \"".$node_id."\"");
      $this->connection->exec("DELETE FROM node WHERE node_id = \"".$node_id."\"");
    }
    return $result["count(*)"];
  }
  public function get_node_using_id($node_id){
    $statement = $this->connection->query("SELECT * FROM node WHERE node_id = \"$node_id\"");
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  public function get_child_nodes_id($node_id){
    $statement = $this->connection->query("SELECT child_id FROM node_to_node WHERE parent_id = \"$node_id\"");
    $result = $statement -> fetchAll();
    return $result;
  }
  public function get_content_from_node($node_id){
    $statement = $this->connection->query("SELECT content FROM node WHERE node_id = \"$node_id\"");
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result["content"];
  }
  public function get_member_name_from_board($board_id){
      $statement = $this->connection->query("SELECT name FROM member JOIN board ON board.publisher_id = member.member_id WHERE board_id = \"$board_id\"");
      $result = $statement -> fetch(PDO::FETCH_ASSOC);
      return $result["name"];
  }
  public function make_mind_map($node_id){
    $node = $this->get_node_using_id($node_id);
    $child_nodes = $this->get_child_nodes_id($node_id);
    $child_count = count($child_nodes);
    print "<li><a href=\"".$node["node_id"]."\"> ".$node["title"]." </a>";
    if($child_count > 0){
      print "<ul>";
      for($i = 0; $i < $child_count; $i++){
        $this->make_mind_map($child_nodes[$i]["child_id"]);
      }
      print "</ul>";
    }
    print "</li>";
  }
  public function get_categories(){
    $statement = $this->connection->query("SELECT name FROM category");
    $result = $statement -> fetchALL();
    return $result;
  }
  public function get_categories_name($category_id){
    $statement = $this->connection->query("SELECT name FROM category WHERE category_id =\"$category_id\"");
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result["name"];
  }
  public function get_board_list($check_category, $number_of_page, $token){
    try{
    $category_bit = array();
    for($i = 128 ; (int)($i) > 0 ; $i /= 2){
      $category_bit[] = (int)($check_category / $i);
      $check_category = (int)($check_category % $i) ;
    }
    $category_bit = array_reverse($category_bit);
    $query = "SELECT * FROM board ";
    $count_query = "SELECT count(*) FROM board ";
    $last_on_bit = -1;
    $count = count($category_bit);
    for($i = 0 ; $i < $count - 1 ; $i ++){
      if($category_bit[$i] == 1){
        $last_on_bit = $i;
      }
    }
    if($last_on_bit >= 0 || $category_bit[$count - 1] == 1){
      $query.= "WHERE (";
      $count_query.= "WHERE (";
    }
    for($i = 0 ; $i < $count - 1 ; $i ++){
      if($category_bit[$i] == 1){
        $query.="category_id = ".($i + 1)." ";
        $count_query.="category_id = ".($i + 1)." ";
        if($i != $last_on_bit){
          $query.="OR ";
          $count_query.="OR ";
        }
      }
    }
    if($category_bit[$count -1] == 1){
      if($last_on_bit >= 0){
        $query.= ") AND ";
        $count_query.= ") AND ";
      }
      $query.= " end_date >= \"".date("Y-m-d");
      $count_query.= " end_date >= \"".date("Y-m-d");
      if($token != ""){
        $query.="\" AND title LIKE \"%".$token."%";
        $count_query.="\" AND title LIKE \"%".$token."%";
      }
      if($last_on_bit >= 0){
        $query.= "\" ORDER BY end_date ASC LIMIT ";
        $count_query.= "\" ORDER BY end_date ASC ";
      }else{
        $query.= "\") ORDER BY end_date ASC LIMIT ";
        $count_query.= "\") ORDER BY end_date ASC ";

      }
    }
    else{
      if($last_on_bit >= 0){
        $query.= ")";
        $count_query.= ")";
        if($token != ""){
          $query.= " AND title";
          $count_query.= " AND title";
        }
      }else{
        if($token != ""){
          $query .= "WHERE title";
          $count_query .= "WHERE title";
        }
      }
      if($token != ""){
        $query.= " LIKE '%".$token."%' ";
        $count_query.= " LIKE '%".$token."%' ";
      }
      $query.=" ORDER BY board_id DESC LIMIT ";
      $count_query.=" ORDER BY board_id DESC ";

    }
    $temp = ($number_of_page-1) * 5;
    $query.=$temp.",5";

    $statement = $this -> connection -> query($query);
    $result = $statement ->fetchAll();
    $statement = $this -> connection -> query($count_query);
    $count_result= $statement -> fetch(PDO::FETCH_ASSOC);
    $count = $count_result["count(*)"];
    $data = array(
      "result" => $result,
      "count" => $count
    );
    return $data;
  }catch(Exception $e){
    print ($e -> getMessage());
  }
 }
  public function get_index_array($current_page){
    $query = "SELECT count(*) FROM board";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    $count = $result["count(*)"];
    if($count % 5 == 0){
      $total_pages = (int) ($count / 5);
    }else{
      $total_pages = (int) ($count / 5) + 1;
    }
    $index_array = array();
    if($current_page % 10 == 0)
    {
      for($i = $current_page - 9; $i <= $current_page; $i++)
      {
        $index_array[] = $i;
      }
    }
    else
    {
      for($i = (int)($current_page -1 / 10) + 1; $i <= min((int)(($current_page + 9)/10) * 10, $total_pages) ; $i ++) {
        $index_array[] = $i;
      }
    }
    return $index_array;
  }
  public function get_index_array_custom($current_page, $count)
  {
    if($count % 5 == 0){
      $total_pages = (int) ($count / 5);
    }else{
      $total_pages = (int) ($count / 5) + 1;
    }
    $index_array = array();

    for($i = (((int)(($current_page-1)/10)*10) + 1); $i <= min((int)(($current_page + 9)/10) * 10, $total_pages) ; $i ++) {
      $index_array[] = $i;
    }

    return $index_array;
  }
  public function get_root_node($board_id){
    $query = "SELECT node_id FROM board_to_node WHERE board_id = ".$board_id;
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result["node_id"];
  }
  public function login($id, $password){
    $query = "SELECT count(*) FROM member WHERE member_id = \"".$id."\" and password = \"".$password."\"";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result["count(*)"];
  }
  public function signup($id, $name, $password, $password_to_confirm, $field_id){
    $query = "SELECT count(*) FROM member WHERE member_id = \"".$id."\"";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    if($result["count(*)"] > 0){
      return -1; // 중복된 아이디
    }else if($password != $password_to_confirm){
      return -2; // 비밀번호랑 비밀번호 확인이랑 불일치
    }else{
      $query = "INSERT INTO member VALUES("."\"$id\","."\"$password\","."\"$name\","."\"$field_id\")";
      $this -> connection -> exec($query);
      return 1; // 성공
    }
  }
  public function exec_query($query){
    $this->connection->exec($query);
  }
  public function login_get_name_and_field($id){
      $query = "SELECT name,field_id FROM member WHERE member_id = \"".$id."\"";
      $statement = $this -> connection -> query($query);
      $result = $statement -> fetch(PDO::FETCH_ASSOC);
      return array($result["name"],$result["field_id"]);
  }
  public function regs_auth($id, $name, $password, $password_to_confirm, $field_id,$auth){
    $query = "SELECT count(*) FROM member WHERE member_id = \"".$id."\"";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    if($result["count(*)"] > 0){
      return -1; // 중복된 아이디
    }else if($password != $password_to_confirm){
      return -2; // 비밀번호랑 비밀번호 확인이랑 불일치
    }else{
      $query = "INSERT INTO member_auth VALUES("."\"$id\","."\"$password\","."\"$name\","."\"$field_id\","."\"$auth\")";
      $this -> connection -> exec($query);
      return 1; // 성공
    }
  }
  public function auth_check($auth){
    $query = "SELECT member_id, password, name, field_id FROM member_auth WHERE auth = \"".$auth."\"";
    $statement = $this -> connection -> query($query);
    $result = $statement -> fetch(PDO::FETCH_ASSOC);

    $member_id = $result["member_id"];
    $password = $result["password"];
    $name = $result["name"];
    $field_id = $result["field_id"];

    $query = "INSERT INTO member VALUES("."\"$member_id\","."\"$password\","."\"$name\","."\"$field_id\")";
    $this -> connection -> exec($query);

    $query = "DELETE FROM member_auth WHERE auth = \"".$auth."\"";
    $this -> connection -> exec($query);

    return $result["member_id"];
  }

  public function get_publisher($node_id){
    $statement = $this ->connection-> query("SELECT publisher_id FROM node WHERE node_id = \"".$node_id."\"");
    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result["publisher_id"];
  }

  public function get_board_id($node_id){
      $query = "SELECT board_id FROM board_to_node WHERE node_id =\"".$node_id."\"";
      $statement = $this -> connection -> query($query);
      $result = $statement -> fetch(PDO::FETCH_ASSOC);
      return $result["board_id"];
  }

}

?>
