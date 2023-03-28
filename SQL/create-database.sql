DROP DATABASE IF EXISTS projet_we4a;
CREATE DATABASE IF NOT EXISTS projet_we4a;
USE projet_we4a;


DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS user
(
    idUser INT          NOT NULL AUTO_INCREMENT,
    username  VARCHAR(20)  NOT NULL,
    passwd VARCHAR(100) NOT NULL,
    idRole INT          DEFAULT 1,
    avatar VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (idUser)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS category;
CREATE TABLE IF NOT EXISTS category
(
    idCategory   INT         NOT NULL AUTO_INCREMENT,
    nameCategory VARCHAR(50) NOT NULL,
    PRIMARY KEY (idCategory)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS post;
CREATE TABLE IF NOT EXISTS post
(
    idPost     INT          NOT NULL AUTO_INCREMENT,
    title      VARCHAR(100) NOT NULL,
    content    VARCHAR(500) NOT NULL,
    datePost   DATETIME     DEFAULT NOW(),
    idUser     INT          NOT NULL,
    idCategory INT          NOT NULL,
    PRIMARY KEY (idPost),
    FOREIGN KEY (idUser) REFERENCES user (idUser),
    FOREIGN KEY (idCategory) REFERENCES category (idCategory)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS comment;
CREATE TABLE IF NOT EXISTS comment
(
    idComment INT          NOT NULL AUTO_INCREMENT,
    idUser    INT          NOT NULL,
    content   VARCHAR(500) NOT NULL,
    PRIMARY KEY (idComment),
    FOREIGN KEY (idUser) REFERENCES user (idUser)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS comment_post;
CREATE TABLE IF NOT EXISTS comment_post
(
    idComment INT NOT NULL,
    idPost    INT NOT NULL,
    PRIMARY KEY (idComment),
    FOREIGN KEY (idComment) REFERENCES comment (idComment),
    FOREIGN KEY (idPost) REFERENCES post (idPost)
) ENGINE = InnoDB;

DROP TABLE IF EXISTS comment_thread;
CREATE TABLE IF NOT EXISTS comment_thread
(
    idComment     INT NOT NULL,
    idCommentResp INT NOT NULL,
    PRIMARY KEY (idComment),
    FOREIGN KEY (idComment) REFERENCES comment (idComment),
    FOREIGN KEY (idCommentResp) REFERENCES comment (idComment)
) ENGINE = InnoDB;



CREATE USER IF NOT EXISTS 'ProjetWE4A'@'localhost' IDENTIFIED BY '1P1rSOm2V&&w';
GRANT SELECT, INSERT, DELETE, UPDATE ON user TO 'ProjetWE4A'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON category TO 'ProjetWE4A'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON post TO 'ProjetWE4A'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON comment TO 'ProjetWE4A'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON comment_post TO 'ProjetWE4A'@'localhost';
GRANT SELECT, INSERT, DELETE, UPDATE ON comment_thread TO 'ProjetWE4A'@'localhost';
