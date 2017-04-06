# Drop all previous tables:
DROP DATABASE sc2257;
CREATE DATABASE sc2257;

USE sc2257;

# Make new tables

CREATE TABLE users(
  userId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  uTimeStamp TIMESTAMP,
  userName VARCHAR(32) NOT NULL,
  realName VARCHAR(128),
  emailAddress VARCHAR(128),
  phoneNumber VARCHAR(15),
  passwordHash VARCHAR(128) NOT NULL,
  avatarImage VARCHAR(255),
  banned TINYINT(1),
  admin TINYINT(1),

  PRIMARY KEY(userId)
);

CREATE TABLE groups(
  groupId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  groupName VARCHAR(128),
  groupDesc VARCHAR(255),
  gTimeStamp TIMESTAMP,
  gType INT,
  creator BIGINT UNSIGNED,

  PRIMARY KEY(groupId)
);

CREATE TABLE member_of(
  ID BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  userId BIGINT UNSIGNED,
  groupId BIGINT UNSIGNED,

  PRIMARY KEY(ID)
);

CREATE TABLE removed_from(
  ID BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  userId BIGINT UNSIGNED,
  groupId BIGINT UNSIGNED,

  PRIMARY KEY(ID)
);

# There should be one of these queries executed when a new group is created, so that the group has a database to
# store its messages and members in. The name should be "message_$groupId"
# CREATE TABLE messages_template(
# messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
# fromUser BIGINT UNSIGNED,
# mTimeStamp TIMESTAMP,
# upvotes INT,
# downvotes INT,
# message VARCHAR(255),
# PRIMARY KEY(messageId)
# );

#Users
INSERT INTO sc2257.users (uTimeStamp, userName, realName, emailAddress, phoneNumber, passwordHash, avatarImage, banned, admin) VALUES ('2017-04-04 19:14:18', 'asdfasdf', 'asdf', 'asdf@asdf.com', '1234567891', '401b09eab3c013d4ca54922bb802bec8fd5318192b0a75f201d8b3727429080fb337591abd3e44453b954555b7a0812e1081c39b740293f765eae731f5a65ed1', '', 0, 0);
INSERT INTO sc2257.users (uTimeStamp, userName, realName, emailAddress, phoneNumber, passwordHash, avatarImage, banned, admin) VALUES ('2017-04-06 08:57:34', 'asdfasdfasdf', 'asdfa asdfa', 'asdf@gmail.com', '1234567891', '401b09eab3c013d4ca54922bb802bec8fd5318192b0a75f201d8b3727429080fb337591abd3e44453b954555b7a0812e1081c39b740293f765eae731f5a65ed1', '', 0, 0);
INSERT INTO sc2257.users (uTimeStamp, userName, realName, emailAddress, phoneNumber, passwordHash, avatarImage, banned, admin) VALUES ('2017-03-21 16:24:09', 'asdf', 'asdf', 'asdf@asdf.com', '1234567891', '401b09eab3c013d4ca54922bb802bec8fd5318192b0a75f201d8b3727429080fb337591abd3e44453b954555b7a0812e1081c39b740293f765eae731f5a65ed1', '', 0, 0);

#Groups
INSERT INTO sc2257.groups (groupName, groupDesc, gTimeStamp, gType, creator) VALUES ('asdf1', 'this', '2017-03-21 16:30:39', 1, 1);
INSERT INTO sc2257.groups (groupName, groupDesc, gTimeStamp, gType, creator) VALUES ('asdf2', 'is', '2017-03-21 16:30:36', 1, 1);
INSERT INTO sc2257.groups (groupName, groupDesc, gTimeStamp, gType, creator) VALUES ('asdf3', 'sparta', '2017-03-21 16:30:33', 1, 1);
INSERT INTO sc2257.groups (groupName, groupDesc, gTimeStamp, gType, creator) VALUES ('asdf4', '!!!111!!!1!!11!', '2017-03-21 16:30:30', 1, 1);
INSERT INTO sc2257.groups (groupName, groupDesc, gTimeStamp, gType, creator) VALUES ('asdf5', '', '2017-04-04 16:14:07', 1, 1);
INSERT INTO sc2257.groups (groupName, groupDesc, gTimeStamp, gType, creator) VALUES ('asdf6', '', '2017-04-04 16:15:04', 1, 1);

#member_of
INSERT INTO sc2257.member_of (userId, groupId) VALUES (2, 2);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (2, 3);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (2, 4);

INSERT INTO sc2257.member_of (userId, groupId) VALUES (1, 6);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (1, 5);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (1, 4);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (1, 3);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (1, 2);
INSERT INTO sc2257.member_of (userId, groupId) VALUES (1, 1);

#removed_from

#messages tables
CREATE TABLE messages_1(
  messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  fromUser BIGINT UNSIGNED,
  mTimeStamp TIMESTAMP,
  upvotes INT,
  downvotes INT,
  message VARCHAR(255),
  PRIMARY KEY(messageId)
);

CREATE TABLE messages_2(
  messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  fromUser BIGINT UNSIGNED,
  mTimeStamp TIMESTAMP,
  upvotes INT,
  downvotes INT,
  message VARCHAR(255),
  PRIMARY KEY(messageId)
);

CREATE TABLE messages_3(
  messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  fromUser BIGINT UNSIGNED,
  mTimeStamp TIMESTAMP,
  upvotes INT,
  downvotes INT,
  message VARCHAR(255),
  PRIMARY KEY(messageId)
);

CREATE TABLE messages_4(
  messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  fromUser BIGINT UNSIGNED,
  mTimeStamp TIMESTAMP,
  upvotes INT,
  downvotes INT,
  message VARCHAR(255),
  PRIMARY KEY(messageId)
);

CREATE TABLE messages_5(
  messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  fromUser BIGINT UNSIGNED,
  mTimeStamp TIMESTAMP,
  upvotes INT,
  downvotes INT,
  message VARCHAR(255),
  PRIMARY KEY(messageId)
);

CREATE TABLE messages_6(
  messageId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  fromUser BIGINT UNSIGNED,
  mTimeStamp TIMESTAMP,
  upvotes INT,
  downvotes INT,
  message VARCHAR(255),
  PRIMARY KEY(messageId)
);

INSERT INTO sc2257.messages_1 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-03-21 16:30:30', 0, 0, '1 created the group asdf1.');

INSERT INTO sc2257.messages_2 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-03-21 16:30:30', 0, 0, '1 created the group asdf2.');
INSERT INTO sc2257.messages_2 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-04-04 19:18:29', 0, 0, 'asdf added asdfasdf to the group.');

INSERT INTO sc2257.messages_3 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-03-21 16:30:30', 0, 0, '1 created the group asdf3.');
INSERT INTO sc2257.messages_3 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-04-04 19:17:38', 0, 0, 'asdf added asdfasdf to the group.');

INSERT INTO sc2257.messages_4 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-03-21 16:30:30', 0, 0, '1 created the group asdf4.');

INSERT INTO sc2257.messages_5 (fromUser, mTimeStamp, upvotes, downvotes, message) VALUES (1, '2017-03-21 16:30:30', 0, 0, '1 created the group asdf5.');
