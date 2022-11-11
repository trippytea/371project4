
CREATE TABLE users (
    username VARCHAR(60) NOT NULL,
    fName VARCHAR(60) NOT NULL,
    lName VARCHAR (60) NOT NULL,
    email VARCHAR(60) NOT NULL,
    password CHAR(60) NOT NULL,
    profilePic CHAR(60) NOT NULL,
   	PRIMARY KEY (username)
); 

CREATE TABLE post (
    postId int NOT NULL AUTO_INCREMENT,
    postContent LONGTEXT NOT NULL,
    shortTitle CHAR(16) NOT NULL,
    username VARCHAR(60) NOT NULL,
    PRIMARY KEY(postId),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE comment (
    commentId int NOT NULL AUTO_INCREMENT,
    commentContent LONGTEXT NOT NULL,
    postId int NOT NULL,
    username VARCHAR(60) NOT NULL,
    PRIMARY KEY(commentId),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (postId) REFERENCES post(postId)
);

CREATE TABLE postlike (
    likeId int NOT NULL AUTO_INCREMENT,
    postId int NOT NULL,
    username VARCHAR(60) NOT NULL,
    PRIMARY KEY(likeId),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (postId) REFERENCES post(postId)
);

CREATE TABLE commentlike (
    likeId int NOT NULL AUTO_INCREMENT,
    commentId int NOT NULL,
    username VARCHAR(60) NOT NULL,
    PRIMARY KEY(likeId),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (commentId) REFERENCES comment(commentId)
);

