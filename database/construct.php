<?php
try{
  require_once("database.php");
  $database = new Database("localhost");

  $construct_file = file("../database/construct.sql");
  $database -> exec_query(
    "DROP DATABASE tikkle;
    CREATE DATABASE IF NOT EXISTS tikkle;
    USE tikkle;
    CREATE TABLE IF NOT EXISTS category(
      category_id TINYINT AUTO_INCREMENT,
      name VARCHAR(20) NOT NULL,
      PRIMARY KEY(category_id)
    );

    CREATE TABLE IF NOT EXISTS field(
      field_id TINYINT AUTO_INCREMENT NOT NULL,
      name VARCHAR(30) NOT NULL,
      PRIMARY KEY (field_id)
    );

    CREATE TABLE IF NOT EXISTS member(
      member_id VARCHAR(30) NOT NULL,
      password VARCHAR(15) NOT NULL,
      name VARCHAR(10) NOT NULL,
      field_id TINYINT NOT NULL,
      PRIMARY KEY (member_id),
      FOREIGN KEY (field_id) REFERENCES field(field_id)
    );

    CREATE TABLE IF NOT EXISTS board(
      board_id INTEGER AUTO_INCREMENT NOT NULL,
      publisher_id VARCHAR(30) NOT NULL,
      title VARCHAR(256) NOT NULL,
      content VARCHAR(8192) NOT NULL,
      start_date DATE NOT NULL,
      end_date DATE NOT NULL,
      category_id TINYINT NOT NULL,
      privacy_bound TINYINT NOT NULL,
      PRIMARY KEY (board_id),
      FOREIGN KEY (publisher_id) REFERENCES member(member_id),
      FOREIGN KEY (category_id) REFERENCES category(category_id)
    );

    CREATE TABLE IF NOT EXISTS node(
      node_id INTEGER AUTO_INCREMENT NOT NULL,
      title VARCHAR(50) NOT NULL,
      publisher_id VARCHAR(30) NOT NULL,
      content VARCHAR(300) NOT NULL,
      PRIMARY KEY(node_id),
      FOREIGN KEY(publisher_id) REFERENCES member(member_id)
    );

    CREATE TABLE IF NOT EXISTS board_to_node(
      board_id INTEGER NOT NULL,
      node_id INTEGER NOT NULL,
      PRIMARY KEY (board_id, node_id),
      FOREIGN KEY (board_id) REFERENCES board(board_id),
      FOREIGN KEY (node_id) REFERENCES node(node_id)
    );

    CREATE TABLE IF NOT EXISTS node_to_node(
      parent_id INTEGER NOT NULL,
      child_id INTEGER NOT NULL,
      PRIMARY KEY(parent_id, child_id),
      FOREIGN KEY(parent_id) REFERENCES node(node_id),
      FOREIGN KEY(child_id) REFERENCES node(node_id)
    );

    CREATE TABLE IF NOT EXISTS member_auth(
      member_id VARCHAR(30) NOT NULL,
      password VARCHAR(15) NOT NULL,
      name VARCHAR(10) NOT NULL,
      field_id TINYINT NOT NULL,
      auth VARCHAR(10) NOT NULL
    );
    ");
    $database -> exec_query('
    INSERT INTO category(name) VALUES("IOT Device");
    INSERT INTO category(name) VALUES("Web Application");
    INSERT INTO category(name) VALUES("Android");
    INSERT INTO category(name) VALUES("IOS");
    INSERT INTO category(name) VALUES("Big Data");
    INSERT INTO category(name) VALUES("Game");
    INSERT INTO category(name) VALUES("Etc");

    INSERT INTO field(name) VALUES("개발");
    INSERT INTO field(name) VALUES("기획");
    INSERT INTO field(name) VALUES("디자인");
    ');
    $database -> exec_query('
    INSERT INTO member VALUES ("wldnjs11118@gmail.com","0000","박지원",1);
    INSERT INTO member VALUES ("wlsgks234@naver.com","0000","윤진한",1);
    INSERT INTO member VALUES ("pjh08190819@naver.com","0000","박진혁",1);
    INSERT INTO member VALUES ("qkrtmdgh1207@naver.com","0000","박승호",1);
    INSERT INTO member VALUES ("warham1@naver.com","0000","박진경",1);
    INSERT INTO member VALUES ("pjh08190819@hanyang.ac.kr","0000","손재희",2);
    INSERT INTO member VALUES ("jinhan_1030@nate.com","0000","윤솔한",3);
    INSERT INTO member VALUES ("pjh08190819@gmail.com","0000","손윤주",3);
    INSERT INTO member VALUES ("wlsgks234@gmail.com","0000","최효은",2);
    INSERT INTO member VALUES ("am520@nate.com","0000","박성아",3);
    INSERT INTO member VALUES ("wldnjs11118@hanyang.ac.kr","0000","배예리",2);
    ');

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);
    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",2,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wldnjs11118@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wldnjs11118@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","jinhan_1030@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",5,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","wlsgks234@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("wlsgks234@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",1,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","am520@nate.com","Test board 입니다.\n", 0);
    $database -> insert_board("am520@nate.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",7,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","pjh08190819@gmail.com","Test board 입니다.\n", 0);
    $database -> insert_board("pjh08190819@gmail.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",6,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","warham1@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("warham1@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",4,$root_node_id,0);

    $root_node_id = $database -> insert_node("Test Page","qkrtmdgh1207@naver.com","Test board 입니다.\n", 0);
    $database -> insert_board("qkrtmdgh1207@naver.com","Test Board".$root_node_id,"Test Board 입니다","2016-11-20","2017-02-28",3,$root_node_id,0);

    $root_node_id = $database -> insert_node("웹 / 모바일웹","wlsgks234@naver.com","플랫폼 구축 후 앱화 로고 디자인 작업", 0);
    $database -> insert_board("wlsgks234@naver.com","부동산 중개 플랫폼","<프로젝트 진행 방식>

초기 오프라인 미팅 1회
주 2회 이상 미팅 ( 화 / 금 )
재택근무

작업 시작 예상일 :
+ 2017년 1월 둘째주

<프로젝트의 현재 상황>

기획자는 없지만 스토리보드 작성 진행 중 ( 80% 정도 ) / 보안요청
웹 / 모바일웹 플랫폼 구축 후 앱화 예정
로고 디자인 작업 되어있음

<상세한 업무 내용>

부동산 분양 중개 웹서비스 구축을 의뢰드립니다.

필요 요소 : 서버 및 웹관리자 , 클라이언트 ( pc / mobile web ), 디자인

간략 기능 요약 :
+ 회원가입 , 간편 로그인
+ 회원분류 : 일반유저, 매물등록회원(부동산) , 관리자
+ 분양매물등록/수정 ( 관리자 승인 필 )
+ 지도 UI 기반 서비스
+ 매물 검색 ( 지역,지하철 역주변 등 )
+ 매물 찜, 최근본방리스트
+ 매물 공유, 매물 상세 페이지
+ 매물관련 문의하기 ( 쪽지 / SMS / 이메일 발송 )

요청 사항 :
+ 특수매물(카테고리로 분류)을 소유한 부동산에게 금액 역제안 기능 (역경매)
-- 상기 기능 포함/미포함 견적 부탁드립니다.

BM모델은 타 중개 플랫폼과 유사한 광고/회원제를 채택합니다.

<참고 자료/유의 사항>

[참고자료]
트러스트부동산 / 두꺼비세상 (99% 유사)
직방 / 다방과 (초기 서비스와 유사)","2016-09-01","2017-06-28",5,$root_node_id,0);
    $parent_node_id = $database -> insert_node("지도 UI", "am520@nate.com","지도 UI 기반 서비스 제공 및 매물 검색 ( 지역,지하철 역주변 등 ) / 매물 찜, 최근본방리스트", $root_node_id);
    $parent_node_id = $database -> insert_node("BM모델", "wldnjs11118@gmail.com","BM모델은 타 중개 플랫폼과 유사한 광고/회원제를 채택합니다.", $root_node_id);
    $database -> insert_node("매물관련 문의", "wldnjs11118@gmail.com","쪽지 / SMS / 이메일 발송.",$parent_node_id);

    $root_node_id = $database -> insert_node("음악 반주어플","wldnjs11118@gmail.com","음악 및 소셜 동영상 서비스 개발 경험이 있으신 모바일 앱 개발자 분을 찾고 있습니다.", 0);
    $database -> insert_board("wldnjs11118@gmail.com","음악 반주","<프로젝트 진행 방식>

사전 미팅 시 협의 후 조정 가능합니다.

<프로젝트의 현재 상황>

출시 직전 소스코드 리팩토링 및 추가 기능 보완 작업을 계획중입니다.
내부 디자이너/ 전체 서비스 PM 있습니다.

서버, db 쪽은 내부에서 담당할 팀이 있습니다.

<상세한 업무 내용>

음악 반주애플리케이션을 출시하고자 합니다.

음악 및 소셜 동영상 서비스 개발 경험이 있으신
모바일 앱 개발자 분을 찾고 있습니다.

필요 요소 :
+ Android (Java) 앱 개발
+ iOS (Objective-C) 앱 개발
+ 오류 사항 점검 및 보완 / 추가 기획 기능들에 대한 구현

본 서비스를 이용하는 유저의 종류는 다음과 같습니다.
+ 클래식 음악 (성악/기악) 전공자
+ 클래식 음악 연주 취미자

주요 업무 :
+ 미디어 플레이어 보완
+ 사용자들 간 커뮤니케이션 기능 강화( 메신저 기능 추가- 채팅 기능 )
+ 앱 클라이언트 단 인앱 연동
+ 녹음/녹화 기능 개선
+ 앱단 곡 검색 기능 강화

기존 앱 클라이언트 수정/보완 개발 업무입니다.
ios의 경우 출시되었으며 안드로이드는 마켓 등록 전입니다.

세부 기획이 변경될 수 있으며, 파트너스 분들의 제안을 적극 수용하고자 합니다.

<참고자료 / 유의사항>

참고 서비스 : Sing!Karaoke, EverySing

유지보수 성격의 업무이므로 ( 2차개발로 이해해주시면 편할 듯 합니다.)
4개월간 진행할 예정입니다.","2016-11-13","2017-01-01",5,$root_node_id,0);
    $parent_node_id = $database -> insert_node("Android", "am520@nate.com","Android 기반 전체적인 어플 개발", $root_node_id);
    $parent_node_id = $database -> insert_node("iOS", "wlsgks234@gmail.com","iOS 기반 전체적인 어플 개발", $root_node_id);
      $database -> insert_node("미디어 플레이어", "wlsgks234@naver.com","웹 미디어 플레이어 구축",$parent_node_id);
    $parent_node_id = $database -> insert_node("커뮤니케이션 기능", "wldnjs11118@gmail.com","Drill을 이용해 커뮤니케이션 기능", $root_node_id);
      $database -> insert_node("앱 클라이언트", "am520@nate.com","앱 클라이언트을 이용한 전처리. 경험상 파이썬을 사용하는 것이 개발 효율이 더 좋고 웹 서버도 파이썬으로 하는 게 더 편리합니다.",$parent_node_id);
      $database -> insert_node("녹음/녹화", "wldnjs11118@hanyang.ac.kr","녹음/녹화을 이용한 전처리를 해본 경험이 있습니다! 관련 자료 https://github.com/WEBTIKKLE/TIKKLE",$parent_node_id);
    $parent_node_id = $database -> insert_node("앱단 곡 검색", "am520@nate.com","앱단 곡 검색 - 자바 네이티브를 이용한 전처리", $root_node_id);
    $parent_node_id = $database -> insert_node("빅데이터 전처리 툴 개발","wldnjs11118@gmail.com","빅데이터 전처리의 해결 방안을 찾습니다.", $root_node_id);
    $parent_node_id = $database -> insert_node("UI / UX", "pjh08190819@gmail.com","편리한 UI 또한 중요하다고 생각합니다!", $root_node_id);
      $database -> insert_node("Sin Karaoke", "pjh08190819@gmail.com","Column관련 UI에 대한 아이디어를 갖고 있습니다. 관련자료 https://github.com/bakjeeone/hatchery",$parent_node_id);

    $root_node_id = $database -> insert_node("Eat City","pjh08190819@naver.com","Eat City 글로벌 맛집 예약 및 결제 플랫폼 구축.\n 이와 관련된 UI/UX 및 프로그램 개발자를 모집하고 있습니다. \n경력자는 경력과 관련한 링크를 남겨주세요.", 0);
    $database -> insert_board("pjh08190819@naver.com","Eat City","<프로젝트 진행 방식>

사전 미팅 진행 후 계약할 파트너스를 선정할 예정입니다.
계약 진행 간 주단위 온/오프라인 미팅을 요청드립니다.

<프로젝트의 현재 상황>

사업 기획은 완료되었으며, 현재 IT 서비스 진행 경험은 없습니다.
내부 인력 중 IT 서비스 경험이 있으신 분도 없기에 파트너스님의 역할이 매우 중요합니다.

<상세한 업무 내용>

여행지 현지의 맛집에 대한 정보를 볼 수 있으며,
예약/주문/결제까지 한번에 진행할 수 있는 플랫폼을 개발하고자 합니다.

필요 요소 :

+ 서비스 기획 / 웹, 앱 디자인
+ 반응형 웹 개발 / 안드로이드, IOS 앱 개발
+ 서버 구축 및 관리자페이지

현재 계획으로는 반응형웹 개발 후 이를 토대로
하이브리드앱으로 포팅하는 방식으로 개발을 진행하고자 합니다.
( 기획 시 변경될 수 있으며, 파트너스분들의 제안을 적극 수용하고자 합니다. )

본 서비스에 참여하는 유저의 종류는 다음과 같습니다.
+ 여행객 - 일반 유저
+ 맛집 업체 - 여행지 현지에 위치한 업체 유저입니다.
+ 서비스 운영관리자

요구 사항 :
+ 시스템에서 개인의 취향에 맞춘 맛집 정보를 추천해줍니다.
+ 지역별 여행 정보가 제공됩니다.( 무료 정보이며 관리자에서 등록하게 됩니다. )
+ 여행지에 위치한 맛집 정보들을 검색할 수 있습니다. ( 검색 조건 중 여행 일정이 추가됩니다. )
+ 여행지에 위치한 맛집 방문 예약을 진행할 수 있습니다.
+ 여행지에 위치한 맛집에서 주문할 메뉴를 미리 볼 수 있으며 예약 시 선주문/선결제를 진핼할 수 있습니다.
+ 저희가 기획하여 제공하는 프로모션/특별 메뉴등 또한 유저들이 이용할 수 있습니다.
+ 여행자는 서비스를 제공받은 후 평점/리뷰등의 feedback을 남길 수 있습니다.

+ 맛집(식당 업체)는 개별적인 소개 및 예약/결제 페이지가 주어지면 관련 정보를 수정/관리할 수 있습니다.
+ 결제 프로세스는 선결제/현장 결제로 구상중에 있으며, 시스템 상에서의 지원은 기획단계에서 세부 프로세스가 정의될 예정입니다.
+ 정산 프로세스를 운영 관리자가 관리자용 페이지에서 효율적으로 관리/진행 가능해야 합니다.
+ 1차 런칭은 한국어, 영어, 중국어를 기반으로 우선적으로 진행합니다. ( 차후, 여러가지의 언어를 지원할 예정입니다. )

업체용 화면에 대해서는 현재 별도의 웹으로 진행할지,
혹은 업체용 앱까지 같이 출시할 지 결정되지 않았습니다.
( 기획단계에서 해당 업무에 대한 범위 확정 예정입니다. )

식사 금액 정산에 대한 부분은 현재 내부에서 구상중에 있으며,
현재까지 나온 구상안으로는 송금 혹은 저희 회사 카드를 통해 주기적인 온라인결제 진행입니다.

하기의 'Open Table’의 서비스 프로세스가 저희가 생각하는 프로세스와 유사합니다.
미팅 참여 전, Open Table을 상세히 검토 후 제안해주시기 바랍니다.

<참고자료 / 유의사항>

참고 서비스 : AirBnB, Open Table

기획 단계에서 효울적인 서비스 운영과 관리를 위한 많은 조언을 기대하고 있습니다.
( 글로벌 사이트 런칭 경험 혹은 관련 개발 경험이 있으신 분을 우대합니다. )","2016-11-20","2017-02-28",3,$root_node_id,0);
    $parent_node_id = $database -> insert_node("웹 소켓 프로그래밍", "am520@nate.com","웹 소켓 프로그래밍 계열 가능자입니다. 관련 주소 https://www.google.com ", $root_node_id);
    $parent_node_id = $database -> insert_node("AUTH 2.0 인증 개발 가능자", "wlsgks234@gmail.com","결제 인증 시스템 개발자 입니다. 관련 자료 https://www.naver.com", $root_node_id);
    $parent_node_id = $database -> insert_node("웹, 앱 디자인", "pjh08190819@naver.com","금융 API 사용 경력자 우대합니다.\n 경력자는 경력과 관련한 링크를 남겨주세요.", $root_node_id);

    print ("database setting is success\n");
}catch(Exception $e){
  print "ERROR";
  print $e -> getMessage();
}
?>
