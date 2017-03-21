CREATE TABLE users(
  userId BIGINT UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  uTimeStamp TIMESTAMP,
  userName VARCHAR(32),
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
#CREATE TABLE messages_template(
# messageId BIGINT UNSIGNED UNIQUE NOT NULL,
# fromUser BIGINT UNSIGNED,
# mTimeStamp TIMESTAMP,
# upvotes INT,
# downvotes INT,
# message VARCHAR(255),
# PRIMARY KEY(messageId)
#);