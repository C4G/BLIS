USE blis_revamp;

2012-05-24 17:16:32	INSERT INTO user (user_id, username, password, created_by, lab_config_id, level, lang_id) VALUES (117, 'as', '18865bfdeed2fd380316ecde609d94d7285af83f', 26, '8', 2, 'default') 
2012-05-24 17:16:32	INSERT INTO lab_config(name, location, admin_user_id, id_mode, lab_config_id, country) VALUES ('asd', 'as', 117, 1, '8', 'Cameroon')
2012-05-24 17:16:32	UPDATE lab_config SET db_name='blis_8' WHERE lab_config_id='8' 
2012-05-24 17:22:43	DELETE FROM lab_config_access WHERE lab_config_id=8
2012-05-24 17:22:43	DELETE FROM user WHERE lab_config_id=8
2012-05-24 17:22:43	DELETE FROM report_disease WHERE lab_config_id=8
2012-05-24 17:22:43	DELETE FROM lab_config WHERE lab_config_id=8
