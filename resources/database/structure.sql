DROP TABLE IF EXISTS `contact_mobile_numbers`;
DROP TABLE IF EXISTS `contact_email_addresses`;
DROP TABLE IF EXISTS `contact_addresses`;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `notes`;
DROP TABLE IF EXISTS `note_categories`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users`
(
    `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
    `name`       VARCHAR(50)  NOT NULL,
    `email`      VARCHAR(150) NOT NULL,
    `password`   VARCHAR(150) NOT NULL,
    `created_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS `note_categories`
(
    `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id`    INTEGER      NOT NULL,
    `name`       VARCHAR(100) NOT NULL,
    `created_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS notes
(
    `note_id`         INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id`         INTEGER      NOT NULL,
    `category_id`     INTEGER      NOT NULL,
    `note_title`      VARCHAR(250) NOT NULL,
    `note_note`       TEXT         NOT NULL,
    `note_created_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `note_updated_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `note_categories` (`id`)
);


CREATE TABLE IF NOT EXISTS `contacts`
(
    `id`               INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id`          INTEGER      NOT NULL,
    `mobile_number_id` INTEGER               DEFAULT NULL,
    `email_address_id` INTEGER               DEFAULT NULL,
    `address_id`       INTEGER               DEFAULT NULL,
    `name`             VARCHAR(150) NOT NULL,
    `photo`            VARCHAR(150)          DEFAULT NULL,
    `gender`           VARCHAR(150)          DEFAULT NULL,
    `created_at`       VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`       VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `contact_mobile_numbers`
(
    `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
    `contact_id` INTEGER     NOT NULL,
    `number`     INTEGER(15) NOT NULL,
    'note'       VARCHAR(500)         DEFAULT NULL,
    `created_at` VARCHAR(30) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` VARCHAR(30) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
);


CREATE TABLE IF NOT EXISTS `contact_email_addresses`
(
    `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
    `contact_id` INTEGER      NOT NULL,
    `email`      VARCHAR(150) NOT NULL,
    'note'       VARCHAR(500)          DEFAULT NULL,
    `created_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
);


CREATE TABLE IF NOT EXISTS `contact_addresses`
(
    `id`         INTEGER PRIMARY KEY AUTOINCREMENT,
    `contact_id` INTEGER      NOT NULL,
    `address`    VARCHAR(500) NOT NULL,
    `country`    VARCHAR(100)          DEFAULT NULL,
    `state`      VARCHAR(100)          DEFAULT NULL,
    `city`       VARCHAR(100)          DEFAULT NULL,
    'note'       VARCHAR(500)          DEFAULT NULL,
    `created_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` VARCHAR(30)  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`)
);