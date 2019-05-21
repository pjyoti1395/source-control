CREATE TABLE `tbl_followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_repository` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `language` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rep_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_repository_star` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `repository_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `user_name` varchar(45) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_db`.`vw_followers` AS select `a`.`id` AS `id`,`a`.`user_id` AS `user_id`,`b`.`user_name` AS `user_name`,`a`.`follower_id` AS `follower_id`,`c`.`user_name` AS `follower_name`,`a`.`created_at` AS `created_at` from ((`company_db`.`tbl_followers` `a` join `company_db`.`tbl_user` `b` on((`a`.`user_id` = `b`.`user_id`))) join `company_db`.`tbl_user` `c` on((`a`.`follower_id` = `c`.`user_id`)));
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_db`.`vw_followers_by_user` AS select `a`.`id` AS `id`,`a`.`user_id` AS `user_id`,`b`.`user_name` AS `user_name`,`a`.`follower_id` AS `follower_id`,`c`.`user_name` AS `follower_name`,`a`.`created_at` AS `created_at` from ((`company_db`.`tbl_followers` `a` join `company_db`.`tbl_user` `b` on((`a`.`user_id` = `b`.`user_id`))) join `company_db`.`tbl_user` `c` on((`a`.`follower_id` = `c`.`user_id`))) order by `a`.`created_at` desc;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_db`.`vw_repository_star_all` AS select `rs`.`id` AS `id`,`rs`.`user_id` AS `user_id`,`u`.`user_name` AS `user_name`,`rs`.`repository_id` AS `repository_id`,`r`.`name` AS `repository_name`,`rs`.`created_at` AS `created_at` from ((`company_db`.`tbl_repository_star` `rs` join `company_db`.`tbl_user` `u` on((`rs`.`user_id` = `u`.`user_id`))) join `company_db`.`tbl_repository` `r` on((`rs`.`repository_id` = `r`.`rep_id`)));
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_db`.`vw_repository_star_by_rep` AS select `rs`.`id` AS `id`,`rs`.`user_id` AS `user_id`,`u`.`user_name` AS `user_name`,`rs`.`repository_id` AS `repository_id`,`r`.`name` AS `repository_name`,`rs`.`created_at` AS `created_at` from ((`company_db`.`tbl_repository_star` `rs` join `company_db`.`tbl_user` `u` on((`rs`.`user_id` = `u`.`user_id`))) join `company_db`.`tbl_repository` `r` on((`rs`.`repository_id` = `r`.`rep_id`)));
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `company_db`.`vw_repository_star_by_user` AS select `rs`.`id` AS `id`,`rs`.`user_id` AS `user_id`,`u`.`user_name` AS `user_name`,`rs`.`repository_id` AS `repository_id`,`r`.`name` AS `name`,`rs`.`created_at` AS `created_at` from ((`company_db`.`tbl_repository_star` `rs` join `company_db`.`tbl_user` `u` on((`rs`.`user_id` = `u`.`user_id`))) join `company_db`.`tbl_repository` `r` on((`rs`.`user_id` = `r`.`user_id`)));

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleting_user_data`(IN _user_id INT)
BEGIN
	DELETE FROM tbl_user WHERE user_id = _user_id;
    DELETE FROM tbl_repository WHERE user_id = _user_id;
    DELETE FROM tbl_followers WHERE user_id = _user_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_rep_summary`(IN _rep_id INT)
BEGIN
	-- user's repositories
    SELECT rep_id, user_id, name, description, language, created_at, updated_at,
    (SELECT COUNT(repository_id) FROM tbl_repository_star WHERE repository_id = _rep_id)  AS count_star_repository
    FROM tbl_repository WHERE rep_id = _rep_id;
    
    -- star repository
    SELECT COUNT(repository_id) AS count_star_repository FROM tbl_repository_star WHERE repository_id = _rep_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_all_data`(IN _user_id INT)
BEGIN
	SELECT * FROM tbl_user WHERE user_id = _user_id;
    SELECT * FROM tbl_repository WHERE user_id = _user_id;
    SELECT * FROM vw_followers WHERE user_id = _user_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_summary`(IN _user_id INT)
BEGIN

	DECLARE countRepository INT DEFAULT 0;
    DECLARE countStarRepository INT DEFAULT 0;
    DECLARE countFollowers INT DEFAULT 0;
    DECLARE countFollowing INT DEFAULT 0;

	-- user
    SELECT * FROM tbl_user WHERE user_id = _user_id;
    
    -- user's repostories
    SELECT * FROM tbl_repository WHERE user_id = _user_id ORDER BY created_at DESC LIMIT 6;
    
    -- set count values
    SET countRepository 	= (SELECT COUNT(rep_id) AS count_repository FROM tbl_repository  WHERE user_id = _user_id);
    SET countStarRepository	= (SELECT COUNT(repository_id) AS count_star_repository FROM tbl_repository_star  WHERE user_id = _user_id);
    SET countFollowers		= (SELECT COUNT(follower_id) AS count_follower FROM tbl_followers WHERE user_id = _user_id);
    SET countFollowing 		= (SELECT COUNT(user_id) AS count_following FROM tbl_followers WHERE follower_id = _user_id);
    
    -- count
    SELECT 	countRepository AS 'count_repository',
			countStarRepository AS 'count_star_repository',
            countFollowers AS 'count_followers',
            countFollowing AS 'count_following';

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_repository`(
	IN _repository_id INT,
	IN _name VARCHAR(50),
	IN _description VARCHAR(150),
	IN _language VARCHAR(50)
)
BEGIN

	SET SQL_SAFE_UPDATES = 0;

    UPDATE tbl_repository
	SET    name = _name,
		   description = _description,
		   language = _language,		   
		   updated_at = sysdate()
	WHERE  repository_id = _repository_id;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user`(
	IN _user_id INT,
	IN _first_name VARCHAR(50),
	IN _last_name VARCHAR(50),
	IN _user_name VARCHAR(60),
	IN _password VARCHAR(50),
	IN _email VARCHAR(80),
	IN _mobile_no BIGINT
)
BEGIN

	SET SQL_SAFE_UPDATES = 0;
    
	UPDATE tbl_user 
    SET    first_name = _first_name,
		   last_name = _last_name,
           user_name = _user_name,
           password = _password,
           email = _email,
           mobile_no = _mobile_no
	WHERE  user_id = _user_id;    
    
END$$
DELIMITER ;
