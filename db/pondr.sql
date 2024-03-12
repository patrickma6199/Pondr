/*  
    This is the initial iteration of our DDL schema for Pondr. Structures
    May be altered at later dates to fit our potentially evolving requirements.
*/

CREATE DATABASE pondr; -- Use only in the first iteration to generate the database
USE pondr;

CREATE TABLE users (
    userId INT AUTO_INCREMENT,
    utype BIT(1) NOT NULL, -- 0 if normal user, 1 if admin
    fName VARCHAR(255) NOT NULL,
    lName VARCHAR(255) NOT NULL,
    uName VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    bio VARCHAR(1000) NOT NULL, -- will be "No Bio Made" by default
    pfp BLOB,
    recoveryKey VARCHAR(32),
    PRIMARY KEY(userId)
) ENGINE = InnoDB;


-- INSERT INTO users() VALUES();
INSERT INTO users(utype,fName,lName,uName,email,pass,bio) VALUES(0, 'John', 'Doe', 'john_doe', 'john.doe@example.com', 'password123', 'No Bio Made');
INSERT INTO users(utype,fName,lName,uName,email,pass,bio) VALUES(0, 'Jane', 'Doe', 'jane_doe', 'jane.doe@example.com', 'securePass', 'No Bio Made');
INSERT INTO users(utype,fName,lName,uName,email,pass,bio) VALUES(0, 'Mike', 'Smith', 'mike_smith', 'mike.smith@example.com', 'mike1234', 'No Bio Made');
INSERT INTO users(utype,fName,lName,uName,email,pass,bio) VALUES(0, 'Emily', 'Jones', 'emily_jones', 'emily.jones@example.com', 'emilysPass', 'No Bio Made');
INSERT INTO users(utype,fName,lName,uName,email,pass,bio) VALUES(0, 'Chris', 'Brown', 'chris_brown', 'chris.brown@example.com', 'chrisPass', 'No Bio Made');

-- Create new admin account

CREATE TABLE categories (
    catId INT AUTO_INCREMENT,
    userId INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    count INT NOT NULL DEFAULT(0), -- Count of posts under each category
    PRIMARY KEY(catId),
    FOREIGN KEY(userId) REFERENCES users(userId)
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO categories(userId,Name) VALUES(1,'Category 1');
INSERT INTO categories(userId,Name) VALUES(2,'Category 2');
INSERT INTO categories(userId,Name) VALUES(3,'Category 3');
INSERT INTO categories(userId,Name) VALUES(4,'Category 4');
-- 5 deleted

CREATE TABLE posts (
    postId INT AUTO_INCREMENT,
    userId INT NOT NULL, 
    postDate DATETIME NOT NULL, -- use GETDATE() when inserting new posts
    title VARCHAR(255) NOT NULL,
    text VARCHAR(3000) NOT NULL, -- 3000 character cap on discussion text
    img BLOB,

    link VARCHAR(255),
    catId INT,
    likes INT NOT NULL DEFAULT(0),
    PRIMARY KEY(postId,userId),
    FOREIGN KEY(userId) REFERENCES users(userId)
        ON DELETE CASCADE,
    FOREIGN KEY(catId) REFERENCES categories(catId)
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO posts(userId, title, text, link, catId, likes, postDate) VALUES(1, 'Post Title 1', 'Post Text 1', 'www.link1.com', 1, 0, '20120618 10:34:09 AM');
-- INSERT INTO posts(userId, title, text, link, catId, likes,postDate) VALUES(2, 'Post Title 2', 'Post Text 2', 'www.link2.com', 2, 0, GETDATE());
-- INSERT INTO posts(userId, title, text, link, catId, likes,postDate) VALUES(3, 'Post Title 3', 'Post Text 3', 'www.link3.com', 3, 0, GETDATE());
-- INSERT INTO posts(userId, title, text, link, catId, likes, postDate) VALUES(4, 'Post Title 4', 'Post Text 4', 'www.link4.com', 4, 0, GETDATE());
-- INSERT INTO posts(userId, title, text, link, catId, likes,postDate) VALUES(5, 'Post Title 5', 'Post Text 5', 'www.link5.com', 5, 0, GETDATE());


CREATE TABLE comments (
    comId INT AUTO_INCREMENT,
    userId INT NOT NULL,
    postId INT NOT NULL,
    parentComId INT, -- if sub comment, user comment id, if not sub comment, enter null (can maybe come up with better method)
    comDate DATETIME NOT NULL, -- same thing with GETDATE()
    text VARCHAR(3000) NOT NULL, -- 3000 character cap on dicussion comments'
    PRIMARY KEY(comId,userId),
    FOREIGN KEY(postId) REFERENCES posts(postId)
        ON DELETE CASCADE,
    FOREIGN KEY(parentComId) REFERENCES comments(comId)
        ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE likes (
    likesId INT AUTO_INCREMENT,
    userId INT NOT NULL,
    postId INT NOT NULL,
    PRIMARY KEY(likesId),
    FOREIGN KEY(postId) REFERENCES posts(postId)
        ON DELETE CASCADE,
    FOREIGN KEY(userId) REFERENCES users(userId)
        ON DELETE CASCADE
)ENGINE = InnoDB;
