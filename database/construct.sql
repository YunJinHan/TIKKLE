DROP DATABASE tikkle;
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
  PRIMARY KEY (member_id)
);

CREATE TABLE IF NOT EXISTS board(
  board_id INTEGER AUTO_INCREMENT NOT NULL,
  publisher_id VARCHAR(30) NOT NULL,
  title VARCHAR(256) NOT NULL,
  content VARCHAR(1024) NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  category_id TINYINT NOT NULL,
  privacy_bound VARCHAR(20) NOT NULL,
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

/* Data */

INSERT INTO category(name) VALUES("IOT Device");
INSERT INTO category(name) VALUES("Web Application");
INSERT INTO category(name) VALUES("Android");
INSERT INTO category(name) VALUES("I O S");
INSERT INTO category(name) VALUES("Big Data");
INSERT INTO category(name) VALUES("Game");
INSERT INTO category(name) VALUES("Etc");

INSERT INTO field(name) VALUES("개발");
INSERT INTO field(name) VALUES("기획");
INSERT INTO field(name) VALUES("디자인");

INSERT INTO member VALUES ("wldnjs11118@gmail.com","0000","박지원",1);
INSERT INTO member VALUES ("wlsgks234@naver.com","0000","윤진한",2);
INSERT INTO node(title, publisher_id, content) VALUES ("빅데이터 전처리","wldnjs11118@gmail.com","빅데이터 전처리의 해결 방안을 찾습니다.");
INSERT INTO board(publisher_id, title, content, start_date, end_date,category_id, privacy_bound) VALUES ("wldnjs11118@gmail.com","빅데이터 전처리","빅데이터 전처리의 해결방안을 찾습니다. 보수 500만원 ㅎㅎ","2014-08-10","2016-08-13",5,"전체 공개");

INSERT INTO node(title, publisher_id, content) VALUES ("Map reduce", "wldnjs11118@gmail.com","맵리듀스를 통한 전처리");
INSERT INTO node_to_node VALUES(1,2);
INSERT INTO node(title, publisher_id, content) VALUES ("SPARK", "wldnjs11118@gmail.com","스파크를 이용한 전처리");
INSERT INTO node_to_node VALUES(1,3);
INSERT INTO node(title, publisher_id, content) VALUES ("드릴", "wldnjs11118@gmail.com","드릴을 이용한 전처리");
INSERT INTO node_to_node VALUES(1,4);
INSERT INTO node(title, publisher_id, content) VALUES ("자바 네이티브", "wldnjs11118@gmail.com","자바 네이티브를 이용한 전처리");
INSERT INTO node_to_node VALUES(1,5);
INSERT INTO node(title, publisher_id, content) VALUES ("파이썬 스파크", "wldnjs11118@gmail.com","파이썬 스파크을 이용한 전처리");
INSERT INTO node_to_node VALUES(3,6);
INSERT INTO node(title, publisher_id, content) VALUES ("파이썬 드릴", "wldnjs11118@gmail.com","파이썬 드릴을 이용한 전처리");
INSERT INTO node_to_node VALUES(4,7);
INSERT INTO node(title, publisher_id, content) VALUES ("자바 드릴", "wldnjs11118@gmail.com","자바 드릴을 이용한 전처리");
INSERT INTO node_to_node VALUES(4,8);

INSERT INTO board_to_node VALUES (1,1);

INSERT INTO board(publisher_id, title, content, start_date, end_date,category_id, privacy_bound) VALUES ("wldnjs11118@gmail.com","캡스톤 전처리","캡스톤 전처리의 해결방안을 찾습니다. 보수 500만원 ㅎㅎ","2014-08-10","2016-08-13",4,"전체 공개");
INSERT INTO node(title, publisher_id, content) VALUES ("캡스톤 전처리","wldnjs11118@gmail.com","캡스톤 이다.");

INSERT INTO node(title, publisher_id, content) VALUES ("드론","wldnjs11118@gmail.com","드론 이다.");
INSERT INTO node_to_node VALUES(9,10);

INSERT INTO board_to_node VALUES(2,9);

INSERT INTO board(publisher_id, title, content, start_date, end_date,category_id, privacy_bound) VALUES ("wldnjs11118@gmail.com","드론 전처리","드론 전처리의 해결방안을 찾습니다. 보수 500만원 ㅎㅎ","2014-08-10","2016-08-13",3,"전체 공개");
INSERT INTO node(title, publisher_id, content) VALUES ("드론 전처리","wldnjs11118@gmail.com","드론.");


INSERT INTO board_to_node VALUES(3,11);
