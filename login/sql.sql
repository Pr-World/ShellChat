-- users table
CREATE TABLE Users (
  id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  uname varchar(64) NOT NULL,
  passw_hash char(64) NOT NULL,
)

CREATE TABLE History (
    chat_line varchar(200) NOT NULL,
    id_from INT NOT NULL,
    id_to INT NOT NULL,
    chat_time BIGINT NOT NULL,
	  PRIMARY KEY (id_from, id_to, chat_time),
    CONSTRAINT FK FOREIGN KEY (id_from) REFERENCES Users(id),
    CONSTRAINT FK2 FOREIGN KEY (id_to) REFERENCES Users(id)
)