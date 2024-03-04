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
    PRIMARY KEY(userId)
) ENGINE = InnoDB;

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

CREATE TABLE posts (
    postId INT AUTO_INCREMENT,
    userId INT NOT NULL, 
    postDate DATETIME NOT NULL, -- use GETDATE() when inserting new posts
    title VARCHAR(255) NOT NULL,
    text VARCHAR(3000) NOT NULL, -- 3000 character cap on discussion text
    img BLOB,
    link VARCHAR(255) NOT NULL,
    catId INT NOT NULL,
    likes INT NOT NULL DEFAULT(0),
    PRIMARY KEY(postId,userId),
    FOREIGN KEY(userId) REFERENCES users(userId)
        ON DELETE CASCADE,
    FOREIGN KEY(catId) REFERENCES categories(catId)
        ON DELETE CASCADE
) ENGINE = InnoDB;

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