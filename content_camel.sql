-- Content Camel database schema
-- Run this in MySQL (e.g. via phpMyAdmin or the mysql CLI) to create the database and tables.

CREATE DATABASE IF NOT EXISTS `content_camel`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `content_camel`;

-- Users
CREATE TABLE IF NOT EXISTS `ContentCamelUsers` (
    `userId`   VARCHAR(32)  NOT NULL,
    `email`    VARCHAR(255) NOT NULL,
    `forename` VARCHAR(100) NOT NULL,
    `surname`  VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`userId`),
    UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories (per user)
CREATE TABLE IF NOT EXISTS `ContentCamelCategories` (
    `categoryId` VARCHAR(32)  NOT NULL,
    `userId`     VARCHAR(32)  NOT NULL,
    `name`       VARCHAR(30)  NOT NULL,
    PRIMARY KEY (`categoryId`),
    KEY `idx_user` (`userId`),
    CONSTRAINT `fk_cat_user`
        FOREIGN KEY (`userId`) REFERENCES `ContentCamelUsers` (`userId`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Posts
CREATE TABLE IF NOT EXISTS `ContentCamelPosts` (
    `postId`      VARCHAR(32)  NOT NULL,
    `userId`      VARCHAR(32)  NOT NULL,
    `title`       VARCHAR(60)  NOT NULL,
    `content`     TEXT         NOT NULL,
    `dateCreated` DATETIME     NOT NULL,
    `categoryId`  VARCHAR(32)  DEFAULT NULL,
    `isPosted`    TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (`postId`),
    KEY `idx_user` (`userId`),
    KEY `idx_category` (`categoryId`),
    CONSTRAINT `fk_post_user`
        FOREIGN KEY (`userId`) REFERENCES `ContentCamelUsers` (`userId`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_post_category`
        FOREIGN KEY (`categoryId`) REFERENCES `ContentCamelCategories` (`categoryId`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
