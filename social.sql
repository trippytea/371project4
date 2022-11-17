
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
    shortTitle CHAR(16) NOT NULL,
    username VARCHAR(50) NOT NULL,
    PRIMARY KEY(postId),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE comment (
    commentId int NOT NULL AUTO_INCREMENT,
    commentContent LONGTEXT NOT NULL,
    postId int NOT NULL,
    username VARCHAR(50) NOT NULL,
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

