CREATE TABLE users(
  userId BIGINT UNSIGNED UNIQUE NOT NULL,
  uTimeStamp TIMESTAMP,
  userName VARCHAR(32),
  realName VARCHAR(128),
  emailAddress VARCHAR(128),
  phoneNumber VARCHAR(15),
  passwordHash VARCHAR(128),
  avatarImage VARCHAR(255),
  banned TINYINT(1),
  admin TINYINT(1),

  PRIMARY KEY(userId)
);

CREATE TABLE groups(
  groupId BIGINT UNSIGNED UNIQUE NOT NULL,
  groupName VARCHAR(128),
  gTimeStamp TIMESTAMP,
  type INT,
  creator BIGINT UNSIGNED,

  PRIMARY KEY(groupId)
);

create TABLE member_of(
  ID BIGINT UNSIGNED UNIQUE NOT NULL,
  userId BIGINT UNSIGNED,
  groupId BIGINT UNSIGNED,

  PRIMARY KEY(ID)
);

create TABLE removed_from(
  ID BIGINT UNSIGNED UNIQUE NOT NULL,
  userId BIGINT UNSIGNED,
  groupId BIGINT UNSIGNED,

  PRIMARY KEY(ID)
);