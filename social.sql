
CREATE TABLE users (
    username VARCHAR(50) NOT NULL,
    fName VARCHAR(50) NOT NULL,
    lName VARCHAR (50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password CHAR(60) NOT NULL,
    profilePic CHAR(60) NOT NULL,
   	PRIMARY KEY (username)
); 

CREATE TABLE friends (
    friendId int NOT NULL AUTO_INCREMENT,
    friendUsername VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    PRIMARY KEY(friendId),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (friendUsername) REFERENCES users(username)
); 

CREATE TABLE post (
    postId int NOT NULL AUTO_INCREMENT,
    postContent LONGTEXT NOT NULL,
    username VARCHAR(50) NOT NULL,
    date DATETIME NOT NULL,
    PRIMARY KEY(postId),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE comment (
    commentId int NOT NULL AUTO_INCREMENT,
    commentContent LONGTEXT NOT NULL,
    postId int NOT NULL,
    username VARCHAR(50) NOT NULL,
    date DATETIME NOT NULL,
    PRIMARY KEY(commentId),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (postId) REFERENCES post(postId)
);

CREATE TABLE postlike (
    likeId int NOT NULL AUTO_INCREMENT,
    postId int NOT NULL,
    likedBy VARCHAR(50) NOT NULL,
    PRIMARY KEY(likeId),
    FOREIGN KEY (likedBy) REFERENCES users(username),
    FOREIGN KEY (postId) REFERENCES post(postId)
);

CREATE TABLE commentlike (
    likeId int NOT NULL AUTO_INCREMENT,
    commentId int NOT NULL,
    username VARCHAR(50) NOT NULL,
    PRIMARY KEY(likeId),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (commentId) REFERENCES comment(commentId)
);

INSERT INTO users (username, fname, lname, email, password, profilePic) 
VALUES ('Grugg', 'Grug', 'Gruggerson', 'grug@hotmail.com', '$2y$10$7na2EnNVM.3jckVYm0dcyuwoPAOKL9R/LwWc/e6jzv/9NgZvijR1i', 'goblin5.png'),
        ('Krugg', 'Kris', 'Gruggerson', 'krug@hotmail.com', '$2y$10$RvhSpji66SiN9up8EfZ5y.D0QSpzrMgVk8w1.ZJJWhdsBuMxrpjpm', 'goblin2.png'),
        ('Goblin_Tom', 'Tommy', 'McGoblin', 'tom@myspace.com', '$2y$10$bzF8EmkA2xY/6Yg2VTSuqOyL8w25nbe51azppUizXBFX8OfWpMyZK', 'goblin4.png');

INSERT INTO friends (friendUsername, username)
VALUES ('Grugg','Grugg'),('Krugg','Krugg'),('Goblin_Tom','Goblin_Tom');

INSERT INTO post (postContent, username, date)
VALUES ('Goblin do no bad. Goblin only want to eat trash and take shiny gold. Why people no like goblin? World make Grugg sad. . . :(', 
         'Grugg', now()),
       ('KRUUUUUUUUUGGGGGG IS DA BEST, OH YEAH BABY!!!!', 'Krugg', now()),
       ('Welcome to the den, fellow goblin!', 'Goblin_Tom', now());