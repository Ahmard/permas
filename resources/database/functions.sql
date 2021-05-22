DROP FUNCTION IF EXISTS `createAccount`;

DELIMITER $$

CREATE FUNCTION `createAccount`(
    _username VARCHAR(50),
    _email VARCHAR(150),
    _password VARCHAR(150)
) RETURNS VARCHAR(50) DETERMINISTIC
BEGIN
    DECLARE existingUsername VARCHAR(50) DEFAULT NULL;
    DECLARE existingEmail VARCHAR(150) DEFAULT NULL;

    SELECT `username`, `email`
    INTO existingUsername, existingEmail
    FROM users
    WHERE `email` = _email
       OR `username` = _username
    LIMIT 1;

    IF existingUsername = _username THEN
        RETURN 'username exists';
    END IF;

    IF existingEmail = _email THEN
        RETURN 'email exists';
    END IF;

    INSERT INTO `users`(username, email, password) VALUE (_username, _email, _password);
    RETURN CONVERT(LAST_INSERT_ID() USING utf8);
END
$$