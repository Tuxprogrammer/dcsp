<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 3/7/17
 * Time: 5:20 PM
 */

//TODO: This file should mimic the structure of create_user, just with the group fields.


# There should be one of these queries executed when a new group is created, so that the group has a database to
# store its messages and members in. The name should be "message_$groupId"
#CREATE TABLE messages_template(
# messageId BIGINT UNSIGNED UNIQUE NOT NULL,
# from_USER BIGINT UNSIGNED,
# mTimeStamp TIMESTAMP,
# upvotes INT,
# downvotes INT,
# message VARCHAR(255),
# PRIMARY KEY(messageId)
#);