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
    pfp VARCHAR(255),
    recoveryKey VARCHAR(255) NOT NULL,
    PRIMARY KEY(userId)
) ENGINE = InnoDB;


-- INSERT INTO users() VALUES();
INSERT INTO users(utype,fName,lName,uName,email,pass,bio,recoveryKey) VALUES(0, 'John', 'Doe', 'john_doe', 'john.doe@example.com', 'password123', 'No Bio Made',"NONE");
INSERT INTO users(utype,fName,lName,uName,email,pass,bio,recoveryKey) VALUES(0, 'Jane', 'Doe', 'jane_doe', 'jane.doe@example.com', 'securePass', 'No Bio Made', "NONE");
INSERT INTO users(utype,fName,lName,uName,email,pass,bio,recoveryKey) VALUES(0, 'Mike', 'Smith', 'mike_smith', 'mike.smith@example.com', 'mike1234', 'No Bio Made', "NONE");
INSERT INTO users(utype,fName,lName,uName,email,pass,bio,recoveryKey) VALUES(0, 'Emily', 'Jones', 'emily_jones', 'emily.jones@example.com', 'emilysPass', 'No Bio Made', "NONE");
INSERT INTO users(utype,fName,lName,uName,email,pass,bio,recoveryKey) VALUES(0, 'Chris', 'Brown', 'chris_brown', 'chris.brown@example.com', 'chrisPass', 'No Bio Made', "NONE");

-- Create new admin account
INSERT INTO users(utype,fName,lName,uName,email,pass,bio,recoveryKey) VALUES(1, 'Admin', 'Scott', 'admin_scott', 'admin.scott@example.com', 'password', 'You can find me @ The office ;)', "NONE");


CREATE TABLE categories (
    catId INT AUTO_INCREMENT,
    userId INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    count INT NOT NULL DEFAULT 0, -- Count of posts under each category
    PRIMARY KEY(catId),
    FOREIGN KEY(userId) REFERENCES users(userId)
        ON DELETE CASCADE
) ENGINE = InnoDB;

INSERT INTO categories (userId, name, description) VALUES (1, 'Mr. Beast', 'Content related to the YouTuber Mr.Beast and his philanthropic adventures.');
INSERT INTO categories (userId, name, description) VALUES (2, 'Lord of the Rings', 'Discussions and posts about the Lord of the Rings book and movie series.');
INSERT INTO categories (userId, name, description) VALUES (3, 'Knitting', 'A place for knitting enthusiasts to share patterns, advice, and projects.');
INSERT INTO categories (userId, name, description) VALUES (4, 'Ramen', 'Exploring the world of Ramen - from instant noodles to gourmet dishes.');
INSERT INTO categories (userId, name, description) VALUES (5, 'Crisps of the World', 'A category for crisp (chip) lovers to discuss and review crisps from around the globe.');

CREATE TABLE posts (
    postId INT AUTO_INCREMENT,
    userId INT NOT NULL, 
    postDate DATETIME NOT NULL, -- use GETDATE() when inserting new posts
    title VARCHAR(255) NOT NULL,
    text VARCHAR(3000) NOT NULL, -- 3000 character cap on discussion text
    img VARCHAR(255),
    link VARCHAR(255),
    catId INT,
    likes INT NOT NULL DEFAULT 0,
    comment INT NOT NULL DEFAULT 0,
    PRIMARY KEY(postId,userId),
    FOREIGN KEY(userId) REFERENCES users(userId)
        ON DELETE CASCADE,
    FOREIGN KEY(catId) REFERENCES categories(catId)
        ON DELETE CASCADE
    
) ENGINE = InnoDB;

INSERT INTO posts(userId, title, text, link, catId, likes,comment, postDate) VALUES(1, 'Post Title 1', 'Post Text 1', 'www.link1.com', 1, 0, 1, NOW());
INSERT INTO posts(userId, title, text, link, catId, likes,comment, postDate) VALUES(2, 'Post Title 2', 'Post Text 2', 'www.link2.com', 2, 0,0, NOW());
INSERT INTO posts(userId, title, text, link, catId, likes,comment, postDate) VALUES(3, 'Post Title 3', 'Post Text 3', 'www.link3.com', 3, 0,0, NOW());
INSERT INTO posts(userId, title, text, link, catId, likes, comment, postDate) VALUES(4, 'Post Title 4', 'Post Text 4', 'www.link4.com', 4, 0,0, NOW());
INSERT INTO posts(userId, title, text, link, catId, likes,comment, postDate) VALUES(5, 'Post Title 5', 'Post Text 5', 'www.link5.com', 5, 0,0, NOW());


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
