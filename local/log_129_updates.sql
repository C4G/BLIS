USE blis_129;

INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
UPDATE test_type SET target_tat=40 WHERE test_type_id=90;
DELETE FROM reference_range WHERE measure_id=98;
UPDATE measure SET name='ASLO', range=':', unit='IU/ml' WHERE measure_id=98;
UPDATE test_type SET name='ASLO', description='Antistreptolysin o', clinical_data='', test_category_id='1', hide_patient_name='0', prevalence_threshold=70, target_tat=60 WHERE test_type_id=92;
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (98, '0', '100', 'B', '200', '400');
INSERT INTO patient_daily (datestring, count) VALUES ('20120301', 1);
INSERT INTO specimen_session(session_num, count) VALUES ('20120301', 1);
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (16971, '', 'Sw/05/kg', 0, 'M', '1982-03-01', '00381', 116, '88699c1eac34a90d5c41db0b6fdea0308f6f985f', '2012-03-01 00:00:00');
update patient_daily set count=2 where datestring='20120301' ;
UPDATE specimen_session SET count=2 WHERE session_num='20120301';
update patient_daily set count=3 where datestring='20120301' ;
UPDATE specimen_session SET count=3 WHERE session_num='20120301';
BEGIN;
INSERT INTO specimen (
			specimen_id, 
			patient_id, 
			specimen_type_id, 
			date_collected, 
			date_recvd, 
			user_id, 
			status_code_id, 
			referred_to, 
			comments, 
			aux_id,
			session_num, 
			time_collected, 
			report_to, 
			doctor, 
			referred_to_name, 
			daily_num
		) 
		VALUES (
			40489, 
			8570, 
			7, 
			'2012-03-01', 
			'2012-03-01', 
			116, 
			0, 
			0, 
			'', 
			'', 
			'20120301-3', 
			'12:14', 
			1, 
			'', 
			'', 
			'20120301-3'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			12,  
			40489, 
			'', 
			'', 
			0, 
			116 );
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			14,  
			40489, 
			'', 
			'', 
			0, 
			116 );
COMMIT;
UPDATE test SET result='3,df286509d490a358b5efe0f3231810adbcad468a', comments='', user_id=116, ts='2012-03-01 00:00:00' WHERE test_id=44730 ;
UPDATE test SET result='2.0,df286509d490a358b5efe0f3231810adbcad468a', comments='', user_id=116, ts='2012-03-01 00:00:00' WHERE test_id=44731 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=40489;
INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
INSERT INTO patient_daily (datestring, count) VALUES ('20120303', 1);
INSERT INTO specimen_session(session_num, count) VALUES ('20120303', 1);
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (16972, '', 'March3 Test1', 0, 'M', '2011-03-03', '', 116, 'a9e8b24b7679beb3c12c6633ff0bad2181bbef14', '2012-03-03 00:00:00');
BEGIN;
INSERT INTO specimen (
			specimen_id, 
			patient_id, 
			specimen_type_id, 
			date_collected, 
			date_recvd, 
			user_id, 
			status_code_id, 
			referred_to, 
			comments, 
			aux_id,
			session_num, 
			time_collected, 
			report_to, 
			doctor, 
			referred_to_name, 
			daily_num
		) 
		VALUES (
			40490, 
			16972, 
			6, 
			'2012-03-03', 
			'2012-03-03', 
			116, 
			0, 
			0, 
			'', 
			'', 
			'20120303-1', 
			'19:49', 
			1, 
			'', 
			'', 
			'20120303-1'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			63,  
			40490, 
			'', 
			'', 
			0, 
			116 );
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			38,  
			40490, 
			'', 
			'', 
			0, 
			116 );
COMMIT;
BEGIN;
INSERT INTO specimen (
			specimen_id, 
			patient_id, 
			specimen_type_id, 
			date_collected, 
			date_recvd, 
			user_id, 
			status_code_id, 
			referred_to, 
			comments, 
			aux_id,
			session_num, 
			time_collected, 
			report_to, 
			doctor, 
			referred_to_name, 
			daily_num
		) 
		VALUES (
			40492, 
			16972, 
			11, 
			'2012-03-03', 
			'2012-03-03', 
			116, 
			0, 
			0, 
			'', 
			'', 
			'20120303-1', 
			'19:49', 
			1, 
			'', 
			'', 
			'20120303-1'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			90,  
			40492, 
			'', 
			'', 
			0, 
			116 );
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			91,  
			40492, 
			'', 
			'', 
			0, 
			116 );
COMMIT;
UPDATE test SET result='O,Rh +ve,,a9e8b24b7679beb3c12c6633ff0bad2181bbef14', comments='Blood Group:O', user_id=116, ts='2012-03-03 19:50:03' WHERE test_id=44732 ;
UPDATE test SET result='Positive,,a9e8b24b7679beb3c12c6633ff0bad2181bbef14', comments='Blood Group', user_id=116, ts='2012-03-03 19:50:03' WHERE test_id=44733 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=40490;
UPDATE test SET result='Negative,,a9e8b24b7679beb3c12c6633ff0bad2181bbef14', comments='Albumin:Negative', user_id=116, ts='2012-03-03 19:50:25' WHERE test_id=44734 ;
UPDATE test SET result='Negative,,a9e8b24b7679beb3c12c6633ff0bad2181bbef14', comments='Albumin:NegativeSugar:Negative', user_id=116, ts='2012-03-03 19:50:26' WHERE test_id=44735 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=40492;
INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
UPDATE measure SET name='AFB', range='N/P', unit='' WHERE measure_id=89;
UPDATE test_type SET name='AFB', description='', clinical_data='', test_category_id='10', hide_patient_name='0', prevalence_threshold=70, target_tat=48 WHERE test_type_id=85;
INSERT INTO user_rating (user_id, rating) VALUES (116, 6);
2012-05-24 16:39:30	INSERT INTO user_rating (user_id, rating, comments) VALUES (116, 3, '')
2012-05-24 17:12:03	INSERT INTO user_rating (user_id, rating, comments) VALUES (116, 3, '')
2012-05-24 17:25:28	TRUNCATE TABLE test
2012-05-24 17:25:28	TRUNCATE TABLE specimen
2012-05-24 17:25:28	TRUNCATE TABLE patient
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1, 'npdcpm hjfnhh' , '1969-12-31' , 'M', 5001, 8501)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2, 'rxmsmc oqjhgm' , '1969-12-31' , 'M', 5002, 8502)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (3, 'njeqdv bnnxpc' , '1969-12-31' , 'F', 5003, 8503)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (4, 'pzsjrr xrwyvj' , '1969-12-31' , 'F', 5004, 8504)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (5, 'dhghrs jyqmqe' , '1969-12-31' , 'M', 5005, 8505)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (6, 'icrhvy xthqry' , '1969-12-31' , 'M', 5006, 8506)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (7, 'mubrfm rwrakb' , '1969-12-31' , 'F', 5007, 8507)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (8, 'eufocv hurtrp' , '1969-12-31' , 'M', 5008, 8508)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (9, 'kawrfv zxljtg' , '1969-12-31' , 'M', 5009, 8509)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (10, 'idxsdh pnxzzc' , '1969-12-31' , 'M', 5010, 8510)
2012-05-24 17:25:28	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (11, 'wiyhsf wbzrqs' , '1969-12-31' , 'F', 5011, 8511)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (12, 'jzzjsq xobauu' , '1969-12-31' , 'M', 5012, 8512)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (13, 'upcapt hqbetd' , '1969-12-31' , 'M', 5013, 8513)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (14, 'mqdlch vmvmrk' , '1969-12-31' , 'F', 5014, 8514)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (15, 'hsomyx ewrphy' , '1969-12-31' , 'F', 5015, 8515)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (16, 'pmtdug baagvk' , '1969-12-31' , 'M', 5016, 8516)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (17, 'dxaccd vvxgmz' , '1969-12-31' , 'M', 5017, 8517)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (18, 'fkvpno zpugbf' , '1969-12-31' , 'M', 5018, 8518)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (19, 'otegwb qcrjwj' , '1969-12-31' , 'M', 5019, 8519)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (20, 'mqulgp cpdyrs' , '1969-12-31' , 'F', 5020, 8520)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (21, 'otilwu aovhpf' , '1969-12-31' , 'M', 5021, 8521)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (22, 'invhkz eagvjq' , '1969-12-31' , 'M', 5022, 8522)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (23, 'cwgyko udgtjp' , '1969-12-31' , 'F', 5023, 8523)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (24, 'yehryv kqrssf' , '1969-12-31' , 'M', 5024, 8524)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (25, 'obftvu zhxyjx' , '1969-12-31' , 'F', 5025, 8525)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (26, 'tkomzv gvpubw' , '1969-12-31' , 'M', 5026, 8526)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (27, 'tkmsnb fhjjbp' , '1969-12-31' , 'F', 5027, 8527)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (28, 'rtshsi eylmug' , '1969-12-31' , 'M', 5028, 8528)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (29, 'bjpjag nphhhz' , '1969-12-31' , 'F', 5029, 8529)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (30, 'nxstsx iyqwfv' , '1969-12-31' , 'F', 5030, 8530)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (31, 'aqrhos mueyel' , '1969-12-31' , 'M', 5031, 8531)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (32, 'taepyx hqwfjr' , '1969-12-31' , 'F', 5032, 8532)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (33, 'rssfaa ictstq' , '1969-12-31' , 'F', 5033, 8533)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (34, 'stszag wdwaea' , '1969-12-31' , 'F', 5034, 8534)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (35, 'tsjggq cxmzdl' , '1969-12-31' , 'F', 5035, 8535)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (36, 'aigxwu fjsica' , '1969-12-31' , 'F', 5036, 8536)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (37, 'fxbzdr zpxdql' , '1969-12-31' , 'M', 5037, 8537)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (38, 'lontrt tjepzh' , '1969-12-31' , 'M', 5038, 8538)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (39, 'xosiqk wculyc' , '1969-12-31' , 'M', 5039, 8539)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (40, 'ncocab oulvvx' , '1969-12-31' , 'M', 5040, 8540)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (41, 'ubglxc nxvbps' , '1969-12-31' , 'F', 5041, 8541)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (42, 'vniuvb qoexmk' , '1969-12-31' , 'M', 5042, 8542)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (43, 'npopvx ciowre' , '1969-12-31' , 'F', 5043, 8543)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (44, 'mwsfth toaoyu' , '1969-12-31' , 'M', 5044, 8544)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (45, 'chhwgk jtioig' , '1969-12-31' , 'M', 5045, 8545)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (46, 'htxjgf bvvnol' , '1969-12-31' , 'F', 5046, 8546)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (47, 'gvbixf cqckbn' , '1969-12-31' , 'M', 5047, 8547)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (48, 'stlcas pybjfn' , '1969-12-31' , 'M', 5048, 8548)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (49, 'cdabys wefuer' , '1969-12-31' , 'M', 5049, 8549)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (50, 'jbxkzg ijpdnc' , '1969-12-31' , 'F', 5050, 8550)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (51, 'jnvimc fmxzvh' , '1969-12-31' , 'F', 5051, 8551)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (52, 'qnbfql tshlnn' , '1969-12-31' , 'M', 5052, 8552)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (53, 'gpetqb fwtgdp' , '1969-12-31' , 'F', 5053, 8553)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (54, 'cieblo ayszhb' , '1969-12-31' , 'F', 5054, 8554)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (55, 'nurlbp bkuhgu' , '1969-12-31' , 'M', 5055, 8555)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (56, 'gvkwof abgvkg' , '1969-12-31' , 'F', 5056, 8556)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (57, 'zsiaky vwrvhm' , '1969-12-31' , 'F', 5057, 8557)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (58, 'uprxmf dfvrym' , '1969-12-31' , 'F', 5058, 8558)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (59, 'viroic oawjxn' , '1969-12-31' , 'M', 5059, 8559)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (60, 'zxkpkn sdsume' , '1969-12-31' , 'F', 5060, 8560)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (61, 'wbsqvd hjqvhf' , '1969-12-31' , 'M', 5061, 8561)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (62, 'snaecu ddlkii' , '1969-12-31' , 'M', 5062, 8562)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (63, 'esozmv wkuovl' , '1969-12-31' , 'F', 5063, 8563)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (64, 'ppppah yarnrs' , '1969-12-31' , 'M', 5064, 8564)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (65, 'tzgkxp ecoyxb' , '1969-12-31' , 'F', 5065, 8565)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (66, 'oilrlu oalisd' , '1969-12-31' , 'M', 5066, 8566)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (67, 'asvrnc rpmpyp' , '1969-12-31' , 'M', 5067, 8567)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (68, 'xvlkvm tdcaev' , '1969-12-31' , 'M', 5068, 8568)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (69, 'omdxav navoct' , '1969-12-31' , 'F', 5069, 8569)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (70, 'qqbpxe wtlsoe' , '1969-12-31' , 'M', 5070, 8570)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (71, 'xyttrg slklru' , '1969-12-31' , 'M', 5071, 8571)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (72, 'kqxwtn kpdhub' , '1969-12-31' , 'M', 5072, 8572)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (73, 'hjrixg bpfsyu' , '1969-12-31' , 'F', 5073, 8573)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (74, 'shptjo bgazud' , '1969-12-31' , 'M', 5074, 8574)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (75, 'jvjppg flqabm' , '1969-12-31' , 'M', 5075, 8575)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (76, 'xcypmn egyqit' , '1969-12-31' , 'F', 5076, 8576)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (77, 'kfnttt glyzts' , '1969-12-31' , 'F', 5077, 8577)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (78, 'zfmwah rsqugb' , '1969-12-31' , 'F', 5078, 8578)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (79, 'bjqtqw bwfjqg' , '1969-12-31' , 'F', 5079, 8579)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (80, 'xlhxus psefpt' , '1969-12-31' , 'F', 5080, 8580)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (81, 'wgymkh ekepme' , '1969-12-31' , 'M', 5081, 8581)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (82, 'bdvjyx qejzew' , '1969-12-31' , 'F', 5082, 8582)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (83, 'pkbmeu xeieol' , '1969-12-31' , 'M', 5083, 8583)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (84, 'mooemg istguv' , '1969-12-31' , 'F', 5084, 8584)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (85, 'zzjatf yjsxee' , '1969-12-31' , 'M', 5085, 8585)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (86, 'ijllzj mhtliz' , '1969-12-31' , 'F', 5086, 8586)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (87, 'iutirq jyzynx' , '1969-12-31' , 'F', 5087, 8587)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (88, 'ofgzow tcvavb' , '1969-12-31' , 'M', 5088, 8588)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (89, 'hsuzrq aefqbj' , '1969-12-31' , 'M', 5089, 8589)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (90, 'osqlke puttwv' , '1969-12-31' , 'F', 5090, 8590)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (91, 'rwuyjb bbfjht' , '1969-12-31' , 'F', 5091, 8591)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (92, 'xqwtqj nklyvq' , '1969-12-31' , 'M', 5092, 8592)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (93, 'wqjgru vyzagx' , '1969-12-31' , 'F', 5093, 8593)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (94, 'vasbbb hatoza' , '1969-12-31' , 'M', 5094, 8594)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (95, 'lhmwxf hsphdh' , '1969-12-31' , 'M', 5095, 8595)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (96, 'cnqsso cxeusp' , '1969-12-31' , 'F', 5096, 8596)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (97, 'ddulwd nhvind' , '1969-12-31' , 'M', 5097, 8597)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (98, 'irdkoc rdfofk' , '1969-12-31' , 'M', 5098, 8598)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (99, 'tdhovy vqlzgr' , '1969-12-31' , 'M', 5099, 8599)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (100, 'kfrujs xrquod' , '1969-12-31' , 'M', 5100, 8600)
2012-05-24 17:25:29	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (101, 'lbosxj uikeea' , '1969-12-31' , 'F', 5101, 8601)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (102, 'rickcd pwesdj' , '1969-12-31' , 'M', 5102, 8602)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (103, 'jgwiub ucdeqp' , '1969-12-31' , 'F', 5103, 8603)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (104, 'xzuzdb bzsqjq' , '1969-12-31' , 'M', 5104, 8604)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (105, 'hulvld coudso' , '1969-12-31' , 'M', 5105, 8605)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (106, 'limwxs xngehw' , '1969-12-31' , 'F', 5106, 8606)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (107, 'lzsgrf xpzupx' , '1969-12-31' , 'M', 5107, 8607)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (108, 'uebsvr wkxjyl' , '1969-12-31' , 'M', 5108, 8608)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (109, 'sxiokq nghona' , '1969-12-31' , 'M', 5109, 8609)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (110, 'kwovtr fvfked' , '1969-12-31' , 'M', 5110, 8610)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (111, 'qeybad fudrqm' , '1969-12-31' , 'M', 5111, 8611)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (112, 'czfdmv xqjnty' , '1969-12-31' , 'M', 5112, 8612)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (113, 'aagnbf bdxxbd' , '1969-12-31' , 'F', 5113, 8613)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (114, 'pscnhr jfjmeb' , '1969-12-31' , 'M', 5114, 8614)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (115, 'czeknh omyqxa' , '1969-12-31' , 'M', 5115, 8615)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (116, 'yaxsdj vqnrrf' , '1969-12-31' , 'F', 5116, 8616)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (117, 'zghujg hjchol' , '1969-12-31' , 'F', 5117, 8617)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (118, 'nlphie zvmzfv' , '1969-12-31' , 'M', 5118, 8618)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (119, 'vholwe jbihik' , '1969-12-31' , 'M', 5119, 8619)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (120, 'ncrzjm zqrlhq' , '1969-12-31' , 'F', 5120, 8620)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (121, 'kvjyuh hhtdzd' , '1969-12-31' , 'F', 5121, 8621)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (122, 'yscwgd lbgyws' , '1969-12-31' , 'M', 5122, 8622)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (123, 'lumfyb lixbmp' , '1969-12-31' , 'M', 5123, 8623)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (124, 'zrwuqj pbqysm' , '1969-12-31' , 'F', 5124, 8624)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (125, 'ntemjr utnxjk' , '1969-12-31' , 'M', 5125, 8625)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (126, 'thfqcx ynmxwn' , '1969-12-31' , 'F', 5126, 8626)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (127, 'ixifjt jzjdyi' , '1969-12-31' , 'M', 5127, 8627)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (128, 'tvyqez uglvqk' , '1969-12-31' , 'M', 5128, 8628)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (129, 'ceeabu esrzlk' , '1969-12-31' , 'M', 5129, 8629)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (130, 'chdfmc ycmwur' , '1969-12-31' , 'M', 5130, 8630)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (131, 'xlhvff jbasxp' , '1969-12-31' , 'F', 5131, 8631)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (132, 'lmsjiq lbzlmy' , '1969-12-31' , 'F', 5132, 8632)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (133, 'mgaciz chtnic' , '1969-12-31' , 'M', 5133, 8633)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (134, 'qruoxk kbchlr' , '1969-12-31' , 'M', 5134, 8634)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (135, 'rrzdtt mgwwdc' , '1969-12-31' , 'F', 5135, 8635)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (136, 'bxhapk azwzaw' , '1969-12-31' , 'F', 5136, 8636)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (137, 'fstfeq fcftix' , '1969-12-31' , 'M', 5137, 8637)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (138, 'phycwu xbyzuk' , '1969-12-31' , 'M', 5138, 8638)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (139, 'ukzqdk odjygv' , '1969-12-31' , 'M', 5139, 8639)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (140, 'bkagfb ojhcup' , '1969-12-31' , 'F', 5140, 8640)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (141, 'dmiwjq tnlyla' , '1969-12-31' , 'F', 5141, 8641)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (142, 'fpysap ofzsme' , '1969-12-31' , 'F', 5142, 8642)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (143, 'rlgjea mhnfgg' , '1969-12-31' , 'M', 5143, 8643)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (144, 'qfpumr iruchy' , '1969-12-31' , 'F', 5144, 8644)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (145, 'tujhmx wbwdvj' , '1969-12-31' , 'M', 5145, 8645)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (146, 'krzqxi jimceu' , '1969-12-31' , 'M', 5146, 8646)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (147, 'hichbi duqdgm' , '1969-12-31' , 'M', 5147, 8647)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (148, 'qjjhlr ipxobl' , '1969-12-31' , 'F', 5148, 8648)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (149, 'yohrim ukprse' , '1969-12-31' , 'M', 5149, 8649)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (150, 'chtlbj fobhsx' , '1969-12-31' , 'M', 5150, 8650)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (151, 'rwvznv hbuupc' , '1969-12-31' , 'F', 5151, 8651)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (152, 'xngffb dmbaex' , '1969-12-31' , 'M', 5152, 8652)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (153, 'moqnva juyhio' , '1969-12-31' , 'M', 5153, 8653)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (154, 'krtydo punjrm' , '1969-12-31' , 'M', 5154, 8654)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (155, 'gjtodx qowoos' , '1969-12-31' , 'M', 5155, 8655)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (156, 'ikryuf itlenz' , '1969-12-31' , 'F', 5156, 8656)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (157, 'pvkeip umtwmc' , '1969-12-31' , 'M', 5157, 8657)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (158, 'ktzxuj ivcurd' , '1969-12-31' , 'F', 5158, 8658)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (159, 'ldmpms qccmgv' , '1969-12-31' , 'F', 5159, 8659)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (160, 'kjlzcw czewxd' , '1969-12-31' , 'M', 5160, 8660)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (161, 'qoinmy rpvlpe' , '1969-12-31' , 'M', 5161, 8661)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (162, 'noeaoj srgptx' , '1969-12-31' , 'M', 5162, 8662)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (163, 'ojgtix oxfrcm' , '1969-12-31' , 'F', 5163, 8663)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (164, 'drgbvt qprgdk' , '1969-12-31' , 'F', 5164, 8664)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (165, 'ifheas hvlhsh' , '1969-12-31' , 'M', 5165, 8665)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (166, 'akgipw smwndr' , '1969-12-31' , 'M', 5166, 8666)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (167, 'kucfzc nyjvqp' , '1969-12-31' , 'M', 5167, 8667)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (168, 'vgoufn lrsuqt' , '1969-12-31' , 'F', 5168, 8668)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (169, 'djkhok vnpsny' , '1969-12-31' , 'M', 5169, 8669)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (170, 'ngfkcl ysepkv' , '1969-12-31' , 'F', 5170, 8670)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (171, 'vtfmqj bswapm' , '1969-12-31' , 'M', 5171, 8671)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (172, 'xsgczv ekvmtm' , '1969-12-31' , 'F', 5172, 8672)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (173, 'uzwxpc wqgliy' , '1969-12-31' , 'F', 5173, 8673)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (174, 'yxcbae zgphcb' , '1969-12-31' , 'M', 5174, 8674)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (175, 'renuum qfrfgm' , '1969-12-31' , 'M', 5175, 8675)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (176, 'fujlct zhdith' , '1969-12-31' , 'F', 5176, 8676)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (177, 'gxznqo cvgbel' , '1969-12-31' , 'F', 5177, 8677)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (178, 'vwhxgh usxphr' , '1969-12-31' , 'M', 5178, 8678)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (179, 'aigimr frlrcq' , '1969-12-31' , 'M', 5179, 8679)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (180, 'mzkuvb npvwom' , '1969-12-31' , 'F', 5180, 8680)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (181, 'nricfh umgogc' , '1969-12-31' , 'F', 5181, 8681)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (182, 'rmgebg jqlhse' , '1969-12-31' , 'F', 5182, 8682)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (183, 'cxbhrg lvkkaj' , '1969-12-31' , 'M', 5183, 8683)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (184, 'etpbja aiopbh' , '1969-12-31' , 'F', 5184, 8684)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (185, 'wfuxtv oludnw' , '1969-12-31' , 'F', 5185, 8685)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (186, 'hpbuzv kevazs' , '1969-12-31' , 'F', 5186, 8686)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (187, 'cgjlab ajmzbj' , '1969-12-31' , 'M', 5187, 8687)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (188, 'hjfvkt rjdwkd' , '1969-12-31' , 'F', 5188, 8688)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (189, 'kpdzhc mfwdvb' , '1969-12-31' , 'F', 5189, 8689)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (190, 'xbhqmx lqhcod' , '1969-12-31' , 'F', 5190, 8690)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (191, 'tgbtru ptzvux' , '1969-12-31' , 'F', 5191, 8691)
2012-05-24 17:25:30	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (192, 'nsvyif hkcaym' , '1969-12-31' , 'F', 5192, 8692)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (193, 'cxiurt blkcyv' , '1969-12-31' , 'M', 5193, 8693)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (194, 'cswqyy qmhhwc' , '1969-12-31' , 'F', 5194, 8694)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (195, 'isxjfg thbutj' , '1969-12-31' , 'M', 5195, 8695)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (196, 'zzllms bugqhp' , '1969-12-31' , 'F', 5196, 8696)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (197, 'pwafrw nvgvrg' , '1969-12-31' , 'F', 5197, 8697)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (198, 'oxvorx mlzrpj' , '1969-12-31' , 'M', 5198, 8698)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (199, 'stqfrn ftbcng' , '1969-12-31' , 'F', 5199, 8699)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (200, 'qbsjpt qiwgqm' , '1969-12-31' , 'M', 5200, 8700)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (201, 'lnjrsp gwxnow' , '1969-12-31' , 'M', 5201, 8701)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (202, 'wifkyp rocica' , '1969-12-31' , 'M', 5202, 8702)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (203, 'xddzcs vkowxb' , '1969-12-31' , 'F', 5203, 8703)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (204, 'zmkvxw vppaub' , '1969-12-31' , 'M', 5204, 8704)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (205, 'sjbrec ajjrvd' , '1969-12-31' , 'M', 5205, 8705)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (206, 'reekuu agrpjj' , '1969-12-31' , 'M', 5206, 8706)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (207, 'lvjpdw nihmxh' , '1969-12-31' , 'M', 5207, 8707)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (208, 'gwraxn cspjsy' , '1969-12-31' , 'M', 5208, 8708)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (209, 'lkzlvi zrpprq' , '1969-12-31' , 'M', 5209, 8709)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (210, 'ooerwq uhrybi' , '1969-12-31' , 'M', 5210, 8710)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (211, 'sxznze awouhj' , '1969-12-31' , 'M', 5211, 8711)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (212, 'ylqdta npthdy' , '1969-12-31' , 'M', 5212, 8712)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (213, 'fbwnge kjznhd' , '1969-12-31' , 'M', 5213, 8713)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (214, 'xhgvnt naptqx' , '1969-12-31' , 'F', 5214, 8714)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (215, 'aucqot drjcog' , '1969-12-31' , 'F', 5215, 8715)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (216, 'onutjs ofpcap' , '1969-12-31' , 'M', 5216, 8716)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (217, 'wgwpvq wwxlns' , '1969-12-31' , 'M', 5217, 8717)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (218, 'nzuzpy ddslxs' , '1969-12-31' , 'F', 5218, 8718)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (219, 'pduulv tbibqh' , '1969-12-31' , 'M', 5219, 8719)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (220, 'lixwvj rnzcph' , '1969-12-31' , 'F', 5220, 8720)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (221, 'hputcy cigqac' , '1969-12-31' , 'M', 5221, 8721)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (222, 'yirath bxulku' , '1969-12-31' , 'F', 5222, 8722)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (223, 'nujelm wohbfo' , '1969-12-31' , 'F', 5223, 8723)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (224, 'udlarn dwxdiu' , '1969-12-31' , 'M', 5224, 8724)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (225, 'iswbgc mphkyt' , '1969-12-31' , 'F', 5225, 8725)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (226, 'ybfgiz hswmsd' , '1969-12-31' , 'F', 5226, 8726)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (227, 'ljxkwn vtwfll' , '1969-12-31' , 'M', 5227, 8727)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (228, 'yovyyo dfnyqs' , '1969-12-31' , 'F', 5228, 8728)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (229, 'zzuzpf xjdugn' , '1969-12-31' , 'F', 5229, 8729)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (230, 'hyxdfj axrctp' , '1969-12-31' , 'M', 5230, 8730)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (231, 'ecxwma tpssfy' , '1969-12-31' , 'M', 5231, 8731)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (232, 'pqywrs wwwpnk' , '1969-12-31' , 'M', 5232, 8732)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (233, 'pdrlub iwlkit' , '1969-12-31' , 'F', 5233, 8733)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (234, 'jtqyns fxtawn' , '1969-12-31' , 'F', 5234, 8734)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (235, 'zteyyw kvchwc' , '1969-12-31' , 'F', 5235, 8735)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (236, 'tboaal bmbham' , '1969-12-31' , 'M', 5236, 8736)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (237, 'benozy yuktau' , '1969-12-31' , 'F', 5237, 8737)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (238, 'bvgcnn aagawd' , '1969-12-31' , 'M', 5238, 8738)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (239, 'heowif daazfy' , '1969-12-31' , 'F', 5239, 8739)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (240, 'lehrad nxgsgv' , '1969-12-31' , 'M', 5240, 8740)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (241, 'rvwpbx ggfxzp' , '1969-12-31' , 'F', 5241, 8741)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (242, 'uhafst dwykic' , '1969-12-31' , 'F', 5242, 8742)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (243, 'glgfqz pptudi' , '1969-12-31' , 'M', 5243, 8743)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (244, 'szgvhs cjvbjm' , '1969-12-31' , 'F', 5244, 8744)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (245, 'tchdok tljqwv' , '1969-12-31' , 'F', 5245, 8745)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (246, 'genqhh upgony' , '1969-12-31' , 'F', 5246, 8746)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (247, 'oholzw zvohmu' , '1969-12-31' , 'F', 5247, 8747)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (248, 'bbqspf dlmmhi' , '1969-12-31' , 'F', 5248, 8748)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (249, 'buozud ngzwmw' , '1969-12-31' , 'M', 5249, 8749)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (250, 'zsjosu qxfxju' , '1969-12-31' , 'M', 5250, 8750)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (251, 'kxtghv mvlqbz' , '1969-12-31' , 'F', 5251, 8751)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (252, 'zdchie vitohs' , '1969-12-31' , 'F', 5252, 8752)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (253, 'ixmauz delsyb' , '1969-12-31' , 'F', 5253, 8753)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (254, 'qzdhfl csmxgv' , '1969-12-31' , 'M', 5254, 8754)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (255, 'fwaewv wutlcx' , '1969-12-31' , 'F', 5255, 8755)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (256, 'nspscz yznzqq' , '1969-12-31' , 'F', 5256, 8756)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (257, 'lbnbvd oiassw' , '1969-12-31' , 'F', 5257, 8757)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (258, 'aampyh mqbnxx' , '1969-12-31' , 'F', 5258, 8758)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (259, 'wrlulv umusvp' , '1969-12-31' , 'F', 5259, 8759)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (260, 'jrpdbi oahump' , '1969-12-31' , 'M', 5260, 8760)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (261, 'afxdxt czfbng' , '1969-12-31' , 'M', 5261, 8761)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (262, 'xzboac vegkup' , '1969-12-31' , 'F', 5262, 8762)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (263, 'phfuoo ydegpb' , '1969-12-31' , 'M', 5263, 8763)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (264, 'wuindb qsbead' , '1969-12-31' , 'F', 5264, 8764)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (265, 'dbgnlr trxvtv' , '1969-12-31' , 'F', 5265, 8765)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (266, 'ifhbdl fjszkr' , '1969-12-31' , 'M', 5266, 8766)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (267, 'zfflov skmlte' , '1969-12-31' , 'M', 5267, 8767)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (268, 'repmns carxvl' , '1969-12-31' , 'F', 5268, 8768)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (269, 'ocjlbq lxmdcm' , '1969-12-31' , 'M', 5269, 8769)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (270, 'huuiof dkvryc' , '1969-12-31' , 'M', 5270, 8770)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (271, 'agwevi trdyli' , '1969-12-31' , 'M', 5271, 8771)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (272, 'mchadz swwxod' , '1969-12-31' , 'M', 5272, 8772)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (273, 'yiiamr fatevf' , '1969-12-31' , 'F', 5273, 8773)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (274, 'bjhbgp nqucuq' , '1969-12-31' , 'F', 5274, 8774)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (275, 'jwdtnx tngrda' , '1969-12-31' , 'M', 5275, 8775)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (276, 'ugjxui dowity' , '1969-12-31' , 'M', 5276, 8776)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (277, 'tcamgn ayqgeh' , '1969-12-31' , 'M', 5277, 8777)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (278, 'sqfsto gsoqvj' , '1969-12-31' , 'F', 5278, 8778)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (279, 'pvzvmj frdlrg' , '1969-12-31' , 'F', 5279, 8779)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (280, 'trklry hxhxfu' , '1969-12-31' , 'M', 5280, 8780)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (281, 'csesxf idfnjl' , '1969-12-31' , 'M', 5281, 8781)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (282, 'rguzon ehfvdx' , '1969-12-31' , 'M', 5282, 8782)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (283, 'bemkhv wpctbw' , '1969-12-31' , 'M', 5283, 8783)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (284, 'qgaxin oesqrj' , '1969-12-31' , 'F', 5284, 8784)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (285, 'lssqux jerssv' , '1969-12-31' , 'F', 5285, 8785)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (286, 'yyloyb vgsztj' , '1969-12-31' , 'M', 5286, 8786)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (287, 'qczqzw kzokht' , '1969-12-31' , 'M', 5287, 8787)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (288, 'kscsbk baezqj' , '1969-12-31' , 'F', 5288, 8788)
2012-05-24 17:25:31	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (289, 'xelunv yptmah' , '1969-12-31' , 'M', 5289, 8789)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (290, 'nonjqb yolywl' , '1969-12-31' , 'F', 5290, 8790)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (291, 'ixufru stafub' , '1969-12-31' , 'F', 5291, 8791)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (292, 'wflaeq pxhvlx' , '1969-12-31' , 'M', 5292, 8792)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (293, 'lbaafp lcwvdx' , '1969-12-31' , 'M', 5293, 8793)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (294, 'eqxluv asctzp' , '1969-12-31' , 'M', 5294, 8794)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (295, 'ftywbr tjcyoo' , '1969-12-31' , 'F', 5295, 8795)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (296, 'tgvhcf ybqcdr' , '1969-12-31' , 'F', 5296, 8796)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (297, 'oilcqm lilqbl' , '1969-12-31' , 'M', 5297, 8797)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (298, 'lfjmkq rdkvpx' , '1969-12-31' , 'F', 5298, 8798)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (299, 'wznzzk iqfecv' , '1969-12-31' , 'F', 5299, 8799)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (300, 'jpagra laqlrz' , '1969-12-31' , 'F', 5300, 8800)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (301, 'ytbzlm uoldng' , '1969-12-31' , 'M', 5301, 8801)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (302, 'mfmldj qxutwi' , '1969-12-31' , 'M', 5302, 8802)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (303, 'xyyzrr mlxbet' , '1969-12-31' , 'F', 5303, 8803)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (304, 'hijeev rsfolo' , '1969-12-31' , 'M', 5304, 8804)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (305, 'fvsswq sgpuvd' , '1969-12-31' , 'F', 5305, 8805)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (306, 'myzobe haovbz' , '1969-12-31' , 'M', 5306, 8806)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (307, 'wemdiu gjxrto' , '1969-12-31' , 'M', 5307, 8807)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (308, 'aaoezl tegibf' , '1969-12-31' , 'M', 5308, 8808)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (309, 'tyjwte kkxpqv' , '1969-12-31' , 'F', 5309, 8809)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (310, 'qfevuu vubmsa' , '1969-12-31' , 'M', 5310, 8810)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (311, 'yvlbnm lnywhc' , '1969-12-31' , 'F', 5311, 8811)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (312, 'llidet jtsqiu' , '1969-12-31' , 'F', 5312, 8812)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (313, 'twaxey llegps' , '1969-12-31' , 'M', 5313, 8813)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (314, 'ruegvq hptgzc' , '1969-12-31' , 'F', 5314, 8814)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (315, 'xphbpj hbnaqe' , '1969-12-31' , 'F', 5315, 8815)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (316, 'tjzlul gtirmc' , '1969-12-31' , 'M', 5316, 8816)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (317, 'psmfae ndzcwr' , '1969-12-31' , 'M', 5317, 8817)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (318, 'vmgwvj vijtni' , '1969-12-31' , 'F', 5318, 8818)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (319, 'rfpcah zxzgwl' , '1969-12-31' , 'M', 5319, 8819)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (320, 'oldurx aowjng' , '1969-12-31' , 'F', 5320, 8820)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (321, 'xuhybh vghkop' , '1969-12-31' , 'M', 5321, 8821)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (322, 'ybftoj rwfuoh' , '1969-12-31' , 'M', 5322, 8822)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (323, 'oylyld oxzsux' , '1969-12-31' , 'M', 5323, 8823)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (324, 'esqgpx lrjtjl' , '1969-12-31' , 'F', 5324, 8824)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (325, 'klqsmc dgqblz' , '1969-12-31' , 'F', 5325, 8825)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (326, 'frrzgk lefnfd' , '1969-12-31' , 'F', 5326, 8826)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (327, 'diwohr qifbsw' , '1969-12-31' , 'F', 5327, 8827)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (328, 'nrqjiw ufbvzd' , '1969-12-31' , 'M', 5328, 8828)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (329, 'cuafjy mtokmm' , '1969-12-31' , 'M', 5329, 8829)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (330, 'kfzrhn zwenxb' , '1969-12-31' , 'M', 5330, 8830)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (331, 'ltplvu mecqtt' , '1969-12-31' , 'M', 5331, 8831)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (332, 'wgmvxf ferfnr' , '1969-12-31' , 'M', 5332, 8832)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (333, 'tcrvmz abyyes' , '1969-12-31' , 'F', 5333, 8833)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (334, 'tfmvta ezdfjr' , '1969-12-31' , 'M', 5334, 8834)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (335, 'tjdlwv cfrwap' , '1969-12-31' , 'F', 5335, 8835)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (336, 'zrjuys bfevcd' , '1969-12-31' , 'F', 5336, 8836)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (337, 'wwspcl vjxxwg' , '1969-12-31' , 'F', 5337, 8837)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (338, 'gtxlps mywoam' , '1969-12-31' , 'F', 5338, 8838)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (339, 'uwjrxp atsnyp' , '1969-12-31' , 'M', 5339, 8839)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (340, 'vifglo qmgryu' , '1969-12-31' , 'M', 5340, 8840)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (341, 'ppbyox baaqla' , '1969-12-31' , 'M', 5341, 8841)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (342, 'jeaaib dklrkf' , '1969-12-31' , 'M', 5342, 8842)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (343, 'usskkb ecsgtb' , '1969-12-31' , 'F', 5343, 8843)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (344, 'hrjxkf rvqgue' , '1969-12-31' , 'M', 5344, 8844)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (345, 'hcbcvd knhjht' , '1969-12-31' , 'F', 5345, 8845)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (346, 'qeaflu bvgugl' , '1969-12-31' , 'F', 5346, 8846)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (347, 'lsunwa dkqtma' , '1969-12-31' , 'F', 5347, 8847)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (348, 'wkydqm uigfnm' , '1969-12-31' , 'F', 5348, 8848)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (349, 'imqezh phayfk' , '1969-12-31' , 'F', 5349, 8849)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (350, 'zjhtxa ygtcpl' , '1969-12-31' , 'F', 5350, 8850)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (351, 'vrvyho jzobwe' , '1969-12-31' , 'F', 5351, 8851)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (352, 'wzyjeh jwjrig' , '1969-12-31' , 'F', 5352, 8852)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (353, 'qglbkv mtloaa' , '1969-12-31' , 'F', 5353, 8853)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (354, 'srdzse cwylqy' , '1969-12-31' , 'F', 5354, 8854)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (355, 'clmjul jmkatz' , '1969-12-31' , 'M', 5355, 8855)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (356, 'ilommf buinxo' , '1969-12-31' , 'F', 5356, 8856)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (357, 'puwqtd klmeup' , '1969-12-31' , 'F', 5357, 8857)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (358, 'uaotbz voajha' , '1969-12-31' , 'M', 5358, 8858)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (359, 'qunqze thazht' , '1969-12-31' , 'M', 5359, 8859)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (360, 'qqapwp abyzfn' , '1969-12-31' , 'M', 5360, 8860)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (361, 'hmlxzf pkmjte' , '1969-12-31' , 'F', 5361, 8861)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (362, 'uizopl jcufww' , '1969-12-31' , 'F', 5362, 8862)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (363, 'qkqubf olmcsu' , '1969-12-31' , 'M', 5363, 8863)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (364, 'pssvhd ogiyzf' , '1969-12-31' , 'M', 5364, 8864)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (365, 'idmjns hjrywo' , '1969-12-31' , 'M', 5365, 8865)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (366, 'hevscn pwbwqn' , '1969-12-31' , 'F', 5366, 8866)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (367, 'zrqjab rdfhcm' , '1969-12-31' , 'F', 5367, 8867)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (368, 'raevhr txcqzj' , '1969-12-31' , 'F', 5368, 8868)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (369, 'dgaawz vkiyua' , '1969-12-31' , 'M', 5369, 8869)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (370, 'hjxlcw yjdoib' , '1969-12-31' , 'M', 5370, 8870)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (371, 'brxtau gccdux' , '1969-12-31' , 'M', 5371, 8871)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (372, 'hczomq vluhua' , '1969-12-31' , 'M', 5372, 8872)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (373, 'drmqjh ytkrxk' , '1969-12-31' , 'F', 5373, 8873)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (374, 'uyblvb mwazey' , '1969-12-31' , 'F', 5374, 8874)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (375, 'rctaqf hsfmhd' , '1969-12-31' , 'F', 5375, 8875)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (376, 'vzbctw yscmwd' , '1969-12-31' , 'F', 5376, 8876)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (377, 'gnytzd vxbtmv' , '1969-12-31' , 'M', 5377, 8877)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (378, 'ocqqwy ofrrgz' , '1969-12-31' , 'M', 5378, 8878)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (379, 'bzjslb ngmkgw' , '1969-12-31' , 'F', 5379, 8879)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (380, 'txnfvz bxgwdw' , '1969-12-31' , 'M', 5380, 8880)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (381, 'nuaqzu jvuajs' , '1969-12-31' , 'M', 5381, 8881)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (382, 'hwsokt uuntow' , '1969-12-31' , 'F', 5382, 8882)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (383, 'pekwfm qtnzqf' , '1969-12-31' , 'F', 5383, 8883)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (384, 'jfbaow eiibfi' , '1969-12-31' , 'M', 5384, 8884)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (385, 'tgbums oarwzh' , '1969-12-31' , 'F', 5385, 8885)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (386, 'dfgynx wbxinz' , '1969-12-31' , 'M', 5386, 8886)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (387, 'usaeat mzaaem' , '1969-12-31' , 'F', 5387, 8887)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (388, 'nuvwhy tbpcwz' , '1969-12-31' , 'M', 5388, 8888)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (389, 'ymedhb tkuyra' , '1969-12-31' , 'M', 5389, 8889)
2012-05-24 17:25:32	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (390, 'ptmldf jiiejm' , '1969-12-31' , 'F', 5390, 8890)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (391, 'ygkxcb qxzcvm' , '1969-12-31' , 'M', 5391, 8891)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (392, 'iwxtrn jvbnri' , '1969-12-31' , 'F', 5392, 8892)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (393, 'mpospv somkiv' , '1969-12-31' , 'F', 5393, 8893)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (394, 'datujy colfby' , '1969-12-31' , 'M', 5394, 8894)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (395, 'zldpzh xsknyf' , '1969-12-31' , 'F', 5395, 8895)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (396, 'fcgytd waljpf' , '1969-12-31' , 'F', 5396, 8896)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (397, 'kmghzs ipeqyo' , '1969-12-31' , 'F', 5397, 8897)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (398, 'dvamnu znbeoe' , '1969-12-31' , 'M', 5398, 8898)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (399, 'qublfy azowzc' , '1969-12-31' , 'F', 5399, 8899)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (400, 'twwitf chyadj' , '1969-12-31' , 'F', 5400, 8900)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (401, 'upqgap ptwilb' , '1969-12-31' , 'F', 5401, 8901)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (402, 'wekwrv gbwryw' , '1969-12-31' , 'M', 5402, 8902)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (403, 'litnsy kxnstz' , '1969-12-31' , 'F', 5403, 8903)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (404, 'dngizr rmerjg' , '1969-12-31' , 'F', 5404, 8904)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (405, 'mxozhb fwtnpf' , '1969-12-31' , 'M', 5405, 8905)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (406, 'udoafu japltk' , '1969-12-31' , 'F', 5406, 8906)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (407, 'bhxrjg maolvm' , '1969-12-31' , 'F', 5407, 8907)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (408, 'kznugz hefksu' , '1969-12-31' , 'M', 5408, 8908)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (409, 'hmojaa klreur' , '1969-12-31' , 'F', 5409, 8909)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (410, 'egltki vnifik' , '1969-12-31' , 'M', 5410, 8910)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (411, 'tbfxte cgtlcj' , '1969-12-31' , 'F', 5411, 8911)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (412, 'kdwrog lamjgc' , '1969-12-31' , 'F', 5412, 8912)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (413, 'ptydfa mqzefp' , '1969-12-31' , 'M', 5413, 8913)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (414, 'woobpd rqiupb' , '1969-12-31' , 'F', 5414, 8914)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (415, 'khziul uxjtwq' , '1969-12-31' , 'F', 5415, 8915)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (416, 'ztfvqt chmzdp' , '1969-12-31' , 'M', 5416, 8916)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (417, 'zngpek muxgzx' , '1969-12-31' , 'F', 5417, 8917)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (418, 'oazxps asnodw' , '1969-12-31' , 'M', 5418, 8918)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (419, 'xwxzmi nmjrse' , '1969-12-31' , 'F', 5419, 8919)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (420, 'qvdpej qxmksq' , '1969-12-31' , 'F', 5420, 8920)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (421, 'ajpkcb dkcgqw' , '1969-12-31' , 'M', 5421, 8921)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (422, 'kmgjbg nnpbet' , '1969-12-31' , 'F', 5422, 8922)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (423, 'eqjejv zdjprw' , '1969-12-31' , 'F', 5423, 8923)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (424, 'rmgnyp dfppnx' , '1969-12-31' , 'F', 5424, 8924)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (425, 'nfkpsq knxjak' , '1969-12-31' , 'F', 5425, 8925)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (426, 'gkeoqh pgcylq' , '1969-12-31' , 'F', 5426, 8926)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (427, 'zaezwg jlmype' , '1969-12-31' , 'F', 5427, 8927)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (428, 'gcakje hfnlih' , '1969-12-31' , 'F', 5428, 8928)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (429, 'aexxak dqqeij' , '1969-12-31' , 'F', 5429, 8929)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (430, 'burhzb vtforc' , '1969-12-31' , 'F', 5430, 8930)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (431, 'uegola spyqet' , '1969-12-31' , 'M', 5431, 8931)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (432, 'kwfhpt ziuwkz' , '1969-12-31' , 'F', 5432, 8932)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (433, 'amodgf kqobkk' , '1969-12-31' , 'M', 5433, 8933)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (434, 'chqzwh yfccxd' , '1969-12-31' , 'F', 5434, 8934)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (435, 'frkhrt lquybw' , '1969-12-31' , 'M', 5435, 8935)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (436, 'furnrx bxnioc' , '1969-12-31' , 'M', 5436, 8936)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (437, 'wxhnov bkhghn' , '1969-12-31' , 'F', 5437, 8937)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (438, 'atwjpk jeszir' , '1969-12-31' , 'M', 5438, 8938)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (439, 'camldh xqjrsj' , '1969-12-31' , 'F', 5439, 8939)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (440, 'apjxmz buwyui' , '1969-12-31' , 'F', 5440, 8940)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (441, 'rlilma ymenpx' , '1969-12-31' , 'F', 5441, 8941)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (442, 'dlmkuh nbebvk' , '1969-12-31' , 'M', 5442, 8942)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (443, 'kpuqgn bsccbz' , '1969-12-31' , 'M', 5443, 8943)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (444, 'grfgcq trmive' , '1969-12-31' , 'M', 5444, 8944)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (445, 'oeezff szidax' , '1969-12-31' , 'F', 5445, 8945)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (446, 'hjbxit btivwo' , '1969-12-31' , 'M', 5446, 8946)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (447, 'jjmisx nkbvnj' , '1969-12-31' , 'F', 5447, 8947)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (448, 'auwjzz wxqcmw' , '1969-12-31' , 'M', 5448, 8948)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (449, 'pbbwbw qqodrc' , '1969-12-31' , 'F', 5449, 8949)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (450, 'sftxof wjhlgj' , '1969-12-31' , 'F', 5450, 8950)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (451, 'dmcake umycoq' , '1969-12-31' , 'F', 5451, 8951)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (452, 'injxyx cavmys' , '1969-12-31' , 'M', 5452, 8952)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (453, 'dbxhlm jkjlet' , '1969-12-31' , 'F', 5453, 8953)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (454, 'ryzjgf oxwums' , '1969-12-31' , 'F', 5454, 8954)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (455, 'hklnds tbkzmt' , '1969-12-31' , 'F', 5455, 8955)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (456, 'unhvze ghbrct' , '1969-12-31' , 'M', 5456, 8956)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (457, 'laqswt zzvcsz' , '1969-12-31' , 'F', 5457, 8957)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (458, 'nsuaov uqowth' , '1969-12-31' , 'M', 5458, 8958)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (459, 'olyjza bwamqx' , '1969-12-31' , 'F', 5459, 8959)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (460, 'lesqdw lahadf' , '1969-12-31' , 'F', 5460, 8960)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (461, 'rirdqp qjmpkt' , '1969-12-31' , 'M', 5461, 8961)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (462, 'ymdpqs lhcfvu' , '1969-12-31' , 'F', 5462, 8962)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (463, 'rnpdgn uyczec' , '1969-12-31' , 'M', 5463, 8963)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (464, 'dkuzzf rebvcf' , '1969-12-31' , 'M', 5464, 8964)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (465, 'nmkdpn htxdxl' , '1969-12-31' , 'F', 5465, 8965)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (466, 'ermzln jxaxwt' , '1969-12-31' , 'M', 5466, 8966)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (467, 'iwcdda znbtcx' , '1969-12-31' , 'F', 5467, 8967)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (468, 'gkcooi hvimbw' , '1969-12-31' , 'F', 5468, 8968)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (469, 'ohetia dvxjor' , '1969-12-31' , 'M', 5469, 8969)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (470, 'ambixc evkfzt' , '1969-12-31' , 'M', 5470, 8970)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (471, 'tmfpsj hglfud' , '1969-12-31' , 'F', 5471, 8971)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (472, 'oqoglf jyhixp' , '1969-12-31' , 'M', 5472, 8972)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (473, 'dfkoxj cnurrw' , '1969-12-31' , 'F', 5473, 8973)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (474, 'ffzihb mfxrnw' , '1969-12-31' , 'M', 5474, 8974)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (475, 'qkaduo lbvpef' , '1969-12-31' , 'M', 5475, 8975)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (476, 'wzfnbj jovnxf' , '1969-12-31' , 'M', 5476, 8976)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (477, 'eldiiu fyjzsv' , '1969-12-31' , 'M', 5477, 8977)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (478, 'cwahym ndwnig' , '1969-12-31' , 'M', 5478, 8978)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (479, 'kqahvx fzeboy' , '1969-12-31' , 'M', 5479, 8979)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (480, 'xulioi hewlqe' , '1969-12-31' , 'M', 5480, 8980)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (481, 'sutaos gbsizh' , '1969-12-31' , 'M', 5481, 8981)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (482, 'hhsnfp mkgufi' , '1969-12-31' , 'M', 5482, 8982)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (483, 'dlsxjg qfxiyf' , '1969-12-31' , 'F', 5483, 8983)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (484, 'nfwbas lhozny' , '1969-12-31' , 'M', 5484, 8984)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (485, 'ywzebo hekcei' , '1969-12-31' , 'F', 5485, 8985)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (486, 'frsufs frdcov' , '1969-12-31' , 'F', 5486, 8986)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (487, 'feytyh plddhw' , '1969-12-31' , 'M', 5487, 8987)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (488, 'pthqht cvkzrf' , '1969-12-31' , 'M', 5488, 8988)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (489, 'batrur tkzzhe' , '1969-12-31' , 'M', 5489, 8989)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (490, 'inswqy fkduum' , '1969-12-31' , 'F', 5490, 8990)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (491, 'ndxasu qxgpkj' , '1969-12-31' , 'F', 5491, 8991)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (492, 'rlsmsi eqfdqn' , '1969-12-31' , 'F', 5492, 8992)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (493, 'bmkdxm mnifyi' , '1969-12-31' , 'F', 5493, 8993)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (494, 'pnsgzj lrqlnz' , '1969-12-31' , 'F', 5494, 8994)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (495, 'qhxbjz dalpwm' , '1969-12-31' , 'M', 5495, 8995)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (496, 'gxefnh zsaepb' , '1969-12-31' , 'M', 5496, 8996)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (497, 'rchblz qdaznz' , '1969-12-31' , 'M', 5497, 8997)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (498, 'wpxafl ludmlq' , '1969-12-31' , 'F', 5498, 8998)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (499, 'fhiqbw ovcppz' , '1969-12-31' , 'M', 5499, 8999)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (500, 'gkykgi ykoicn' , '1969-12-31' , 'F', 5500, 9000)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (501, 'ujsezm mthykk' , '1969-12-31' , 'F', 5501, 9001)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (502, 'qfgqby luhdau' , '1969-12-31' , 'F', 5502, 9002)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (503, 'donhoc ckargj' , '1969-12-31' , 'F', 5503, 9003)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (504, 'pqkbec trrwal' , '1969-12-31' , 'M', 5504, 9004)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (505, 'jrqsda yhrpwc' , '1969-12-31' , 'F', 5505, 9005)
2012-05-24 17:25:33	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (506, 'vnbqjc rhicbc' , '1969-12-31' , 'F', 5506, 9006)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (507, 'unisdh frvgal' , '1969-12-31' , 'M', 5507, 9007)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (508, 'knzvax mrrfbc' , '1969-12-31' , 'M', 5508, 9008)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (509, 'hbuqir pefvpa' , '1969-12-31' , 'F', 5509, 9009)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (510, 'fzhzfa bpedvt' , '1969-12-31' , 'F', 5510, 9010)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (511, 'aeczzw twlbzs' , '1969-12-31' , 'M', 5511, 9011)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (512, 'bfwudx hfdzdj' , '1969-12-31' , 'F', 5512, 9012)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (513, 'uihwjr aglrye' , '1969-12-31' , 'M', 5513, 9013)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (514, 'ssquml yctxqc' , '1969-12-31' , 'F', 5514, 9014)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (515, 'alkepg pocozi' , '1969-12-31' , 'M', 5515, 9015)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (516, 'qxgams zhrveu' , '1969-12-31' , 'F', 5516, 9016)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (517, 'yakxmo kpyysk' , '1969-12-31' , 'M', 5517, 9017)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (518, 'djhtve hsiyiq' , '1969-12-31' , 'F', 5518, 9018)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (519, 'qncljf sumncc' , '1969-12-31' , 'M', 5519, 9019)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (520, 'cloenz bqhjso' , '1969-12-31' , 'F', 5520, 9020)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (521, 'uvdzcp btaxay' , '1969-12-31' , 'M', 5521, 9021)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (522, 'tsqzgm cqoktw' , '1969-12-31' , 'M', 5522, 9022)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (523, 'daltfj eudfft' , '1969-12-31' , 'M', 5523, 9023)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (524, 'bixvac vsrzdp' , '1969-12-31' , 'M', 5524, 9024)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (525, 'rsehnq txrryq' , '1969-12-31' , 'M', 5525, 9025)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (526, 'vpciai pbafle' , '1969-12-31' , 'F', 5526, 9026)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (527, 'ayupbm vhtltk' , '1969-12-31' , 'M', 5527, 9027)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (528, 'thbdsd dltogk' , '1969-12-31' , 'M', 5528, 9028)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (529, 'qezgfv xqzpxu' , '1969-12-31' , 'M', 5529, 9029)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (530, 'jjhuoo qzwxgg' , '1969-12-31' , 'F', 5530, 9030)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (531, 'bnjydq qjjegz' , '1969-12-31' , 'F', 5531, 9031)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (532, 'vocnke onandg' , '1969-12-31' , 'F', 5532, 9032)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (533, 'jpcteo lsvurn' , '1969-12-31' , 'M', 5533, 9033)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (534, 'cpapbj pjxbma' , '1969-12-31' , 'F', 5534, 9034)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (535, 'nbyazj mvglkc' , '1969-12-31' , 'M', 5535, 9035)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (536, 'iuxogo cuuzez' , '1969-12-31' , 'M', 5536, 9036)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (537, 'yfpgja grooxq' , '1969-12-31' , 'F', 5537, 9037)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (538, 'spsyky dlocoy' , '1969-12-31' , 'F', 5538, 9038)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (539, 'gewobv aoyejj' , '1969-12-31' , 'M', 5539, 9039)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (540, 'spagvm dwwghf' , '1969-12-31' , 'M', 5540, 9040)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (541, 'tqavzd fnktbo' , '1969-12-31' , 'F', 5541, 9041)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (542, 'gpxazg jagftf' , '1969-12-31' , 'F', 5542, 9042)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (543, 'rtutrc oqazmx' , '1969-12-31' , 'F', 5543, 9043)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (544, 'qsmyjz plqxpp' , '1969-12-31' , 'M', 5544, 9044)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (545, 'zlbubt zcigjg' , '1969-12-31' , 'F', 5545, 9045)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (546, 'pmkhod vohrsh' , '1969-12-31' , 'F', 5546, 9046)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (547, 'dhdbyt vmfnbu' , '1969-12-31' , 'M', 5547, 9047)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (548, 'rbklwg uvthya' , '1969-12-31' , 'F', 5548, 9048)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (549, 'xnpihd wqzfiu' , '1969-12-31' , 'M', 5549, 9049)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (550, 'ftjbpy vkkktz' , '1969-12-31' , 'F', 5550, 9050)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (551, 'ngehbn icadtw' , '1969-12-31' , 'F', 5551, 9051)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (552, 'xcyxbi gvakez' , '1969-12-31' , 'F', 5552, 9052)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (553, 'nlbldy pfkund' , '1969-12-31' , 'F', 5553, 9053)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (554, 'irzhpy xusmpx' , '1969-12-31' , 'F', 5554, 9054)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (555, 'vggdzw jimeev' , '1969-12-31' , 'M', 5555, 9055)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (556, 'ovqqzj qampfx' , '1969-12-31' , 'M', 5556, 9056)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (557, 'trzkyz ihceqn' , '1969-12-31' , 'M', 5557, 9057)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (558, 'lsmdab phqsbi' , '1969-12-31' , 'M', 5558, 9058)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (559, 'fyarfx zactpo' , '1969-12-31' , 'F', 5559, 9059)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (560, 'izkzhy fwtmzr' , '1969-12-31' , 'M', 5560, 9060)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (561, 'gfxhxu mosxnu' , '1969-12-31' , 'M', 5561, 9061)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (562, 'xfagdc voibib' , '1969-12-31' , 'M', 5562, 9062)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (563, 'ypfrzt jesnev' , '1969-12-31' , 'M', 5563, 9063)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (564, 'zsqlyp xvoxmk' , '1969-12-31' , 'F', 5564, 9064)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (565, 'ltafko crjuvp' , '1969-12-31' , 'F', 5565, 9065)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (566, 'qneedh hsnydd' , '1969-12-31' , 'M', 5566, 9066)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (567, 'bpwfkq gfsldq' , '1969-12-31' , 'F', 5567, 9067)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (568, 'zqajgs jnhotd' , '1969-12-31' , 'M', 5568, 9068)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (569, 'cwkpwm nzphaz' , '1969-12-31' , 'F', 5569, 9069)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (570, 'ywpkqf oylrhs' , '1969-12-31' , 'M', 5570, 9070)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (571, 'xalqlh vvjank' , '1969-12-31' , 'F', 5571, 9071)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (572, 'mohfzd zclwip' , '1969-12-31' , 'M', 5572, 9072)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (573, 'kabgoj hwyrcn' , '1969-12-31' , 'M', 5573, 9073)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (574, 'bkreoq dghmnh' , '1969-12-31' , 'M', 5574, 9074)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (575, 'lrzbur hfispu' , '1969-12-31' , 'M', 5575, 9075)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (576, 'oxgcch bpfoel' , '1969-12-31' , 'F', 5576, 9076)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (577, 'pwjbpu yybwlv' , '1969-12-31' , 'F', 5577, 9077)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (578, 'emecme swwxox' , '1969-12-31' , 'F', 5578, 9078)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (579, 'bgzaxf stolob' , '1969-12-31' , 'F', 5579, 9079)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (580, 'wkmftb avocje' , '1969-12-31' , 'M', 5580, 9080)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (581, 'fzkqvr qdvqmq' , '1969-12-31' , 'F', 5581, 9081)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (582, 'khifem ctofwm' , '1969-12-31' , 'M', 5582, 9082)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (583, 'dputke xxasqq' , '1969-12-31' , 'F', 5583, 9083)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (584, 'zkyqox uzfqrs' , '1969-12-31' , 'M', 5584, 9084)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (585, 'pqbncc hyecsg' , '1969-12-31' , 'F', 5585, 9085)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (586, 'tjuurl asixzp' , '1969-12-31' , 'F', 5586, 9086)
2012-05-24 17:25:34	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (587, 'oebgzf gyefaj' , '1969-12-31' , 'F', 5587, 9087)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (588, 'dzyrsj ruolml' , '1969-12-31' , 'F', 5588, 9088)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (589, 'vqlzxj hjpvky' , '1969-12-31' , 'F', 5589, 9089)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (590, 'onedpy bnsqrj' , '1969-12-31' , 'F', 5590, 9090)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (591, 'oenqiu cfmdxh' , '1969-12-31' , 'M', 5591, 9091)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (592, 'pufkil kasbxp' , '1969-12-31' , 'F', 5592, 9092)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (593, 'yhrzwa yfwncd' , '1969-12-31' , 'M', 5593, 9093)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (594, 'tfnsak saimhd' , '1969-12-31' , 'M', 5594, 9094)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (595, 'vdzdnl eixkkf' , '1969-12-31' , 'F', 5595, 9095)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (596, 'muljxr bntjlq' , '1969-12-31' , 'M', 5596, 9096)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (597, 'gxiamk lrkzji' , '1969-12-31' , 'M', 5597, 9097)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (598, 'hqqixl elbmgg' , '1969-12-31' , 'M', 5598, 9098)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (599, 'zjjrrs mgbjti' , '1969-12-31' , 'M', 5599, 9099)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (600, 'mjenmv bjczaa' , '1969-12-31' , 'M', 5600, 9100)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (601, 'zkkuye fkxfxp' , '1969-12-31' , 'M', 5601, 9101)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (602, 'risxpu lvaemw' , '1969-12-31' , 'M', 5602, 9102)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (603, 'yvcnel sxjrii' , '1969-12-31' , 'M', 5603, 9103)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (604, 'haackz vjysvr' , '1969-12-31' , 'M', 5604, 9104)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (605, 'onrrkb adenqx' , '1969-12-31' , 'F', 5605, 9105)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (606, 'ohuudb fdakjq' , '1969-12-31' , 'F', 5606, 9106)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (607, 'busgkr wnzpgb' , '1969-12-31' , 'F', 5607, 9107)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (608, 'eidhty esfxen' , '1969-12-31' , 'F', 5608, 9108)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (609, 'hxjrbk rkbnxk' , '1969-12-31' , 'M', 5609, 9109)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (610, 'rggzqk oqjcaf' , '1969-12-31' , 'F', 5610, 9110)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (611, 'ifgilb ddyyef' , '1969-12-31' , 'F', 5611, 9111)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (612, 'ipvwlb fagxpi' , '1969-12-31' , 'F', 5612, 9112)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (613, 'lrrclg ejgdtk' , '1969-12-31' , 'F', 5613, 9113)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (614, 'brbuvd ztdfyb' , '1969-12-31' , 'F', 5614, 9114)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (615, 'maptqv fpowjk' , '1969-12-31' , 'M', 5615, 9115)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (616, 'pqofpv pvndmr' , '1969-12-31' , 'M', 5616, 9116)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (617, 'wowatn iqgcpl' , '1969-12-31' , 'M', 5617, 9117)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (618, 'qhtnaa cqlrby' , '1969-12-31' , 'F', 5618, 9118)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (619, 'gppuxu ggubit' , '1969-12-31' , 'M', 5619, 9119)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (620, 'rfghfp eilpci' , '1969-12-31' , 'F', 5620, 9120)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (621, 'ncvidz jcspgq' , '1969-12-31' , 'M', 5621, 9121)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (622, 'gdprpn khbgdr' , '1969-12-31' , 'M', 5622, 9122)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (623, 'sqiqfg nfhiqd' , '1969-12-31' , 'F', 5623, 9123)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (624, 'gcmsbt inbcja' , '1969-12-31' , 'F', 5624, 9124)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (625, 'smwqdf qzwkvc' , '1969-12-31' , 'M', 5625, 9125)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (626, 'isfhhu vapqkn' , '1969-12-31' , 'M', 5626, 9126)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (627, 'ysamau rdwnci' , '1969-12-31' , 'M', 5627, 9127)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (628, 'jzjuol rfibdp' , '1969-12-31' , 'F', 5628, 9128)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (629, 'orwugb uyetpe' , '1969-12-31' , 'F', 5629, 9129)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (630, 'srstjv wxxbzf' , '1969-12-31' , 'M', 5630, 9130)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (631, 'xofuvh nrodwq' , '1969-12-31' , 'F', 5631, 9131)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (632, 'yxivwt hwzcdf' , '1969-12-31' , 'M', 5632, 9132)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (633, 'shrjue pqxwwc' , '1969-12-31' , 'F', 5633, 9133)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (634, 'kvkapz xrbiwd' , '1969-12-31' , 'F', 5634, 9134)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (635, 'iuzpon tzqyvu' , '1969-12-31' , 'F', 5635, 9135)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (636, 'izamkq hrpuld' , '1969-12-31' , 'F', 5636, 9136)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (637, 'vlzxqi koliqb' , '1969-12-31' , 'M', 5637, 9137)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (638, 'hyghgu tozlrv' , '1969-12-31' , 'M', 5638, 9138)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (639, 'fditsn ctxcna' , '1969-12-31' , 'F', 5639, 9139)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (640, 'cevgbj wufeoh' , '1969-12-31' , 'M', 5640, 9140)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (641, 'befvhu hnqgff' , '1969-12-31' , 'M', 5641, 9141)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (642, 'nfjujt gxllwh' , '1969-12-31' , 'M', 5642, 9142)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (643, 'nsioje qnlzab' , '1969-12-31' , 'M', 5643, 9143)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (644, 'swkhcd sorawa' , '1969-12-31' , 'M', 5644, 9144)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (645, 'orewpg gwxbor' , '1969-12-31' , 'M', 5645, 9145)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (646, 'jyqrhb dgxqpl' , '1969-12-31' , 'M', 5646, 9146)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (647, 'mvqneo yuzmer' , '1969-12-31' , 'M', 5647, 9147)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (648, 'crmpdh gkaytx' , '1969-12-31' , 'F', 5648, 9148)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (649, 'rhrvpg bitndj' , '1969-12-31' , 'M', 5649, 9149)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (650, 'kptfdl jdfnqi' , '1969-12-31' , 'F', 5650, 9150)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (651, 'hwmydk ynirtx' , '1969-12-31' , 'F', 5651, 9151)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (652, 'mfrhnr xszogp' , '1969-12-31' , 'M', 5652, 9152)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (653, 'ipyben ufakhs' , '1969-12-31' , 'F', 5653, 9153)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (654, 'zoexji gdfjsq' , '1969-12-31' , 'M', 5654, 9154)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (655, 'rkiisy ezjhfa' , '1969-12-31' , 'F', 5655, 9155)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (656, 'vikhos khzpfa' , '1969-12-31' , 'M', 5656, 9156)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (657, 'kqzcmd tlbius' , '1969-12-31' , 'M', 5657, 9157)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (658, 'wwboeo xzaend' , '1969-12-31' , 'M', 5658, 9158)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (659, 'vhnhib rodjws' , '1969-12-31' , 'F', 5659, 9159)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (660, 'ghyyuy abxezl' , '1969-12-31' , 'M', 5660, 9160)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (661, 'zdgygg svokfh' , '1969-12-31' , 'M', 5661, 9161)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (662, 'hkrpam fujixl' , '1969-12-31' , 'M', 5662, 9162)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (663, 'mjjjtu kgvbmz' , '1969-12-31' , 'M', 5663, 9163)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (664, 'vomgvm llefsb' , '1969-12-31' , 'M', 5664, 9164)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (665, 'gcvdlc duewhx' , '1969-12-31' , 'M', 5665, 9165)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (666, 'depito noredu' , '1969-12-31' , 'F', 5666, 9166)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (667, 'vdgwgi foouwr' , '1969-12-31' , 'F', 5667, 9167)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (668, 'ilelni mbbskb' , '1969-12-31' , 'M', 5668, 9168)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (669, 'ajcyvm uuhheb' , '1969-12-31' , 'M', 5669, 9169)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (670, 'jfjpxv cnwyqx' , '1969-12-31' , 'M', 5670, 9170)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (671, 'tsxnso uexbif' , '1969-12-31' , 'M', 5671, 9171)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (672, 'blqmme xloufh' , '1969-12-31' , 'F', 5672, 9172)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (673, 'ahvvfu eaabmw' , '1969-12-31' , 'M', 5673, 9173)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (674, 'trvciv vexiap' , '1969-12-31' , 'M', 5674, 9174)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (675, 'rwhwub lyfpdl' , '1969-12-31' , 'M', 5675, 9175)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (676, 'fzudnu nsyblv' , '1969-12-31' , 'M', 5676, 9176)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (677, 'wgxekn ijenim' , '1969-12-31' , 'M', 5677, 9177)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (678, 'zkqzgq ewyipa' , '1969-12-31' , 'F', 5678, 9178)
2012-05-24 17:25:35	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (679, 'sbxint nlviru' , '1969-12-31' , 'M', 5679, 9179)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (680, 'awmzzf iqhwpe' , '1969-12-31' , 'F', 5680, 9180)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (681, 'pmoqwq lqwwfn' , '1969-12-31' , 'M', 5681, 9181)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (682, 'trphzr weohsy' , '1969-12-31' , 'F', 5682, 9182)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (683, 'uokdmk fkhchu' , '1969-12-31' , 'F', 5683, 9183)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (684, 'hthyat awkvrg' , '1969-12-31' , 'M', 5684, 9184)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (685, 'etajln towiop' , '1969-12-31' , 'F', 5685, 9185)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (686, 'jeqcfy ujbcgz' , '1969-12-31' , 'M', 5686, 9186)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (687, 'bwhrbq iqzpkf' , '1969-12-31' , 'F', 5687, 9187)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (688, 'ulxcbz utkiss' , '1969-12-31' , 'F', 5688, 9188)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (689, 'uoawfc wishgr' , '1969-12-31' , 'F', 5689, 9189)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (690, 'talpts xevxmz' , '1969-12-31' , 'F', 5690, 9190)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (691, 'nvnqtm bjusgw' , '1969-12-31' , 'F', 5691, 9191)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (692, 'atzdlk loflyi' , '1969-12-31' , 'M', 5692, 9192)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (693, 'ckdouy hrdvkf' , '1969-12-31' , 'F', 5693, 9193)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (694, 'zmdjln deoult' , '1969-12-31' , 'F', 5694, 9194)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (695, 'zxkqkf azgvgc' , '1969-12-31' , 'F', 5695, 9195)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (696, 'icmkgx nlnuzq' , '1969-12-31' , 'M', 5696, 9196)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (697, 'vzccuj vemmdg' , '1969-12-31' , 'M', 5697, 9197)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (698, 'iwavdg pbstps' , '1969-12-31' , 'M', 5698, 9198)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (699, 'dbojab qbiteu' , '1969-12-31' , 'F', 5699, 9199)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (700, 'nqdqke bduail' , '1969-12-31' , 'F', 5700, 9200)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (701, 'zpqsmx aswtem' , '1969-12-31' , 'F', 5701, 9201)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (702, 'ginhvo dxiwdd' , '1969-12-31' , 'F', 5702, 9202)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (703, 'ckidxz jfxggo' , '1969-12-31' , 'M', 5703, 9203)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (704, 'xhozie prztbs' , '1969-12-31' , 'M', 5704, 9204)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (705, 'lzmaej eoqxyt' , '1969-12-31' , 'M', 5705, 9205)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (706, 'vvlmql nzbebu' , '1969-12-31' , 'M', 5706, 9206)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (707, 'pyggfa mhuzju' , '1969-12-31' , 'F', 5707, 9207)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (708, 'dqrxcx rldmjt' , '1969-12-31' , 'F', 5708, 9208)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (709, 'fuoswb mecmjg' , '1969-12-31' , 'F', 5709, 9209)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (710, 'pwzkff qdykgb' , '1969-12-31' , 'M', 5710, 9210)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (711, 'ihaifm mchnoj' , '1969-12-31' , 'M', 5711, 9211)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (712, 'xcrzto mubnza' , '1969-12-31' , 'M', 5712, 9212)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (713, 'tvcrtj xitapz' , '1969-12-31' , 'M', 5713, 9213)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (714, 'cirihf zjguzu' , '1969-12-31' , 'F', 5714, 9214)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (715, 'tofzen gbaivc' , '1969-12-31' , 'M', 5715, 9215)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (716, 'hbsgvl krvkva' , '1969-12-31' , 'F', 5716, 9216)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (717, 'yblzrk ceblhy' , '1969-12-31' , 'M', 5717, 9217)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (718, 'bvyazq jiodua' , '1969-12-31' , 'M', 5718, 9218)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (719, 'aglxpz dwevum' , '1969-12-31' , 'F', 5719, 9219)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (720, 'zxnjov vkkusp' , '1969-12-31' , 'M', 5720, 9220)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (721, 'ckkqfp xxpcrl' , '1969-12-31' , 'M', 5721, 9221)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (722, 'dujqhr uhwbli' , '1969-12-31' , 'F', 5722, 9222)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (723, 'cielub kahbtk' , '1969-12-31' , 'F', 5723, 9223)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (724, 'fjdlpk ffvxrb' , '1969-12-31' , 'M', 5724, 9224)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (725, 'uuhgrp gbdrfi' , '1969-12-31' , 'M', 5725, 9225)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (726, 'vzxfba eufycc' , '1969-12-31' , 'F', 5726, 9226)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (727, 'rmhkbo zzmvqr' , '1969-12-31' , 'M', 5727, 9227)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (728, 'zxfydp xanknt' , '1969-12-31' , 'M', 5728, 9228)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (729, 'vmcpjw rhhdja' , '1969-12-31' , 'M', 5729, 9229)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (730, 'upbmpg tyfnvz' , '1969-12-31' , 'M', 5730, 9230)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (731, 'eunvbt pxrxft' , '1969-12-31' , 'F', 5731, 9231)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (732, 'ghmiux mjpekt' , '1969-12-31' , 'M', 5732, 9232)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (733, 'aanwwh dsxyfp' , '1969-12-31' , 'M', 5733, 9233)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (734, 'honqyi dkhang' , '1969-12-31' , 'F', 5734, 9234)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (735, 'zlephs revsvf' , '1969-12-31' , 'F', 5735, 9235)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (736, 'xrsaqs ufvzfe' , '1969-12-31' , 'M', 5736, 9236)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (737, 'htsctt lqjccq' , '1969-12-31' , 'F', 5737, 9237)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (738, 'zmjuux raywsw' , '1969-12-31' , 'M', 5738, 9238)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (739, 'ndmqhp gektnx' , '1969-12-31' , 'F', 5739, 9239)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (740, 'xlfglx hlexlr' , '1969-12-31' , 'F', 5740, 9240)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (741, 'bnduvw fxsmyw' , '1969-12-31' , 'F', 5741, 9241)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (742, 'sazdxu ppxyjj' , '1969-12-31' , 'M', 5742, 9242)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (743, 'ugobxk qavpoa' , '1969-12-31' , 'F', 5743, 9243)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (744, 'jpifjd xoaeep' , '1969-12-31' , 'M', 5744, 9244)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (745, 'wvovwp citijc' , '1969-12-31' , 'F', 5745, 9245)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (746, 'jopwka khunut' , '1969-12-31' , 'F', 5746, 9246)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (747, 'wxodad qdwptp' , '1969-12-31' , 'M', 5747, 9247)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (748, 'zmwprj wpmupm' , '1969-12-31' , 'F', 5748, 9248)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (749, 'pfasva ialcbr' , '1969-12-31' , 'F', 5749, 9249)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (750, 'eciqas ozdnmi' , '1969-12-31' , 'F', 5750, 9250)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (751, 'yzizyw qpreeb' , '1969-12-31' , 'M', 5751, 9251)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (752, 'tqtwsa fsvppt' , '1969-12-31' , 'M', 5752, 9252)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (753, 'kzrdme ergnof' , '1969-12-31' , 'F', 5753, 9253)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (754, 'ziygad rqljri' , '1969-12-31' , 'M', 5754, 9254)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (755, 'yyimeh bnvwog' , '1969-12-31' , 'F', 5755, 9255)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (756, 'xinqjf fdbaea' , '1969-12-31' , 'M', 5756, 9256)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (757, 'asbfak beqfmm' , '1969-12-31' , 'F', 5757, 9257)
2012-05-24 17:25:36	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (758, 'padyun zvbbou' , '1969-12-31' , 'M', 5758, 9258)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (759, 'kmmwho zonwyb' , '1969-12-31' , 'M', 5759, 9259)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (760, 'hieccl wpppoe' , '1969-12-31' , 'M', 5760, 9260)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (761, 'pkzqqa ynsloj' , '1969-12-31' , 'M', 5761, 9261)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (762, 'moxfhm trdlet' , '1969-12-31' , 'F', 5762, 9262)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (763, 'ewbqgy ezcubi' , '1969-12-31' , 'M', 5763, 9263)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (764, 'qcsjbd oxlncq' , '1969-12-31' , 'F', 5764, 9264)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (765, 'uzodnq vgfjnd' , '1969-12-31' , 'F', 5765, 9265)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (766, 'oqfvxl pjkotv' , '1969-12-31' , 'M', 5766, 9266)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (767, 'iqztau bujefy' , '1969-12-31' , 'M', 5767, 9267)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (768, 'hdzabk vubdea' , '1969-12-31' , 'F', 5768, 9268)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (769, 'skatbx gabajz' , '1969-12-31' , 'F', 5769, 9269)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (770, 'ugxfjj ueleea' , '1969-12-31' , 'F', 5770, 9270)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (771, 'jusgph rorkxy' , '1969-12-31' , 'M', 5771, 9271)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (772, 'cvrnhw ttrvdx' , '1969-12-31' , 'M', 5772, 9272)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (773, 'qgahzz mwfndg' , '1969-12-31' , 'M', 5773, 9273)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (774, 'lppume rpqken' , '1969-12-31' , 'M', 5774, 9274)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (775, 'ahybby ljmwct' , '1969-12-31' , 'F', 5775, 9275)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (776, 'zcjdcp ssgsmu' , '1969-12-31' , 'F', 5776, 9276)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (777, 'lacoqh pfweqj' , '1969-12-31' , 'F', 5777, 9277)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (778, 'kxvzba tlziny' , '1969-12-31' , 'F', 5778, 9278)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (779, 'hvfbdv pkbhnt' , '1969-12-31' , 'M', 5779, 9279)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (780, 'wfamit xgdrew' , '1969-12-31' , 'F', 5780, 9280)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (781, 'cmspog uxbdif' , '1969-12-31' , 'M', 5781, 9281)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (782, 'udxghq nzzdsq' , '1969-12-31' , 'M', 5782, 9282)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (783, 'rdbgwu vkqkvh' , '1969-12-31' , 'F', 5783, 9283)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (784, 'jntrrc gooxes' , '1969-12-31' , 'F', 5784, 9284)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (785, 'mrqslo iwglgy' , '1969-12-31' , 'F', 5785, 9285)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (786, 'mhlajr wgjaqa' , '1969-12-31' , 'F', 5786, 9286)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (787, 'dssqjz tcmrlc' , '1969-12-31' , 'F', 5787, 9287)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (788, 'nkihnc qasxbz' , '1969-12-31' , 'M', 5788, 9288)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (789, 'iqpjxw fiqpfb' , '1969-12-31' , 'M', 5789, 9289)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (790, 'dpatkp aakuti' , '1969-12-31' , 'M', 5790, 9290)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (791, 'hsiksa gsbrng' , '1969-12-31' , 'M', 5791, 9291)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (792, 'asbflo yxekqh' , '1969-12-31' , 'M', 5792, 9292)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (793, 'xkqkek nytome' , '1969-12-31' , 'M', 5793, 9293)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (794, 'ymmrih bcyglf' , '1969-12-31' , 'F', 5794, 9294)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (795, 'myeivv chodgh' , '1969-12-31' , 'F', 5795, 9295)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (796, 'bvocdc mlpyes' , '1969-12-31' , 'M', 5796, 9296)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (797, 'seqwoo fgnyxu' , '1969-12-31' , 'F', 5797, 9297)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (798, 'eznhto zdhqvm' , '1969-12-31' , 'F', 5798, 9298)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (799, 'trnjah wbemhw' , '1969-12-31' , 'F', 5799, 9299)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (800, 'ladjib eahmgt' , '1969-12-31' , 'M', 5800, 9300)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (801, 'ezkvnd ilrlue' , '1969-12-31' , 'M', 5801, 9301)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (802, 'wjkyej jfchce' , '1969-12-31' , 'M', 5802, 9302)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (803, 'szmsxx lzuoxq' , '1969-12-31' , 'M', 5803, 9303)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (804, 'hnlovs ciajvk' , '1969-12-31' , 'M', 5804, 9304)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (805, 'txsdbf rxwrdp' , '1969-12-31' , 'M', 5805, 9305)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (806, 'orpmss bingac' , '1969-12-31' , 'M', 5806, 9306)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (807, 'eqrpdu hhpjpj' , '1969-12-31' , 'M', 5807, 9307)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (808, 'nmjugf aimbkp' , '1969-12-31' , 'F', 5808, 9308)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (809, 'asnxhf fobpps' , '1969-12-31' , 'M', 5809, 9309)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (810, 'amhnqr xtanph' , '1969-12-31' , 'F', 5810, 9310)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (811, 'ckwaup nlqdff' , '1969-12-31' , 'M', 5811, 9311)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (812, 'cfjxzh zaloji' , '1969-12-31' , 'F', 5812, 9312)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (813, 'kylfzz immivi' , '1969-12-31' , 'M', 5813, 9313)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (814, 'hthwuv bdqxyw' , '1969-12-31' , 'F', 5814, 9314)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (815, 'bcubzs ugdzpo' , '1969-12-31' , 'M', 5815, 9315)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (816, 'geuphf tdbikt' , '1969-12-31' , 'M', 5816, 9316)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (817, 'vhfgrz crmcfd' , '1969-12-31' , 'F', 5817, 9317)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (818, 'orfsqs whmosa' , '1969-12-31' , 'M', 5818, 9318)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (819, 'zeorxr iaszhn' , '1969-12-31' , 'F', 5819, 9319)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (820, 'vreocz ifboza' , '1969-12-31' , 'M', 5820, 9320)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (821, 'voupdp rwdjog' , '1969-12-31' , 'F', 5821, 9321)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (822, 'mnqfvk caaetv' , '1969-12-31' , 'F', 5822, 9322)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (823, 'nnypmw rnmxle' , '1969-12-31' , 'M', 5823, 9323)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (824, 'gkwnzx tboszh' , '1969-12-31' , 'M', 5824, 9324)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (825, 'zaqafz dcfytu' , '1969-12-31' , 'M', 5825, 9325)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (826, 'azsoxo rlqeja' , '1969-12-31' , 'M', 5826, 9326)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (827, 'qmtmwr pjoexj' , '1969-12-31' , 'M', 5827, 9327)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (828, 'asbmlh dyymba' , '1969-12-31' , 'F', 5828, 9328)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (829, 'bpqijm hngwmr' , '1969-12-31' , 'M', 5829, 9329)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (830, 'zemzrd wiucaj' , '1969-12-31' , 'M', 5830, 9330)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (831, 'khmwsp emikkw' , '1969-12-31' , 'F', 5831, 9331)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (832, 'veezlw zaiwkd' , '1969-12-31' , 'F', 5832, 9332)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (833, 'ebwkzw utbfph' , '1969-12-31' , 'M', 5833, 9333)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (834, 'ejqyfi jlmpht' , '1969-12-31' , 'F', 5834, 9334)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (835, 'lvemph qdnify' , '1969-12-31' , 'F', 5835, 9335)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (836, 'vnhbag cyikvw' , '1969-12-31' , 'M', 5836, 9336)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (837, 'axajqo nasltx' , '1969-12-31' , 'F', 5837, 9337)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (838, 'gyjltu gcytot' , '1969-12-31' , 'M', 5838, 9338)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (839, 'lieula ysvfcb' , '1969-12-31' , 'M', 5839, 9339)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (840, 'oyiaqn yqrqgz' , '1969-12-31' , 'M', 5840, 9340)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (841, 'arpajs mnjmlq' , '1969-12-31' , 'M', 5841, 9341)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (842, 'yjwblw wuexff' , '1969-12-31' , 'F', 5842, 9342)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (843, 'ezfisa hnbvow' , '1969-12-31' , 'F', 5843, 9343)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (844, 'cvyoey wmpmzv' , '1969-12-31' , 'M', 5844, 9344)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (845, 'ygpyww rtqaxv' , '1969-12-31' , 'F', 5845, 9345)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (846, 'nqzmkl gxypli' , '1969-12-31' , 'F', 5846, 9346)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (847, 'zjrkxh mbwicy' , '1969-12-31' , 'M', 5847, 9347)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (848, 'zkvjfu ofinch' , '1969-12-31' , 'F', 5848, 9348)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (849, 'rnnucl zpgiti' , '1969-12-31' , 'F', 5849, 9349)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (850, 'qrmhqi hzrqjf' , '1969-12-31' , 'M', 5850, 9350)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (851, 'avubtj toybod' , '1969-12-31' , 'F', 5851, 9351)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (852, 'ytycjl tinjhx' , '1969-12-31' , 'F', 5852, 9352)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (853, 'ubvgqz gcgvov' , '1969-12-31' , 'M', 5853, 9353)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (854, 'phtmxe ubpbnu' , '1969-12-31' , 'F', 5854, 9354)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (855, 'nwbumk uhwcih' , '1969-12-31' , 'M', 5855, 9355)
2012-05-24 17:25:37	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (856, 'wzjkue whnmqo' , '1969-12-31' , 'M', 5856, 9356)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (857, 'zrjvzz qeycxn' , '1969-12-31' , 'F', 5857, 9357)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (858, 'lzcdky ksubad' , '1969-12-31' , 'M', 5858, 9358)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (859, 'mrdknv dguocm' , '1969-12-31' , 'M', 5859, 9359)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (860, 'cyzkty bjsdfq' , '1969-12-31' , 'F', 5860, 9360)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (861, 'jcvgah frlrou' , '1969-12-31' , 'F', 5861, 9361)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (862, 'kregfk kwrhdo' , '1969-12-31' , 'M', 5862, 9362)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (863, 'zlaxfa glwwbd' , '1969-12-31' , 'M', 5863, 9363)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (864, 'jaszya wninnj' , '1969-12-31' , 'F', 5864, 9364)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (865, 'rdjrah hwoadl' , '1969-12-31' , 'F', 5865, 9365)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (866, 'ikyysq ickfin' , '1969-12-31' , 'F', 5866, 9366)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (867, 'piqyrh nyjlnt' , '1969-12-31' , 'F', 5867, 9367)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (868, 'bwnddx qnwoga' , '1969-12-31' , 'M', 5868, 9368)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (869, 'cspvbm eissvc' , '1969-12-31' , 'F', 5869, 9369)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (870, 'ugtpcn jrqjox' , '1969-12-31' , 'M', 5870, 9370)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (871, 'hkxwto huzenf' , '1969-12-31' , 'F', 5871, 9371)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (872, 'cgnwez lezwfe' , '1969-12-31' , 'M', 5872, 9372)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (873, 'astmvl ubbfvy' , '1969-12-31' , 'F', 5873, 9373)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (874, 'wpzrnd vsbwaj' , '1969-12-31' , 'F', 5874, 9374)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (875, 'vloxly dyljdq' , '1969-12-31' , 'F', 5875, 9375)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (876, 'qduwcd hclijw' , '1969-12-31' , 'M', 5876, 9376)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (877, 'awlrpl eevcaz' , '1969-12-31' , 'M', 5877, 9377)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (878, 'fosdyj gdfnyb' , '1969-12-31' , 'F', 5878, 9378)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (879, 'zsdplx desxaj' , '1969-12-31' , 'M', 5879, 9379)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (880, 'dsqdlw dzpmak' , '1969-12-31' , 'F', 5880, 9380)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (881, 'rupdxz vsfdyd' , '1969-12-31' , 'F', 5881, 9381)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (882, 'zigzoj vvszti' , '1969-12-31' , 'F', 5882, 9382)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (883, 'xbwxgg yoavub' , '1969-12-31' , 'F', 5883, 9383)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (884, 'qorfvh ftrepv' , '1969-12-31' , 'M', 5884, 9384)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (885, 'wxblwu pdrsoq' , '1969-12-31' , 'F', 5885, 9385)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (886, 'mfjnga buwvyq' , '1969-12-31' , 'M', 5886, 9386)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (887, 'mbswgh lyrvtp' , '1969-12-31' , 'M', 5887, 9387)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (888, 'zhtoke wnewxz' , '1969-12-31' , 'M', 5888, 9388)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (889, 'wirjqt rtitqs' , '1969-12-31' , 'M', 5889, 9389)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (890, 'ygotvm jfcamd' , '1969-12-31' , 'F', 5890, 9390)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (891, 'iqofpy lfeysi' , '1969-12-31' , 'F', 5891, 9391)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (892, 'stvbjd rggnja' , '1969-12-31' , 'F', 5892, 9392)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (893, 'ukxrpl fseilv' , '1969-12-31' , 'M', 5893, 9393)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (894, 'llaotw ybvyms' , '1969-12-31' , 'F', 5894, 9394)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (895, 'atkmyp jbpmfa' , '1969-12-31' , 'M', 5895, 9395)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (896, 'bmjmbq eehzva' , '1969-12-31' , 'F', 5896, 9396)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (897, 'muavsf ucnzjc' , '1969-12-31' , 'F', 5897, 9397)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (898, 'epkhfn hjphxy' , '1969-12-31' , 'M', 5898, 9398)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (899, 'uzcyic oeiohj' , '1969-12-31' , 'M', 5899, 9399)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (900, 'bwumvo ckhasz' , '1969-12-31' , 'F', 5900, 9400)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (901, 'utilse bjpoze' , '1969-12-31' , 'M', 5901, 9401)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (902, 'tnbzni hnqdyi' , '1969-12-31' , 'M', 5902, 9402)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (903, 'ectwxz hffsbk' , '1969-12-31' , 'F', 5903, 9403)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (904, 'ceotdk rqawym' , '1969-12-31' , 'F', 5904, 9404)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (905, 'phfgbd xvenku' , '1969-12-31' , 'F', 5905, 9405)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (906, 'kbcyvv hjzuvc' , '1969-12-31' , 'F', 5906, 9406)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (907, 'uuabwf vbbqbd' , '1969-12-31' , 'M', 5907, 9407)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (908, 'beiwni plbsif' , '1969-12-31' , 'F', 5908, 9408)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (909, 'bsfpul jfimxj' , '1969-12-31' , 'F', 5909, 9409)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (910, 'szzbeg lnzbui' , '1969-12-31' , 'F', 5910, 9410)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (911, 'dnmnon lvuyui' , '1969-12-31' , 'M', 5911, 9411)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (912, 'fiqwss dpkhvt' , '1969-12-31' , 'M', 5912, 9412)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (913, 'lqcfbs owhdfu' , '1969-12-31' , 'F', 5913, 9413)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (914, 'qylapw fzuzet' , '1969-12-31' , 'M', 5914, 9414)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (915, 'xwbvlh xfvezb' , '1969-12-31' , 'M', 5915, 9415)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (916, 'amasck chwyhw' , '1969-12-31' , 'F', 5916, 9416)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (917, 'jsjzlo putthx' , '1969-12-31' , 'M', 5917, 9417)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (918, 'ixtztm qjdovb' , '1969-12-31' , 'M', 5918, 9418)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (919, 'ruxhrr wtpvws' , '1969-12-31' , 'M', 5919, 9419)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (920, 'deqnjj pyrfjq' , '1969-12-31' , 'M', 5920, 9420)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (921, 'twurnn hfzpxm' , '1969-12-31' , 'F', 5921, 9421)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (922, 'sasmwi rkspsu' , '1969-12-31' , 'F', 5922, 9422)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (923, 'sqgbvb bvzxoz' , '1969-12-31' , 'M', 5923, 9423)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (924, 'peodxs vtgemq' , '1969-12-31' , 'F', 5924, 9424)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (925, 'hsaikl eettlg' , '1969-12-31' , 'M', 5925, 9425)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (926, 'atzxde aqdkic' , '1969-12-31' , 'F', 5926, 9426)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (927, 'cawrvq aaaqqe' , '1969-12-31' , 'M', 5927, 9427)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (928, 'mvqdsx tiyfnv' , '1969-12-31' , 'F', 5928, 9428)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (929, 'dpflag ipyefp' , '1969-12-31' , 'F', 5929, 9429)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (930, 'sxyycx kalrxo' , '1969-12-31' , 'F', 5930, 9430)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (931, 'uzxjgl ljbgft' , '1969-12-31' , 'M', 5931, 9431)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (932, 'vybaqn gkdaec' , '1969-12-31' , 'F', 5932, 9432)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (933, 'pyurub ejxdhw' , '1969-12-31' , 'M', 5933, 9433)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (934, 'owxcnv smphim' , '1969-12-31' , 'M', 5934, 9434)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (935, 'xgapkc tkpeez' , '1969-12-31' , 'M', 5935, 9435)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (936, 'smwkva cakahe' , '1969-12-31' , 'F', 5936, 9436)
2012-05-24 17:25:38	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (937, 'nfgeqt liafew' , '1969-12-31' , 'F', 5937, 9437)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (938, 'ikwhke frjtgo' , '1969-12-31' , 'F', 5938, 9438)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (939, 'jsdmyl rrdkmp' , '1969-12-31' , 'M', 5939, 9439)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (940, 'dcobzy ovzcmq' , '1969-12-31' , 'F', 5940, 9440)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (941, 'bbmxys ejlnzg' , '1969-12-31' , 'F', 5941, 9441)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (942, 'hwovyl vincbg' , '1969-12-31' , 'M', 5942, 9442)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (943, 'ohektt zcxaif' , '1969-12-31' , 'F', 5943, 9443)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (944, 'qqrglb xynbyw' , '1969-12-31' , 'M', 5944, 9444)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (945, 'gwhoob lbagaz' , '1969-12-31' , 'M', 5945, 9445)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (946, 'tqtqvb pmdyvk' , '1969-12-31' , 'F', 5946, 9446)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (947, 'kiznxj hnomcv' , '1969-12-31' , 'F', 5947, 9447)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (948, 'sreqqp qwemkt' , '1969-12-31' , 'F', 5948, 9448)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (949, 'zqvaur ogchne' , '1969-12-31' , 'F', 5949, 9449)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (950, 'doikrf qmgdxw' , '1969-12-31' , 'F', 5950, 9450)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (951, 'juxfbu qyibhg' , '1969-12-31' , 'M', 5951, 9451)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (952, 'mupzut dhmkat' , '1969-12-31' , 'M', 5952, 9452)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (953, 'wwcetu fuaxqo' , '1969-12-31' , 'F', 5953, 9453)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (954, 'zsokts xqgxxz' , '1969-12-31' , 'M', 5954, 9454)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (955, 'jkdrqc hrtext' , '1969-12-31' , 'F', 5955, 9455)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (956, 'lbzuwo qrivcv' , '1969-12-31' , 'F', 5956, 9456)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (957, 'qsjevc xchoql' , '1969-12-31' , 'F', 5957, 9457)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (958, 'bkmdcl qkylgz' , '1969-12-31' , 'M', 5958, 9458)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (959, 'crnnfz coqnxs' , '1969-12-31' , 'M', 5959, 9459)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (960, 'zviuhm npppbr' , '1969-12-31' , 'M', 5960, 9460)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (961, 'ixknce nijgml' , '1969-12-31' , 'F', 5961, 9461)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (962, 'rlhytg vjuczj' , '1969-12-31' , 'M', 5962, 9462)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (963, 'lcqdqv safnwt' , '1969-12-31' , 'F', 5963, 9463)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (964, 'hcprua uoljjs' , '1969-12-31' , 'M', 5964, 9464)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (965, 'belllt ayinnx' , '1969-12-31' , 'F', 5965, 9465)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (966, 'loygdz pyrjit' , '1969-12-31' , 'F', 5966, 9466)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (967, 'ptagqy fmsslv' , '1969-12-31' , 'M', 5967, 9467)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (968, 'wdixva yxkrho' , '1969-12-31' , 'M', 5968, 9468)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (969, 'lgjacz ncjlxy' , '1969-12-31' , 'F', 5969, 9469)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (970, 'yekajk zoxifz' , '1969-12-31' , 'F', 5970, 9470)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (971, 'wrbspx fvxtik' , '1969-12-31' , 'M', 5971, 9471)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (972, 'tseqsp iioczh' , '1969-12-31' , 'M', 5972, 9472)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (973, 'yyxbru ipbrmu' , '1969-12-31' , 'M', 5973, 9473)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (974, 'yzcazz zafwry' , '1969-12-31' , 'F', 5974, 9474)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (975, 'czkowb ethmph' , '1969-12-31' , 'M', 5975, 9475)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (976, 'hnfpyg svelur' , '1969-12-31' , 'M', 5976, 9476)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (977, 'bsoldt crkpda' , '1969-12-31' , 'F', 5977, 9477)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (978, 'rulpas iixbcs' , '1969-12-31' , 'F', 5978, 9478)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (979, 'bmqklw gsqoeo' , '1969-12-31' , 'M', 5979, 9479)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (980, 'femhsg qhjqug' , '1969-12-31' , 'F', 5980, 9480)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (981, 'tszryk purqsl' , '1969-12-31' , 'M', 5981, 9481)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (982, 'llwaoi qotexz' , '1969-12-31' , 'M', 5982, 9482)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (983, 'hlgxtj fxeqpp' , '1969-12-31' , 'F', 5983, 9483)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (984, 'iwkwzb rxqayz' , '1969-12-31' , 'M', 5984, 9484)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (985, 'hbddmk shsmyv' , '1969-12-31' , 'F', 5985, 9485)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (986, 'dtxhyw fqeqhp' , '1969-12-31' , 'M', 5986, 9486)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (987, 'muemhs ycysaj' , '1969-12-31' , 'F', 5987, 9487)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (988, 'cylhcu ifosdd' , '1969-12-31' , 'F', 5988, 9488)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (989, 'cvazkg hkmyer' , '1969-12-31' , 'M', 5989, 9489)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (990, 'beeoiz dvtetq' , '1969-12-31' , 'F', 5990, 9490)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (991, 'hgvraj zmysjr' , '1969-12-31' , 'F', 5991, 9491)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (992, 'fclndp lylwdx' , '1969-12-31' , 'M', 5992, 9492)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (993, 'kjurqx wulzpg' , '1969-12-31' , 'M', 5993, 9493)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (994, 'uykozt vtetpp' , '1969-12-31' , 'M', 5994, 9494)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (995, 'gtabrp olmnpg' , '1969-12-31' , 'M', 5995, 9495)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (996, 'mbkevs xcqrey' , '1969-12-31' , 'M', 5996, 9496)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (997, 'bepean zprxvo' , '1969-12-31' , 'F', 5997, 9497)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (998, 'kuxshm mefcmr' , '1969-12-31' , 'M', 5998, 9498)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (999, 'buimqb ncrctt' , '1969-12-31' , 'F', 5999, 9499)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1000, 'azzlbu eduggu' , '1969-12-31' , 'M', 6000, 9500)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1001, 'uqzdqn tactlc' , '1969-12-31' , 'M', 6001, 9501)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1002, 'exmrxa kjhcpf' , '1969-12-31' , 'M', 6002, 9502)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1003, 'viizzh vvumnq' , '1969-12-31' , 'M', 6003, 9503)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1004, 'jjaxua sxtbka' , '1969-12-31' , 'M', 6004, 9504)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1005, 'uanbvq riqoqt' , '1969-12-31' , 'F', 6005, 9505)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1006, 'xgvlbr echefv' , '1969-12-31' , 'M', 6006, 9506)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1007, 'zkcgsf lhublf' , '1969-12-31' , 'F', 6007, 9507)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1008, 'xbexwi uzqixo' , '1969-12-31' , 'M', 6008, 9508)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1009, 'cxwlgs pvfqeu' , '1969-12-31' , 'M', 6009, 9509)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1010, 'wacsmi uehobm' , '1969-12-31' , 'M', 6010, 9510)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1011, 'rvwncd iwuecq' , '1969-12-31' , 'F', 6011, 9511)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1012, 'yerzdl oiyqau' , '1969-12-31' , 'F', 6012, 9512)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1013, 'zoeyxp vsfovc' , '1969-12-31' , 'F', 6013, 9513)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1014, 'ypyibx yvpthy' , '1969-12-31' , 'F', 6014, 9514)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1015, 'lksbcs vqffsv' , '1969-12-31' , 'M', 6015, 9515)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1016, 'bdcsop rfkegr' , '1969-12-31' , 'M', 6016, 9516)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1017, 'ijgijj zkisru' , '1969-12-31' , 'F', 6017, 9517)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1018, 'vsrzji ojllay' , '1969-12-31' , 'F', 6018, 9518)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1019, 'fnaola neiyoc' , '1969-12-31' , 'F', 6019, 9519)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1020, 'dbgwns dlmsdf' , '1969-12-31' , 'M', 6020, 9520)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1021, 'kbfnqw nbidls' , '1969-12-31' , 'F', 6021, 9521)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1022, 'ucqozm krcxjf' , '1969-12-31' , 'M', 6022, 9522)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1023, 'oxpipf gbtsjx' , '1969-12-31' , 'F', 6023, 9523)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1024, 'thcyni glzruj' , '1969-12-31' , 'M', 6024, 9524)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1025, 'ujcelt tqvwoh' , '1969-12-31' , 'M', 6025, 9525)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1026, 'wiprku qcuemi' , '1969-12-31' , 'M', 6026, 9526)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1027, 'yejezv qsnmjk' , '1969-12-31' , 'F', 6027, 9527)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1028, 'hcvvvc pupegv' , '1969-12-31' , 'M', 6028, 9528)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1029, 'ppxdlk usqkuq' , '1969-12-31' , 'M', 6029, 9529)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1030, 'kenmmf ybasnf' , '1969-12-31' , 'F', 6030, 9530)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1031, 'ehipig akpvsg' , '1969-12-31' , 'F', 6031, 9531)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1032, 'dgxlbo rebvgf' , '1969-12-31' , 'F', 6032, 9532)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1033, 'jfnlfs qvcgmn' , '1969-12-31' , 'M', 6033, 9533)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1034, 'luswxr ljseak' , '1969-12-31' , 'F', 6034, 9534)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1035, 'xrholq qxbrgg' , '1969-12-31' , 'F', 6035, 9535)
2012-05-24 17:25:39	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1036, 'virgwt vtjmur' , '1969-12-31' , 'F', 6036, 9536)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1037, 'remflr npiwrt' , '1969-12-31' , 'M', 6037, 9537)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1038, 'spdhwe lrjsav' , '1969-12-31' , 'M', 6038, 9538)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1039, 'bvgisx pdewyu' , '1969-12-31' , 'F', 6039, 9539)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1040, 'lekvnk cgmmnj' , '1969-12-31' , 'F', 6040, 9540)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1041, 'gdjsud vicogq' , '1969-12-31' , 'M', 6041, 9541)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1042, 'wyysrn esmpws' , '1969-12-31' , 'M', 6042, 9542)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1043, 'sjakrn bsdonp' , '1969-12-31' , 'M', 6043, 9543)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1044, 'octbbb tawhps' , '1969-12-31' , 'M', 6044, 9544)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1045, 'lkjoct tmtrcc' , '1969-12-31' , 'M', 6045, 9545)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1046, 'godjfh xjdpcw' , '1969-12-31' , 'F', 6046, 9546)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1047, 'xdiywi zwhnav' , '1969-12-31' , 'F', 6047, 9547)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1048, 'iecgbl narvdq' , '1969-12-31' , 'M', 6048, 9548)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1049, 'qruqmt vbljhn' , '1969-12-31' , 'F', 6049, 9549)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1050, 'lmskme pcmdva' , '1969-12-31' , 'F', 6050, 9550)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1051, 'dpperr mavets' , '1969-12-31' , 'F', 6051, 9551)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1052, 'lplidc yeehmd' , '1969-12-31' , 'F', 6052, 9552)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1053, 'ikunks ykvlnw' , '1969-12-31' , 'F', 6053, 9553)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1054, 'avksbt rbfpke' , '1969-12-31' , 'M', 6054, 9554)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1055, 'dyhcop uaplsz' , '1969-12-31' , 'M', 6055, 9555)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1056, 'jlwtgs uaypbl' , '1969-12-31' , 'M', 6056, 9556)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1057, 'esmapr lgkvmy' , '1969-12-31' , 'F', 6057, 9557)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1058, 'ruyumh bvgyvm' , '1969-12-31' , 'M', 6058, 9558)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1059, 'eqvgps gzipit' , '1969-12-31' , 'F', 6059, 9559)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1060, 'uhyofl oqctqt' , '1969-12-31' , 'M', 6060, 9560)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1061, 'icircs redyzl' , '1969-12-31' , 'M', 6061, 9561)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1062, 'jkrmvl bfczhz' , '1969-12-31' , 'M', 6062, 9562)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1063, 'icbcbi fkfxwh' , '1969-12-31' , 'M', 6063, 9563)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1064, 'mpoiur niohsq' , '1969-12-31' , 'F', 6064, 9564)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1065, 'dbugxp qxqxns' , '1969-12-31' , 'F', 6065, 9565)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1066, 'nzdipo ewsvlc' , '1969-12-31' , 'M', 6066, 9566)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1067, 'qhqpxc zqthbl' , '1969-12-31' , 'F', 6067, 9567)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1068, 'qmuqvt oloqkb' , '1969-12-31' , 'F', 6068, 9568)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1069, 'pjnvnb hedaly' , '1969-12-31' , 'M', 6069, 9569)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1070, 'hbdehr ntzywj' , '1969-12-31' , 'M', 6070, 9570)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1071, 'edvbjd visexk' , '1969-12-31' , 'F', 6071, 9571)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1072, 'nyddge umvrbw' , '1969-12-31' , 'F', 6072, 9572)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1073, 'aniezb fqbwot' , '1969-12-31' , 'M', 6073, 9573)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1074, 'csxiir ltqrsq' , '1969-12-31' , 'M', 6074, 9574)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1075, 'hdkwyc yrofou' , '1969-12-31' , 'F', 6075, 9575)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1076, 'itsdmu ukqmjd' , '1969-12-31' , 'F', 6076, 9576)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1077, 'lwaluv efpaxv' , '1969-12-31' , 'F', 6077, 9577)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1078, 'ylmzqh rvtxpg' , '1969-12-31' , 'M', 6078, 9578)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1079, 'gnziyh xdtsnx' , '1969-12-31' , 'M', 6079, 9579)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1080, 'gzujam ermxrx' , '1969-12-31' , 'M', 6080, 9580)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1081, 'bngwws lzqkeu' , '1969-12-31' , 'F', 6081, 9581)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1082, 'sappqp renwlx' , '1969-12-31' , 'M', 6082, 9582)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1083, 'uzjhkt rwhocy' , '1969-12-31' , 'M', 6083, 9583)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1084, 'hjpxru zprfmc' , '1969-12-31' , 'M', 6084, 9584)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1085, 'measqq qzsymt' , '1969-12-31' , 'M', 6085, 9585)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1086, 'hxggzc gxhybc' , '1969-12-31' , 'F', 6086, 9586)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1087, 'foukzx zdrhfn' , '1969-12-31' , 'M', 6087, 9587)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1088, 'nortoo lkxszj' , '1969-12-31' , 'F', 6088, 9588)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1089, 'qvjfyh exzuib' , '1969-12-31' , 'F', 6089, 9589)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1090, 'lnosmr doqvyo' , '1969-12-31' , 'F', 6090, 9590)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1091, 'xpbeff yzkqgj' , '1969-12-31' , 'M', 6091, 9591)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1092, 'gyxsfn fuyvsa' , '1969-12-31' , 'F', 6092, 9592)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1093, 'agjnid ekjqpp' , '1969-12-31' , 'F', 6093, 9593)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1094, 'htklpf zbcqmb' , '1969-12-31' , 'F', 6094, 9594)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1095, 'tsfbtn ktdywf' , '1969-12-31' , 'M', 6095, 9595)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1096, 'zpkcul hekhnq' , '1969-12-31' , 'M', 6096, 9596)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1097, 'xtohfu imvmxm' , '1969-12-31' , 'F', 6097, 9597)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1098, 'dnsteh nvnzgz' , '1969-12-31' , 'F', 6098, 9598)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1099, 'pjayur jsfbfy' , '1969-12-31' , 'M', 6099, 9599)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1100, 'ujworo jqizby' , '1969-12-31' , 'F', 6100, 9600)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1101, 'otftrt ubqyol' , '1969-12-31' , 'F', 6101, 9601)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1102, 'armxkq qmhfsg' , '1969-12-31' , 'M', 6102, 9602)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1103, 'gxqqkj bdoeqw' , '1969-12-31' , 'F', 6103, 9603)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1104, 'ppcvlp jsauao' , '1969-12-31' , 'F', 6104, 9604)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1105, 'pcohki zoiehb' , '1969-12-31' , 'M', 6105, 9605)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1106, 'doview bcsaia' , '1969-12-31' , 'M', 6106, 9606)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1107, 'nivaws bjwmlr' , '1969-12-31' , 'M', 6107, 9607)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1108, 'fexldb kvbdea' , '1969-12-31' , 'M', 6108, 9608)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1109, 'xjexvn igfjzp' , '1969-12-31' , 'M', 6109, 9609)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1110, 'puywgc qjsrbl' , '1969-12-31' , 'M', 6110, 9610)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1111, 'qtioce jdkmrc' , '1969-12-31' , 'F', 6111, 9611)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1112, 'rllesm jbxzdf' , '1969-12-31' , 'F', 6112, 9612)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1113, 'mxcomw eezjce' , '1969-12-31' , 'M', 6113, 9613)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1114, 'mtixeo mnpkoi' , '1969-12-31' , 'M', 6114, 9614)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1115, 'owpkkb gxjzki' , '1969-12-31' , 'F', 6115, 9615)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1116, 'urdhaz euklww' , '1969-12-31' , 'F', 6116, 9616)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1117, 'hpunaw gjbfhy' , '1969-12-31' , 'F', 6117, 9617)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1118, 'ohnhrb vyfxer' , '1969-12-31' , 'F', 6118, 9618)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1119, 'pindgi xtxdlt' , '1969-12-31' , 'M', 6119, 9619)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1120, 'povixt pkqszc' , '1969-12-31' , 'M', 6120, 9620)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1121, 'dstfzh cmcoui' , '1969-12-31' , 'M', 6121, 9621)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1122, 'nargrf wrledz' , '1969-12-31' , 'F', 6122, 9622)
2012-05-24 17:25:40	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1123, 'fyezmf yzgctf' , '1969-12-31' , 'M', 6123, 9623)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1124, 'rqjlws omhjyr' , '1969-12-31' , 'F', 6124, 9624)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1125, 'hcfhiz wpouns' , '1969-12-31' , 'F', 6125, 9625)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1126, 'jyewdi clinkv' , '1969-12-31' , 'F', 6126, 9626)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1127, 'kxihwc bhjozj' , '1969-12-31' , 'F', 6127, 9627)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1128, 'dfdatp vmgqvw' , '1969-12-31' , 'M', 6128, 9628)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1129, 'ritsvh jnngsu' , '1969-12-31' , 'M', 6129, 9629)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1130, 'vxowpy wbhvmk' , '1969-12-31' , 'M', 6130, 9630)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1131, 'hdzumh xsbrcl' , '1969-12-31' , 'F', 6131, 9631)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1132, 'sxdxgu ufizhr' , '1969-12-31' , 'F', 6132, 9632)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1133, 'qbckjp adjvrk' , '1969-12-31' , 'M', 6133, 9633)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1134, 'ndxcvm zjvtko' , '1969-12-31' , 'F', 6134, 9634)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1135, 'fptjjg tqujzd' , '1969-12-31' , 'M', 6135, 9635)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1136, 'tkgpcq smtpoq' , '1969-12-31' , 'F', 6136, 9636)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1137, 'amnrio uzxlby' , '1969-12-31' , 'M', 6137, 9637)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1138, 'awmgil hmtwwp' , '1969-12-31' , 'F', 6138, 9638)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1139, 'zlfcsg qwpoyi' , '1969-12-31' , 'F', 6139, 9639)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1140, 'podpnv ugimgu' , '1969-12-31' , 'M', 6140, 9640)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1141, 'csksuw npvxii' , '1969-12-31' , 'F', 6141, 9641)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1142, 'lfzjma zkpuyp' , '1969-12-31' , 'F', 6142, 9642)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1143, 'eevpiu mizocj' , '1969-12-31' , 'M', 6143, 9643)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1144, 'rnjzcp yqmbwh' , '1969-12-31' , 'M', 6144, 9644)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1145, 'tokqfu aecjmo' , '1969-12-31' , 'F', 6145, 9645)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1146, 'jyafve zegaec' , '1969-12-31' , 'F', 6146, 9646)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1147, 'kngipp jluhyc' , '1969-12-31' , 'M', 6147, 9647)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1148, 'xwacon wdprpb' , '1969-12-31' , 'M', 6148, 9648)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1149, 'atdnjn ioihrm' , '1969-12-31' , 'M', 6149, 9649)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1150, 'dnrcct yntpha' , '1969-12-31' , 'M', 6150, 9650)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1151, 'lmhzpy rzgnwi' , '1969-12-31' , 'M', 6151, 9651)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1152, 'qswmfl mgwzsk' , '1969-12-31' , 'F', 6152, 9652)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1153, 'tywyjd xpeyjs' , '1969-12-31' , 'M', 6153, 9653)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1154, 'egyuiq gnvxjq' , '1969-12-31' , 'F', 6154, 9654)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1155, 'qsoabc qbkiwt' , '1969-12-31' , 'F', 6155, 9655)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1156, 'veivoc qyvoml' , '1969-12-31' , 'M', 6156, 9656)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1157, 'ndufoy blzmge' , '1969-12-31' , 'M', 6157, 9657)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1158, 'lpbxar wjhzif' , '1969-12-31' , 'F', 6158, 9658)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1159, 'obuypc rxgqoi' , '1969-12-31' , 'M', 6159, 9659)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1160, 'wgownc brgbem' , '1969-12-31' , 'F', 6160, 9660)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1161, 'cjmzht mcukia' , '1969-12-31' , 'F', 6161, 9661)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1162, 'pbcfsc yxnush' , '1969-12-31' , 'F', 6162, 9662)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1163, 'lehvow blmazu' , '1969-12-31' , 'M', 6163, 9663)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1164, 'kjmsac kxyigq' , '1969-12-31' , 'M', 6164, 9664)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1165, 'drkjje pvhukm' , '1969-12-31' , 'F', 6165, 9665)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1166, 'yjxavz uincaa' , '1969-12-31' , 'M', 6166, 9666)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1167, 'uvndgc zhvvdr' , '1969-12-31' , 'M', 6167, 9667)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1168, 'qucuvj oukidn' , '1969-12-31' , 'M', 6168, 9668)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1169, 'xwybxa orzwnr' , '1969-12-31' , 'M', 6169, 9669)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1170, 'zmlroz ftxbnf' , '1969-12-31' , 'F', 6170, 9670)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1171, 'espriv pnzyhe' , '1969-12-31' , 'M', 6171, 9671)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1172, 'sbyvsk gqzhgu' , '1969-12-31' , 'M', 6172, 9672)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1173, 'vzbrtk fkibrn' , '1969-12-31' , 'M', 6173, 9673)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1174, 'cdygak mkmynl' , '1969-12-31' , 'F', 6174, 9674)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1175, 'horehn xslgux' , '1969-12-31' , 'F', 6175, 9675)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1176, 'khatff asqlox' , '1969-12-31' , 'F', 6176, 9676)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1177, 'behgsi rlaeqj' , '1969-12-31' , 'M', 6177, 9677)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1178, 'kpzcap nivbev' , '1969-12-31' , 'F', 6178, 9678)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1179, 'jinoro vahtbr' , '1969-12-31' , 'M', 6179, 9679)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1180, 'zjpaiv wycinc' , '1969-12-31' , 'M', 6180, 9680)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1181, 'oxvyjl bztaeg' , '1969-12-31' , 'M', 6181, 9681)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1182, 'mibkrx vwpgwd' , '1969-12-31' , 'F', 6182, 9682)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1183, 'gufdpp olcoej' , '1969-12-31' , 'F', 6183, 9683)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1184, 'gencho xrztis' , '1969-12-31' , 'F', 6184, 9684)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1185, 'ahdrkz nnwhgb' , '1969-12-31' , 'F', 6185, 9685)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1186, 'qigmca isqgxy' , '1969-12-31' , 'F', 6186, 9686)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1187, 'bxjswd fqgeqk' , '1969-12-31' , 'F', 6187, 9687)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1188, 'phvfmy hzryyn' , '1969-12-31' , 'M', 6188, 9688)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1189, 'oslfyq lrkxcp' , '1969-12-31' , 'M', 6189, 9689)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1190, 'iuttae clnnar' , '1969-12-31' , 'F', 6190, 9690)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1191, 'hjnnaz gusnko' , '1969-12-31' , 'F', 6191, 9691)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1192, 'xqyukv wkbbxj' , '1969-12-31' , 'F', 6192, 9692)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1193, 'qikspu vnvyri' , '1969-12-31' , 'M', 6193, 9693)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1194, 'ypzblb rnguum' , '1969-12-31' , 'M', 6194, 9694)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1195, 'zckdtj ieoamw' , '1969-12-31' , 'M', 6195, 9695)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1196, 'cyvsmv isimpg' , '1969-12-31' , 'M', 6196, 9696)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1197, 'cyevch jwnqeh' , '1969-12-31' , 'F', 6197, 9697)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1198, 'nbjofi ssdyhk' , '1969-12-31' , 'F', 6198, 9698)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1199, 'hmguww wsgskd' , '1969-12-31' , 'M', 6199, 9699)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1200, 'ueskld ghoyvc' , '1969-12-31' , 'M', 6200, 9700)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1201, 'asjiuu vnquri' , '1969-12-31' , 'F', 6201, 9701)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1202, 'zbfyzw whrtjh' , '1969-12-31' , 'M', 6202, 9702)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1203, 'leuuca fhprty' , '1969-12-31' , 'M', 6203, 9703)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1204, 'kvfgql rqmfau' , '1969-12-31' , 'M', 6204, 9704)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1205, 'fopzwo wmznzq' , '1969-12-31' , 'F', 6205, 9705)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1206, 'dhzkep thlfpq' , '1969-12-31' , 'M', 6206, 9706)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1207, 'sjjxww jkgpmg' , '1969-12-31' , 'F', 6207, 9707)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1208, 'rtippb zyrdgo' , '1969-12-31' , 'M', 6208, 9708)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1209, 'ogcquy ryunjy' , '1969-12-31' , 'M', 6209, 9709)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1210, 'wcocrq vfzewl' , '1969-12-31' , 'M', 6210, 9710)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1211, 'pqxolr ztydry' , '1969-12-31' , 'M', 6211, 9711)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1212, 'nibqsc prfivp' , '1969-12-31' , 'M', 6212, 9712)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1213, 'whcuax aacony' , '1969-12-31' , 'F', 6213, 9713)
2012-05-24 17:25:41	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1214, 'jxetdc sfprmm' , '1969-12-31' , 'M', 6214, 9714)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1215, 'hgdwrp wrsvtv' , '1969-12-31' , 'F', 6215, 9715)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1216, 'jkdaga wshmtd' , '1969-12-31' , 'M', 6216, 9716)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1217, 'sxjosw efhosr' , '1969-12-31' , 'M', 6217, 9717)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1218, 'hucgti iaplqm' , '1969-12-31' , 'M', 6218, 9718)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1219, 'bbirzu sqsgoy' , '1969-12-31' , 'M', 6219, 9719)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1220, 'yytugx dfjtzz' , '1969-12-31' , 'F', 6220, 9720)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1221, 'vpwvpl lxphdz' , '1969-12-31' , 'F', 6221, 9721)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1222, 'bzqjeb sogsqi' , '1969-12-31' , 'F', 6222, 9722)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1223, 'bjoylu hkitay' , '1969-12-31' , 'F', 6223, 9723)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1224, 'pgqdgg exovjl' , '1969-12-31' , 'F', 6224, 9724)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1225, 'mmfcgc euvznm' , '1969-12-31' , 'M', 6225, 9725)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1226, 'iqqagl wskquv' , '1969-12-31' , 'F', 6226, 9726)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1227, 'njkpty lcpjsr' , '1969-12-31' , 'F', 6227, 9727)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1228, 'kmbuiq asmymf' , '1969-12-31' , 'F', 6228, 9728)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1229, 'oznnml lmqtol' , '1969-12-31' , 'M', 6229, 9729)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1230, 'pkxfpv bxgavg' , '1969-12-31' , 'F', 6230, 9730)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1231, 'byqygy fjmjgi' , '1969-12-31' , 'M', 6231, 9731)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1232, 'afqqjv rcgfxo' , '1969-12-31' , 'F', 6232, 9732)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1233, 'ahwovl gpzqcc' , '1969-12-31' , 'M', 6233, 9733)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1234, 'jbtpjw jgmdwp' , '1969-12-31' , 'F', 6234, 9734)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1235, 'muueec cjsccy' , '1969-12-31' , 'M', 6235, 9735)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1236, 'mvbkqb hueahc' , '1969-12-31' , 'F', 6236, 9736)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1237, 'ocqvgc cwtwlz' , '1969-12-31' , 'M', 6237, 9737)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1238, 'qhrukv dhelvx' , '1969-12-31' , 'M', 6238, 9738)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1239, 'fookss ximafj' , '1969-12-31' , 'F', 6239, 9739)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1240, 'rpeopa kxspfm' , '1969-12-31' , 'F', 6240, 9740)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1241, 'jafqzj anviee' , '1969-12-31' , 'M', 6241, 9741)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1242, 'zptrjg qxrnub' , '1969-12-31' , 'M', 6242, 9742)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1243, 'uemdwd jkryow' , '1969-12-31' , 'M', 6243, 9743)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1244, 'kgywkw pgnuql' , '1969-12-31' , 'M', 6244, 9744)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1245, 'xffglx cxuesq' , '1969-12-31' , 'M', 6245, 9745)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1246, 'jtvwcb fizcrl' , '1969-12-31' , 'M', 6246, 9746)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1247, 'saiiul cefyty' , '1969-12-31' , 'M', 6247, 9747)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1248, 'iaqeat bcgrdi' , '1969-12-31' , 'F', 6248, 9748)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1249, 'helldr ntolfq' , '1969-12-31' , 'F', 6249, 9749)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1250, 'byynmh kfiuio' , '1969-12-31' , 'F', 6250, 9750)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1251, 'gyfvgu gevwpl' , '1969-12-31' , 'M', 6251, 9751)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1252, 'zhgmyg hrmoak' , '1969-12-31' , 'M', 6252, 9752)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1253, 'jryspq stutna' , '1969-12-31' , 'F', 6253, 9753)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1254, 'tvepdi wsrbsc' , '1969-12-31' , 'F', 6254, 9754)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1255, 'uupzrg cvitrh' , '1969-12-31' , 'M', 6255, 9755)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1256, 'kpjmjw itkyzu' , '1969-12-31' , 'F', 6256, 9756)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1257, 'arcagf ppmbde' , '1969-12-31' , 'F', 6257, 9757)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1258, 'tiichh hrwojz' , '1969-12-31' , 'M', 6258, 9758)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1259, 'udbnfb ibftjy' , '1969-12-31' , 'F', 6259, 9759)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1260, 'sajjht rybaki' , '1969-12-31' , 'F', 6260, 9760)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1261, 'gzvbxf fdqdnx' , '1969-12-31' , 'F', 6261, 9761)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1262, 'mfymiw loeouf' , '1969-12-31' , 'F', 6262, 9762)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1263, 'rcybjb grvwld' , '1969-12-31' , 'F', 6263, 9763)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1264, 'dlfmjt nvjqdy' , '1969-12-31' , 'M', 6264, 9764)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1265, 'qbnghv qxwftc' , '1969-12-31' , 'F', 6265, 9765)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1266, 'hopuyo eoxdpg' , '1969-12-31' , 'M', 6266, 9766)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1267, 'kkklwc oilgni' , '1969-12-31' , 'M', 6267, 9767)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1268, 'cwmdlm cwwpub' , '1969-12-31' , 'M', 6268, 9768)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1269, 'ozkyck fjdnnc' , '1969-12-31' , 'F', 6269, 9769)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1270, 'logmgd xzyxvo' , '1969-12-31' , 'F', 6270, 9770)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1271, 'qoqyij eplkex' , '1969-12-31' , 'F', 6271, 9771)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1272, 'iyxpxh pqocag' , '1969-12-31' , 'M', 6272, 9772)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1273, 'peveyh flolab' , '1969-12-31' , 'M', 6273, 9773)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1274, 'vuskyr uuguyd' , '1969-12-31' , 'F', 6274, 9774)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1275, 'fwqueo llhkwj' , '1969-12-31' , 'F', 6275, 9775)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1276, 'lntlou mscxez' , '1969-12-31' , 'M', 6276, 9776)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1277, 'cbejff zfjtoe' , '1969-12-31' , 'F', 6277, 9777)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1278, 'tgwzim usqrno' , '1969-12-31' , 'F', 6278, 9778)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1279, 'qljvxd nosbyy' , '1969-12-31' , 'F', 6279, 9779)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1280, 'yvuomv xobrjj' , '1969-12-31' , 'M', 6280, 9780)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1281, 'rabqpo olelyx' , '1969-12-31' , 'F', 6281, 9781)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1282, 'xljsup gqeiod' , '1969-12-31' , 'M', 6282, 9782)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1283, 'acrzqj iydkqs' , '1969-12-31' , 'F', 6283, 9783)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1284, 'wrpdau hnxlgq' , '1969-12-31' , 'F', 6284, 9784)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1285, 'tfiztm jsmvvx' , '1969-12-31' , 'M', 6285, 9785)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1286, 'rolzib wfhauo' , '1969-12-31' , 'M', 6286, 9786)
2012-05-24 17:25:42	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1287, 'kebpqn xloicw' , '1969-12-31' , 'M', 6287, 9787)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1288, 'rftwuh fkckya' , '1969-12-31' , 'M', 6288, 9788)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1289, 'btylmd fgztsg' , '1969-12-31' , 'F', 6289, 9789)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1290, 'gottxe ifqtrd' , '1969-12-31' , 'F', 6290, 9790)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1291, 'ptrimr wbgxbe' , '1969-12-31' , 'F', 6291, 9791)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1292, 'aqfdmz xvxfdk' , '1969-12-31' , 'M', 6292, 9792)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1293, 'mxsugy ogqzrm' , '1969-12-31' , 'M', 6293, 9793)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1294, 'pznrvo ggsnvr' , '1969-12-31' , 'F', 6294, 9794)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1295, 'vcowbo nkjpby' , '1969-12-31' , 'M', 6295, 9795)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1296, 'lvheei fwcqil' , '1969-12-31' , 'F', 6296, 9796)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1297, 'noighc nngovr' , '1969-12-31' , 'F', 6297, 9797)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1298, 'ipgokw nntlld' , '1969-12-31' , 'M', 6298, 9798)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1299, 'wsfmij fzodbo' , '1969-12-31' , 'M', 6299, 9799)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1300, 'uzbsmq tgufqb' , '1969-12-31' , 'F', 6300, 9800)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1301, 'jnrtrk fujenv' , '1969-12-31' , 'M', 6301, 9801)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1302, 'lndoij ulfinr' , '1969-12-31' , 'F', 6302, 9802)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1303, 'jyzqhw xsdxin' , '1969-12-31' , 'F', 6303, 9803)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1304, 'blabtg odtyiu' , '1969-12-31' , 'F', 6304, 9804)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1305, 'ojqrsz hzgvog' , '1969-12-31' , 'M', 6305, 9805)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1306, 'ewrmll kcubvq' , '1969-12-31' , 'F', 6306, 9806)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1307, 'chcyyq eigkdz' , '1969-12-31' , 'F', 6307, 9807)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1308, 'plcmil pragoq' , '1969-12-31' , 'M', 6308, 9808)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1309, 'hgaknv xrdpis' , '1969-12-31' , 'F', 6309, 9809)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1310, 'bwzacr inunch' , '1969-12-31' , 'F', 6310, 9810)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1311, 'bememk tmgjuo' , '1969-12-31' , 'M', 6311, 9811)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1312, 'tzzthv lnqyck' , '1969-12-31' , 'M', 6312, 9812)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1313, 'lkwusi fvtlej' , '1969-12-31' , 'M', 6313, 9813)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1314, 'ciwdgj xhhvjf' , '1969-12-31' , 'M', 6314, 9814)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1315, 'nhydls vxcbbw' , '1969-12-31' , 'F', 6315, 9815)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1316, 'athgec eiwakh' , '1969-12-31' , 'F', 6316, 9816)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1317, 'wlnxcu otsbal' , '1969-12-31' , 'M', 6317, 9817)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1318, 'feerlr lhhmvq' , '1969-12-31' , 'F', 6318, 9818)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1319, 'efoccr bwlwrp' , '1969-12-31' , 'F', 6319, 9819)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1320, 'adfgpe somqls' , '1969-12-31' , 'M', 6320, 9820)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1321, 'pgwjgp kpohwg' , '1969-12-31' , 'M', 6321, 9821)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1322, 'ebxbxu wawqlo' , '1969-12-31' , 'M', 6322, 9822)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1323, 'yczbyt adycbk' , '1969-12-31' , 'F', 6323, 9823)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1324, 'atggae ndatfc' , '1969-12-31' , 'M', 6324, 9824)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1325, 'fortmv bixece' , '1969-12-31' , 'M', 6325, 9825)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1326, 'wvutci mkpxsa' , '1969-12-31' , 'M', 6326, 9826)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1327, 'peddco zeoeby' , '1969-12-31' , 'F', 6327, 9827)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1328, 'kkoiom lhtdot' , '1969-12-31' , 'F', 6328, 9828)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1329, 'aepmyo uxngbt' , '1969-12-31' , 'F', 6329, 9829)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1330, 'yuiqsc imcfab' , '1969-12-31' , 'F', 6330, 9830)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1331, 'bbimwh outidy' , '1969-12-31' , 'M', 6331, 9831)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1332, 'sqpino axgmfr' , '1969-12-31' , 'F', 6332, 9832)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1333, 'eajjsh ttsyuy' , '1969-12-31' , 'F', 6333, 9833)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1334, 'esmaqg yqvqsv' , '1969-12-31' , 'F', 6334, 9834)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1335, 'vchrdw mtorhu' , '1969-12-31' , 'F', 6335, 9835)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1336, 'bntahb gbckmu' , '1969-12-31' , 'M', 6336, 9836)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1337, 'yxdihi qteuwv' , '1969-12-31' , 'M', 6337, 9837)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1338, 'rkujri aygoqe' , '1969-12-31' , 'M', 6338, 9838)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1339, 'gmuyff mjclpt' , '1969-12-31' , 'F', 6339, 9839)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1340, 'ubanfp rfxtuz' , '1969-12-31' , 'F', 6340, 9840)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1341, 'bqlmkn yvwjtg' , '1969-12-31' , 'M', 6341, 9841)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1342, 'tfehhs jcxqsf' , '1969-12-31' , 'M', 6342, 9842)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1343, 'zksbhf priscr' , '1969-12-31' , 'M', 6343, 9843)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1344, 'nmebeg qahatl' , '1969-12-31' , 'F', 6344, 9844)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1345, 'yaxhjd lcmifb' , '1969-12-31' , 'M', 6345, 9845)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1346, 'mtmjdu wwvnix' , '1969-12-31' , 'F', 6346, 9846)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1347, 'pjcbmi ugtbya' , '1969-12-31' , 'M', 6347, 9847)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1348, 'qeayzd iwozyk' , '1969-12-31' , 'M', 6348, 9848)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1349, 'ovgtxa yqbesx' , '1969-12-31' , 'F', 6349, 9849)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1350, 'xexwfp xngjux' , '1969-12-31' , 'M', 6350, 9850)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1351, 'rfptun dmkrec' , '1969-12-31' , 'F', 6351, 9851)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1352, 'qixzzo hnoftg' , '1969-12-31' , 'F', 6352, 9852)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1353, 'wzqpof dlkhgv' , '1969-12-31' , 'M', 6353, 9853)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1354, 'abszwx giqfny' , '1969-12-31' , 'F', 6354, 9854)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1355, 'jfqthp twtbdp' , '1969-12-31' , 'M', 6355, 9855)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1356, 'pcpomf xmhsak' , '1969-12-31' , 'F', 6356, 9856)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1357, 'upkmcn idrytm' , '1969-12-31' , 'F', 6357, 9857)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1358, 'jbhnqk pzlest' , '1969-12-31' , 'F', 6358, 9858)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1359, 'qiccsp xxacfe' , '1969-12-31' , 'F', 6359, 9859)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1360, 'pgzdzd dvdrwg' , '1969-12-31' , 'M', 6360, 9860)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1361, 'qkdbvd lnxgys' , '1969-12-31' , 'F', 6361, 9861)
2012-05-24 17:25:43	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1362, 'ahkfmr vnewrp' , '1969-12-31' , 'M', 6362, 9862)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1363, 'ghzpqa iipqfy' , '1969-12-31' , 'M', 6363, 9863)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1364, 'ccfrsl aerhxq' , '1969-12-31' , 'F', 6364, 9864)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1365, 'kncedh gfyzlc' , '1969-12-31' , 'M', 6365, 9865)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1366, 'dnmhfv djwgxg' , '1969-12-31' , 'F', 6366, 9866)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1367, 'xqwcxt odoxbm' , '1969-12-31' , 'F', 6367, 9867)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1368, 'pptogx vrqijr' , '1969-12-31' , 'F', 6368, 9868)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1369, 'npsioe jjtsuu' , '1969-12-31' , 'F', 6369, 9869)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1370, 'hkrjyu gcfhok' , '1969-12-31' , 'F', 6370, 9870)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1371, 'wxclyn hvzcft' , '1969-12-31' , 'F', 6371, 9871)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1372, 'megqmb nzbddi' , '1969-12-31' , 'M', 6372, 9872)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1373, 'udzqln iswpkl' , '1969-12-31' , 'F', 6373, 9873)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1374, 'sedmti blugok' , '1969-12-31' , 'M', 6374, 9874)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1375, 'xheczr lcmxhk' , '1969-12-31' , 'F', 6375, 9875)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1376, 'oifeos ivlixr' , '1969-12-31' , 'M', 6376, 9876)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1377, 'rtxoki wojnvo' , '1969-12-31' , 'F', 6377, 9877)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1378, 'lgwamu voazxy' , '1969-12-31' , 'M', 6378, 9878)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1379, 'justeg rydhtc' , '1969-12-31' , 'M', 6379, 9879)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1380, 'uystgd agfzji' , '1969-12-31' , 'M', 6380, 9880)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1381, 'tpgpnq medsze' , '1969-12-31' , 'F', 6381, 9881)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1382, 'tbcxhy semqqi' , '1969-12-31' , 'F', 6382, 9882)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1383, 'bjhkpq ayixmc' , '1969-12-31' , 'M', 6383, 9883)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1384, 'ipdmqh jsktkw' , '1969-12-31' , 'F', 6384, 9884)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1385, 'tatplg qsbftx' , '1969-12-31' , 'F', 6385, 9885)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1386, 'lyygyq lzfpkp' , '1969-12-31' , 'M', 6386, 9886)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1387, 'coaymp pvsifl' , '1969-12-31' , 'M', 6387, 9887)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1388, 'rviubr jxinlf' , '1969-12-31' , 'F', 6388, 9888)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1389, 'msxhmr zbzjrc' , '1969-12-31' , 'M', 6389, 9889)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1390, 'qpufzh oqtrhq' , '1969-12-31' , 'M', 6390, 9890)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1391, 'zwfpka uxkwsg' , '1969-12-31' , 'F', 6391, 9891)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1392, 'hvewau fscjex' , '1969-12-31' , 'F', 6392, 9892)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1393, 'tfirgv tvqtxk' , '1969-12-31' , 'F', 6393, 9893)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1394, 'jynezh ufdqgp' , '1969-12-31' , 'F', 6394, 9894)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1395, 'hezqdx xfyaks' , '1969-12-31' , 'M', 6395, 9895)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1396, 'uomjla igewzi' , '1969-12-31' , 'F', 6396, 9896)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1397, 'hyrqig zulgtw' , '1969-12-31' , 'F', 6397, 9897)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1398, 'gigaxl emtcuq' , '1969-12-31' , 'M', 6398, 9898)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1399, 'rhvcsf hgnlxs' , '1969-12-31' , 'F', 6399, 9899)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1400, 'jxzgcb biukhy' , '1969-12-31' , 'M', 6400, 9900)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1401, 'vjeqgo prcnza' , '1969-12-31' , 'M', 6401, 9901)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1402, 'gvodzb jaezcy' , '1969-12-31' , 'M', 6402, 9902)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1403, 'kzjyzf wuypjk' , '1969-12-31' , 'M', 6403, 9903)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1404, 'xpbwib hntier' , '1969-12-31' , 'F', 6404, 9904)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1405, 'ukkxgn nyuucx' , '1969-12-31' , 'M', 6405, 9905)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1406, 'ftvkaj uwmtvy' , '1969-12-31' , 'M', 6406, 9906)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1407, 'blqndc bixjji' , '1969-12-31' , 'F', 6407, 9907)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1408, 'maimhn gguhqq' , '1969-12-31' , 'F', 6408, 9908)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1409, 'geerhs cqqokn' , '1969-12-31' , 'F', 6409, 9909)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1410, 'zsbfrx xbswee' , '1969-12-31' , 'F', 6410, 9910)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1411, 'cktfdw rgmusq' , '1969-12-31' , 'F', 6411, 9911)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1412, 'ubabaz ikmdkl' , '1969-12-31' , 'F', 6412, 9912)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1413, 'shuzss nhczft' , '1969-12-31' , 'M', 6413, 9913)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1414, 'bkfuzx euruea' , '1969-12-31' , 'M', 6414, 9914)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1415, 'utrpki bvryfn' , '1969-12-31' , 'M', 6415, 9915)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1416, 'wuqgnc luaejj' , '1969-12-31' , 'M', 6416, 9916)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1417, 'edqqcj ixvidl' , '1969-12-31' , 'M', 6417, 9917)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1418, 'nvpmst kmzfme' , '1969-12-31' , 'F', 6418, 9918)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1419, 'dtbdja cfhfdg' , '1969-12-31' , 'F', 6419, 9919)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1420, 'aapzhq mtgiha' , '1969-12-31' , 'F', 6420, 9920)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1421, 'hftcyt acwydg' , '1969-12-31' , 'F', 6421, 9921)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1422, 'cdbtmx jrtulf' , '1969-12-31' , 'M', 6422, 9922)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1423, 'upivdj eifjmt' , '1969-12-31' , 'F', 6423, 9923)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1424, 'wqfcmd ffnztj' , '1969-12-31' , 'M', 6424, 9924)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1425, 'hmcevp spilog' , '1969-12-31' , 'F', 6425, 9925)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1426, 'pdunqf ibtxvg' , '1969-12-31' , 'F', 6426, 9926)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1427, 'fzbleq mvfcvv' , '1969-12-31' , 'M', 6427, 9927)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1428, 'ewpatq cdqnye' , '1969-12-31' , 'M', 6428, 9928)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1429, 'tazgmx gjrjke' , '1969-12-31' , 'M', 6429, 9929)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1430, 'pnelzc ohbmhu' , '1969-12-31' , 'M', 6430, 9930)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1431, 'gkudny bkzxoo' , '1969-12-31' , 'F', 6431, 9931)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1432, 'yrpgts wtytpe' , '1969-12-31' , 'F', 6432, 9932)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1433, 'gcbexs azfkud' , '1969-12-31' , 'F', 6433, 9933)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1434, 'kjlnbr eaciem' , '1969-12-31' , 'M', 6434, 9934)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1435, 'esqpyj scquim' , '1969-12-31' , 'F', 6435, 9935)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1436, 'aisqvf gyraup' , '1969-12-31' , 'M', 6436, 9936)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1437, 'qbpdug iipkud' , '1969-12-31' , 'M', 6437, 9937)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1438, 'vsbyej lvwbtt' , '1969-12-31' , 'M', 6438, 9938)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1439, 'tstaji aszdog' , '1969-12-31' , 'M', 6439, 9939)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1440, 'usboel aeqpwt' , '1969-12-31' , 'F', 6440, 9940)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1441, 'pmqotf ogyviw' , '1969-12-31' , 'M', 6441, 9941)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1442, 'nzhonh rnzbyr' , '1969-12-31' , 'F', 6442, 9942)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1443, 'krxnmj gkgprn' , '1969-12-31' , 'F', 6443, 9943)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1444, 'gnpqty gbgwxh' , '1969-12-31' , 'F', 6444, 9944)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1445, 'zesxor vprsrs' , '1969-12-31' , 'M', 6445, 9945)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1446, 'catdkv cdtiyv' , '1969-12-31' , 'M', 6446, 9946)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1447, 'zkvsio lzszne' , '1969-12-31' , 'F', 6447, 9947)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1448, 'wixdwu vikeuw' , '1969-12-31' , 'M', 6448, 9948)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1449, 'ivofek utmpyt' , '1969-12-31' , 'F', 6449, 9949)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1450, 'pkbvjv hsapmt' , '1969-12-31' , 'M', 6450, 9950)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1451, 'iwsdsa yqvdrq' , '1969-12-31' , 'M', 6451, 9951)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1452, 'fzjqvr ieqehp' , '1969-12-31' , 'F', 6452, 9952)
2012-05-24 17:25:44	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1453, 'mxvhyd cprkln' , '1969-12-31' , 'F', 6453, 9953)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1454, 'yircww oebhnv' , '1969-12-31' , 'M', 6454, 9954)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1455, 'avotbc wbkvep' , '1969-12-31' , 'M', 6455, 9955)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1456, 'tmoonp dbeaur' , '1969-12-31' , 'M', 6456, 9956)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1457, 'onhnyn flhkiy' , '1969-12-31' , 'M', 6457, 9957)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1458, 'fagksb gwnmns' , '1969-12-31' , 'M', 6458, 9958)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1459, 'fibwyd tkxvjh' , '1969-12-31' , 'M', 6459, 9959)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1460, 'gbwxjx jfdlmm' , '1969-12-31' , 'F', 6460, 9960)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1461, 'qptzll fdedou' , '1969-12-31' , 'F', 6461, 9961)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1462, 'frhkuh sbcfxn' , '1969-12-31' , 'F', 6462, 9962)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1463, 'mphxur ljksxo' , '1969-12-31' , 'F', 6463, 9963)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1464, 'obhhix oecfbd' , '1969-12-31' , 'M', 6464, 9964)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1465, 'bkbpoy qqiuun' , '1969-12-31' , 'F', 6465, 9965)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1466, 'oeotsf xaavxp' , '1969-12-31' , 'F', 6466, 9966)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1467, 'tabngz alphgl' , '1969-12-31' , 'M', 6467, 9967)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1468, 'veqiix xcfmgj' , '1969-12-31' , 'F', 6468, 9968)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1469, 'djbqdp iezicl' , '1969-12-31' , 'F', 6469, 9969)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1470, 'pdacqn ygenyz' , '1969-12-31' , 'F', 6470, 9970)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1471, 'makhht qgahls' , '1969-12-31' , 'F', 6471, 9971)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1472, 'fqniow wyyndq' , '1969-12-31' , 'F', 6472, 9972)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1473, 'oivhpr efdqdn' , '1969-12-31' , 'F', 6473, 9973)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1474, 'dqwdxz jafxqn' , '1969-12-31' , 'F', 6474, 9974)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1475, 'xocizv kubcmf' , '1969-12-31' , 'M', 6475, 9975)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1476, 'kfofof yqxnic' , '1969-12-31' , 'F', 6476, 9976)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1477, 'mrdmqa tswebl' , '1969-12-31' , 'F', 6477, 9977)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1478, 'bvgvyg xvouxe' , '1969-12-31' , 'M', 6478, 9978)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1479, 'fnroie pkxnju' , '1969-12-31' , 'F', 6479, 9979)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1480, 'yjqbnc ejmmnb' , '1969-12-31' , 'F', 6480, 9980)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1481, 'qwbykp wgvknq' , '1969-12-31' , 'F', 6481, 9981)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1482, 'xbdfqb ixcsyd' , '1969-12-31' , 'M', 6482, 9982)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1483, 'ensykq nyvvdn' , '1969-12-31' , 'F', 6483, 9983)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1484, 'qcvqkq glrqmm' , '1969-12-31' , 'M', 6484, 9984)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1485, 'mfkxir xpnhtt' , '1969-12-31' , 'M', 6485, 9985)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1486, 'mjofni zjzgew' , '1969-12-31' , 'M', 6486, 9986)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1487, 'dkunve vsupff' , '1969-12-31' , 'F', 6487, 9987)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1488, 'sznxuo caultp' , '1969-12-31' , 'F', 6488, 9988)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1489, 'jfiqjg gcltwy' , '1969-12-31' , 'F', 6489, 9989)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1490, 'bprhud srzazz' , '1969-12-31' , 'M', 6490, 9990)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1491, 'nnmopf rqbqhz' , '1969-12-31' , 'F', 6491, 9991)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1492, 'ijmnmi opgnti' , '1969-12-31' , 'M', 6492, 9992)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1493, 'mpcpfp fysdzy' , '1969-12-31' , 'M', 6493, 9993)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1494, 'qfgvgt tkjbkd' , '1969-12-31' , 'F', 6494, 9994)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1495, 'wzeiuy nvzfsk' , '1969-12-31' , 'M', 6495, 9995)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1496, 'ojakiu pcuwsi' , '1969-12-31' , 'F', 6496, 9996)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1497, 'zlxhhb mhfyiv' , '1969-12-31' , 'F', 6497, 9997)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1498, 'aerjex duipvo' , '1969-12-31' , 'F', 6498, 9998)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1499, 'oyvnuw oozjhv' , '1969-12-31' , 'M', 6499, 9999)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1500, 'cobswh ayjcgn' , '1969-12-31' , 'F', 6500, 10000)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1501, 'zfqzqg zwxymc' , '1969-12-31' , 'M', 6501, 10001)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1502, 'nhfdyf jsxyfj' , '1969-12-31' , 'F', 6502, 10002)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1503, 'nkbida vpzqxh' , '1969-12-31' , 'M', 6503, 10003)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1504, 'udwrzm hczabw' , '1969-12-31' , 'F', 6504, 10004)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1505, 'cnaxer hlycmf' , '1969-12-31' , 'M', 6505, 10005)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1506, 'wyxrhz plbmjh' , '1969-12-31' , 'F', 6506, 10006)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1507, 'grharn pkwbps' , '1969-12-31' , 'M', 6507, 10007)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1508, 'qipkjh zayday' , '1969-12-31' , 'F', 6508, 10008)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1509, 'lzudph sbcvar' , '1969-12-31' , 'F', 6509, 10009)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1510, 'dsdzxh pesuyj' , '1969-12-31' , 'M', 6510, 10010)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1511, 'kmyhpg ltlkoj' , '1969-12-31' , 'M', 6511, 10011)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1512, 'qtdopg cpgabn' , '1969-12-31' , 'F', 6512, 10012)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1513, 'qamsyg gjcdrp' , '1969-12-31' , 'M', 6513, 10013)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1514, 'suqqqz mhifmw' , '1969-12-31' , 'M', 6514, 10014)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1515, 'ncdrbz pnoedh' , '1969-12-31' , 'F', 6515, 10015)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1516, 'pzdhba bfuquo' , '1969-12-31' , 'M', 6516, 10016)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1517, 'lgjnba uvdiff' , '1969-12-31' , 'F', 6517, 10017)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1518, 'rqkowx mqsiee' , '1969-12-31' , 'F', 6518, 10018)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1519, 'emfeia kovnea' , '1969-12-31' , 'M', 6519, 10019)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1520, 'lhjlcy uvxcwl' , '1969-12-31' , 'F', 6520, 10020)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1521, 'fuspls uwbeiq' , '1969-12-31' , 'M', 6521, 10021)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1522, 'zpjmmg rqxvhb' , '1969-12-31' , 'M', 6522, 10022)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1523, 'efrgnw vndemg' , '1969-12-31' , 'M', 6523, 10023)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1524, 'mcsasi irnbxf' , '1969-12-31' , 'F', 6524, 10024)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1525, 'mzzjsi mvqofd' , '1969-12-31' , 'F', 6525, 10025)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1526, 'yxtkok cjmxds' , '1969-12-31' , 'M', 6526, 10026)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1527, 'bilzor sfnfdl' , '1969-12-31' , 'F', 6527, 10027)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1528, 'pmhqur rmksid' , '1969-12-31' , 'M', 6528, 10028)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1529, 'cwgqeh mwxslc' , '1969-12-31' , 'F', 6529, 10029)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1530, 'hnsoyg duhvdb' , '1969-12-31' , 'M', 6530, 10030)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1531, 'yzokyz mhuitp' , '1969-12-31' , 'M', 6531, 10031)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1532, 'nvclhz onzxgw' , '1969-12-31' , 'F', 6532, 10032)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1533, 'odaufa oadaem' , '1969-12-31' , 'F', 6533, 10033)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1534, 'ijatyt wybxup' , '1969-12-31' , 'M', 6534, 10034)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1535, 'fhkksl fjwaka' , '1969-12-31' , 'M', 6535, 10035)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1536, 'wrhdbz fwkwiq' , '1969-12-31' , 'M', 6536, 10036)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1537, 'giurbs mwbbji' , '1969-12-31' , 'M', 6537, 10037)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1538, 'ppfnkd fbmhfp' , '1969-12-31' , 'M', 6538, 10038)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1539, 'khribu edqjwi' , '1969-12-31' , 'M', 6539, 10039)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1540, 'dnhyli zfmyzg' , '1969-12-31' , 'M', 6540, 10040)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1541, 'vcgfrt cevfzk' , '1969-12-31' , 'M', 6541, 10041)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1542, 'iblzmo dqlhwu' , '1969-12-31' , 'M', 6542, 10042)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1543, 'lultlb hluhjw' , '1969-12-31' , 'M', 6543, 10043)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1544, 'atgoyd upxoyy' , '1969-12-31' , 'M', 6544, 10044)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1545, 'wmkqzq kcfujg' , '1969-12-31' , 'M', 6545, 10045)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1546, 'fuclln bmnswa' , '1969-12-31' , 'M', 6546, 10046)
2012-05-24 17:25:45	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1547, 'hbwagw bomyzb' , '1969-12-31' , 'M', 6547, 10047)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1548, 'kakzal ngipkh' , '1969-12-31' , 'F', 6548, 10048)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1549, 'qdzvyo ccvumk' , '1969-12-31' , 'M', 6549, 10049)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1550, 'tsragf pysivh' , '1969-12-31' , 'M', 6550, 10050)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1551, 'drsbou zxtzxh' , '1969-12-31' , 'M', 6551, 10051)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1552, 'uiilje cxsipy' , '1969-12-31' , 'F', 6552, 10052)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1553, 'hkzcnw iwobbd' , '1969-12-31' , 'F', 6553, 10053)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1554, 'xuplez ozgodl' , '1969-12-31' , 'M', 6554, 10054)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1555, 'aabjgm noilvo' , '1969-12-31' , 'F', 6555, 10055)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1556, 'keudsl ympxyg' , '1969-12-31' , 'M', 6556, 10056)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1557, 'msvugy ykdwlr' , '1969-12-31' , 'M', 6557, 10057)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1558, 'rdmghx vonwrz' , '1969-12-31' , 'M', 6558, 10058)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1559, 'dqpfta bkbfhq' , '1969-12-31' , 'M', 6559, 10059)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1560, 'bmubnx aeqjpc' , '1969-12-31' , 'F', 6560, 10060)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1561, 'kwcjaj wfvtpt' , '1969-12-31' , 'M', 6561, 10061)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1562, 'czijhg ytvidt' , '1969-12-31' , 'M', 6562, 10062)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1563, 'jobhgh qmdhdm' , '1969-12-31' , 'M', 6563, 10063)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1564, 'qbdmub xigcwx' , '1969-12-31' , 'F', 6564, 10064)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1565, 'efxdte mscdik' , '1969-12-31' , 'F', 6565, 10065)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1566, 'rqudgj qxcdhq' , '1969-12-31' , 'M', 6566, 10066)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1567, 'wqvbbk gzgmno' , '1969-12-31' , 'F', 6567, 10067)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1568, 'sjvyrq dcgmdg' , '1969-12-31' , 'M', 6568, 10068)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1569, 'gpsaru gmpjdw' , '1969-12-31' , 'F', 6569, 10069)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1570, 'ltdwie vfgslc' , '1969-12-31' , 'M', 6570, 10070)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1571, 'bmxzno dvpwfy' , '1969-12-31' , 'M', 6571, 10071)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1572, 'lxecuj ycgxao' , '1969-12-31' , 'M', 6572, 10072)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1573, 'uzcpak ikojpi' , '1969-12-31' , 'M', 6573, 10073)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1574, 'uoojjl pbruok' , '1969-12-31' , 'M', 6574, 10074)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1575, 'dyshjh pzyptx' , '1969-12-31' , 'F', 6575, 10075)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1576, 'nftokm hjwifv' , '1969-12-31' , 'M', 6576, 10076)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1577, 'dhkjzy sfadeo' , '1969-12-31' , 'F', 6577, 10077)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1578, 'lznqkl qagqcn' , '1969-12-31' , 'M', 6578, 10078)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1579, 'eztezv oabmau' , '1969-12-31' , 'M', 6579, 10079)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1580, 'zdnggf iqjgwj' , '1969-12-31' , 'F', 6580, 10080)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1581, 'yfhugq jdrnkn' , '1969-12-31' , 'M', 6581, 10081)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1582, 'hcdewd yooldl' , '1969-12-31' , 'F', 6582, 10082)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1583, 'clidht gbfsle' , '1969-12-31' , 'M', 6583, 10083)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1584, 'ffzptn clbitc' , '1969-12-31' , 'F', 6584, 10084)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1585, 'wtevoc xdrekf' , '1969-12-31' , 'M', 6585, 10085)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1586, 'bwvjpt uyreqg' , '1969-12-31' , 'F', 6586, 10086)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1587, 'psshaw fsxnag' , '1969-12-31' , 'M', 6587, 10087)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1588, 'naxnad wsucjy' , '1969-12-31' , 'M', 6588, 10088)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1589, 'wfbnwg jxintt' , '1969-12-31' , 'F', 6589, 10089)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1590, 'xwuaue oumsli' , '1969-12-31' , 'F', 6590, 10090)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1591, 'gezwef xlcvnf' , '1969-12-31' , 'F', 6591, 10091)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1592, 'gqvrbr uqpses' , '1969-12-31' , 'M', 6592, 10092)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1593, 'jrhsml hshdjc' , '1969-12-31' , 'F', 6593, 10093)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1594, 'pzjtix jdwclz' , '1969-12-31' , 'F', 6594, 10094)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1595, 'cdctny becraj' , '1969-12-31' , 'F', 6595, 10095)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1596, 'kvihtk erdbhw' , '1969-12-31' , 'F', 6596, 10096)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1597, 'rcnwgm sieeqc' , '1969-12-31' , 'M', 6597, 10097)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1598, 'gknzcn jsyany' , '1969-12-31' , 'M', 6598, 10098)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1599, 'mfilyi rrotvd' , '1969-12-31' , 'F', 6599, 10099)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1600, 'emqqcr zphhhf' , '1969-12-31' , 'M', 6600, 10100)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1601, 'mpppjo jcwttd' , '1969-12-31' , 'F', 6601, 10101)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1602, 'paakde twybcc' , '1969-12-31' , 'M', 6602, 10102)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1603, 'heuejd uhzmic' , '1969-12-31' , 'F', 6603, 10103)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1604, 'yqnlop xdvkuz' , '1969-12-31' , 'F', 6604, 10104)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1605, 'xvdrdd adnsui' , '1969-12-31' , 'F', 6605, 10105)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1606, 'djdrag osaduf' , '1969-12-31' , 'M', 6606, 10106)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1607, 'fvqzlu vlhpqp' , '1969-12-31' , 'F', 6607, 10107)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1608, 'ihqpsd dxixho' , '1969-12-31' , 'F', 6608, 10108)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1609, 'fvbvfv vpxfsi' , '1969-12-31' , 'F', 6609, 10109)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1610, 'txenay nwtbde' , '1969-12-31' , 'M', 6610, 10110)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1611, 'sbrhmj obhxxe' , '1969-12-31' , 'F', 6611, 10111)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1612, 'aloejf vmozxq' , '1969-12-31' , 'M', 6612, 10112)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1613, 'saunio ktdeav' , '1969-12-31' , 'F', 6613, 10113)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1614, 'sctfwf ilaslm' , '1969-12-31' , 'F', 6614, 10114)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1615, 'kgiknz iltrso' , '1969-12-31' , 'M', 6615, 10115)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1616, 'gihyyr vfurji' , '1969-12-31' , 'M', 6616, 10116)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1617, 'fxkhcj ezjwek' , '1969-12-31' , 'M', 6617, 10117)
2012-05-24 17:25:46	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1618, 'ctpfaq uxackn' , '1969-12-31' , 'F', 6618, 10118)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1619, 'kajxcw spemvv' , '1969-12-31' , 'F', 6619, 10119)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1620, 'guxphh vgbxla' , '1969-12-31' , 'M', 6620, 10120)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1621, 'zzkunk pwjlco' , '1969-12-31' , 'M', 6621, 10121)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1622, 'huxbbe rgmnst' , '1969-12-31' , 'F', 6622, 10122)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1623, 'rbtcqv mzrqux' , '1969-12-31' , 'M', 6623, 10123)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1624, 'fczdlg onkwyh' , '1969-12-31' , 'F', 6624, 10124)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1625, 'xtwxlo xxxnyk' , '1969-12-31' , 'M', 6625, 10125)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1626, 'jslnwp jiyphk' , '1969-12-31' , 'F', 6626, 10126)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1627, 'fmxsna hqnjni' , '1969-12-31' , 'M', 6627, 10127)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1628, 'hitmwk emrqtp' , '1969-12-31' , 'F', 6628, 10128)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1629, 'vrbuhn zbakrd' , '1969-12-31' , 'F', 6629, 10129)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1630, 'qpipgz jelcmh' , '1969-12-31' , 'M', 6630, 10130)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1631, 'jbdfck dpdyms' , '1969-12-31' , 'F', 6631, 10131)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1632, 'cabxvy dwtujd' , '1969-12-31' , 'M', 6632, 10132)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1633, 'ixtpbw sskkjq' , '1969-12-31' , 'M', 6633, 10133)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1634, 'vvkwul ircnex' , '1969-12-31' , 'M', 6634, 10134)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1635, 'lzezoe xocvbb' , '1969-12-31' , 'F', 6635, 10135)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1636, 'pbozcl vouztz' , '1969-12-31' , 'F', 6636, 10136)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1637, 'bqmuvq tzjika' , '1969-12-31' , 'F', 6637, 10137)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1638, 'froyia dfhspg' , '1969-12-31' , 'M', 6638, 10138)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1639, 'abhqwn crrmia' , '1969-12-31' , 'F', 6639, 10139)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1640, 'vjzkje gcipmu' , '1969-12-31' , 'F', 6640, 10140)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1641, 'bhotxx qazfpz' , '1969-12-31' , 'M', 6641, 10141)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1642, 'uxptaf tfvmlq' , '1969-12-31' , 'M', 6642, 10142)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1643, 'yrwcua bnwiqu' , '1969-12-31' , 'M', 6643, 10143)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1644, 'mcvmhx evzlcg' , '1969-12-31' , 'M', 6644, 10144)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1645, 'wloluz ypablr' , '1969-12-31' , 'M', 6645, 10145)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1646, 'jlckhh nhddtn' , '1969-12-31' , 'F', 6646, 10146)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1647, 'bilzjo ockmen' , '1969-12-31' , 'F', 6647, 10147)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1648, 'xsarve qdilxa' , '1969-12-31' , 'M', 6648, 10148)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1649, 'vuygck nnamlr' , '1969-12-31' , 'M', 6649, 10149)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1650, 'zmvbjb einqyd' , '1969-12-31' , 'F', 6650, 10150)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1651, 'iddrja enftvo' , '1969-12-31' , 'M', 6651, 10151)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1652, 'uybjmg bpxiln' , '1969-12-31' , 'M', 6652, 10152)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1653, 'ixxiqr gwclmb' , '1969-12-31' , 'F', 6653, 10153)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1654, 'igjytj qvbcqx' , '1969-12-31' , 'M', 6654, 10154)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1655, 'avzsdl lhawxa' , '1969-12-31' , 'F', 6655, 10155)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1656, 'idaonv pvkpcc' , '1969-12-31' , 'M', 6656, 10156)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1657, 'dslwzg nxxbwc' , '1969-12-31' , 'F', 6657, 10157)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1658, 'tutzof awtujh' , '1969-12-31' , 'M', 6658, 10158)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1659, 'ybfvep yxthpn' , '1969-12-31' , 'F', 6659, 10159)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1660, 'laqoiz ocderb' , '1969-12-31' , 'M', 6660, 10160)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1661, 'qymfwk tegfke' , '1969-12-31' , 'M', 6661, 10161)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1662, 'znlsky qgyxmh' , '1969-12-31' , 'F', 6662, 10162)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1663, 'nfcatu fjcpxa' , '1969-12-31' , 'F', 6663, 10163)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1664, 'kcpcom uhgztw' , '1969-12-31' , 'F', 6664, 10164)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1665, 'drxlel rwvkyk' , '1969-12-31' , 'M', 6665, 10165)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1666, 'zcawax pypihn' , '1969-12-31' , 'F', 6666, 10166)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1667, 'ypzubz kislnq' , '1969-12-31' , 'M', 6667, 10167)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1668, 'vkxgui ocklgb' , '1969-12-31' , 'F', 6668, 10168)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1669, 'gybgsx lqsasy' , '1969-12-31' , 'M', 6669, 10169)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1670, 'luaipk pikrrz' , '1969-12-31' , 'F', 6670, 10170)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1671, 'recjfn oslygd' , '1969-12-31' , 'F', 6671, 10171)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1672, 'vnzecr ldlvdi' , '1969-12-31' , 'M', 6672, 10172)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1673, 'ysiuzr ixsblf' , '1969-12-31' , 'F', 6673, 10173)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1674, 'xdqlru wllxxt' , '1969-12-31' , 'M', 6674, 10174)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1675, 'aingen lfqimm' , '1969-12-31' , 'F', 6675, 10175)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1676, 'gegjxz ovelya' , '1969-12-31' , 'F', 6676, 10176)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1677, 'zsyrzm wabynr' , '1969-12-31' , 'F', 6677, 10177)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1678, 'ehrape smedfr' , '1969-12-31' , 'F', 6678, 10178)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1679, 'kfybbd palolg' , '1969-12-31' , 'M', 6679, 10179)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1680, 'mltgis hroklv' , '1969-12-31' , 'M', 6680, 10180)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1681, 'rxavrg ghocez' , '1969-12-31' , 'M', 6681, 10181)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1682, 'nkmrpl ehtbze' , '1969-12-31' , 'F', 6682, 10182)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1683, 'nsuagm bzxqpe' , '1969-12-31' , 'F', 6683, 10183)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1684, 'yfdnka styqam' , '1969-12-31' , 'F', 6684, 10184)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1685, 'wozxxu lcnjqi' , '1969-12-31' , 'M', 6685, 10185)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1686, 'fnxmgu acwtlt' , '1969-12-31' , 'F', 6686, 10186)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1687, 'lttncr yhjmmp' , '1969-12-31' , 'M', 6687, 10187)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1688, 'kopnws escvdc' , '1969-12-31' , 'F', 6688, 10188)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1689, 'mtampx shjlja' , '1969-12-31' , 'M', 6689, 10189)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1690, 'rlfjgj qjbode' , '1969-12-31' , 'M', 6690, 10190)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1691, 'qzprzs ajiums' , '1969-12-31' , 'F', 6691, 10191)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1692, 'qppomh tnlmsy' , '1969-12-31' , 'F', 6692, 10192)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1693, 'vdjmij hjlszb' , '1969-12-31' , 'M', 6693, 10193)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1694, 'yyuyxj dxbckv' , '1969-12-31' , 'F', 6694, 10194)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1695, 'qwsiaj sqfidv' , '1969-12-31' , 'M', 6695, 10195)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1696, 'iioghy xtlkfv' , '1969-12-31' , 'F', 6696, 10196)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1697, 'ixhqbg kaqhyg' , '1969-12-31' , 'F', 6697, 10197)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1698, 'yckiee zskfgb' , '1969-12-31' , 'M', 6698, 10198)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1699, 'spjaie tescld' , '1969-12-31' , 'M', 6699, 10199)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1700, 'twiykt bietux' , '1969-12-31' , 'F', 6700, 10200)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1701, 'etyotx rltcki' , '1969-12-31' , 'M', 6701, 10201)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1702, 'pjuaty hlvbhz' , '1969-12-31' , 'M', 6702, 10202)
2012-05-24 17:25:47	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1703, 'grdmbr bvpyri' , '1969-12-31' , 'M', 6703, 10203)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1704, 'mifeqq bwxkrk' , '1969-12-31' , 'M', 6704, 10204)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1705, 'advfic yqauid' , '1969-12-31' , 'M', 6705, 10205)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1706, 'tnpyfz qniito' , '1969-12-31' , 'M', 6706, 10206)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1707, 'rdmljh yfejue' , '1969-12-31' , 'F', 6707, 10207)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1708, 'sioxxn owqxuf' , '1969-12-31' , 'F', 6708, 10208)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1709, 'ocxakf pfxror' , '1969-12-31' , 'F', 6709, 10209)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1710, 'cluuls outode' , '1969-12-31' , 'M', 6710, 10210)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1711, 'ieilax ophjqs' , '1969-12-31' , 'F', 6711, 10211)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1712, 'qcsajb refjsw' , '1969-12-31' , 'M', 6712, 10212)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1713, 'ifuyva jmmres' , '1969-12-31' , 'F', 6713, 10213)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1714, 'gcivve haqdxm' , '1969-12-31' , 'M', 6714, 10214)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1715, 'ngpwrg ysxbqr' , '1969-12-31' , 'M', 6715, 10215)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1716, 'bmlhzz fyakcu' , '1969-12-31' , 'M', 6716, 10216)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1717, 'idnddn riueqe' , '1969-12-31' , 'F', 6717, 10217)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1718, 'mcrkri gkhrep' , '1969-12-31' , 'M', 6718, 10218)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1719, 'fnruzv akqvic' , '1969-12-31' , 'M', 6719, 10219)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1720, 'ajlixr yrkvlo' , '1969-12-31' , 'F', 6720, 10220)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1721, 'grtyae jpdhnr' , '1969-12-31' , 'M', 6721, 10221)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1722, 'vmqvzk ghbkbn' , '1969-12-31' , 'F', 6722, 10222)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1723, 'eimooy ojatji' , '1969-12-31' , 'M', 6723, 10223)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1724, 'lsxrzv utgpgq' , '1969-12-31' , 'M', 6724, 10224)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1725, 'kqjyeq xdgult' , '1969-12-31' , 'F', 6725, 10225)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1726, 'edjbse djnpmo' , '1969-12-31' , 'M', 6726, 10226)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1727, 'gkzjxp mqrgao' , '1969-12-31' , 'M', 6727, 10227)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1728, 'izznja npocjj' , '1969-12-31' , 'F', 6728, 10228)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1729, 'nbuqhf rdfpop' , '1969-12-31' , 'M', 6729, 10229)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1730, 'cybvda bhbzug' , '1969-12-31' , 'F', 6730, 10230)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1731, 'iaqdwd vzujut' , '1969-12-31' , 'F', 6731, 10231)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1732, 'bfshym qilzkq' , '1969-12-31' , 'M', 6732, 10232)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1733, 'lfurqu wjhcel' , '1969-12-31' , 'F', 6733, 10233)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1734, 'cbdmpm sqwqee' , '1969-12-31' , 'F', 6734, 10234)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1735, 'patjvp rvzlqe' , '1969-12-31' , 'M', 6735, 10235)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1736, 'hwebhe mmkies' , '1969-12-31' , 'F', 6736, 10236)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1737, 'pbthoy eogduq' , '1969-12-31' , 'M', 6737, 10237)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1738, 'pvkrxf fgowka' , '1969-12-31' , 'M', 6738, 10238)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1739, 'gubwnl kvlnmc' , '1969-12-31' , 'M', 6739, 10239)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1740, 'vreodg fciwzr' , '1969-12-31' , 'F', 6740, 10240)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1741, 'zflbrn wtnvgn' , '1969-12-31' , 'M', 6741, 10241)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1742, 'vzlimo kovvvx' , '1969-12-31' , 'F', 6742, 10242)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1743, 'rfgwkk cydcgr' , '1969-12-31' , 'F', 6743, 10243)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1744, 'mvtjrg wjuymx' , '1969-12-31' , 'F', 6744, 10244)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1745, 'hcvnzc vcjemg' , '1969-12-31' , 'M', 6745, 10245)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1746, 'eahcop gqwdfy' , '1969-12-31' , 'M', 6746, 10246)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1747, 'jmbkga lzlcyb' , '1969-12-31' , 'F', 6747, 10247)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1748, 'simrac dlwoga' , '1969-12-31' , 'F', 6748, 10248)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1749, 'srshup ircsij' , '1969-12-31' , 'M', 6749, 10249)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1750, 'btiltc qrftfp' , '1969-12-31' , 'M', 6750, 10250)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1751, 'gtvrcv vhxuot' , '1969-12-31' , 'M', 6751, 10251)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1752, 'catdhb zxpoeq' , '1969-12-31' , 'F', 6752, 10252)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1753, 'fcuyeq hlftcb' , '1969-12-31' , 'M', 6753, 10253)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1754, 'niwrkz yoedti' , '1969-12-31' , 'F', 6754, 10254)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1755, 'ixmrxg bbxhqc' , '1969-12-31' , 'F', 6755, 10255)
2012-05-24 17:25:48	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1756, 'janxtm nvcwge' , '1969-12-31' , 'F', 6756, 10256)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1757, 'drngdv oockti' , '1969-12-31' , 'M', 6757, 10257)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1758, 'xciutm mlwxix' , '1969-12-31' , 'M', 6758, 10258)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1759, 'njektg josaae' , '1969-12-31' , 'F', 6759, 10259)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1760, 'unfbrl ryqpkp' , '1969-12-31' , 'F', 6760, 10260)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1761, 'ylknco wdgonm' , '1969-12-31' , 'F', 6761, 10261)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1762, 'sffwwe ljpqnb' , '1969-12-31' , 'F', 6762, 10262)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1763, 'cnibto uxgwuw' , '1969-12-31' , 'F', 6763, 10263)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1764, 'rsyopj yhyzwd' , '1969-12-31' , 'M', 6764, 10264)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1765, 'uydeyd wzbsor' , '1969-12-31' , 'F', 6765, 10265)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1766, 'wppimj blwkdy' , '1969-12-31' , 'M', 6766, 10266)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1767, 'xaedoe zfbbpf' , '1969-12-31' , 'F', 6767, 10267)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1768, 'mikkiq ztlnnt' , '1969-12-31' , 'F', 6768, 10268)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1769, 'tyfjmi toemky' , '1969-12-31' , 'F', 6769, 10269)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1770, 'dtarlh hsjnhp' , '1969-12-31' , 'M', 6770, 10270)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1771, 'yndwwp prarhv' , '1969-12-31' , 'M', 6771, 10271)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1772, 'ygphyf marqyo' , '1969-12-31' , 'F', 6772, 10272)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1773, 'bpnxgp xsydzg' , '1969-12-31' , 'F', 6773, 10273)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1774, 'ppufpe kgaclk' , '1969-12-31' , 'M', 6774, 10274)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1775, 'llehsc qzwsgy' , '1969-12-31' , 'M', 6775, 10275)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1776, 'hkekoh aiygdn' , '1969-12-31' , 'F', 6776, 10276)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1777, 'tznvul hsdwkd' , '1969-12-31' , 'F', 6777, 10277)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1778, 'cowxsj ghdtth' , '1969-12-31' , 'F', 6778, 10278)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1779, 'nnqita wffqca' , '1969-12-31' , 'F', 6779, 10279)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1780, 'rzomqw tjjosy' , '1969-12-31' , 'F', 6780, 10280)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1781, 'oloduc yitrae' , '1969-12-31' , 'F', 6781, 10281)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1782, 'odvkdl gvfmko' , '1969-12-31' , 'F', 6782, 10282)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1783, 'pobrev gdmdhw' , '1969-12-31' , 'M', 6783, 10283)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1784, 'cnblrs qwiljq' , '1969-12-31' , 'F', 6784, 10284)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1785, 'hzdokc tqgvga' , '1969-12-31' , 'M', 6785, 10285)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1786, 'mmmlcf jidljg' , '1969-12-31' , 'M', 6786, 10286)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1787, 'fmvhfz twwjbh' , '1969-12-31' , 'M', 6787, 10287)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1788, 'kwlafq wzzktr' , '1969-12-31' , 'M', 6788, 10288)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1789, 'ujztso zgbese' , '1969-12-31' , 'F', 6789, 10289)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1790, 'jfabse snvemg' , '1969-12-31' , 'M', 6790, 10290)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1791, 'ulnbmh yyojhy' , '1969-12-31' , 'F', 6791, 10291)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1792, 'edrneh gydnyj' , '1969-12-31' , 'M', 6792, 10292)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1793, 'mcfbjl coiswg' , '1969-12-31' , 'F', 6793, 10293)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1794, 'nopntx pjigtx' , '1969-12-31' , 'M', 6794, 10294)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1795, 'qmnxid huwkez' , '1969-12-31' , 'M', 6795, 10295)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1796, 'sfndtu qxspzm' , '1969-12-31' , 'F', 6796, 10296)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1797, 'evhqni rqjtws' , '1969-12-31' , 'M', 6797, 10297)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1798, 'dejhjb tijrxr' , '1969-12-31' , 'F', 6798, 10298)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1799, 'vfxkmn pnbbrv' , '1969-12-31' , 'F', 6799, 10299)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1800, 'spjopz vqlkov' , '1969-12-31' , 'M', 6800, 10300)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1801, 'bjoyde xshpkk' , '1969-12-31' , 'F', 6801, 10301)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1802, 'lqvqkx nkvksm' , '1969-12-31' , 'M', 6802, 10302)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1803, 'mmvdmf tpxxar' , '1969-12-31' , 'M', 6803, 10303)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1804, 'abljso sxegkh' , '1969-12-31' , 'M', 6804, 10304)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1805, 'eerfjs ygyfcr' , '1969-12-31' , 'M', 6805, 10305)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1806, 'lsaihe cpsglh' , '1969-12-31' , 'M', 6806, 10306)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1807, 'bzubyr mmhtyp' , '1969-12-31' , 'F', 6807, 10307)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1808, 'mgsoro uxjzmm' , '1969-12-31' , 'M', 6808, 10308)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1809, 'ilkjvi echpcu' , '1969-12-31' , 'M', 6809, 10309)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1810, 'fhjmdy gregvn' , '1969-12-31' , 'M', 6810, 10310)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1811, 'kmdnev pyihra' , '1969-12-31' , 'F', 6811, 10311)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1812, 'bbpepl fxvblz' , '1969-12-31' , 'F', 6812, 10312)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1813, 'nprtnz kylsco' , '1969-12-31' , 'M', 6813, 10313)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1814, 'zuqwwv jxumzy' , '1969-12-31' , 'F', 6814, 10314)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1815, 'yhrelq oplvuv' , '1969-12-31' , 'M', 6815, 10315)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1816, 'rszcxl sjomox' , '1969-12-31' , 'F', 6816, 10316)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1817, 'dnuieb zjpuzr' , '1969-12-31' , 'F', 6817, 10317)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1818, 'xepywd sbufeu' , '1969-12-31' , 'M', 6818, 10318)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1819, 'fvbhho umujpb' , '1969-12-31' , 'M', 6819, 10319)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1820, 'hhesxw qwwrgf' , '1969-12-31' , 'M', 6820, 10320)
2012-05-24 17:25:49	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1821, 'qibyox dntflz' , '1969-12-31' , 'F', 6821, 10321)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1822, 'fqvjun uhbfdf' , '1969-12-31' , 'M', 6822, 10322)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1823, 'faiazu xdinwo' , '1969-12-31' , 'F', 6823, 10323)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1824, 'mipino aoyzak' , '1969-12-31' , 'F', 6824, 10324)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1825, 'ekhhfc yicfkn' , '1969-12-31' , 'M', 6825, 10325)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1826, 'ulooxi vmoiku' , '1969-12-31' , 'F', 6826, 10326)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1827, 'mocrvn yquykh' , '1969-12-31' , 'M', 6827, 10327)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1828, 'pgebre ecxayr' , '1969-12-31' , 'F', 6828, 10328)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1829, 'xqdknm wmqwty' , '1969-12-31' , 'M', 6829, 10329)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1830, 'wnxszq ovpujg' , '1969-12-31' , 'F', 6830, 10330)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1831, 'tmyofg nnezcb' , '1969-12-31' , 'M', 6831, 10331)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1832, 'ieprku yshrrm' , '1969-12-31' , 'M', 6832, 10332)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1833, 'lztxug avzkum' , '1969-12-31' , 'M', 6833, 10333)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1834, 'frjymv gyhaut' , '1969-12-31' , 'M', 6834, 10334)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1835, 'nnzalb kdyfjw' , '1969-12-31' , 'M', 6835, 10335)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1836, 'zdhced gserzp' , '1969-12-31' , 'M', 6836, 10336)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1837, 'pskagr ldydem' , '1969-12-31' , 'M', 6837, 10337)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1838, 'ennszh rkfepi' , '1969-12-31' , 'M', 6838, 10338)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1839, 'hynoca qbcexl' , '1969-12-31' , 'M', 6839, 10339)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1840, 'uwykln ytcvtk' , '1969-12-31' , 'F', 6840, 10340)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1841, 'dgepbg zlcozk' , '1969-12-31' , 'F', 6841, 10341)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1842, 'bhytpi jydqoq' , '1969-12-31' , 'F', 6842, 10342)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1843, 'ledlpm qrqebd' , '1969-12-31' , 'F', 6843, 10343)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1844, 'fzlwka ktrzqj' , '1969-12-31' , 'F', 6844, 10344)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1845, 'hyxaud pspwrr' , '1969-12-31' , 'F', 6845, 10345)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1846, 'kpieqj oefypr' , '1969-12-31' , 'M', 6846, 10346)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1847, 'wxfaxa rsyget' , '1969-12-31' , 'M', 6847, 10347)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1848, 'xaojax qwspdp' , '1969-12-31' , 'F', 6848, 10348)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1849, 'elydzh vsjmlv' , '1969-12-31' , 'M', 6849, 10349)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1850, 'gnoyif jexcrp' , '1969-12-31' , 'F', 6850, 10350)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1851, 'zqxtpu iaghgy' , '1969-12-31' , 'M', 6851, 10351)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1852, 'yxutcy gqrqao' , '1969-12-31' , 'M', 6852, 10352)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1853, 'jsnvsb dkgqav' , '1969-12-31' , 'M', 6853, 10353)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1854, 'qvzvrc mkqyrn' , '1969-12-31' , 'F', 6854, 10354)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1855, 'ozynma zkmukr' , '1969-12-31' , 'F', 6855, 10355)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1856, 'rgxeov ligpil' , '1969-12-31' , 'M', 6856, 10356)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1857, 'jtswxw wvsaar' , '1969-12-31' , 'M', 6857, 10357)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1858, 'roufwj zwdmex' , '1969-12-31' , 'M', 6858, 10358)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1859, 'farfrv edhzgw' , '1969-12-31' , 'F', 6859, 10359)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1860, 'nyhbiu cvzejg' , '1969-12-31' , 'M', 6860, 10360)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1861, 'aljbpz kbzbcq' , '1969-12-31' , 'F', 6861, 10361)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1862, 'ejuuiw oriknv' , '1969-12-31' , 'F', 6862, 10362)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1863, 'nucpyh kpmvdu' , '1969-12-31' , 'M', 6863, 10363)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1864, 'neauyd selpfx' , '1969-12-31' , 'F', 6864, 10364)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1865, 'rwaxld gagdln' , '1969-12-31' , 'M', 6865, 10365)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1866, 'ktqxio vdshrp' , '1969-12-31' , 'M', 6866, 10366)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1867, 'uxwump hrxlpb' , '1969-12-31' , 'F', 6867, 10367)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1868, 'bdvnwq henzut' , '1969-12-31' , 'F', 6868, 10368)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1869, 'gfgpmz qqlumd' , '1969-12-31' , 'M', 6869, 10369)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1870, 'lvzijn agcvyh' , '1969-12-31' , 'M', 6870, 10370)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1871, 'koudpf cxlypq' , '1969-12-31' , 'M', 6871, 10371)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1872, 'cwybzt mdmdyf' , '1969-12-31' , 'M', 6872, 10372)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1873, 'erjqcn hbchza' , '1969-12-31' , 'F', 6873, 10373)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1874, 'bfagkd totuqi' , '1969-12-31' , 'F', 6874, 10374)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1875, 'qmzphu vasfex' , '1969-12-31' , 'F', 6875, 10375)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1876, 'liszbi fwjrsu' , '1969-12-31' , 'M', 6876, 10376)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1877, 'xothot nunoji' , '1969-12-31' , 'M', 6877, 10377)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1878, 'mpfiml xguqqd' , '1969-12-31' , 'M', 6878, 10378)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1879, 'drslta vdeqws' , '1969-12-31' , 'M', 6879, 10379)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1880, 'vkntir tspmpz' , '1969-12-31' , 'F', 6880, 10380)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1881, 'mqswlo rrgrmn' , '1969-12-31' , 'F', 6881, 10381)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1882, 'rknzjz iltjzk' , '1969-12-31' , 'F', 6882, 10382)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1883, 'vkcqhy gmmsjl' , '1969-12-31' , 'M', 6883, 10383)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1884, 'smndud cxntqp' , '1969-12-31' , 'M', 6884, 10384)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1885, 'mmaeas hygmqr' , '1969-12-31' , 'M', 6885, 10385)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1886, 'ayhevj guejoh' , '1969-12-31' , 'F', 6886, 10386)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1887, 'pgqxqi mrxggn' , '1969-12-31' , 'M', 6887, 10387)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1888, 'dwjaud vnrqcd' , '1969-12-31' , 'M', 6888, 10388)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1889, 'daepbu kpgiar' , '1969-12-31' , 'F', 6889, 10389)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1890, 'utrnro ovcphh' , '1969-12-31' , 'M', 6890, 10390)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1891, 'flzkig gqxmxm' , '1969-12-31' , 'F', 6891, 10391)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1892, 'yfhtwl zfmusy' , '1969-12-31' , 'F', 6892, 10392)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1893, 'avejgg autjca' , '1969-12-31' , 'F', 6893, 10393)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1894, 'skaggl tfypwh' , '1969-12-31' , 'F', 6894, 10394)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1895, 'tpyafj frworf' , '1969-12-31' , 'F', 6895, 10395)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1896, 'uaisay glkhzl' , '1969-12-31' , 'F', 6896, 10396)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1897, 'brpjgp vviygn' , '1969-12-31' , 'F', 6897, 10397)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1898, 'cunufe itlwib' , '1969-12-31' , 'M', 6898, 10398)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1899, 'rxklsg kdaomq' , '1969-12-31' , 'F', 6899, 10399)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1900, 'yxhvjr ssstax' , '1969-12-31' , 'F', 6900, 10400)
2012-05-24 17:25:50	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1901, 'vxtnsq qxkixc' , '1969-12-31' , 'M', 6901, 10401)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1902, 'koqolh jbgvup' , '1969-12-31' , 'M', 6902, 10402)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1903, 'zbihfl iqoxgf' , '1969-12-31' , 'M', 6903, 10403)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1904, 'moeest knxexg' , '1969-12-31' , 'M', 6904, 10404)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1905, 'pjmvjs vufxav' , '1969-12-31' , 'F', 6905, 10405)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1906, 'pyrkxz lkwkoz' , '1969-12-31' , 'M', 6906, 10406)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1907, 'lspdau xlbqmb' , '1969-12-31' , 'F', 6907, 10407)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1908, 'gzmphm mekuni' , '1969-12-31' , 'F', 6908, 10408)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1909, 'alacep zortxy' , '1969-12-31' , 'F', 6909, 10409)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1910, 'janwcc mbmfym' , '1969-12-31' , 'F', 6910, 10410)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1911, 'pjopyv tuahju' , '1969-12-31' , 'M', 6911, 10411)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1912, 'vlptqr iizcps' , '1969-12-31' , 'F', 6912, 10412)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1913, 'mqbjyi opgtsv' , '1969-12-31' , 'M', 6913, 10413)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1914, 'ihwgfb ryjfat' , '1969-12-31' , 'M', 6914, 10414)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1915, 'uiuedz mzbvjq' , '1969-12-31' , 'F', 6915, 10415)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1916, 'wwceuu ozpfmd' , '1969-12-31' , 'M', 6916, 10416)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1917, 'pnpsnu ovrtqz' , '1969-12-31' , 'M', 6917, 10417)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1918, 'cqwpvk lmaggl' , '1969-12-31' , 'M', 6918, 10418)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1919, 'zariah ygmamb' , '1969-12-31' , 'M', 6919, 10419)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1920, 'pmlnmk khkgyj' , '1969-12-31' , 'F', 6920, 10420)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1921, 'ngvgnt yzdkyz' , '1969-12-31' , 'F', 6921, 10421)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1922, 'opmjis cozuex' , '1969-12-31' , 'M', 6922, 10422)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1923, 'qfobat gpjppt' , '1969-12-31' , 'M', 6923, 10423)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1924, 'nbhbgf plsmsp' , '1969-12-31' , 'M', 6924, 10424)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1925, 'xubtkb qpibab' , '1969-12-31' , 'M', 6925, 10425)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1926, 'kboifi egrsej' , '1969-12-31' , 'F', 6926, 10426)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1927, 'xstvvl ztjnzn' , '1969-12-31' , 'F', 6927, 10427)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1928, 'sssqaq cxapxu' , '1969-12-31' , 'M', 6928, 10428)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1929, 'ctugnt xwhchw' , '1969-12-31' , 'M', 6929, 10429)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1930, 'wcxiln fgzzdz' , '1969-12-31' , 'M', 6930, 10430)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1931, 'wotejm teoyya' , '1969-12-31' , 'M', 6931, 10431)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1932, 'zaxztt uetfzp' , '1969-12-31' , 'M', 6932, 10432)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1933, 'ydkirs cqqasm' , '1969-12-31' , 'F', 6933, 10433)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1934, 'zisygh gvxsos' , '1969-12-31' , 'M', 6934, 10434)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1935, 'kfnhdk kalqan' , '1969-12-31' , 'M', 6935, 10435)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1936, 'aosrbo qpxsdy' , '1969-12-31' , 'F', 6936, 10436)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1937, 'alpdqd afklav' , '1969-12-31' , 'F', 6937, 10437)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1938, 'fxtazj cyyxzl' , '1969-12-31' , 'M', 6938, 10438)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1939, 'otmelo iqcutb' , '1969-12-31' , 'F', 6939, 10439)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1940, 'jbxlqo djpnky' , '1969-12-31' , 'M', 6940, 10440)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1941, 'tubtqn szuxvj' , '1969-12-31' , 'M', 6941, 10441)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1942, 'gpvyeb bxkrah' , '1969-12-31' , 'F', 6942, 10442)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1943, 'lanjlp xjzmhi' , '1969-12-31' , 'F', 6943, 10443)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1944, 'tgfcwj prazdp' , '1969-12-31' , 'F', 6944, 10444)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1945, 'axywex dcolbu' , '1969-12-31' , 'F', 6945, 10445)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1946, 'eydhad gvzjjw' , '1969-12-31' , 'M', 6946, 10446)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1947, 'jwjiym vwhpoh' , '1969-12-31' , 'M', 6947, 10447)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1948, 'oxuyue kdqgfo' , '1969-12-31' , 'M', 6948, 10448)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1949, 'ubrgsr cgkqhn' , '1969-12-31' , 'M', 6949, 10449)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1950, 'hhaxxe geletu' , '1969-12-31' , 'M', 6950, 10450)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1951, 'zoqbmg njnjwy' , '1969-12-31' , 'F', 6951, 10451)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1952, 'fusawh btedjm' , '1969-12-31' , 'M', 6952, 10452)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1953, 'uwzvee jwooem' , '1969-12-31' , 'M', 6953, 10453)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1954, 'octbxz npmjdn' , '1969-12-31' , 'M', 6954, 10454)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1955, 'adsygs zpafmw' , '1969-12-31' , 'M', 6955, 10455)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1956, 'ygnxbr fjszpe' , '1969-12-31' , 'M', 6956, 10456)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1957, 'jwiwet gczmov' , '1969-12-31' , 'M', 6957, 10457)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1958, 'qpprht jlpvhk' , '1969-12-31' , 'F', 6958, 10458)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1959, 'coppyw iytcjt' , '1969-12-31' , 'M', 6959, 10459)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1960, 'qeaqyf vusxqk' , '1969-12-31' , 'M', 6960, 10460)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1961, 'jlffoc bcsfsu' , '1969-12-31' , 'F', 6961, 10461)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1962, 'vvfftl pxbihg' , '1969-12-31' , 'F', 6962, 10462)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1963, 'hkroab mxvlqo' , '1969-12-31' , 'F', 6963, 10463)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1964, 'fvmmqi ibyoor' , '1969-12-31' , 'M', 6964, 10464)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1965, 'cefbea jylftl' , '1969-12-31' , 'F', 6965, 10465)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1966, 'tqsxyq yrdxql' , '1969-12-31' , 'F', 6966, 10466)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1967, 'vebyjt samrld' , '1969-12-31' , 'F', 6967, 10467)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1968, 'jpggwm obuydp' , '1969-12-31' , 'M', 6968, 10468)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1969, 'eaxybj cbeqgq' , '1969-12-31' , 'M', 6969, 10469)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1970, 'qcumtk sedinj' , '1969-12-31' , 'M', 6970, 10470)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1971, 'tskngw dcttmt' , '1969-12-31' , 'F', 6971, 10471)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1972, 'ssdnof rpoiqe' , '1969-12-31' , 'M', 6972, 10472)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1973, 'ksufks rpweig' , '1969-12-31' , 'F', 6973, 10473)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1974, 'vzeodi jtbzca' , '1969-12-31' , 'M', 6974, 10474)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1975, 'lxsdbs aukdad' , '1969-12-31' , 'M', 6975, 10475)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1976, 'xlzmwr mtbayx' , '1969-12-31' , 'F', 6976, 10476)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1977, 'cxqywt mrbvyx' , '1969-12-31' , 'F', 6977, 10477)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1978, 'lwobzu xzwpbf' , '1969-12-31' , 'F', 6978, 10478)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1979, 'mpxnmo qayxhb' , '1969-12-31' , 'F', 6979, 10479)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1980, 'yxthdx skuurh' , '1969-12-31' , 'F', 6980, 10480)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1981, 'eupowv exbixj' , '1969-12-31' , 'F', 6981, 10481)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1982, 'lbirjn wpwwzi' , '1969-12-31' , 'M', 6982, 10482)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1983, 'sqqajw qxngiq' , '1969-12-31' , 'M', 6983, 10483)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1984, 'ihekqc jhdxfj' , '1969-12-31' , 'F', 6984, 10484)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1985, 'mkongp rdponk' , '1969-12-31' , 'M', 6985, 10485)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1986, 'iofgnq txvase' , '1969-12-31' , 'F', 6986, 10486)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1987, 'suwaje vhguru' , '1969-12-31' , 'F', 6987, 10487)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1988, 'pfyqyn arncva' , '1969-12-31' , 'F', 6988, 10488)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1989, 'tbfqnm ceohly' , '1969-12-31' , 'F', 6989, 10489)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1990, 'kjzbqw vpfphd' , '1969-12-31' , 'M', 6990, 10490)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1991, 'abbovs twlleh' , '1969-12-31' , 'M', 6991, 10491)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1992, 'kequiu rkebbf' , '1969-12-31' , 'F', 6992, 10492)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1993, 'iwdtdl lbsupt' , '1969-12-31' , 'F', 6993, 10493)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1994, 'idgrly ucbjwy' , '1969-12-31' , 'M', 6994, 10494)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1995, 'krkhwt qnpufm' , '1969-12-31' , 'M', 6995, 10495)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1996, 'tsjbok ibppfa' , '1969-12-31' , 'F', 6996, 10496)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1997, 'cponyc itvodg' , '1969-12-31' , 'F', 6997, 10497)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1998, 'cwmhxd tbohni' , '1969-12-31' , 'M', 6998, 10498)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (1999, 'ugpgbv jmqpxv' , '1969-12-31' , 'M', 6999, 10499)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2000, 'jpoeyg naukxi' , '1969-12-31' , 'F', 7000, 10500)
2012-05-24 17:25:51	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2001, 'irzxfq uxrhvn' , '1969-12-31' , 'F', 7001, 10501)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2002, 'hvzzxc gjodfm' , '1969-12-31' , 'M', 7002, 10502)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2003, 'qtlxas hsnhzt' , '1969-12-31' , 'M', 7003, 10503)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2004, 'pteghd wifgrq' , '1969-12-31' , 'M', 7004, 10504)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2005, 'xcjswd kfmihy' , '1969-12-31' , 'M', 7005, 10505)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2006, 'bvyzma dieqlw' , '1969-12-31' , 'M', 7006, 10506)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2007, 'gesajw rpokac' , '1969-12-31' , 'F', 7007, 10507)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2008, 'lvijlx vwmxzd' , '1969-12-31' , 'F', 7008, 10508)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2009, 'cbxqvk zvlabc' , '1969-12-31' , 'F', 7009, 10509)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2010, 'ipyvfr rykdih' , '1969-12-31' , 'F', 7010, 10510)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2011, 'jxcvos bylwre' , '1969-12-31' , 'F', 7011, 10511)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2012, 'zyyjre pthmse' , '1969-12-31' , 'M', 7012, 10512)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2013, 'khmrxw wjvmeg' , '1969-12-31' , 'F', 7013, 10513)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2014, 'fuuege fsshny' , '1969-12-31' , 'M', 7014, 10514)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2015, 'udceoh lgpoqb' , '1969-12-31' , 'F', 7015, 10515)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2016, 'xkbhfp uhbxfd' , '1969-12-31' , 'F', 7016, 10516)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2017, 'qnmjij cojncb' , '1969-12-31' , 'M', 7017, 10517)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2018, 'mjpjjn evowwr' , '1969-12-31' , 'F', 7018, 10518)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2019, 'igezlb tvlfcq' , '1969-12-31' , 'F', 7019, 10519)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2020, 'iauvhm vlhgou' , '1969-12-31' , 'F', 7020, 10520)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2021, 'cogrbo hreuje' , '1969-12-31' , 'F', 7021, 10521)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2022, 'fvzvdk gylnjg' , '1969-12-31' , 'F', 7022, 10522)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2023, 'sawvfk uuhiqq' , '1969-12-31' , 'F', 7023, 10523)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2024, 'aiynvy hybwng' , '1969-12-31' , 'F', 7024, 10524)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2025, 'toxlpc rgvzln' , '1969-12-31' , 'M', 7025, 10525)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2026, 'ktjang pwkknk' , '1969-12-31' , 'F', 7026, 10526)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2027, 'rqdobg fddcud' , '1969-12-31' , 'M', 7027, 10527)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2028, 'pccowh xuzrka' , '1969-12-31' , 'F', 7028, 10528)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2029, 'bodjdo odjqzd' , '1969-12-31' , 'F', 7029, 10529)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2030, 'athbbv ihvfaf' , '1969-12-31' , 'F', 7030, 10530)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2031, 'rjjayw mivhar' , '1969-12-31' , 'F', 7031, 10531)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2032, 'spxoga wctkkv' , '1969-12-31' , 'F', 7032, 10532)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2033, 'wlqndb vpsysz' , '1969-12-31' , 'M', 7033, 10533)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2034, 'aazzpz kitwop' , '1969-12-31' , 'F', 7034, 10534)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2035, 'iftjij bpwhvc' , '1969-12-31' , 'F', 7035, 10535)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2036, 'qunfsx yrmsth' , '1969-12-31' , 'M', 7036, 10536)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2037, 'waxere tqetdq' , '1969-12-31' , 'F', 7037, 10537)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2038, 'pxabgr tnrbxo' , '1969-12-31' , 'M', 7038, 10538)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2039, 'lecsdd ldgggm' , '1969-12-31' , 'M', 7039, 10539)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2040, 'wkvmov xrrwgc' , '1969-12-31' , 'F', 7040, 10540)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2041, 'xzebfg ooyrry' , '1969-12-31' , 'F', 7041, 10541)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2042, 'lzhyan jwbxzu' , '1969-12-31' , 'M', 7042, 10542)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2043, 'vadksy vwjduz' , '1969-12-31' , 'F', 7043, 10543)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2044, 'jyqtep mmbqsy' , '1969-12-31' , 'F', 7044, 10544)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2045, 'kqbflw gmeknx' , '1969-12-31' , 'F', 7045, 10545)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2046, 'kscqdn dfdljo' , '1969-12-31' , 'F', 7046, 10546)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2047, 'wsrpfj qajokg' , '1969-12-31' , 'F', 7047, 10547)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2048, 'vqcqlg jssjao' , '1969-12-31' , 'F', 7048, 10548)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2049, 'lutgqg ibduif' , '1969-12-31' , 'M', 7049, 10549)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2050, 'lhymah drmgkg' , '1969-12-31' , 'F', 7050, 10550)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2051, 'dohbcv qdoeky' , '1969-12-31' , 'M', 7051, 10551)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2052, 'kikdzy leerxk' , '1969-12-31' , 'M', 7052, 10552)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2053, 'fvxmhn xjqfvw' , '1969-12-31' , 'M', 7053, 10553)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2054, 'duhlih qymwnx' , '1969-12-31' , 'M', 7054, 10554)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2055, 'olqtif ixmkiv' , '1969-12-31' , 'F', 7055, 10555)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2056, 'dempew nhfjlu' , '1969-12-31' , 'M', 7056, 10556)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2057, 'zgmxdh gfrmaq' , '1969-12-31' , 'M', 7057, 10557)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2058, 'ysqsny foilwj' , '1969-12-31' , 'M', 7058, 10558)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2059, 'zpxyux qsetul' , '1969-12-31' , 'F', 7059, 10559)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2060, 'lyhkqs ngayjp' , '1969-12-31' , 'M', 7060, 10560)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2061, 'nvajpp rjxykx' , '1969-12-31' , 'M', 7061, 10561)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2062, 'rtvrcd lfqoyp' , '1969-12-31' , 'F', 7062, 10562)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2063, 'vjukac mcngan' , '1969-12-31' , 'F', 7063, 10563)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2064, 'mqifqa jdhrdm' , '1969-12-31' , 'M', 7064, 10564)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2065, 'kutrhn lkkapv' , '1969-12-31' , 'F', 7065, 10565)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2066, 'xgrmji yezhyi' , '1969-12-31' , 'F', 7066, 10566)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2067, 'gmdzck yxzdmw' , '1969-12-31' , 'M', 7067, 10567)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2068, 'kmnlcx jdxbko' , '1969-12-31' , 'F', 7068, 10568)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2069, 'qtljwm dxtfgv' , '1969-12-31' , 'M', 7069, 10569)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2070, 'wyoqab lhbgge' , '1969-12-31' , 'M', 7070, 10570)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2071, 'edakrc fnimbc' , '1969-12-31' , 'F', 7071, 10571)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2072, 'ciwpoz erkuqi' , '1969-12-31' , 'F', 7072, 10572)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2073, 'yvjwep hztibr' , '1969-12-31' , 'M', 7073, 10573)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2074, 'jlfgqp crzkht' , '1969-12-31' , 'M', 7074, 10574)
2012-05-24 17:25:52	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2075, 'ymtxml nbrqrs' , '1969-12-31' , 'F', 7075, 10575)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2076, 'jclliw eecngr' , '1969-12-31' , 'M', 7076, 10576)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2077, 'ntezwj bapvko' , '1969-12-31' , 'F', 7077, 10577)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2078, 'xgnqck jqqbcc' , '1969-12-31' , 'F', 7078, 10578)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2079, 'ufdgts awside' , '1969-12-31' , 'M', 7079, 10579)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2080, 'gllucs ooouhe' , '1969-12-31' , 'F', 7080, 10580)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2081, 'kgyadm dzrhox' , '1969-12-31' , 'F', 7081, 10581)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2082, 'odiqhj diqqwz' , '1969-12-31' , 'F', 7082, 10582)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2083, 'ecpnwo hkhkvz' , '1969-12-31' , 'F', 7083, 10583)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2084, 'fofhle qhcjfm' , '1969-12-31' , 'F', 7084, 10584)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2085, 'jektgr kdaecb' , '1969-12-31' , 'M', 7085, 10585)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2086, 'cqqooc sdalli' , '1969-12-31' , 'F', 7086, 10586)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2087, 'iojjcp mmxdmn' , '1969-12-31' , 'M', 7087, 10587)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2088, 'ftxfpo xajami' , '1969-12-31' , 'M', 7088, 10588)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2089, 'rnpyzi moemmy' , '1969-12-31' , 'F', 7089, 10589)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2090, 'mrysoq sqejem' , '1969-12-31' , 'F', 7090, 10590)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2091, 'uilkwz qmxmya' , '1969-12-31' , 'F', 7091, 10591)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2092, 'qhybmo nqbesh' , '1969-12-31' , 'F', 7092, 10592)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2093, 'kgodvj wabhpm' , '1969-12-31' , 'M', 7093, 10593)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2094, 'yssnir arebmj' , '1969-12-31' , 'F', 7094, 10594)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2095, 'myrmrj tzoiiu' , '1969-12-31' , 'F', 7095, 10595)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2096, 'blqfno zyeorx' , '1969-12-31' , 'M', 7096, 10596)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2097, 'fkpvrb wzvcde' , '1969-12-31' , 'M', 7097, 10597)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2098, 'yjhzwt awjnjv' , '1969-12-31' , 'F', 7098, 10598)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2099, 'npyngy nrhwvb' , '1969-12-31' , 'F', 7099, 10599)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2100, 'wptncq olxtgt' , '1969-12-31' , 'M', 7100, 10600)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2101, 'tuowys skpnoj' , '1969-12-31' , 'F', 7101, 10601)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2102, 'zikhgo jldzfs' , '1969-12-31' , 'F', 7102, 10602)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2103, 'oymqod bxzvnh' , '1969-12-31' , 'M', 7103, 10603)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2104, 'rvfvgf vdwjls' , '1969-12-31' , 'F', 7104, 10604)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2105, 'sequxc lntafz' , '1969-12-31' , 'F', 7105, 10605)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2106, 'bjilmr retbaa' , '1969-12-31' , 'F', 7106, 10606)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2107, 'wprfjb lwamjg' , '1969-12-31' , 'M', 7107, 10607)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2108, 'evubsu rtzekh' , '1969-12-31' , 'F', 7108, 10608)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2109, 'lhalvf cdzxqk' , '1969-12-31' , 'M', 7109, 10609)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2110, 'wgqnnn lrxyro' , '1969-12-31' , 'M', 7110, 10610)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2111, 'ugmnpm snwems' , '1969-12-31' , 'M', 7111, 10611)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2112, 'wvqyex huhhpi' , '1969-12-31' , 'M', 7112, 10612)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2113, 'xpnacr jjycmt' , '1969-12-31' , 'F', 7113, 10613)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2114, 'qoytgn pbteut' , '1969-12-31' , 'M', 7114, 10614)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2115, 'wetgtw qclgsl' , '1969-12-31' , 'M', 7115, 10615)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2116, 'ygxeue unqcof' , '1969-12-31' , 'M', 7116, 10616)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2117, 'cfygae mlstrp' , '1969-12-31' , 'F', 7117, 10617)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2118, 'qsbses smfezj' , '1969-12-31' , 'M', 7118, 10618)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2119, 'mvarue fkqvim' , '1969-12-31' , 'F', 7119, 10619)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2120, 'yatyew hankkr' , '1969-12-31' , 'F', 7120, 10620)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2121, 'wijdmi qinyna' , '1969-12-31' , 'F', 7121, 10621)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2122, 'dumffm gfaida' , '1969-12-31' , 'M', 7122, 10622)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2123, 'yowece levtpb' , '1969-12-31' , 'F', 7123, 10623)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2124, 'jlftdw ecblgg' , '1969-12-31' , 'M', 7124, 10624)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2125, 'kwdvjd ohjkya' , '1969-12-31' , 'M', 7125, 10625)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2126, 'rekaui bzhvsz' , '1969-12-31' , 'F', 7126, 10626)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2127, 'opwqpg boiogf' , '1969-12-31' , 'F', 7127, 10627)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2128, 'swmpzx jdqbii' , '1969-12-31' , 'M', 7128, 10628)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2129, 'epfoma wbmyux' , '1969-12-31' , 'M', 7129, 10629)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2130, 'nerpqu ronjjp' , '1969-12-31' , 'F', 7130, 10630)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2131, 'phinlr emnlcr' , '1969-12-31' , 'M', 7131, 10631)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2132, 'wppsmc ulyrdm' , '1969-12-31' , 'F', 7132, 10632)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2133, 'vijcoe lghbay' , '1969-12-31' , 'M', 7133, 10633)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2134, 'rgqmzo dguwwm' , '1969-12-31' , 'F', 7134, 10634)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2135, 'oichgs gbpscy' , '1969-12-31' , 'F', 7135, 10635)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2136, 'cwtxon mgpalq' , '1969-12-31' , 'F', 7136, 10636)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2137, 'ooxiaa ivnueu' , '1969-12-31' , 'M', 7137, 10637)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2138, 'layxij zsjgxu' , '1969-12-31' , 'F', 7138, 10638)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2139, 'iuldyk eihuyx' , '1969-12-31' , 'M', 7139, 10639)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2140, 'kujxob myytai' , '1969-12-31' , 'F', 7140, 10640)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2141, 'kkvjxn gzdzwe' , '1969-12-31' , 'M', 7141, 10641)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2142, 'cfvyoo xsktjs' , '1969-12-31' , 'M', 7142, 10642)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2143, 'wkdgpa hniyav' , '1969-12-31' , 'M', 7143, 10643)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2144, 'fvoxuv ffxbcn' , '1969-12-31' , 'M', 7144, 10644)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2145, 'qzplbo dctrpo' , '1969-12-31' , 'M', 7145, 10645)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2146, 'megihh ycomie' , '1969-12-31' , 'F', 7146, 10646)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2147, 'ytkbgw ctmmgt' , '1969-12-31' , 'M', 7147, 10647)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2148, 'oajfpm dbxdpd' , '1969-12-31' , 'M', 7148, 10648)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2149, 'unrozm qjavnp' , '1969-12-31' , 'F', 7149, 10649)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2150, 'cqimwb srkwap' , '1969-12-31' , 'F', 7150, 10650)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2151, 'gcntna ocffad' , '1969-12-31' , 'M', 7151, 10651)
2012-05-24 17:25:53	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2152, 'perfzl hufogf' , '1969-12-31' , 'F', 7152, 10652)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2153, 'wogzhi cmnbjj' , '1969-12-31' , 'F', 7153, 10653)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2154, 'sfrles bclnwh' , '1969-12-31' , 'F', 7154, 10654)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2155, 'bewxwr kjyvcc' , '1969-12-31' , 'F', 7155, 10655)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2156, 'qoxyfr lbhnhu' , '1969-12-31' , 'M', 7156, 10656)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2157, 'syywxl hhjcnk' , '1969-12-31' , 'M', 7157, 10657)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2158, 'jkrhom oubwma' , '1969-12-31' , 'M', 7158, 10658)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2159, 'ugidkx xondgy' , '1969-12-31' , 'M', 7159, 10659)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2160, 'jwhbwr lajdrr' , '1969-12-31' , 'M', 7160, 10660)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2161, 'durihk dbgrrk' , '1969-12-31' , 'M', 7161, 10661)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2162, 'lahtem qhtgbg' , '1969-12-31' , 'M', 7162, 10662)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2163, 'oiuyky aouggk' , '1969-12-31' , 'F', 7163, 10663)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2164, 'yhtvas nqvgzg' , '1969-12-31' , 'F', 7164, 10664)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2165, 'uwqxby gapuog' , '1969-12-31' , 'F', 7165, 10665)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2166, 'fqzywo wkzbve' , '1969-12-31' , 'M', 7166, 10666)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2167, 'jygoub ltylhm' , '1969-12-31' , 'F', 7167, 10667)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2168, 'karwte teriaf' , '1969-12-31' , 'F', 7168, 10668)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2169, 'ymaqgr fnhhda' , '1969-12-31' , 'F', 7169, 10669)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2170, 'xcpnzt hjvzdj' , '1969-12-31' , 'M', 7170, 10670)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2171, 'krytqy dvabwh' , '1969-12-31' , 'M', 7171, 10671)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2172, 'xhlnau cxsmxn' , '1969-12-31' , 'F', 7172, 10672)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2173, 'eoophp twqtor' , '1969-12-31' , 'M', 7173, 10673)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2174, 'eenjbl hbvepv' , '1969-12-31' , 'F', 7174, 10674)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2175, 'pezkoi vkezzv' , '1969-12-31' , 'M', 7175, 10675)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2176, 'qlnxhk kxvbbl' , '1969-12-31' , 'M', 7176, 10676)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2177, 'wxevgd phkbtd' , '1969-12-31' , 'M', 7177, 10677)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2178, 'xqhpgn qldxfl' , '1969-12-31' , 'M', 7178, 10678)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2179, 'lqrkvr thicrw' , '1969-12-31' , 'F', 7179, 10679)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2180, 'jiuzsp twsapj' , '1969-12-31' , 'F', 7180, 10680)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2181, 'doklkc upeawf' , '1969-12-31' , 'M', 7181, 10681)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2182, 'ibhypo hkpncn' , '1969-12-31' , 'M', 7182, 10682)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2183, 'kuafpx cbrkvr' , '1969-12-31' , 'M', 7183, 10683)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2184, 'snqzbj dxvqer' , '1969-12-31' , 'M', 7184, 10684)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2185, 'psshsy tyweuf' , '1969-12-31' , 'F', 7185, 10685)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2186, 'yvqwjj zwuklh' , '1969-12-31' , 'M', 7186, 10686)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2187, 'wqdvfm cfekic' , '1969-12-31' , 'M', 7187, 10687)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2188, 'uzqcau nounzg' , '1969-12-31' , 'F', 7188, 10688)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2189, 'gufunu gnbepa' , '1969-12-31' , 'F', 7189, 10689)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2190, 'viqilp aydyxq' , '1969-12-31' , 'F', 7190, 10690)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2191, 'oopejk uxznac' , '1969-12-31' , 'F', 7191, 10691)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2192, 'ckjzzv rtgssf' , '1969-12-31' , 'F', 7192, 10692)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2193, 'aukucd sogfev' , '1969-12-31' , 'M', 7193, 10693)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2194, 'wdqtwv mwcrvm' , '1969-12-31' , 'M', 7194, 10694)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2195, 'yrikly dijmff' , '1969-12-31' , 'M', 7195, 10695)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2196, 'tzlozs opfacd' , '1969-12-31' , 'F', 7196, 10696)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2197, 'revdwm fmgrot' , '1969-12-31' , 'M', 7197, 10697)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2198, 'tdbnsd dwsdun' , '1969-12-31' , 'M', 7198, 10698)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2199, 'rxathr jdxoxs' , '1969-12-31' , 'F', 7199, 10699)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2200, 'daauck unpxyl' , '1969-12-31' , 'F', 7200, 10700)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2201, 'atvzyg efstuj' , '1969-12-31' , 'M', 7201, 10701)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2202, 'tobmrv zyoiyl' , '1969-12-31' , 'M', 7202, 10702)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2203, 'eeilqh othcbv' , '1969-12-31' , 'M', 7203, 10703)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2204, 'fxkzsu dayoxp' , '1969-12-31' , 'F', 7204, 10704)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2205, 'vxkeyw fnedfd' , '1969-12-31' , 'M', 7205, 10705)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2206, 'qxblze fxzydy' , '1969-12-31' , 'M', 7206, 10706)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2207, 'mgvvdp lzpfzh' , '1969-12-31' , 'F', 7207, 10707)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2208, 'mndmvi aokbqo' , '1969-12-31' , 'M', 7208, 10708)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2209, 'edjnyr fjakep' , '1969-12-31' , 'F', 7209, 10709)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2210, 'gwxwfz ztgbkv' , '1969-12-31' , 'M', 7210, 10710)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2211, 'ztqhsu yjtclh' , '1969-12-31' , 'F', 7211, 10711)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2212, 'asgaxn cxivuj' , '1969-12-31' , 'F', 7212, 10712)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2213, 'wxpdxt ulviju' , '1969-12-31' , 'M', 7213, 10713)
2012-05-24 17:25:54	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2214, 'ihfbsr gsyahc' , '1969-12-31' , 'M', 7214, 10714)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2215, 'assnij swbmqv' , '1969-12-31' , 'F', 7215, 10715)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2216, 'euftoo kjztno' , '1969-12-31' , 'M', 7216, 10716)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2217, 'dyipbk lrqwbd' , '1969-12-31' , 'M', 7217, 10717)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2218, 'lqxdzs ozfqdd' , '1969-12-31' , 'F', 7218, 10718)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2219, 'pvzxjd ioxihp' , '1969-12-31' , 'M', 7219, 10719)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2220, 'xnxmuo rzgrsa' , '1969-12-31' , 'F', 7220, 10720)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2221, 'ampvvh zahyud' , '1969-12-31' , 'F', 7221, 10721)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2222, 'buxaxp lwvbpa' , '1969-12-31' , 'M', 7222, 10722)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2223, 'cgindz zhrlyk' , '1969-12-31' , 'M', 7223, 10723)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2224, 'qjzaip ugjpds' , '1969-12-31' , 'F', 7224, 10724)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2225, 'pcaoty mmzrxh' , '1969-12-31' , 'F', 7225, 10725)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2226, 'pralic ezqisp' , '1969-12-31' , 'F', 7226, 10726)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2227, 'ujlkmk rtqaou' , '1969-12-31' , 'F', 7227, 10727)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2228, 'buylnf yaiaxs' , '1969-12-31' , 'F', 7228, 10728)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2229, 'asoeln qpfdvi' , '1969-12-31' , 'F', 7229, 10729)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2230, 'vxbqyr nmrnbf' , '1969-12-31' , 'F', 7230, 10730)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2231, 'ewcrgj crxsyd' , '1969-12-31' , 'F', 7231, 10731)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2232, 'achghe vjyjwe' , '1969-12-31' , 'F', 7232, 10732)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2233, 'wmerxt danjye' , '1969-12-31' , 'M', 7233, 10733)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2234, 'dkxnvk bsqoyb' , '1969-12-31' , 'F', 7234, 10734)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2235, 'jjjqub ocmvwn' , '1969-12-31' , 'F', 7235, 10735)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2236, 'gsnknt wukvmf' , '1969-12-31' , 'F', 7236, 10736)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2237, 'amhtrq khakxq' , '1969-12-31' , 'F', 7237, 10737)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2238, 'czydgx sfjbeq' , '1969-12-31' , 'F', 7238, 10738)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2239, 'rvtvah jggyhg' , '1969-12-31' , 'F', 7239, 10739)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2240, 'dejzfd iomxar' , '1969-12-31' , 'F', 7240, 10740)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2241, 'pieqse uammfd' , '1969-12-31' , 'F', 7241, 10741)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2242, 'zyvkmj lgghsq' , '1969-12-31' , 'F', 7242, 10742)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2243, 'otryxo ruykyn' , '1969-12-31' , 'M', 7243, 10743)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2244, 'aemyho exlwox' , '1969-12-31' , 'M', 7244, 10744)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2245, 'xhcgfp wuswig' , '1969-12-31' , 'F', 7245, 10745)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2246, 'tjpojd cflgli' , '1969-12-31' , 'M', 7246, 10746)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2247, 'tjzooh somial' , '1969-12-31' , 'F', 7247, 10747)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2248, 'tsqnfk vtonlp' , '1969-12-31' , 'F', 7248, 10748)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2249, 'brohvk nrcuwf' , '1969-12-31' , 'M', 7249, 10749)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2250, 'kprxrg vkaqxx' , '1969-12-31' , 'M', 7250, 10750)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2251, 'fclsob flhjhy' , '1969-12-31' , 'F', 7251, 10751)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2252, 'nkjyhf vckaof' , '1969-12-31' , 'M', 7252, 10752)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2253, 'mcitjw mnkdrz' , '1969-12-31' , 'F', 7253, 10753)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2254, 'crltrh ryymii' , '1969-12-31' , 'M', 7254, 10754)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2255, 'howhsw iqbdkd' , '1969-12-31' , 'M', 7255, 10755)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2256, 'ouuivc pvuftb' , '1969-12-31' , 'F', 7256, 10756)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2257, 'fxuptj vusgtx' , '1969-12-31' , 'M', 7257, 10757)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2258, 'cdmkbq jicaxw' , '1969-12-31' , 'M', 7258, 10758)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2259, 'ykkqoy kuvdub' , '1969-12-31' , 'M', 7259, 10759)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2260, 'ooecux kzfkde' , '1969-12-31' , 'M', 7260, 10760)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2261, 'owapnh owevnc' , '1969-12-31' , 'M', 7261, 10761)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2262, 'dnlxwy fbormi' , '1969-12-31' , 'F', 7262, 10762)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2263, 'ojjrtn hgobtf' , '1969-12-31' , 'F', 7263, 10763)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2264, 'uiigch rfqdvu' , '1969-12-31' , 'M', 7264, 10764)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2265, 'hpblia nfxwur' , '1969-12-31' , 'M', 7265, 10765)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2266, 'ezbqfz vxrsnz' , '1969-12-31' , 'M', 7266, 10766)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2267, 'qvnczo qaxrei' , '1969-12-31' , 'M', 7267, 10767)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2268, 'trngld gurbmf' , '1969-12-31' , 'F', 7268, 10768)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2269, 'wwqsws mdttkt' , '1969-12-31' , 'F', 7269, 10769)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2270, 'hehnfx yfztzf' , '1969-12-31' , 'F', 7270, 10770)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2271, 'suszuz dsjynl' , '1969-12-31' , 'M', 7271, 10771)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2272, 'tulqku adyeea' , '1969-12-31' , 'F', 7272, 10772)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2273, 'kfzolr uzsqcg' , '1969-12-31' , 'F', 7273, 10773)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2274, 'besmar grifvv' , '1969-12-31' , 'M', 7274, 10774)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2275, 'coqfsy blxccg' , '1969-12-31' , 'M', 7275, 10775)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2276, 'qwkock bmydyg' , '1969-12-31' , 'M', 7276, 10776)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2277, 'cbkret oxxwvx' , '1969-12-31' , 'F', 7277, 10777)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2278, 'confgk eyzqkd' , '1969-12-31' , 'M', 7278, 10778)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2279, 'gwrkvq tqgvge' , '1969-12-31' , 'M', 7279, 10779)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2280, 'pyfkba xufgws' , '1969-12-31' , 'F', 7280, 10780)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2281, 'ffnpho qaafon' , '1969-12-31' , 'F', 7281, 10781)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2282, 'xfyydk iirnxu' , '1969-12-31' , 'F', 7282, 10782)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2283, 'ycppfe obmgth' , '1969-12-31' , 'M', 7283, 10783)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2284, 'xqjjmd uiitrl' , '1969-12-31' , 'M', 7284, 10784)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2285, 'oiykak xjatnr' , '1969-12-31' , 'F', 7285, 10785)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2286, 'rhzpdn ilenbr' , '1969-12-31' , 'M', 7286, 10786)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2287, 'ijfead jmihdy' , '1969-12-31' , 'M', 7287, 10787)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2288, 'wfwlnl pdgzsy' , '1969-12-31' , 'F', 7288, 10788)
2012-05-24 17:25:55	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2289, 'rloooh mzurks' , '1969-12-31' , 'F', 7289, 10789)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2290, 'npbarm wbooog' , '1969-12-31' , 'F', 7290, 10790)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2291, 'oaxmxu bsmyfl' , '1969-12-31' , 'M', 7291, 10791)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2292, 'mepcxs gunnlh' , '1969-12-31' , 'F', 7292, 10792)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2293, 'rtszrj bqqfqn' , '1969-12-31' , 'F', 7293, 10793)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2294, 'pdxoen qgkhpp' , '1969-12-31' , 'M', 7294, 10794)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2295, 'ocshsy naqgcq' , '1969-12-31' , 'F', 7295, 10795)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2296, 'qnolqw atntlz' , '1969-12-31' , 'F', 7296, 10796)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2297, 'vbatum hpqwjf' , '1969-12-31' , 'M', 7297, 10797)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2298, 'acfurh dsesgz' , '1969-12-31' , 'F', 7298, 10798)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2299, 'koqxwt yobccl' , '1969-12-31' , 'F', 7299, 10799)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2300, 'zxjmgr kdlkoq' , '1969-12-31' , 'M', 7300, 10800)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2301, 'uoahvz cmccnq' , '1969-12-31' , 'F', 7301, 10801)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2302, 'uakrfx xryhhl' , '1969-12-31' , 'M', 7302, 10802)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2303, 'ynymnz oakqmp' , '1969-12-31' , 'M', 7303, 10803)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2304, 'fgoeax efpgjz' , '1969-12-31' , 'F', 7304, 10804)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2305, 'tbcijj lacylp' , '1969-12-31' , 'F', 7305, 10805)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2306, 'ldqznk jtfuoe' , '1969-12-31' , 'F', 7306, 10806)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2307, 'wdltin jzanwf' , '1969-12-31' , 'F', 7307, 10807)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2308, 'oqcmck gemkja' , '1969-12-31' , 'M', 7308, 10808)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2309, 'jevbcs gdcmvp' , '1969-12-31' , 'M', 7309, 10809)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2310, 'xzgboh cczqar' , '1969-12-31' , 'M', 7310, 10810)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2311, 'zqptva eeybrs' , '1969-12-31' , 'M', 7311, 10811)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2312, 'oqnzlr zgcbmi' , '1969-12-31' , 'M', 7312, 10812)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2313, 'saohhx lytfft' , '1969-12-31' , 'F', 7313, 10813)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2314, 'auoeqo spfhjm' , '1969-12-31' , 'M', 7314, 10814)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2315, 'lgkhal jimxmf' , '1969-12-31' , 'F', 7315, 10815)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2316, 'btsdyf prpqcn' , '1969-12-31' , 'F', 7316, 10816)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2317, 'bttpgp azrfgl' , '1969-12-31' , 'M', 7317, 10817)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2318, 'xqzffl iahtol' , '1969-12-31' , 'M', 7318, 10818)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2319, 'ylzfcm poqidx' , '1969-12-31' , 'M', 7319, 10819)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2320, 'sbrkkb nmdeam' , '1969-12-31' , 'M', 7320, 10820)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2321, 'kyuvnz ydjjfk' , '1969-12-31' , 'M', 7321, 10821)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2322, 'gvinuf dsllfw' , '1969-12-31' , 'F', 7322, 10822)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2323, 'ymeels raovdb' , '1969-12-31' , 'M', 7323, 10823)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2324, 'nrqavr kbwnje' , '1969-12-31' , 'M', 7324, 10824)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2325, 'ueyelk xvzrdp' , '1969-12-31' , 'M', 7325, 10825)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2326, 'hachhm khprlm' , '1969-12-31' , 'M', 7326, 10826)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2327, 'ggfzmp qdqvhr' , '1969-12-31' , 'F', 7327, 10827)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2328, 'dptzie uyeauh' , '1969-12-31' , 'M', 7328, 10828)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2329, 'larlia sttpwp' , '1969-12-31' , 'F', 7329, 10829)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2330, 'mjavux ufchxh' , '1969-12-31' , 'F', 7330, 10830)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2331, 'qbsgyu muuign' , '1969-12-31' , 'F', 7331, 10831)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2332, 'eekjhl zkknit' , '1969-12-31' , 'F', 7332, 10832)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2333, 'ntnfmi vpywke' , '1969-12-31' , 'F', 7333, 10833)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2334, 'yebtoe cjaglq' , '1969-12-31' , 'M', 7334, 10834)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2335, 'hodhrh buyonk' , '1969-12-31' , 'M', 7335, 10835)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2336, 'zgopoj qpkfic' , '1969-12-31' , 'F', 7336, 10836)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2337, 'tawpkd ovidpz' , '1969-12-31' , 'M', 7337, 10837)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2338, 'atdmkg ghsndn' , '1969-12-31' , 'F', 7338, 10838)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2339, 'fdlgqm uwaqvw' , '1969-12-31' , 'F', 7339, 10839)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2340, 'musyep hrfzch' , '1969-12-31' , 'M', 7340, 10840)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2341, 'iflfgj yjvnpx' , '1969-12-31' , 'M', 7341, 10841)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2342, 'qgccye nimays' , '1969-12-31' , 'M', 7342, 10842)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2343, 'epezjp zocsez' , '1969-12-31' , 'F', 7343, 10843)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2344, 'hfoafy gqwwuo' , '1969-12-31' , 'M', 7344, 10844)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2345, 'htncrl nizkdx' , '1969-12-31' , 'M', 7345, 10845)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2346, 'lsaumh bwimow' , '1969-12-31' , 'F', 7346, 10846)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2347, 'jvhnus rcdaot' , '1969-12-31' , 'F', 7347, 10847)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2348, 'tmrkit pprhxa' , '1969-12-31' , 'F', 7348, 10848)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2349, 'xusbnx ayqltn' , '1969-12-31' , 'M', 7349, 10849)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2350, 'hsfmpa ivzjxd' , '1969-12-31' , 'F', 7350, 10850)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2351, 'ydpobl edojmh' , '1969-12-31' , 'F', 7351, 10851)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2352, 'yunnbp ovwiqm' , '1969-12-31' , 'M', 7352, 10852)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2353, 'ilxilr vbfzcw' , '1969-12-31' , 'F', 7353, 10853)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2354, 'dvwttd gwsqeb' , '1969-12-31' , 'M', 7354, 10854)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2355, 'eshekm cdvfud' , '1969-12-31' , 'M', 7355, 10855)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2356, 'bzwhgv nlzjxn' , '1969-12-31' , 'F', 7356, 10856)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2357, 'atmost kwhedd' , '1969-12-31' , 'F', 7357, 10857)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2358, 'oltofy aswhlt' , '1969-12-31' , 'F', 7358, 10858)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2359, 'ciqccj cpjpyd' , '1969-12-31' , 'F', 7359, 10859)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2360, 'qkkdgv glnjuq' , '1969-12-31' , 'F', 7360, 10860)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2361, 'gsqvmx lquqai' , '1969-12-31' , 'M', 7361, 10861)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2362, 'spbfrw viamyd' , '1969-12-31' , 'M', 7362, 10862)
2012-05-24 17:25:56	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2363, 'yzacun bhorut' , '1969-12-31' , 'F', 7363, 10863)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2364, 'wajull jcmxkf' , '1969-12-31' , 'M', 7364, 10864)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2365, 'pzclcs usqelz' , '1969-12-31' , 'M', 7365, 10865)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2366, 'gaptsm favciu' , '1969-12-31' , 'F', 7366, 10866)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2367, 'czasvh mohibq' , '1969-12-31' , 'M', 7367, 10867)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2368, 'scrjnp wdecpc' , '1969-12-31' , 'M', 7368, 10868)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2369, 'lfyzin qejgcs' , '1969-12-31' , 'M', 7369, 10869)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2370, 'ohziwv yanwxc' , '1969-12-31' , 'F', 7370, 10870)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2371, 'vzmmtf qrmxbt' , '1969-12-31' , 'M', 7371, 10871)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2372, 'supqru csdhbe' , '1969-12-31' , 'F', 7372, 10872)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2373, 'skvfpw zelpfc' , '1969-12-31' , 'F', 7373, 10873)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2374, 'akmwio qxkmsa' , '1969-12-31' , 'F', 7374, 10874)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2375, 'hlywfy yofuuc' , '1969-12-31' , 'F', 7375, 10875)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2376, 'xgvveo mqcruk' , '1969-12-31' , 'F', 7376, 10876)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2377, 'cxozrg ulxaco' , '1969-12-31' , 'M', 7377, 10877)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2378, 'ouotic ssjbos' , '1969-12-31' , 'F', 7378, 10878)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2379, 'implwr verjpm' , '1969-12-31' , 'M', 7379, 10879)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2380, 'qpkmik qokkyf' , '1969-12-31' , 'M', 7380, 10880)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2381, 'xwnzma zuwsbk' , '1969-12-31' , 'M', 7381, 10881)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2382, 'rhwlbm jhmrqz' , '1969-12-31' , 'M', 7382, 10882)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2383, 'goessp kqxwzv' , '1969-12-31' , 'F', 7383, 10883)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2384, 'pdiqri lktrsd' , '1969-12-31' , 'F', 7384, 10884)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2385, 'ywcdwx sxpxhu' , '1969-12-31' , 'F', 7385, 10885)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2386, 'rikiyx njrhqq' , '1969-12-31' , 'M', 7386, 10886)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2387, 'tjjllu smkjev' , '1969-12-31' , 'M', 7387, 10887)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2388, 'nnbtfm werdur' , '1969-12-31' , 'M', 7388, 10888)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2389, 'epouox yfbecr' , '1969-12-31' , 'M', 7389, 10889)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2390, 'cthgao pbisma' , '1969-12-31' , 'M', 7390, 10890)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2391, 'pwdqss hkzhyx' , '1969-12-31' , 'F', 7391, 10891)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2392, 'pupnyf qghocd' , '1969-12-31' , 'M', 7392, 10892)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2393, 'hanbte hxancm' , '1969-12-31' , 'F', 7393, 10893)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2394, 'vndpyt rpqivx' , '1969-12-31' , 'M', 7394, 10894)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2395, 'fkxhue xchusz' , '1969-12-31' , 'F', 7395, 10895)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2396, 'svnrzx unfvta' , '1969-12-31' , 'F', 7396, 10896)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2397, 'pvkcye snidbc' , '1969-12-31' , 'M', 7397, 10897)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2398, 'fuqmzo xsqouz' , '1969-12-31' , 'M', 7398, 10898)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2399, 'urkswx wnnaub' , '1969-12-31' , 'F', 7399, 10899)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2400, 'kxjwfm jwlqkm' , '1969-12-31' , 'F', 7400, 10900)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2401, 'ccjpvw vwpvim' , '1969-12-31' , 'F', 7401, 10901)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2402, 'fgvbow fhjwqb' , '1969-12-31' , 'F', 7402, 10902)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2403, 'yjhvqx kpwpqs' , '1969-12-31' , 'M', 7403, 10903)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2404, 'fvajhu rqnfys' , '1969-12-31' , 'F', 7404, 10904)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2405, 'flcbzv ixkfhr' , '1969-12-31' , 'F', 7405, 10905)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2406, 'iantmo gfgnqd' , '1969-12-31' , 'M', 7406, 10906)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2407, 'qfgqgt wdflfj' , '1969-12-31' , 'M', 7407, 10907)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2408, 'cqtowo zjzxdl' , '1969-12-31' , 'M', 7408, 10908)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2409, 'oipoey txqxpi' , '1969-12-31' , 'M', 7409, 10909)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2410, 'drfsfb hsmbga' , '1969-12-31' , 'F', 7410, 10910)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2411, 'vzzrps pffwej' , '1969-12-31' , 'M', 7411, 10911)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2412, 'htizvd nuuylh' , '1969-12-31' , 'F', 7412, 10912)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2413, 'nndcah pzkhwy' , '1969-12-31' , 'M', 7413, 10913)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2414, 'pgdvqy coyaoq' , '1969-12-31' , 'F', 7414, 10914)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2415, 'llfxde nohxwl' , '1969-12-31' , 'F', 7415, 10915)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2416, 'rmhmyv ssctwg' , '1969-12-31' , 'M', 7416, 10916)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2417, 'pqfzqh usgxwl' , '1969-12-31' , 'F', 7417, 10917)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2418, 'iddhbz qcfnhz' , '1969-12-31' , 'M', 7418, 10918)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2419, 'svwmgp mbnsin' , '1969-12-31' , 'M', 7419, 10919)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2420, 'tvhdos vfjdhf' , '1969-12-31' , 'M', 7420, 10920)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2421, 'sphkaf rmpgxm' , '1969-12-31' , 'F', 7421, 10921)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2422, 'qhrpvj pibfku' , '1969-12-31' , 'F', 7422, 10922)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2423, 'idhldh fhuutm' , '1969-12-31' , 'F', 7423, 10923)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2424, 'aaowbg lfifkr' , '1969-12-31' , 'F', 7424, 10924)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2425, 'guqzaf kuzbzl' , '1969-12-31' , 'M', 7425, 10925)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2426, 'cqaeln pgpnhb' , '1969-12-31' , 'F', 7426, 10926)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2427, 'uthwuo aaffpt' , '1969-12-31' , 'M', 7427, 10927)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2428, 'wpmewb ilpavm' , '1969-12-31' , 'M', 7428, 10928)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2429, 'gzropx gwxqit' , '1969-12-31' , 'M', 7429, 10929)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2430, 'jldrrv woizpf' , '1969-12-31' , 'F', 7430, 10930)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2431, 'ehexkf jarwdp' , '1969-12-31' , 'F', 7431, 10931)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2432, 'azwnym asocac' , '1969-12-31' , 'M', 7432, 10932)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2433, 'llqrpz dsnevr' , '1969-12-31' , 'F', 7433, 10933)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2434, 'ogthyu ekjhsc' , '1969-12-31' , 'M', 7434, 10934)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2435, 'rrofba oxohqk' , '1969-12-31' , 'F', 7435, 10935)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2436, 'pomomp pblkhu' , '1969-12-31' , 'M', 7436, 10936)
2012-05-24 17:25:57	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2437, 'cdtpof kfnepm' , '1969-12-31' , 'M', 7437, 10937)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2438, 'yjeyiw qeiekl' , '1969-12-31' , 'F', 7438, 10938)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2439, 'ieirrg hovqdu' , '1969-12-31' , 'M', 7439, 10939)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2440, 'vfpaod oodohj' , '1969-12-31' , 'F', 7440, 10940)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2441, 'omshla lmcgrh' , '1969-12-31' , 'M', 7441, 10941)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2442, 'hlwken remxer' , '1969-12-31' , 'F', 7442, 10942)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2443, 'qhviip remmwl' , '1969-12-31' , 'F', 7443, 10943)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2444, 'xvpzlr traflc' , '1969-12-31' , 'M', 7444, 10944)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2445, 'ivsmug arejtx' , '1969-12-31' , 'F', 7445, 10945)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2446, 'ysycrx kloram' , '1969-12-31' , 'F', 7446, 10946)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2447, 'dhqkny irfrcz' , '1969-12-31' , 'F', 7447, 10947)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2448, 'ntqygp hyaome' , '1969-12-31' , 'F', 7448, 10948)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2449, 'ispgyl jmysfe' , '1969-12-31' , 'F', 7449, 10949)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2450, 'omzavi yrfoyg' , '1969-12-31' , 'M', 7450, 10950)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2451, 'aiclyg jqlmev' , '1969-12-31' , 'M', 7451, 10951)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2452, 'vregsc abvvzl' , '1969-12-31' , 'M', 7452, 10952)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2453, 'vlkkvg uinlai' , '1969-12-31' , 'M', 7453, 10953)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2454, 'jfpmgq uufohw' , '1969-12-31' , 'F', 7454, 10954)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2455, 'qvzgcs htujrr' , '1969-12-31' , 'M', 7455, 10955)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2456, 'vzhowh wlyhih' , '1969-12-31' , 'M', 7456, 10956)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2457, 'ztwthm vrkzjf' , '1969-12-31' , 'F', 7457, 10957)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2458, 'nyxxpl gxctpm' , '1969-12-31' , 'F', 7458, 10958)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2459, 'jtebwb ehfjen' , '1969-12-31' , 'F', 7459, 10959)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2460, 'svzwkx spnjko' , '1969-12-31' , 'M', 7460, 10960)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2461, 'gvsgki mslede' , '1969-12-31' , 'M', 7461, 10961)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2462, 'vaucet wlmcmw' , '1969-12-31' , 'F', 7462, 10962)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2463, 'rdknul liotxz' , '1969-12-31' , 'M', 7463, 10963)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2464, 'mwxxab gpurql' , '1969-12-31' , 'M', 7464, 10964)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2465, 'rhednf vtayet' , '1969-12-31' , 'M', 7465, 10965)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2466, 'izynhm ijmjar' , '1969-12-31' , 'M', 7466, 10966)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2467, 'ajnwvm ohfrke' , '1969-12-31' , 'F', 7467, 10967)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2468, 'qoysku bdaawj' , '1969-12-31' , 'M', 7468, 10968)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2469, 'drbabd vythbr' , '1969-12-31' , 'M', 7469, 10969)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2470, 'pvlsls udgolf' , '1969-12-31' , 'M', 7470, 10970)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2471, 'ukbzgf mwgskz' , '1969-12-31' , 'F', 7471, 10971)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2472, 'hjoqss xbxxcq' , '1969-12-31' , 'F', 7472, 10972)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2473, 'gzoadh eghxma' , '1969-12-31' , 'F', 7473, 10973)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2474, 'ihqepl lxxiib' , '1969-12-31' , 'F', 7474, 10974)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2475, 'kswgqm fmyurq' , '1969-12-31' , 'M', 7475, 10975)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2476, 'alzyop ngptaq' , '1969-12-31' , 'M', 7476, 10976)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2477, 'dixxhx gsnnjr' , '1969-12-31' , 'F', 7477, 10977)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2478, 'bbvhpo hclbfu' , '1969-12-31' , 'F', 7478, 10978)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2479, 'oqyrju cymfoh' , '1969-12-31' , 'M', 7479, 10979)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2480, 'qmuhxs kxzjgr' , '1969-12-31' , 'F', 7480, 10980)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2481, 'hdlcta qdrzpp' , '1969-12-31' , 'M', 7481, 10981)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2482, 'nkmvre buvscr' , '1969-12-31' , 'F', 7482, 10982)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2483, 'phlqvv kinapm' , '1969-12-31' , 'M', 7483, 10983)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2484, 'wzqjjc nnwqcc' , '1969-12-31' , 'M', 7484, 10984)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2485, 'qqqlzl geqyko' , '1969-12-31' , 'F', 7485, 10985)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2486, 'sndcnc jbtzzo' , '1969-12-31' , 'M', 7486, 10986)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2487, 'gvunqe hlohft' , '1969-12-31' , 'F', 7487, 10987)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2488, 'grataj tovkjp' , '1969-12-31' , 'F', 7488, 10988)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2489, 'rgaint irxyki' , '1969-12-31' , 'F', 7489, 10989)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2490, 'wpbbps yiwicr' , '1969-12-31' , 'M', 7490, 10990)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2491, 'fkaxvd drialk' , '1969-12-31' , 'M', 7491, 10991)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2492, 'tnhmpl iuwgdb' , '1969-12-31' , 'M', 7492, 10992)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2493, 'yzybnr rrbscr' , '1969-12-31' , 'F', 7493, 10993)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2494, 'vtjptb bmiwrq' , '1969-12-31' , 'M', 7494, 10994)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2495, 'eiojrt psgbmz' , '1969-12-31' , 'F', 7495, 10995)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2496, 'qhuwcc wyokbo' , '1969-12-31' , 'F', 7496, 10996)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2497, 'aczhfi pdttol' , '1969-12-31' , 'M', 7497, 10997)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2498, 'cbmtqw bdjtrv' , '1969-12-31' , 'M', 7498, 10998)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2499, 'ehsxhk uhqcpz' , '1969-12-31' , 'M', 7499, 10999)
2012-05-24 17:25:58	INSERT INTO `patient` (`patient_id`,`name`,`dob`,`sex`,`addl_id`,`surr_id`)VALUES (2500, 'salhte lwjovb' , '1969-12-31' , 'M', 7500, 11000)
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 1, 583, 6, '2009-05-23', '2009-05-23', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			54,  
			1, 
			'', 
			'', 
			0, 
			0,
			'2009-05-23 10:37:12' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 2, 1056, 9, '2011-09-13', '2011-09-13', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			2, 
			'', 
			'', 
			0, 
			0,
			'2011-09-13 22:32:38' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 3, 1800, 9, '2009-09-15', '2009-09-15', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			3, 
			'', 
			'', 
			0, 
			0,
			'2009-09-15 09:01:42' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 4, 777, 11, '2009-03-14', '2009-03-14', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			102,  
			4, 
			'', 
			'', 
			0, 
			0,
			'2009-03-14 22:38:20' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 5, 1489, 22, '2009-10-03', '2009-10-03', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			5, 
			'', 
			'', 
			0, 
			0,
			'2009-10-03 18:17:50' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 6, 23, 11, '2009-03-09', '2009-03-09', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			61,  
			6, 
			'', 
			'', 
			0, 
			0,
			'2009-03-09 20:25:14' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 7, 361, 23, '2010-05-27', '2010-05-27', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			7, 
			'', 
			'', 
			0, 
			0,
			'2010-05-27 15:01:27' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 8, 2321, 6, '2010-08-19', '2010-08-19', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			40,  
			8, 
			'', 
			'', 
			0, 
			0,
			'2010-08-19 18:26:24' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 9, 277, 6, '2009-02-06', '2009-02-06', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			86,  
			9, 
			'', 
			'', 
			0, 
			0,
			'2009-02-06 00:40:07' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 10, 1104, 6, '2011-03-17', '2011-03-17', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			10, 
			'', 
			'', 
			0, 
			0,
			'2011-03-17 03:42:34' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 11, 1677, 18, '2010-01-05', '2010-01-05', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			11, 
			'', 
			'', 
			0, 
			0,
			'2010-01-05 21:33:47' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 12, 1216, 9, '2010-09-10', '2010-09-10', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			12, 
			'', 
			'', 
			0, 
			0,
			'2010-09-10 21:56:15' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 13, 1898, 21, '2011-11-22', '2011-11-22', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			13, 
			'', 
			'', 
			0, 
			0,
			'2011-11-22 08:14:46' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 14, 816, 10, '2010-03-05', '2010-03-05', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			14, 
			'', 
			'', 
			0, 
			0,
			'2010-03-05 05:53:48' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 15, 1247, 11, '2011-08-21', '2011-08-21', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			61,  
			15, 
			'', 
			'', 
			0, 
			0,
			'2011-08-21 13:43:47' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			91,  
			15, 
			'', 
			'', 
			0, 
			0,
			'2011-08-21 01:06:08' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 16, 1359, 18, '2010-10-26', '2010-10-26', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			16, 
			'', 
			'', 
			0, 
			0,
			'2010-10-26 03:01:05' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 17, 407, 22, '2011-10-26', '2011-10-26', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			17, 
			'', 
			'', 
			0, 
			0,
			'2011-10-26 14:42:46' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 18, 1761, 12, '2009-03-26', '2009-03-26', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			18, 
			'', 
			'', 
			0, 
			0,
			'2009-03-26 15:37:23' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 19, 1596, 7, '2010-10-11', '2010-10-11', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			59,  
			19, 
			'', 
			'', 
			0, 
			0,
			'2010-10-11 20:21:46' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 20, 1400, 9, '2009-06-28', '2009-06-28', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			20, 
			'', 
			'', 
			0, 
			0,
			'2009-06-28 21:55:38' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 21, 2154, 10, '2009-02-10', '2009-02-10', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			21, 
			'', 
			'', 
			0, 
			0,
			'2009-02-10 06:19:12' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 22, 707, 22, '2009-03-04', '2009-03-04', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			22, 
			'', 
			'', 
			0, 
			0,
			'2009-03-04 10:58:18' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 23, 2402, 24, '2009-12-22', '2009-12-22', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			23, 
			'', 
			'', 
			0, 
			0,
			'2009-12-22 15:40:02' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 24, 1095, 8, '2011-12-24', '2011-12-24', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			24, 
			'', 
			'', 
			0, 
			0,
			'2011-12-24 07:02:10' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 25, 3, 10, '2012-01-13', '2012-01-13', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			25, 
			'', 
			'', 
			0, 
			0,
			'2012-01-13 11:43:04' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 26, 1321, 8, '2010-03-27', '2010-03-27', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			26, 
			'', 
			'', 
			0, 
			0,
			'2010-03-27 13:35:11' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 27, 217, 23, '2010-03-10', '2010-03-10', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			27, 
			'', 
			'', 
			0, 
			0,
			'2010-03-10 21:03:25' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			27, 
			'', 
			'', 
			0, 
			0,
			'2010-03-10 16:18:58' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 28, 1846, 21, '2010-06-05', '2010-06-05', 61, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			28, 
			'', 
			'', 
			0, 
			0,
			'2010-06-05 09:57:07' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 29, 1811, 10, '2009-03-21', '2009-03-21', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			29, 
			'', 
			'', 
			0, 
			0,
			'2009-03-21 03:30:03' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 30, 891, 15, '2011-07-21', '2011-07-21', 60, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			30, 
			'', 
			'', 
			0, 
			0,
			'2011-07-21 00:48:49' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 31, 292, 8, '2009-07-28', '2009-07-28', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			70,  
			31, 
			'', 
			'', 
			0, 
			0,
			'2009-07-28 08:33:53' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 32, 2059, 24, '2010-01-29', '2010-01-29', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			32, 
			'', 
			'', 
			0, 
			0,
			'2010-01-29 12:50:53' )
2012-05-24 17:25:59	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 33, 526, 18, '2010-11-08', '2010-11-08', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:25:59	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			33, 
			'', 
			'', 
			0, 
			0,
			'2010-11-08 17:41:37' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 34, 48, 22, '2009-01-30', '2009-01-30', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			34, 
			'', 
			'', 
			0, 
			0,
			'2009-01-30 09:54:11' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 35, 1505, 24, '2011-10-25', '2011-10-25', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			35, 
			'', 
			'', 
			0, 
			0,
			'2011-10-25 08:38:12' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 36, 328, 8, '2011-03-04', '2011-03-04', 61, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			36, 
			'', 
			'', 
			0, 
			0,
			'2011-03-04 08:50:30' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 37, 381, 8, '2009-06-12', '2009-06-12', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			37, 
			'', 
			'', 
			0, 
			0,
			'2009-06-12 11:06:33' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 38, 1040, 6, '2012-01-12', '2012-01-12', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			98,  
			38, 
			'', 
			'', 
			0, 
			0,
			'2012-01-12 09:26:22' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 39, 1679, 8, '2011-12-28', '2011-12-28', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			39, 
			'', 
			'', 
			0, 
			0,
			'2011-12-28 21:49:55' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 40, 1673, 22, '2011-08-22', '2011-08-22', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			40, 
			'', 
			'', 
			0, 
			0,
			'2011-08-22 18:17:13' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 41, 278, 24, '2009-06-29', '2009-06-29', 61, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			41, 
			'', 
			'', 
			0, 
			0,
			'2009-06-29 18:29:39' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			41, 
			'', 
			'', 
			0, 
			0,
			'2009-06-29 04:42:34' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 42, 61, 15, '2010-06-19', '2010-06-19', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			42, 
			'', 
			'', 
			0, 
			0,
			'2010-06-19 08:37:03' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 43, 1007, 11, '2010-05-31', '2010-05-31', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			61,  
			43, 
			'', 
			'', 
			0, 
			0,
			'2010-05-31 02:01:19' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 44, 955, 10, '2011-07-14', '2011-07-14', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			44, 
			'', 
			'', 
			0, 
			0,
			'2011-07-14 13:52:32' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 45, 103, 9, '2009-01-11', '2009-01-11', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			45, 
			'', 
			'', 
			0, 
			0,
			'2009-01-11 07:30:00' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 46, 1332, 23, '2009-09-30', '2009-09-30', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			46, 
			'', 
			'', 
			0, 
			0,
			'2009-09-30 08:03:31' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 47, 2125, 24, '2010-05-05', '2010-05-05', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			47, 
			'', 
			'', 
			0, 
			0,
			'2010-05-05 23:42:33' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 48, 320, 10, '2010-02-21', '2010-02-21', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			48, 
			'', 
			'', 
			0, 
			0,
			'2010-02-21 13:40:19' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 49, 172, 6, '2009-05-12', '2009-05-12', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			108,  
			49, 
			'', 
			'', 
			0, 
			0,
			'2009-05-12 00:06:24' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 50, 1441, 8, '2010-10-01', '2010-10-01', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			50, 
			'', 
			'', 
			0, 
			0,
			'2010-10-01 02:59:01' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 51, 971, 12, '2009-09-14', '2009-09-14', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			51, 
			'', 
			'', 
			0, 
			0,
			'2009-09-14 09:25:24' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 52, 949, 15, '2009-10-15', '2009-10-15', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			52, 
			'', 
			'', 
			0, 
			0,
			'2009-10-15 12:48:01' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 53, 1871, 8, '2010-08-16', '2010-08-16', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			70,  
			53, 
			'', 
			'', 
			0, 
			0,
			'2010-08-16 04:22:26' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 54, 1367, 11, '2011-02-25', '2011-02-25', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			91,  
			54, 
			'', 
			'', 
			0, 
			0,
			'2011-02-25 23:25:22' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 55, 1157, 24, '2010-12-24', '2010-12-24', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			55, 
			'', 
			'', 
			0, 
			0,
			'2010-12-24 23:32:03' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 56, 614, 23, '2009-05-03', '2009-05-03', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			56, 
			'', 
			'', 
			0, 
			0,
			'2009-05-03 22:42:28' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 57, 1614, 10, '2011-08-15', '2011-08-15', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			57, 
			'', 
			'', 
			0, 
			0,
			'2011-08-15 14:56:39' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 58, 999, 9, '2010-04-10', '2010-04-10', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			58, 
			'', 
			'', 
			0, 
			0,
			'2010-04-10 14:31:49' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 59, 1301, 9, '2010-09-10', '2010-09-10', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			59, 
			'', 
			'', 
			0, 
			0,
			'2010-09-10 03:38:56' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 60, 2208, 10, '2011-07-23', '2011-07-23', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			60, 
			'', 
			'', 
			0, 
			0,
			'2011-07-23 01:10:42' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 61, 1212, 9, '2009-09-25', '2009-09-25', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			61, 
			'', 
			'', 
			0, 
			0,
			'2009-09-25 08:30:49' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 62, 1096, 18, '2009-12-25', '2009-12-25', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			62, 
			'', 
			'', 
			0, 
			0,
			'2009-12-25 23:37:37' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 63, 2332, 23, '2011-11-02', '2011-11-02', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			63, 
			'', 
			'', 
			0, 
			0,
			'2011-11-02 15:22:56' )
2012-05-24 17:26:00	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 64, 2253, 7, '2010-11-20', '2010-11-20', 60, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:00	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			93,  
			64, 
			'', 
			'', 
			0, 
			0,
			'2010-11-20 04:34:18' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			58,  
			64, 
			'', 
			'', 
			0, 
			0,
			'2010-11-20 17:28:03' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 65, 1597, 18, '2009-12-22', '2009-12-22', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			65, 
			'', 
			'', 
			0, 
			0,
			'2009-12-22 01:34:15' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 66, 1438, 11, '2011-04-08', '2011-04-08', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			101,  
			66, 
			'', 
			'', 
			0, 
			0,
			'2011-04-08 23:58:35' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 67, 300, 9, '2009-09-16', '2009-09-16', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			67, 
			'', 
			'', 
			0, 
			0,
			'2009-09-16 20:03:23' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 68, 1224, 22, '2011-01-10', '2011-01-10', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			68, 
			'', 
			'', 
			0, 
			0,
			'2011-01-10 18:20:31' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 69, 1410, 6, '2010-07-02', '2010-07-02', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			51,  
			69, 
			'', 
			'', 
			0, 
			0,
			'2010-07-02 09:57:23' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			69, 
			'', 
			'', 
			0, 
			0,
			'2010-07-02 14:06:36' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			86,  
			69, 
			'', 
			'', 
			0, 
			0,
			'2010-07-02 04:39:18' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 70, 654, 23, '2010-11-24', '2010-11-24', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			70, 
			'', 
			'', 
			0, 
			0,
			'2010-11-24 08:42:14' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			70, 
			'', 
			'', 
			0, 
			0,
			'2010-11-24 13:55:05' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 71, 1545, 24, '2011-04-16', '2011-04-16', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			71, 
			'', 
			'', 
			0, 
			0,
			'2011-04-16 22:20:14' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 72, 197, 22, '2009-04-04', '2009-04-04', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			72, 
			'', 
			'', 
			0, 
			0,
			'2009-04-04 13:35:21' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 73, 2232, 24, '2010-01-23', '2010-01-23', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			73, 
			'', 
			'', 
			0, 
			0,
			'2010-01-23 17:07:50' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			73, 
			'', 
			'', 
			0, 
			0,
			'2010-01-23 02:22:01' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			73, 
			'', 
			'', 
			0, 
			0,
			'2010-01-23 03:56:12' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 74, 42, 12, '2010-12-03', '2010-12-03', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			74, 
			'', 
			'', 
			0, 
			0,
			'2010-12-03 22:40:48' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 75, 909, 11, '2009-08-14', '2009-08-14', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			90,  
			75, 
			'', 
			'', 
			0, 
			0,
			'2009-08-14 00:20:04' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 76, 232, 23, '2009-12-19', '2009-12-19', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			76, 
			'', 
			'', 
			0, 
			0,
			'2009-12-19 06:11:17' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 77, 1176, 6, '2009-04-29', '2009-04-29', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			108,  
			77, 
			'', 
			'', 
			0, 
			0,
			'2009-04-29 20:51:15' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 78, 616, 6, '2010-01-05', '2010-01-05', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			39,  
			78, 
			'', 
			'', 
			0, 
			0,
			'2010-01-05 14:19:57' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 79, 428, 12, '2011-04-03', '2011-04-03', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			79, 
			'', 
			'', 
			0, 
			0,
			'2011-04-03 04:37:25' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 80, 438, 9, '2012-01-25', '2012-01-25', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			80, 
			'', 
			'', 
			0, 
			0,
			'2012-01-25 07:44:24' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 81, 351, 9, '2010-02-01', '2010-02-01', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			81, 
			'', 
			'', 
			0, 
			0,
			'2010-02-01 01:45:36' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 82, 1734, 24, '2010-01-19', '2010-01-19', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			82, 
			'', 
			'', 
			0, 
			0,
			'2010-01-19 08:02:46' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 83, 639, 10, '2011-04-26', '2011-04-26', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			83, 
			'', 
			'', 
			0, 
			0,
			'2011-04-26 08:29:09' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 84, 1789, 18, '2011-09-10', '2011-09-10', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			84, 
			'', 
			'', 
			0, 
			0,
			'2011-09-10 08:06:46' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 85, 1070, 22, '2010-11-21', '2010-11-21', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			85, 
			'', 
			'', 
			0, 
			0,
			'2010-11-21 04:56:11' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 86, 152, 23, '2012-01-05', '2012-01-05', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			86, 
			'', 
			'', 
			0, 
			0,
			'2012-01-05 06:29:29' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 87, 290, 6, '2010-12-25', '2010-12-25', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			54,  
			87, 
			'', 
			'', 
			0, 
			0,
			'2010-12-25 13:14:08' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 88, 1894, 9, '2009-07-17', '2009-07-17', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			88, 
			'', 
			'', 
			0, 
			0,
			'2009-07-17 21:17:32' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 89, 463, 23, '2011-04-08', '2011-04-08', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			89, 
			'', 
			'', 
			0, 
			0,
			'2011-04-08 22:27:27' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 90, 1585, 6, '2011-06-18', '2011-06-18', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			86,  
			90, 
			'', 
			'', 
			0, 
			0,
			'2011-06-18 10:48:11' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 91, 1282, 11, '2011-02-24', '2011-02-24', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			101,  
			91, 
			'', 
			'', 
			0, 
			0,
			'2011-02-24 17:42:41' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 92, 1428, 22, '2009-07-25', '2009-07-25', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			92, 
			'', 
			'', 
			0, 
			0,
			'2009-07-25 13:10:55' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 93, 2371, 18, '2010-09-22', '2010-09-22', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			93, 
			'', 
			'', 
			0, 
			0,
			'2010-09-22 02:20:40' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 94, 2183, 12, '2011-03-01', '2011-03-01', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			94, 
			'', 
			'', 
			0, 
			0,
			'2011-03-01 21:50:37' )
2012-05-24 17:26:01	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 95, 1732, 7, '2011-02-26', '2011-02-26', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:01	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			58,  
			95, 
			'', 
			'', 
			0, 
			0,
			'2011-02-26 07:46:39' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			68,  
			95, 
			'', 
			'', 
			0, 
			0,
			'2011-02-26 14:58:09' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			20,  
			95, 
			'', 
			'', 
			0, 
			0,
			'2011-02-26 12:24:28' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 96, 72, 11, '2010-09-02', '2010-09-02', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			90,  
			96, 
			'', 
			'', 
			0, 
			0,
			'2010-09-02 01:51:18' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 97, 1769, 21, '2009-05-15', '2009-05-15', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			97, 
			'', 
			'', 
			0, 
			0,
			'2009-05-15 03:06:53' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 98, 1023, 8, '2009-10-11', '2009-10-11', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			70,  
			98, 
			'', 
			'', 
			0, 
			0,
			'2009-10-11 10:11:14' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			98, 
			'', 
			'', 
			0, 
			0,
			'2009-10-11 23:37:08' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 99, 33, 11, '2011-03-12', '2011-03-12', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			61,  
			99, 
			'', 
			'', 
			0, 
			0,
			'2011-03-12 12:09:16' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 100, 1900, 8, '2011-04-14', '2011-04-14', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			100, 
			'', 
			'', 
			0, 
			0,
			'2011-04-14 22:22:02' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 101, 544, 12, '2009-10-22', '2009-10-22', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			101, 
			'', 
			'', 
			0, 
			0,
			'2009-10-22 00:53:34' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 102, 823, 9, '2009-06-03', '2009-06-03', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			102, 
			'', 
			'', 
			0, 
			0,
			'2009-06-03 09:42:37' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 103, 1301, 18, '2010-07-01', '2010-07-01', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			103, 
			'', 
			'', 
			0, 
			0,
			'2010-07-01 18:44:09' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 104, 1600, 21, '2009-05-07', '2009-05-07', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			104, 
			'', 
			'', 
			0, 
			0,
			'2009-05-07 08:33:06' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 105, 1663, 7, '2012-01-08', '2012-01-08', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			24,  
			105, 
			'', 
			'', 
			0, 
			0,
			'2012-01-08 03:47:17' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 106, 144, 12, '2011-09-05', '2011-09-05', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			106, 
			'', 
			'', 
			0, 
			0,
			'2011-09-05 10:05:12' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 107, 1929, 7, '2010-10-01', '2010-10-01', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			94,  
			107, 
			'', 
			'', 
			0, 
			0,
			'2010-10-01 03:44:36' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 108, 1579, 24, '2011-11-29', '2011-11-29', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			108, 
			'', 
			'', 
			0, 
			0,
			'2011-11-29 02:03:00' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 109, 2069, 22, '2011-11-22', '2011-11-22', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			109, 
			'', 
			'', 
			0, 
			0,
			'2011-11-22 19:40:09' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 110, 870, 24, '2009-05-04', '2009-05-04', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			110, 
			'', 
			'', 
			0, 
			0,
			'2009-05-04 15:50:32' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			110, 
			'', 
			'', 
			0, 
			0,
			'2009-05-04 20:25:45' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 111, 2292, 22, '2011-03-02', '2011-03-02', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			111, 
			'', 
			'', 
			0, 
			0,
			'2011-03-02 13:03:51' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 112, 306, 24, '2011-02-24', '2011-02-24', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			112, 
			'', 
			'', 
			0, 
			0,
			'2011-02-24 16:11:32' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 113, 213, 24, '2011-04-25', '2011-04-25', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			113, 
			'', 
			'', 
			0, 
			0,
			'2011-04-25 03:55:43' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 114, 1038, 10, '2011-07-21', '2011-07-21', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			114, 
			'', 
			'', 
			0, 
			0,
			'2011-07-21 02:43:39' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 115, 146, 12, '2011-08-29', '2011-08-29', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			115, 
			'', 
			'', 
			0, 
			0,
			'2011-08-29 02:56:47' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 116, 2194, 15, '2010-11-14', '2010-11-14', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			116, 
			'', 
			'', 
			0, 
			0,
			'2010-11-14 01:13:44' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 117, 2454, 10, '2009-07-20', '2009-07-20', 60, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			117, 
			'', 
			'', 
			0, 
			0,
			'2009-07-20 02:34:43' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 118, 1348, 8, '2009-11-30', '2009-11-30', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			70,  
			118, 
			'', 
			'', 
			0, 
			0,
			'2009-11-30 11:00:56' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 119, 444, 12, '2009-01-12', '2009-01-12', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			119, 
			'', 
			'', 
			0, 
			0,
			'2009-01-12 06:20:44' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 120, 69, 9, '2011-06-29', '2011-06-29', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			120, 
			'', 
			'', 
			0, 
			0,
			'2011-06-29 03:47:14' )
2012-05-24 17:26:02	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 121, 1261, 22, '2010-07-10', '2010-07-10', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:02	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			121, 
			'', 
			'', 
			0, 
			0,
			'2010-07-10 15:10:59' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 122, 55, 7, '2010-03-21', '2010-03-21', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			92,  
			122, 
			'', 
			'', 
			0, 
			0,
			'2010-03-21 01:05:57' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 123, 716, 18, '2011-08-04', '2011-08-04', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			123, 
			'', 
			'', 
			0, 
			0,
			'2011-08-04 03:40:17' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 124, 1642, 22, '2009-12-31', '2009-12-31', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			124, 
			'', 
			'', 
			0, 
			0,
			'2009-12-31 03:43:46' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 125, 202, 15, '2011-10-20', '2011-10-20', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			125, 
			'', 
			'', 
			0, 
			0,
			'2011-10-20 09:27:22' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 126, 128, 11, '2011-01-04', '2011-01-04', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			61,  
			126, 
			'', 
			'', 
			0, 
			0,
			'2011-01-04 17:16:40' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 127, 1173, 8, '2009-12-14', '2009-12-14', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			70,  
			127, 
			'', 
			'', 
			0, 
			0,
			'2009-12-14 13:52:24' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 128, 791, 7, '2011-06-22', '2011-06-22', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			57,  
			128, 
			'', 
			'', 
			0, 
			0,
			'2011-06-22 05:01:54' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 129, 859, 10, '2011-09-19', '2011-09-19', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			129, 
			'', 
			'', 
			0, 
			0,
			'2011-09-19 08:45:08' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 130, 151, 23, '2009-12-04', '2009-12-04', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			130, 
			'', 
			'', 
			0, 
			0,
			'2009-12-04 10:11:45' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 131, 1642, 11, '2011-11-21', '2011-11-21', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			90,  
			131, 
			'', 
			'', 
			0, 
			0,
			'2011-11-21 15:06:43' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 132, 1630, 21, '2009-01-04', '2009-01-04', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			132, 
			'', 
			'', 
			0, 
			0,
			'2009-01-04 22:50:26' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 133, 1988, 21, '2009-10-07', '2009-10-07', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			133, 
			'', 
			'', 
			0, 
			0,
			'2009-10-07 03:22:53' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 134, 2092, 6, '2010-04-23', '2010-04-23', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			38,  
			134, 
			'', 
			'', 
			0, 
			0,
			'2010-04-23 22:44:06' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 135, 1318, 22, '2009-11-11', '2009-11-11', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			135, 
			'', 
			'', 
			0, 
			0,
			'2009-11-11 02:54:04' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 136, 825, 23, '2010-11-25', '2010-11-25', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			136, 
			'', 
			'', 
			0, 
			0,
			'2010-11-25 20:07:37' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			136, 
			'', 
			'', 
			0, 
			0,
			'2010-11-25 08:27:15' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 137, 73, 23, '2010-11-13', '2010-11-13', 61, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			137, 
			'', 
			'', 
			0, 
			0,
			'2010-11-13 10:46:05' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 138, 1058, 24, '2011-03-08', '2011-03-08', 60, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			138, 
			'', 
			'', 
			0, 
			0,
			'2011-03-08 01:33:04' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			138, 
			'', 
			'', 
			0, 
			0,
			'2011-03-08 19:45:20' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 139, 1761, 12, '2010-03-25', '2010-03-25', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			139, 
			'', 
			'', 
			0, 
			0,
			'2010-03-25 19:19:40' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 140, 1867, 23, '2009-05-12', '2009-05-12', 60, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			140, 
			'', 
			'', 
			0, 
			0,
			'2009-05-12 10:00:38' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 141, 2184, 12, '2009-03-01', '2009-03-01', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			141, 
			'', 
			'', 
			0, 
			0,
			'2009-03-01 14:26:04' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 142, 1190, 18, '2010-11-26', '2010-11-26', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			142, 
			'', 
			'', 
			0, 
			0,
			'2010-11-26 04:28:54' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 143, 1475, 9, '2010-07-26', '2010-07-26', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			143, 
			'', 
			'', 
			0, 
			0,
			'2010-07-26 11:54:17' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 144, 1671, 8, '2009-12-18', '2009-12-18', 61, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			144, 
			'', 
			'', 
			0, 
			0,
			'2009-12-18 22:57:27' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 145, 233, 6, '2009-08-30', '2009-08-30', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			7,  
			145, 
			'', 
			'', 
			0, 
			0,
			'2009-08-30 01:14:55' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 146, 1040, 22, '2009-02-22', '2009-02-22', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			146, 
			'', 
			'', 
			0, 
			0,
			'2009-02-22 18:21:08' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 147, 1155, 8, '2010-03-13', '2010-03-13', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			147, 
			'', 
			'', 
			0, 
			0,
			'2010-03-13 11:52:58' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 148, 954, 23, '2011-05-03', '2011-05-03', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			148, 
			'', 
			'', 
			0, 
			0,
			'2011-05-03 04:57:46' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 149, 734, 22, '2009-11-07', '2009-11-07', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			149, 
			'', 
			'', 
			0, 
			0,
			'2009-11-07 12:06:19' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 150, 1675, 10, '2011-12-03', '2011-12-03', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			150, 
			'', 
			'', 
			0, 
			0,
			'2011-12-03 16:05:10' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 151, 72, 22, '2009-10-12', '2009-10-12', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			151, 
			'', 
			'', 
			0, 
			0,
			'2009-10-12 18:10:38' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 152, 513, 22, '2010-07-23', '2010-07-23', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			152, 
			'', 
			'', 
			0, 
			0,
			'2010-07-23 11:34:12' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 153, 4, 9, '2010-03-26', '2010-03-26', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			153, 
			'', 
			'', 
			0, 
			0,
			'2010-03-26 13:13:18' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 154, 1386, 23, '2009-02-08', '2009-02-08', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			154, 
			'', 
			'', 
			0, 
			0,
			'2009-02-08 02:55:02' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 155, 79, 8, '2011-02-10', '2011-02-10', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			155, 
			'', 
			'', 
			0, 
			0,
			'2011-02-10 18:17:10' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 156, 1487, 10, '2011-03-02', '2011-03-02', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			156, 
			'', 
			'', 
			0, 
			0,
			'2011-03-02 22:58:04' )
2012-05-24 17:26:03	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 157, 1243, 7, '2012-01-25', '2012-01-25', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:03	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			35,  
			157, 
			'', 
			'', 
			0, 
			0,
			'2012-01-25 21:50:11' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 158, 139, 21, '2012-01-08', '2012-01-08', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			158, 
			'', 
			'', 
			0, 
			0,
			'2012-01-08 05:18:25' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 159, 1359, 15, '2009-12-04', '2009-12-04', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			159, 
			'', 
			'', 
			0, 
			0,
			'2009-12-04 19:20:25' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 160, 1557, 24, '2011-03-12', '2011-03-12', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			160, 
			'', 
			'', 
			0, 
			0,
			'2011-03-12 10:38:07' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 161, 685, 15, '2009-12-14', '2009-12-14', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			161, 
			'', 
			'', 
			0, 
			0,
			'2009-12-14 13:06:50' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 162, 1566, 8, '2009-03-24', '2009-03-24', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			162, 
			'', 
			'', 
			0, 
			0,
			'2009-03-24 18:41:29' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 163, 1717, 10, '2011-05-19', '2011-05-19', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			163, 
			'', 
			'', 
			0, 
			0,
			'2011-05-19 22:38:47' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 164, 1748, 23, '2009-09-27', '2009-09-27', 61, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			164, 
			'', 
			'', 
			0, 
			0,
			'2009-09-27 04:17:28' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			164, 
			'', 
			'', 
			0, 
			0,
			'2009-09-27 01:56:37' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 165, 2157, 7, '2012-01-26', '2012-01-26', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			92,  
			165, 
			'', 
			'', 
			0, 
			0,
			'2012-01-26 03:09:11' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 166, 1890, 22, '2012-01-21', '2012-01-21', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			166, 
			'', 
			'', 
			0, 
			0,
			'2012-01-21 01:41:38' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 167, 875, 18, '2010-09-09', '2010-09-09', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			167, 
			'', 
			'', 
			0, 
			0,
			'2010-09-09 23:05:30' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 168, 661, 8, '2010-02-22', '2010-02-22', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			70,  
			168, 
			'', 
			'', 
			0, 
			0,
			'2010-02-22 12:31:04' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 169, 1708, 6, '2010-12-16', '2010-12-16', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			110,  
			169, 
			'', 
			'', 
			0, 
			0,
			'2010-12-16 13:21:20' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 170, 782, 8, '2011-09-30', '2011-09-30', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			170, 
			'', 
			'', 
			0, 
			0,
			'2011-09-30 18:30:21' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 171, 2258, 24, '2011-09-27', '2011-09-27', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			171, 
			'', 
			'', 
			0, 
			0,
			'2011-09-27 21:58:08' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			171, 
			'', 
			'', 
			0, 
			0,
			'2011-09-27 03:36:49' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 172, 1849, 18, '2009-11-27', '2009-11-27', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			172, 
			'', 
			'', 
			0, 
			0,
			'2009-11-27 12:57:34' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 173, 414, 10, '2012-01-24', '2012-01-24', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			173, 
			'', 
			'', 
			0, 
			0,
			'2012-01-24 22:13:52' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 174, 2086, 24, '2009-10-05', '2009-10-05', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			99,  
			174, 
			'', 
			'', 
			0, 
			0,
			'2009-10-05 10:16:38' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 175, 753, 23, '2009-09-11', '2009-09-11', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			175, 
			'', 
			'', 
			0, 
			0,
			'2009-09-11 02:58:56' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 176, 650, 12, '2011-08-19', '2011-08-19', 61, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			176, 
			'', 
			'', 
			0, 
			0,
			'2011-08-19 21:45:00' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 177, 1566, 15, '2010-06-03', '2010-06-03', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			177, 
			'', 
			'', 
			0, 
			0,
			'2010-06-03 07:18:31' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 178, 1091, 10, '2011-11-29', '2011-11-29', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			60,  
			178, 
			'', 
			'', 
			0, 
			0,
			'2011-11-29 01:17:25' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 179, 922, 24, '2010-10-21', '2010-10-21', 61, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			179, 
			'', 
			'', 
			0, 
			0,
			'2010-10-21 14:08:11' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 180, 2306, 9, '2010-08-29', '2010-08-29', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			180, 
			'', 
			'', 
			0, 
			0,
			'2010-08-29 00:23:46' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 181, 686, 23, '2010-07-16', '2010-07-16', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			84,  
			181, 
			'', 
			'', 
			0, 
			0,
			'2010-07-16 15:51:09' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 182, 554, 15, '2011-08-15', '2011-08-15', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			182, 
			'', 
			'', 
			0, 
			0,
			'2011-08-15 07:42:49' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 183, 1008, 15, '2009-02-09', '2009-02-09', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			183, 
			'', 
			'', 
			0, 
			0,
			'2009-02-09 17:22:41' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 184, 407, 9, '2011-06-05', '2011-06-05', 61, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			184, 
			'', 
			'', 
			0, 
			0,
			'2011-06-05 20:53:13' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 185, 546, 11, '2010-12-25', '2010-12-25', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			61,  
			185, 
			'', 
			'', 
			0, 
			0,
			'2010-12-25 06:22:11' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 186, 1080, 22, '2010-09-15', '2010-09-15', 60, 0, 0, '', '', '', '', 1, 'Jones', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			106,  
			186, 
			'', 
			'', 
			0, 
			0,
			'2010-09-15 04:20:54' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 187, 2294, 7, '2011-06-14', '2011-06-14', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			96,  
			187, 
			'', 
			'', 
			0, 
			0,
			'2011-06-14 10:51:47' )
2012-05-24 17:26:04	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 188, 1976, 7, '2009-03-03', '2009-03-03', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:04	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			28,  
			188, 
			'', 
			'', 
			0, 
			0,
			'2009-03-03 16:19:06' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			66,  
			188, 
			'', 
			'', 
			0, 
			0,
			'2009-03-03 03:05:55' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			27,  
			188, 
			'', 
			'', 
			0, 
			0,
			'2009-03-03 23:07:21' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 189, 186, 24, '2011-08-20', '2011-08-20', 60, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			100,  
			189, 
			'', 
			'', 
			0, 
			0,
			'2011-08-20 06:29:58' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			189, 
			'', 
			'', 
			0, 
			0,
			'2011-08-20 00:23:14' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 190, 1817, 15, '2011-06-17', '2011-06-17', 60, 0, 0, '', '', '', '', 1, 'Sweeney', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			190, 
			'', 
			'', 
			0, 
			0,
			'2011-06-17 18:25:42' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 191, 1759, 12, '2009-04-02', '2009-04-02', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			71,  
			191, 
			'', 
			'', 
			0, 
			0,
			'2009-04-02 22:45:49' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 192, 1330, 21, '2010-08-28', '2010-08-28', 61, 0, 0, '', '', '', '', 1, 'Buck', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			89,  
			192, 
			'', 
			'', 
			0, 
			0,
			'2010-08-28 22:52:37' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 193, 33, 9, '2010-11-22', '2010-11-22', 60, 0, 0, '', '', '', '', 1, 'Guzman', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			193, 
			'', 
			'', 
			0, 
			0,
			'2010-11-22 07:12:54' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 194, 925, 15, '2011-03-06', '2011-03-06', 61, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			65,  
			194, 
			'', 
			'', 
			0, 
			0,
			'2011-03-06 00:49:18' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 195, 92, 9, '2010-03-19', '2010-03-19', 61, 0, 0, '', '', '', '', 1, 'Myers', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			195, 
			'', 
			'', 
			0, 
			0,
			'2010-03-19 11:47:33' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 196, 1961, 6, '2011-12-23', '2011-12-23', 60, 0, 0, '', '', '', '', 1, 'Knight', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			108,  
			196, 
			'', 
			'', 
			0, 
			0,
			'2011-12-23 17:20:05' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 197, 1223, 6, '2011-10-30', '2011-10-30', 60, 0, 0, '', '', '', '', 1, 'Fox', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			40,  
			197, 
			'', 
			'', 
			0, 
			0,
			'2011-10-30 13:08:01' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			52,  
			197, 
			'', 
			'', 
			0, 
			0,
			'2011-10-30 23:41:29' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 198, 1458, 18, '2011-09-13', '2011-09-13', 61, 0, 0, '', '', '', '', 1, 'Hood', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			41,  
			198, 
			'', 
			'', 
			0, 
			0,
			'2011-09-13 17:35:31' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 199, 82, 23, '2010-10-16', '2010-10-16', 60, 0, 0, '', '', '', '', 1, 'Harrel', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			9,  
			199, 
			'', 
			'', 
			0, 
			0,
			'2010-10-16 06:12:23' )
2012-05-24 17:26:05	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 200, 1449, 9, '2009-11-20', '2009-11-20', 60, 0, 0, '', '', '', '', 1, 'Dillards', '', '' )
2012-05-24 17:26:05	INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id,
			ts ) 
		VALUES (
			69,  
			200, 
			'', 
			'', 
			0, 
			0,
			'2009-11-20 10:46:15' )
2012-05-24 17:26:05	
2012-05-24 17:26:05	UPDATE `test` SET result='Bloody,++++,Non offensive,Inflammed,2933165c80b9fe9f24aae9edc9debe5a2bb9bc28', comments='', user_id=61, ts='2009-01-05 06:00:00' WHERE test_id=145 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=145
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=132
2012-05-24 17:26:05	UPDATE specimen SET date_reported='2012-05-24 17:26:05' WHERE specimen_id=132
2012-05-24 17:26:05	UPDATE `test` SET result='AAFB not seen,429dcc8637c8837a70682ad55d188a9aa74469df', comments='', user_id=60, ts='2009-01-12 02:00:00' WHERE test_id=48 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=48
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=45
2012-05-24 17:26:05	UPDATE specimen SET date_reported='2012-05-24 17:26:05' WHERE specimen_id=45
2012-05-24 17:26:05	UPDATE `test` SET result='Mucoid,Green,Absent,Offensive,Present,Moderate,Satisfactory,Absent,Moderate,Moderate,Moderate,Protozoa|ova seen,3f32cba1f6833c849bd02f18ad126cf0da689501', comments='', user_id=60, ts='2009-01-13 12:00:00' WHERE test_id=132 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=132
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=119
2012-05-24 17:26:05	UPDATE specimen SET date_reported='2012-05-24 17:26:05' WHERE specimen_id=119
2012-05-24 17:26:05	UPDATE `test` SET result='Negative,d5b41fc82d45dcf1abe2c3e64c5a89e9f8da13f0', comments='', user_id=61, ts='2009-01-31 12:00:00' WHERE test_id=36 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=36
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=34
2012-05-24 17:26:05	UPDATE specimen SET date_reported='2012-05-24 17:26:05' WHERE specimen_id=34
2012-05-24 17:26:05	UPDATE `test` SET result='0,0,0,0,0012e411aee016b921e159283497dccb1242553f', comments='', user_id=61, ts='2009-02-07 05:00:00' WHERE test_id=9 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=9
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=9
2012-05-24 17:26:05	UPDATE specimen SET date_reported='2012-05-24 17:26:05' WHERE specimen_id=9
2012-05-24 17:26:05	UPDATE `test` SET result='0,17218efb51178a386875d2569d8ac5cf1d8a1f55', comments='', user_id=60, ts='2009-02-09 04:00:00' WHERE test_id=169 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=169
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=154
2012-05-24 17:26:05	UPDATE specimen SET date_reported='2012-05-24 17:26:05' WHERE specimen_id=154
2012-05-24 17:26:05	UPDATE `test` SET result='326,17d1ea5a5df92a9b835ecb460cf34f75bd16e50a', comments='', user_id=61, ts='2009-02-10 03:00:00' WHERE test_id=200 
2012-05-24 17:26:05	UPDATE test SET verified_by=2 WHERE test_id=200
2012-05-24 17:26:05	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=183
2012-05-24 17:26:05	UPDATE `test` SET result='Colourless,,,Many,Absent,Many,0,Neutrophils,Negative,0,0,0,504bc8024d5d65f21eb060bfd0e620db2fbd038c', comments='', user_id=60, ts='2009-02-11 02:00:00' WHERE test_id=22 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=22
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=21
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=21
2012-05-24 17:26:06	UPDATE `test` SET result='Positive,a98cbdd1e715b965496240474eb44f1468fd94ff', comments='', user_id=60, ts='2009-02-23 03:00:00' WHERE test_id=161 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=161
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=146
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=146
2012-05-24 17:26:06	UPDATE `test` SET result='Watery,Brown,Present,Offensive,Present,Moderate,Satisfactory,Absent,Absent,Many,Many,No ova or protozoa seen,dc820fd93cd85537f3234d7245ccf437b487bdf5', comments='', user_id=60, ts='2009-03-02 04:00:00' WHERE test_id=156 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=156
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=141
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=141
2012-05-24 17:26:06	UPDATE `test` SET result='0,227d7c65869ee9c78eb6a0e96ba60c26e1ef09ca', comments='', user_id=60, ts='2009-03-04 01:00:00' WHERE test_id=205 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=205
2012-05-24 17:26:06	UPDATE `test` SET result='Negative,227d7c65869ee9c78eb6a0e96ba60c26e1ef09ca', comments='', user_id=60, ts='2009-03-04 01:00:00' WHERE test_id=206 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=206
2012-05-24 17:26:06	UPDATE `test` SET result='0,227d7c65869ee9c78eb6a0e96ba60c26e1ef09ca', comments='', user_id=60, ts='2009-03-04 01:00:00' WHERE test_id=207 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=207
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=188
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=188
2012-05-24 17:26:06	UPDATE `test` SET result='Positive,1ebcdcffd807e03e773d97a568def9786a43efc6', comments='', user_id=60, ts='2009-03-05 05:00:00' WHERE test_id=23 
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=22
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=22
2012-05-24 17:26:06	UPDATE `test` SET result='Positive,34987e2e3d899846902c3238a93a742ac5c34eaf', comments='', user_id=60, ts='2009-03-10 06:00:00' WHERE test_id=6 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=6
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=6
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=6
2012-05-24 17:26:06	UPDATE `test` SET result='Deep Yellow,Clear,Negative,2,+++,Negative,50,15,+++ca 300,5.5,Positive,Ca 70,1.005,Other,94997e9cb843c382acd7fe3ffa715fd636bcd9b2', comments='', user_id=61, ts='2009-03-15 11:00:00' WHERE test_id=4 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=4
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=4
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=4
2012-05-24 17:26:06	UPDATE `test` SET result='Bloody,,,Moderate,Rare,Many,0,Basophils,Positive,0,0,0,3218302c38d477240cf10e6a4b133b3ab38d60ae', comments='', user_id=60, ts='2009-03-22 09:00:00' WHERE test_id=31 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=31
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=29
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=29
2012-05-24 17:26:06	UPDATE `test` SET result='N,bf7c8b9d5a9cc5bd56768b7060d31b2ae674f96a', comments='', user_id=61, ts='2009-03-25 08:00:00' WHERE test_id=177 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=177
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=162
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=162
2012-05-24 17:26:06	UPDATE `test` SET result='Mucoid,Brown,Absent,Foul,Not present,Absent,Satisfactory,Few,Moderate,Moderate,Many,Protozoa|ova seen,6e22820b96be7852bdb4a341509509cf71373729', comments='', user_id=60, ts='2009-03-27 11:00:00' WHERE test_id=19 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=19
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=18
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=18
2012-05-24 17:26:06	UPDATE `test` SET result='Mucoid,Brown,Present,Offensive,Present,Few,Satisfactory,Few,Few,Few,Many,No ova or protozoa seen,0cf5d5df3673bb909c855874032dd5bac6b89f03', comments='', user_id=61, ts='2009-04-03 07:00:00' WHERE test_id=211 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=211
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=191
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=191
2012-05-24 17:26:06	UPDATE `test` SET result='Negative,966b15485ac99e49f2372a8212f7413b83906153', comments='', user_id=60, ts='2009-04-05 09:00:00' WHERE test_id=79 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=79
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=72
2012-05-24 17:26:06	UPDATE specimen SET date_reported='2012-05-24 17:26:06' WHERE specimen_id=72
2012-05-24 17:26:06	UPDATE `test` SET result='0,a757d2783d09b34f619d3f6a9f2624056f082305', comments='', user_id=61, ts='2009-04-30 10:00:00' WHERE test_id=86 
2012-05-24 17:26:06	UPDATE test SET verified_by=2 WHERE test_id=86
2012-05-24 17:26:06	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=77
2012-05-24 17:26:07	UPDATE `test` SET result='0,e2aa25b8435cbee59a34eb5051d2e5b541e2edba', comments='', user_id=60, ts='2009-05-04 02:00:00' WHERE test_id=59 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=59
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=56
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=56
2012-05-24 17:26:07	UPDATE `test` SET result='YES,84982bca54e33ea9a63482ff9b27c878842c292e', comments='', user_id=60, ts='2009-05-05 07:00:00' WHERE test_id=122 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=122
2012-05-24 17:26:07	UPDATE `test` SET result='Trichomonas vaginalis Absent,Many,Moderate,Rare,Rare,Many,Many,Rare,Few,Moderate,Many,Type III,84982bca54e33ea9a63482ff9b27c878842c292e', comments='', user_id=61, ts='2009-05-05 07:00:00' WHERE test_id=123 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=123
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=110
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=110
2012-05-24 17:26:07	UPDATE `test` SET result='NO,bee7db88e803b8d003d21054fa6e7a49eb61d6e1', comments='', user_id=60, ts='2009-05-08 01:00:00' WHERE test_id=116 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=116
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=104
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=104
2012-05-24 17:26:07	UPDATE `test` SET result='0,ffda083e9b4c24e9a5f490dca1b10f62529ec9c5', comments='', user_id=60, ts='2009-05-13 03:00:00' WHERE test_id=52 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=52
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=49
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=49
2012-05-24 17:26:07	UPDATE `test` SET result='0,488022cad5fdba19bc61c805cbe567f650b907ce', comments='', user_id=61, ts='2009-05-13 05:00:00' WHERE test_id=155 
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=140
2012-05-24 17:26:07	UPDATE `test` SET result='NO,7cebed9811441f7cf094c93ce00568f14683bce1', comments='', user_id=60, ts='2009-05-16 10:00:00' WHERE test_id=108 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=108
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=97
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=97
2012-05-24 17:26:07	UPDATE `test` SET result='0,1d2db110923c879199b0f99ba5b87b98f32063f9', comments='', user_id=60, ts='2009-05-24 12:00:00' WHERE test_id=1 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=1
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=1
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=1
2012-05-24 17:26:07	UPDATE `test` SET result='AAFB not seen,594c285f5112e76d85ea80c82821a932ed1870d2', comments='', user_id=61, ts='2009-06-04 02:00:00' WHERE test_id=114 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=114
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=102
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=102
2012-05-24 17:26:07	UPDATE `test` SET result='P,4d087a872ebaef71b19f562b2eea413450387085', comments='', user_id=61, ts='2009-06-13 12:00:00' WHERE test_id=39 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=39
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=37
2012-05-24 17:26:07	UPDATE `test` SET result='AAFB not seen,22b4315ff813e6d0d16532811d546abe0607c916', comments='', user_id=60, ts='2009-06-29 12:00:00' WHERE test_id=21 
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=20
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=20
2012-05-24 17:26:07	UPDATE `test` SET result='Cream White,++,Non offensive,Normal,8371f74e07b0ce50ae29d097e2100a8e0e3c21fc', comments='', user_id=61, ts='2009-06-30 12:00:00' WHERE test_id=43 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=43
2012-05-24 17:26:07	UPDATE `test` SET result='NO,8371f74e07b0ce50ae29d097e2100a8e0e3c21fc', comments='', user_id=61, ts='2009-06-30 12:00:00' WHERE test_id=44 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=44
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=41
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=41
2012-05-24 17:26:07	UPDATE `test` SET result='AAFB not seen,bdb25ed9a60c89cc2079729d2afe80f7fbba680c', comments='', user_id=60, ts='2009-07-18 03:00:00' WHERE test_id=97 
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=88
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=88
2012-05-24 17:26:07	UPDATE `test` SET result='Whitish,,,Many,Rare,Few,0,Neutrophils,Positive,0,0,0,8d88f998600979f0cf9894d6458a389fa72245e8', comments='', user_id=60, ts='2009-07-21 12:00:00' WHERE test_id=130 
2012-05-24 17:26:07	UPDATE test SET verified_by=2 WHERE test_id=130
2012-05-24 17:26:07	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=117
2012-05-24 17:26:07	UPDATE specimen SET date_reported='2012-05-24 17:26:07' WHERE specimen_id=117
2012-05-24 17:26:08	UPDATE `test` SET result='Positive,b4dd4ac56d3d595dd596c686c1f440578d7432dd', comments='', user_id=60, ts='2009-07-26 05:00:00' WHERE test_id=101 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=101
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=92
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=92
2012-05-24 17:26:08	UPDATE `test` SET result='0,8b0bc5f522e968c6cc328003dd767271374ff630', comments='', user_id=60, ts='2009-07-29 02:00:00' WHERE test_id=33 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=33
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=31
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=31
2012-05-24 17:26:08	UPDATE `test` SET result='500 mg#dl,f726fc0a3d99f3a32bb814d8bf76f906dd529546', comments='', user_id=61, ts='2009-08-15 09:00:00' WHERE test_id=84 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=84
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=75
2012-05-24 17:26:08	UPDATE `test` SET result='0,0,,89735039c24bdca446b46d6dcd97f92f8e4d1a74', comments='', user_id=61, ts='2009-08-31 05:00:00' WHERE test_id=160 
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=145
2012-05-24 17:26:08	UPDATE `test` SET result='0,1d41b3defc1f7e3c0ef896891f451559ebc602ca', comments='', user_id=60, ts='2009-09-12 03:00:00' WHERE test_id=192 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=192
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=175
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=175
2012-05-24 17:26:08	UPDATE `test` SET result='Semi-formed(not solid),Green,Present,Foul,Present,Moderate,Unsatisfactory,Moderate,Absent,Moderate,Many,No ova or protozoa seen,02c9099575cc29aaf07057e2bce54c542f2c2f39', comments='', user_id=61, ts='2009-09-15 07:00:00' WHERE test_id=54 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=54
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=51
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=51
2012-05-24 17:26:08	UPDATE `test` SET result='AAFB seen,112158e1b7d69c9684826e630eabc8acee0e4bb9', comments='', user_id=60, ts='2009-09-16 07:00:00' WHERE test_id=3 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=3
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=3
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=3
2012-05-24 17:26:08	UPDATE `test` SET result='AAFB seen,ae964678b5352b283c082cde76aef4ce79e7bf26', comments='', user_id=60, ts='2009-09-17 10:00:00' WHERE test_id=71 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=71
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=67
2012-05-24 17:26:08	UPDATE `test` SET result='AAFB not seen,32bef60c399ad3a379a3fb5b2fb5d6aa8e295d0d', comments='', user_id=60, ts='2009-09-26 10:00:00' WHERE test_id=64 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=64
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=61
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=61
2012-05-24 17:26:08	UPDATE `test` SET result='0,7ea2622635768518458d0c1a309e68ec1cdf5160', comments='', user_id=61, ts='2009-09-28 01:00:00' WHERE test_id=179 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=179
2012-05-24 17:26:08	UPDATE `test` SET result='0,7ea2622635768518458d0c1a309e68ec1cdf5160', comments='', user_id=61, ts='2009-09-28 01:00:00' WHERE test_id=180 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=180
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=164
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=164
2012-05-24 17:26:08	UPDATE `test` SET result='0,2054d10fea4bbe8ba8c4f16af196b6f660f3e918', comments='', user_id=60, ts='2009-10-01 02:00:00' WHERE test_id=49 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=49
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=46
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=46
2012-05-24 17:26:08	UPDATE `test` SET result='Negative,38ac2d12a81a4dbfc89613e90c488d34f8947f84', comments='', user_id=60, ts='2009-10-04 04:00:00' WHERE test_id=5 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=5
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=5
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=5
2012-05-24 17:26:08	UPDATE `test` SET result='Cream White,++,Offensive,Inflammed,712d23296e3e66c7204de946179e179a4f20f7a8', comments='', user_id=61, ts='2009-10-06 03:00:00' WHERE test_id=191 
2012-05-24 17:26:08	UPDATE test SET verified_by=2 WHERE test_id=191
2012-05-24 17:26:08	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=174
2012-05-24 17:26:08	UPDATE specimen SET date_reported='2012-05-24 17:26:08' WHERE specimen_id=174
2012-05-24 17:26:09	UPDATE `test` SET result='YES,705c49b92a8f093df9ebe08107a2502cd1a70c18', comments='', user_id=60, ts='2009-10-08 05:00:00' WHERE test_id=146 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=146
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=133
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=133
2012-05-24 17:26:09	UPDATE `test` SET result='0,9056770fba7fabb292b9e8bf52e4524ceae03dda', comments='', user_id=61, ts='2009-10-12 11:00:00' WHERE test_id=109 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=109
2012-05-24 17:26:09	UPDATE `test` SET result='P,9056770fba7fabb292b9e8bf52e4524ceae03dda', comments='', user_id=61, ts='2009-10-12 11:00:00' WHERE test_id=110 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=110
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=98
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=98
2012-05-24 17:26:09	UPDATE `test` SET result='Positive,19d7b6a833dd91b4ddf8311bdcc2006ec87ebfde', comments='', user_id=60, ts='2009-10-13 10:00:00' WHERE test_id=166 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=166
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=151
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=151
2012-05-24 17:26:09	UPDATE `test` SET result='127,d1fdd414df54fcfbc6f3e88f4724b2931a7fe859', comments='', user_id=60, ts='2009-10-16 02:00:00' WHERE test_id=55 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=55
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=52
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=52
2012-05-24 17:26:09	UPDATE `test` SET result='Watery,Brown,Present,Foul,Not present,Moderate,Satisfactory,Many,Few,Few,Many,No ova or protozoa seen,72d32822ab31a538550791b50d4c88233b48392e', comments='', user_id=60, ts='2009-10-23 11:00:00' WHERE test_id=113 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=113
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=101
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=101
2012-05-24 17:26:09	UPDATE `test` SET result='Negative,61c2fb6471116c710ce37fc9732481a4dd214e83', comments='', user_id=60, ts='2009-11-08 12:00:00' WHERE test_id=164 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=164
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=149
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=149
2012-05-24 17:26:09	UPDATE `test` SET result='Negative,e581b5306b3503c36fe8a690670c90b5af15ef74', comments='', user_id=60, ts='2009-11-12 12:00:00' WHERE test_id=148 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=148
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=135
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=135
2012-05-24 17:26:09	UPDATE `test` SET result='AAFB not seen,5c035e2c4a51952a99f46a6ede4c080bd83ca733', comments='', user_id=61, ts='2009-11-21 04:00:00' WHERE test_id=221 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=221
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=200
2012-05-24 17:26:09	UPDATE `test` SET result='P,77144f09ba647e69728d9affdb4aba294c8461f9', comments='', user_id=60, ts='2009-11-28 08:00:00' WHERE test_id=189 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=189
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=172
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=172
2012-05-24 17:26:09	UPDATE `test` SET result='0,5327d2dbb3a2d6511edfabb1b90fa224def823a3', comments='', user_id=60, ts='2009-12-01 06:00:00' WHERE test_id=131 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=131
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=118
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=118
2012-05-24 17:26:09	UPDATE `test` SET result='0,328427a3e580df9aee660bb971a7817535f820ce', comments='', user_id=61, ts='2009-12-05 03:00:00' WHERE test_id=143 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=143
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=130
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=130
2012-05-24 17:26:09	UPDATE `test` SET result='229,4e57241a5900fd1c15c54cbf94e886e3f96e7687', comments='', user_id=61, ts='2009-12-05 08:00:00' WHERE test_id=174 
2012-05-24 17:26:09	UPDATE test SET verified_by=2 WHERE test_id=174
2012-05-24 17:26:09	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=159
2012-05-24 17:26:09	UPDATE specimen SET date_reported='2012-05-24 17:26:09' WHERE specimen_id=159
2012-05-24 17:26:10	UPDATE `test` SET result='0,0ed523f068edcda29f06c4b4417fda0213dd6858', comments='', user_id=60, ts='2009-12-15 07:00:00' WHERE test_id=140 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=140
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=127
2012-05-24 17:26:10	UPDATE specimen SET date_reported='2012-05-24 17:26:10' WHERE specimen_id=127
2012-05-24 17:26:10	UPDATE `test` SET result='579,813f1384e9e8e5cd4cdcdd0c78f1f1a47c201ea2', comments='', user_id=61, ts='2009-12-15 06:00:00' WHERE test_id=176 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=176
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=161
2012-05-24 17:26:10	UPDATE specimen SET date_reported='2012-05-24 17:26:10' WHERE specimen_id=161
2012-05-24 17:26:10	UPDATE `test` SET result='N,127b5f6a682c501342e8ef2ec3b68132dc1b4882', comments='', user_id=61, ts='2009-12-19 11:00:00' WHERE test_id=159 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=159
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=144
2012-05-24 17:26:10	UPDATE specimen SET date_reported='2012-05-24 17:26:10' WHERE specimen_id=144
2012-05-24 17:26:10	UPDATE `test` SET result='0,26bac2bd2b1f76bdb8980998d9ef1a596a1f06c5', comments='', user_id=60, ts='2009-12-20 03:00:00' WHERE test_id=85 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=85
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=76
2012-05-24 17:26:10	UPDATE specimen SET date_reported='2012-05-24 17:26:10' WHERE specimen_id=76
2012-05-24 17:26:10	UPDATE `test` SET result='Whitish,++++,Non offensive,Pregnant,5ee48ad60305d6351c4e989f018f6ee0a9466fa4', comments='', user_id=60, ts='2009-12-23 07:00:00' WHERE test_id=24 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=24
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=23
2012-05-24 17:26:10	UPDATE specimen SET date_reported='2012-05-24 17:26:10' WHERE specimen_id=23
2012-05-24 17:26:10	UPDATE `test` SET result='N,8e7a36a46676bf691acba5d4a5be6ac14d2e8104', comments='', user_id=61, ts='2009-12-23 09:00:00' WHERE test_id=69 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=69
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=65
2012-05-24 17:26:10	UPDATE `test` SET result='N,f07da3496c685fff02ac7f85d47e62f12835d503', comments='', user_id=60, ts='2009-12-26 04:00:00' WHERE test_id=65 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=65
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=62
2012-05-24 17:26:10	UPDATE `test` SET result='Negative,05a0d2a91f7b6fb042fdbcc382a910f861cf2a8b', comments='', user_id=61, ts='2010-01-01 10:00:00' WHERE test_id=137 
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=124
2012-05-24 17:26:10	UPDATE specimen SET date_reported='2012-05-24 17:26:10' WHERE specimen_id=124
2012-05-24 17:26:10	UPDATE `test` SET result='N,a123e4e3023d12f3e08e718e6aeae0b4fc199925', comments='', user_id=61, ts='2010-01-06 05:00:00' WHERE test_id=11 
2012-05-24 17:26:10	UPDATE test SET verified_by=2 WHERE test_id=11
2012-05-24 17:26:10	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=11
2012-05-24 17:26:11	UPDATE `test` SET result='10,5,0,96,26,35,297,4edb543e138cf47eb60d3d034f3b38c0040a4858', comments='', user_id=61, ts='2010-01-06 06:00:00' WHERE test_id=87 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=87
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=78
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=78
2012-05-24 17:26:11	UPDATE `test` SET result='Trichomonas vaginalis Absent,Rare,Absent,Moderate,Moderate,Rare,Many,Moderate,Moderate,Rare,Rare,Type I,fb16b310bcd46293a9100a2ff495a4481ee01005', comments='', user_id=60, ts='2010-01-20 11:00:00' WHERE test_id=91 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=91
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=82
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=82
2012-05-24 17:26:11	UPDATE `test` SET result='Pale Yellow,++++,Offensive,Inflammed,a08f0405070f67bd2f48fcade780650257128ac3', comments='', user_id=60, ts='2010-01-24 11:00:00' WHERE test_id=80 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=80
2012-05-24 17:26:11	UPDATE `test` SET result='Trichomonas vaginalis Present,Absent,Few,Many,Many,Absent,Moderate,Many,Rare,Rare,Moderate,Type IV,a08f0405070f67bd2f48fcade780650257128ac3', comments='', user_id=61, ts='2010-01-24 11:00:00' WHERE test_id=81 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=81
2012-05-24 17:26:11	UPDATE `test` SET result='NO,a08f0405070f67bd2f48fcade780650257128ac3', comments='', user_id=60, ts='2010-01-24 11:00:00' WHERE test_id=82 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=82
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=73
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=73
2012-05-24 17:26:11	UPDATE `test` SET result='Trichomonas vaginalis Absent,Rare,Absent,Moderate,Few,Few,Rare,Absent,Absent,Rare,Absent,Type IV,25843c3d4ef1ca2913759bd19d36ad0c7b0f5a9a', comments='', user_id=61, ts='2010-01-30 05:00:00' WHERE test_id=34 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=34
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=32
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=32
2012-05-24 17:26:11	UPDATE `test` SET result='AAFB seen,c1a3d33e083a16fe01c2e0b17a691fc5a1c4d02d', comments='', user_id=61, ts='2010-02-02 06:00:00' WHERE test_id=90 
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=81
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=81
2012-05-24 17:26:11	UPDATE `test` SET result='Colourless,,,Moderate,Few,Absent,0,Eosinophils,Positive,0,0,0,bb1eee9a0c52b6fa2de168aa7e7b7078e29ab7fa', comments='', user_id=61, ts='2010-02-22 08:00:00' WHERE test_id=51 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=51
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=48
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=48
2012-05-24 17:26:11	UPDATE `test` SET result='0,23039f0166e6282ff2b336a7e993901029cf5f98', comments='', user_id=61, ts='2010-02-23 12:00:00' WHERE test_id=184 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=184
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=168
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=168
2012-05-24 17:26:11	UPDATE `test` SET result='Bloody,,,Many,Few,Moderate,0,Basophils,Negative,0,0,0,1ff3e2caef9a3b5bc85a532faa4a7fd5cd409482', comments='', user_id=61, ts='2010-03-06 11:00:00' WHERE test_id=14 
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=14
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=14
2012-05-24 17:26:11	UPDATE `test` SET result='0,9ce74d30d92f8aa57dfff786eb3a188e839620e4', comments='', user_id=60, ts='2010-03-11 06:00:00' WHERE test_id=28 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=28
2012-05-24 17:26:11	UPDATE `test` SET result='0,9ce74d30d92f8aa57dfff786eb3a188e839620e4', comments='', user_id=60, ts='2010-03-11 06:00:00' WHERE test_id=29 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=29
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=27
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=27
2012-05-24 17:26:11	UPDATE `test` SET result='P,df7d3811e453c82805d95a9e3f42d8c58538acfa', comments='', user_id=60, ts='2010-03-14 03:00:00' WHERE test_id=162 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=162
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=147
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=147
2012-05-24 17:26:11	UPDATE `test` SET result='AAFB seen,d603fa7ce622d8fb77ae66267bce6de5eaba7001', comments='', user_id=61, ts='2010-03-20 09:00:00' WHERE test_id=215 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=215
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=195
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=195
2012-05-24 17:26:11	UPDATE `test` SET result='0,b66b44b05f0df236a3c71bdc7c7f29d15554e2fd', comments='', user_id=61, ts='2010-03-22 01:00:00' WHERE test_id=135 
2012-05-24 17:26:11	UPDATE test SET verified_by=2 WHERE test_id=135
2012-05-24 17:26:11	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=122
2012-05-24 17:26:11	UPDATE specimen SET date_reported='2012-05-24 17:26:11' WHERE specimen_id=122
2012-05-24 17:26:12	UPDATE `test` SET result='Mucoid,Green,Present,Offensive,Not present,Moderate,Satisfactory,Absent,Few,Many,Many,Protozoa|ova seen,6e22820b96be7852bdb4a341509509cf71373729', comments='', user_id=61, ts='2010-03-26 06:00:00' WHERE test_id=154 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=154
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=139
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=139
2012-05-24 17:26:12	UPDATE `test` SET result='AAFB not seen,e3db088b3c37cf797d57c98700eae6c4c3bb8337', comments='', user_id=61, ts='2010-03-27 08:00:00' WHERE test_id=168 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=168
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=153
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=153
2012-05-24 17:26:12	UPDATE `test` SET result='P,239349f056239221225f726532e897d31ac4e377', comments='', user_id=61, ts='2010-03-28 05:00:00' WHERE test_id=27 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=27
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=26
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=26
2012-05-24 17:26:12	UPDATE `test` SET result='AAFB not seen,aa5f428e84c3537aa6a64035dc5900b83a46dd45', comments='', user_id=61, ts='2010-04-11 07:00:00' WHERE test_id=61 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=61
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=58
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=58
2012-05-24 17:26:12	UPDATE `test` SET result='Negative,e55b34749ec7e3408417d880b4925053cafb3cf4', comments='', user_id=60, ts='2010-04-24 01:00:00' WHERE test_id=147 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=147
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=134
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=134
2012-05-24 17:26:12	UPDATE `test` SET result='NO,4592d9bcdde84a11007ab657e7ef0ce011d7a68e', comments='', user_id=60, ts='2010-05-06 10:00:00' WHERE test_id=50 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=50
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=47
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=47
2012-05-24 17:26:12	UPDATE `test` SET result='0,c98db64770d540bb85d732aa30c32c25d0b59fe4', comments='', user_id=60, ts='2010-05-28 02:00:00' WHERE test_id=7 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=7
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=7
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=7
2012-05-24 17:26:12	UPDATE `test` SET result='Negative,57e162e5479ac73751c39eac3a539ef2d1360fcb', comments='', user_id=60, ts='2010-06-01 03:00:00' WHERE test_id=46 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=46
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=43
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=43
2012-05-24 17:26:12	UPDATE `test` SET result='230,bf7c8b9d5a9cc5bd56768b7060d31b2ae674f96a', comments='', user_id=61, ts='2010-06-04 06:00:00' WHERE test_id=194 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=194
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=177
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=177
2012-05-24 17:26:12	UPDATE `test` SET result='Trichomonas vaginalis Present,Few,Few,Few,Absent,Moderate,Many,Few,Moderate,Few,Rare,Type V,06024df395ac96c9693e06627ad0fa85d54f56af', comments='', user_id=61, ts='2010-06-06 02:00:00' WHERE test_id=30 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=30
2012-05-24 17:26:12	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=28
2012-05-24 17:26:12	UPDATE specimen SET date_reported='2012-05-24 17:26:12' WHERE specimen_id=28
2012-05-24 17:26:12	UPDATE `test` SET result='573,02ad91253cc97e4cb217b2c05ff70581842c75fc', comments='', user_id=61, ts='2010-06-20 01:00:00' WHERE test_id=45 
2012-05-24 17:26:12	UPDATE test SET verified_by=2 WHERE test_id=45
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=42
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=42
2012-05-24 17:26:13	UPDATE `test` SET result='P,0ee53f0c95092cd36202d8b5cb10f57cd371e346', comments='', user_id=60, ts='2010-07-02 04:00:00' WHERE test_id=115 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=115
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=103
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=103
2012-05-24 17:26:13	UPDATE `test` SET result='0,5f95adf5c62fe32bedc8d5c163693d2d17388cb9', comments='', user_id=61, ts='2010-07-03 03:00:00' WHERE test_id=73 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=73
2012-05-24 17:26:13	UPDATE `test` SET result='0,5f95adf5c62fe32bedc8d5c163693d2d17388cb9', comments='', user_id=60, ts='2010-07-03 03:00:00' WHERE test_id=74 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=74
2012-05-24 17:26:13	UPDATE `test` SET result='0,0,0,0,5f95adf5c62fe32bedc8d5c163693d2d17388cb9', comments='', user_id=60, ts='2010-07-03 03:00:00' WHERE test_id=75 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=75
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=69
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=69
2012-05-24 17:26:13	UPDATE `test` SET result='Negative,35127fa2215737b186223ea6c9c30f731c24db53', comments='', user_id=60, ts='2010-07-11 04:00:00' WHERE test_id=134 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=134
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=121
2012-05-24 17:26:13	UPDATE `test` SET result='0,a11b786ae5a1202985a907dbd070b1e893249fe2', comments='', user_id=61, ts='2010-07-17 04:00:00' WHERE test_id=198 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=198
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=181
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=181
2012-05-24 17:26:13	UPDATE `test` SET result='Positive,ae8eed2cc4ce6dc4d66e1d49807a383dffe60968', comments='', user_id=60, ts='2010-07-24 03:00:00' WHERE test_id=167 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=167
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=152
2012-05-24 17:26:13	UPDATE `test` SET result='AAFB not seen,baf1e9df565f15c4fa3d46147ab7d416409eabdc', comments='', user_id=61, ts='2010-07-27 08:00:00' WHERE test_id=158 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=158
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=143
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=143
2012-05-24 17:26:13	UPDATE `test` SET result='0,1c60913f616a9987c88193b6449fb71c3b63bbdb', comments='', user_id=60, ts='2010-08-17 04:00:00' WHERE test_id=56 
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=53
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=53
2012-05-24 17:26:13	UPDATE `test` SET result='0,351527768b90b1400406eb950c8dfce4a294e5aa', comments='', user_id=60, ts='2010-08-20 10:00:00' WHERE test_id=8 
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=8
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=8
2012-05-24 17:26:13	UPDATE `test` SET result='NO,0fdad3067e3f73fcc24b2299362a5892b1bf4158', comments='', user_id=61, ts='2010-08-29 04:00:00' WHERE test_id=212 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=212
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=192
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=192
2012-05-24 17:26:13	UPDATE `test` SET result='AAFB not seen,b015474dad0a9cc566430f6045871bbffbeb7c9f', comments='', user_id=60, ts='2010-08-30 05:00:00' WHERE test_id=197 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=197
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=180
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=180
2012-05-24 17:26:13	UPDATE `test` SET result='500 mg#dl,19d7b6a833dd91b4ddf8311bdcc2006ec87ebfde', comments='', user_id=61, ts='2010-09-03 12:00:00' WHERE test_id=107 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=107
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=96
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=96
2012-05-24 17:26:13	UPDATE `test` SET result='N,088c77fd2b46dc7678cd48d66bc6cd46ad9c6534', comments='', user_id=60, ts='2010-09-10 05:00:00' WHERE test_id=183 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=183
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=167
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=167
2012-05-24 17:26:13	UPDATE `test` SET result='AAFB not seen,d755a4fb56c9f38e730df4a18540dc6b41a1e6e5', comments='', user_id=61, ts='2010-09-11 05:00:00' WHERE test_id=12 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=12
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=12
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=12
2012-05-24 17:26:13	UPDATE `test` SET result='AAFB seen,0ee53f0c95092cd36202d8b5cb10f57cd371e346', comments='', user_id=61, ts='2010-09-11 10:00:00' WHERE test_id=62 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=62
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=59
2012-05-24 17:26:13	UPDATE specimen SET date_reported='2012-05-24 17:26:13' WHERE specimen_id=59
2012-05-24 17:26:13	UPDATE `test` SET result='Negative,336e731700a4e7f8f2dd395b0ef87ebb922b5719', comments='', user_id=61, ts='2010-09-16 01:00:00' WHERE test_id=203 
2012-05-24 17:26:13	UPDATE test SET verified_by=2 WHERE test_id=203
2012-05-24 17:26:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=186
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=186
2012-05-24 17:26:14	UPDATE `test` SET result='P,ac661a2209b7f76a34581d26d827495d38330f7a', comments='', user_id=60, ts='2010-09-23 07:00:00' WHERE test_id=102 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=102
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=93
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=93
2012-05-24 17:26:14	UPDATE `test` SET result='N,7eec0eeadba6ef22480e5afb571ff372c25873e2', comments='', user_id=61, ts='2010-10-02 02:00:00' WHERE test_id=53 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=53
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=50
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=50
2012-05-24 17:26:14	UPDATE `test` SET result='0,6a610f394e57150dd09e2944f6c0a5546408d65d', comments='', user_id=61, ts='2010-10-02 02:00:00' WHERE test_id=119 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=119
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=107
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=107
2012-05-24 17:26:14	UPDATE `test` SET result='0,ebb060babae426ee4f35d142158f7ab0e4846657', comments='', user_id=61, ts='2010-10-12 11:00:00' WHERE test_id=20 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=20
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=19
2012-05-24 17:26:14	UPDATE `test` SET result='0,a65e1b251422f9b308e2e1e313e19d4e5cb6e683', comments='', user_id=60, ts='2010-10-17 04:00:00' WHERE test_id=220 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=220
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=199
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=199
2012-05-24 17:26:14	UPDATE `test` SET result='NO,56ed4437aad4aca42463aca2c2ddb68f4c52ebda', comments='', user_id=61, ts='2010-10-22 08:00:00' WHERE test_id=196 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=196
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=179
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=179
2012-05-24 17:26:14	UPDATE `test` SET result='N,4e57241a5900fd1c15c54cbf94e886e3f96e7687', comments='', user_id=61, ts='2010-10-27 01:00:00' WHERE test_id=17 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=17
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=16
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=16
2012-05-24 17:26:14	UPDATE `test` SET result='P,22c48d7af2b4934f07e90f0320ce0e5111b74965', comments='', user_id=60, ts='2010-11-09 05:00:00' WHERE test_id=35 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=35
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=33
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=33
2012-05-24 17:26:14	UPDATE `test` SET result='0,64627eaceceb9dd7684e08308ac01824a9f78564', comments='', user_id=61, ts='2010-11-14 01:00:00' WHERE test_id=151 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=151
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=137
2012-05-24 17:26:14	UPDATE `test` SET result='69,4b29307fa842d25a5b3fde41b8b5ac0792aded6a', comments='', user_id=61, ts='2010-11-15 07:00:00' WHERE test_id=129 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=129
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=116
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=116
2012-05-24 17:26:14	UPDATE `test` SET result='0,20d75c8ecf1daab496f96e329520172154b49728', comments='', user_id=61, ts='2010-11-21 09:00:00' WHERE test_id=67 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=67
2012-05-24 17:26:14	UPDATE `test` SET result='Reactive,20d75c8ecf1daab496f96e329520172154b49728', comments='', user_id=61, ts='2010-11-21 09:00:00' WHERE test_id=68 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=68
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=64
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=64
2012-05-24 17:26:14	UPDATE `test` SET result='Negative,8f78fb6350ca8527b3bd8b9512683d3645ad70dc', comments='', user_id=61, ts='2010-11-22 09:00:00' WHERE test_id=94 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=94
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=85
2012-05-24 17:26:14	UPDATE specimen SET date_reported='2012-05-24 17:26:14' WHERE specimen_id=85
2012-05-24 17:26:14	UPDATE `test` SET result='AAFB seen,bce2200383fcd04dd3cc67b6cee9509e87992ff1', comments='', user_id=61, ts='2010-11-23 04:00:00' WHERE test_id=213 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=213
2012-05-24 17:26:14	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=193
2012-05-24 17:26:14	UPDATE `test` SET result='0,9a735d1073afc7086c15cefbef9f697f4e8cc669', comments='', user_id=61, ts='2010-11-25 01:00:00' WHERE test_id=76 
2012-05-24 17:26:14	UPDATE `test` SET result='0,9a735d1073afc7086c15cefbef9f697f4e8cc669', comments='', user_id=61, ts='2010-11-25 01:00:00' WHERE test_id=77 
2012-05-24 17:26:14	UPDATE test SET verified_by=2 WHERE test_id=77
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=70
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=70
2012-05-24 17:26:15	UPDATE `test` SET result='0,1c0aafec7e559520b4f2d767a638909fed0cec98', comments='', user_id=61, ts='2010-11-26 04:00:00' WHERE test_id=149 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=149
2012-05-24 17:26:15	UPDATE `test` SET result='0,1c0aafec7e559520b4f2d767a638909fed0cec98', comments='', user_id=60, ts='2010-11-26 04:00:00' WHERE test_id=150 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=150
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=136
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=136
2012-05-24 17:26:15	UPDATE `test` SET result='P,9cdd975b24acb4703614e1ae3b259b5af6424212', comments='', user_id=61, ts='2010-11-27 04:00:00' WHERE test_id=157 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=157
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=142
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=142
2012-05-24 17:26:15	UPDATE `test` SET result='Mucoid,Green,Present,Foul,Not present,Few,Unsatisfactory,Many,Few,Moderate,Few,Protozoa|ova seen,eda5b899bca7a0354583c5cba18f141178f32108', comments='', user_id=60, ts='2010-12-04 12:00:00' WHERE test_id=83 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=83
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=74
2012-05-24 17:26:15	UPDATE `test` SET result='0,377c6fa04d3711eeabe6fbc21bc2b3cbc71ad7af', comments='', user_id=60, ts='2010-12-17 10:00:00' WHERE test_id=185 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=185
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=169
2012-05-24 17:26:15	UPDATE `test` SET result='Whitish,++,Offensive,Normal,d7e9012728b7a9878fd30544ca3621e3a1420650', comments='', user_id=61, ts='2010-12-25 03:00:00' WHERE test_id=58 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=58
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=55
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=55
2012-05-24 17:26:15	UPDATE `test` SET result='0,17cfa997d12bda151ffaffa4b0956b5c338400a4', comments='', user_id=61, ts='2010-12-26 01:00:00' WHERE test_id=96 
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=87
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=87
2012-05-24 17:26:15	UPDATE `test` SET result='Negative,98474bea16a7be3a95761dd738c499c49479e65d', comments='', user_id=60, ts='2010-12-26 02:00:00' WHERE test_id=202 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=202
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=185
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=185
2012-05-24 17:26:15	UPDATE `test` SET result='Positive,6448b0df2a0aab768aeb5b0f86a1263f988c39bd', comments='', user_id=60, ts='2011-01-05 02:00:00' WHERE test_id=139 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=139
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=126
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=126
2012-05-24 17:26:15	UPDATE `test` SET result='Negative,e22d2097ca8cfeca8f27ddcf9d66103b2f39d081', comments='', user_id=61, ts='2011-01-11 02:00:00' WHERE test_id=72 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=72
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=68
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=68
2012-05-24 17:26:15	UPDATE `test` SET result='P,1c4842e1cd75070f7b5514f37fc13cc2e53ee3b9', comments='', user_id=60, ts='2011-02-11 10:00:00' WHERE test_id=170 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=170
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=155
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=155
2012-05-24 17:26:15	UPDATE `test` SET result='Yellow,Yes,0,Absent,Absent,Present,Absent,Present,Absent,Absent,Present,Absent,-,52d22f662fe61198c56f17a1480aed5a782186f2', comments='', user_id=61, ts='2011-02-25 08:00:00' WHERE test_id=100 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=100
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=91
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=91
2012-05-24 17:26:15	UPDATE `test` SET result='Pale Yellow,++++,Non offensive,Normal,d1a3655c139f3783e07ee1e98284bbed8b2816d9', comments='', user_id=61, ts='2011-02-25 09:00:00' WHERE test_id=125 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=125
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=112
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=112
2012-05-24 17:26:15	UPDATE `test` SET result='Positive,ec55482e91f95f1da76f36d4891b6c0432b6be97', comments='', user_id=61, ts='2011-02-26 06:00:00' WHERE test_id=57 
2012-05-24 17:26:15	UPDATE test SET verified_by=2 WHERE test_id=57
2012-05-24 17:26:15	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=54
2012-05-24 17:26:15	UPDATE specimen SET date_reported='2012-05-24 17:26:15' WHERE specimen_id=54
2012-05-24 17:26:15	UPDATE `test` SET result='Reactive,2bc1e13a652eed72759ae27c012b3023d57c2301', comments='', user_id=60, ts='2011-02-27 12:00:00' WHERE test_id=104 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=104
2012-05-24 17:26:16	UPDATE `test` SET result='0,2bc1e13a652eed72759ae27c012b3023d57c2301', comments='', user_id=60, ts='2011-02-27 12:00:00' WHERE test_id=105 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=105
2012-05-24 17:26:16	UPDATE `test` SET result='0,0,2bc1e13a652eed72759ae27c012b3023d57c2301', comments='', user_id=61, ts='2011-02-27 12:00:00' WHERE test_id=106 
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=95
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=95
2012-05-24 17:26:16	UPDATE `test` SET result='Watery,Green,Absent,Foul,Present,Few,Unsatisfactory,Moderate,Absent,Many,Many,Protozoa|ova seen,2ffd97be49d731673960118f04b3ddb2506a8d7a', comments='', user_id=61, ts='2011-03-02 08:00:00' WHERE test_id=103 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=103
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=94
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=94
2012-05-24 17:26:16	UPDATE `test` SET result='Positive,454d6d3c96f3a220f952a5be883df21b94fc56b0', comments='', user_id=61, ts='2011-03-03 02:00:00' WHERE test_id=124 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=124
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=111
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=111
2012-05-24 17:26:16	UPDATE `test` SET result='Colourless,,,Absent,Few,Few,0,Basophils,Positive,0,0,0,25b2900e5381ac9a52c7278460f5aed69b714ed5', comments='', user_id=60, ts='2011-03-03 04:00:00' WHERE test_id=171 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=171
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=156
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=156
2012-05-24 17:26:16	UPDATE `test` SET result='N,bf9114a4aa843434c012bfae0873c16339b2a5c1', comments='', user_id=61, ts='2011-03-05 08:00:00' WHERE test_id=38 
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=36
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=36
2012-05-24 17:26:16	UPDATE `test` SET result='987,31810138d6835fb32a0f8a8d2838323c90c212b0', comments='', user_id=61, ts='2011-03-07 01:00:00' WHERE test_id=214 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=214
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=194
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=194
2012-05-24 17:26:16	UPDATE `test` SET result='NO,aa6f75e08031e8b00b9e7acef082b674cb2d28b6', comments='', user_id=60, ts='2011-03-09 07:00:00' WHERE test_id=152 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=152
2012-05-24 17:26:16	UPDATE `test` SET result='Cream White,+++,Non offensive,Inflammed,aa6f75e08031e8b00b9e7acef082b674cb2d28b6', comments='', user_id=60, ts='2011-03-09 07:00:00' WHERE test_id=153 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=153
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=138
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=138
2012-05-24 17:26:16	UPDATE `test` SET result='Positive,bce2200383fcd04dd3cc67b6cee9509e87992ff1', comments='', user_id=60, ts='2011-03-13 01:00:00' WHERE test_id=111 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=111
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=99
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=99
2012-05-24 17:26:16	UPDATE `test` SET result='Trichomonas vaginalis Absent,Absent,Moderate,Rare,Absent,Few,Absent,Many,Moderate,Moderate,Few,Type IV,2a3ab5386261fbab359adc9a32449bd8b8436305', comments='', user_id=61, ts='2011-03-13 04:00:00' WHERE test_id=175 
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=160
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=160
2012-05-24 17:26:16	UPDATE `test` SET result='0,c3bd6113b4e5062c4723d3411e0f7136b75ec95b', comments='', user_id=61, ts='2011-03-18 08:00:00' WHERE test_id=10 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=10
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=10
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=10
2012-05-24 17:26:16	UPDATE `test` SET result='Semi-formed(not solid),Green,Absent,Offensive,Not present,Few,Unsatisfactory,Moderate,Moderate,Few,Few,Protozoa|ova seen,d428a34fb477f36b65d8f3e25d63372a9a094e97', comments='', user_id=60, ts='2011-04-04 01:00:00' WHERE test_id=88 
2012-05-24 17:26:16	UPDATE test SET verified_by=2 WHERE test_id=88
2012-05-24 17:26:16	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=79
2012-05-24 17:26:16	UPDATE specimen SET date_reported='2012-05-24 17:26:16' WHERE specimen_id=79
2012-05-24 17:26:17	UPDATE `test` SET result='Brown,No,0,Absent,Absent,Absent,Absent,Present,Absent,Present,Present,Present,-,53c8e3b0f4b590e29f9490644f4dcc0843e116c6', comments='', user_id=60, ts='2011-04-09 02:00:00' WHERE test_id=70 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=70
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=66
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=66
2012-05-24 17:26:17	UPDATE `test` SET result='0,815ff1f9bace3f7b9100d214c6c32827fa8ed2cf', comments='', user_id=61, ts='2011-04-09 03:00:00' WHERE test_id=98 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=98
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=89
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=89
2012-05-24 17:26:17	UPDATE `test` SET result='N,46eae28eee77a24786127e0116d2028dbbeac550', comments='', user_id=60, ts='2011-04-15 09:00:00' WHERE test_id=112 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=112
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=100
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=100
2012-05-24 17:26:17	UPDATE `test` SET result='Trichomonas vaginalis Present,Many,Rare,Few,Many,Few,Many,Many,Few,Rare,Absent,Type I,7b91142a1d4f4d76cfd81274597f4ae88e93b273', comments='', user_id=61, ts='2011-04-17 02:00:00' WHERE test_id=78 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=78
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=71
2012-05-24 17:26:17	UPDATE `test` SET result='Pale Yellow,+,Non offensive,Normal,13a334331fea73aef3fc05088f8264d42921a6a6', comments='', user_id=61, ts='2011-04-26 11:00:00' WHERE test_id=126 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=126
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=113
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=113
2012-05-24 17:26:17	UPDATE `test` SET result='Bloody,,,Moderate,Rare,Few,0,Neutrophils,Negative,0,0,0,ed8ab395e63b0b1aef2000b523ea58d0ca2bc116', comments='', user_id=60, ts='2011-04-27 09:00:00' WHERE test_id=92 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=92
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=83
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=83
2012-05-24 17:26:17	UPDATE `test` SET result='0,1b96001e846875f398e625dca2baee0052376206', comments='', user_id=60, ts='2011-05-04 07:00:00' WHERE test_id=163 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=163
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=148
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=148
2012-05-24 17:26:17	UPDATE `test` SET result='Bloody,,,Absent,Rare,Moderate,0,Lymphocytes,Negative,0,0,0,9ac4bd8d1d27acc5176446b3badc934531efaab3', comments='', user_id=60, ts='2011-05-20 02:00:00' WHERE test_id=178 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=178
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=163
2012-05-24 17:26:17	UPDATE `test` SET result='AAFB seen,42bc0bf065a53399e7873aca0f25cb277d812688', comments='', user_id=61, ts='2011-06-06 08:00:00' WHERE test_id=201 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=201
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=184
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=184
2012-05-24 17:26:17	UPDATE `test` SET result='Positive,727192e4ec4605bac111d245af0f731dfe817929', comments='', user_id=61, ts='2011-06-15 05:00:00' WHERE test_id=204 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=204
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=187
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=187
2012-05-24 17:26:17	UPDATE `test` SET result='220,2f8079c8c949496c73b8974867c51ec8c324d767', comments='', user_id=60, ts='2011-06-18 05:00:00' WHERE test_id=210 
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=190
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=190
2012-05-24 17:26:17	UPDATE `test` SET result='0,0,0,0,fb8dd382b99679668f20725dfc00e3e25ba3eb3a', comments='', user_id=60, ts='2011-06-19 06:00:00' WHERE test_id=99 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=99
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=90
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=90
2012-05-24 17:26:17	UPDATE `test` SET result='Positive,9705b25030167be266e7c8c3591180b978900b10', comments='', user_id=61, ts='2011-06-23 08:00:00' WHERE test_id=141 
2012-05-24 17:26:17	UPDATE test SET verified_by=2 WHERE test_id=141
2012-05-24 17:26:17	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=128
2012-05-24 17:26:17	UPDATE specimen SET date_reported='2012-05-24 17:26:17' WHERE specimen_id=128
2012-05-24 17:26:17	UPDATE `test` SET result='AAFB seen,8dba944f18e029626a03578012a71c3c8a68af84', comments='', user_id=61, ts='2011-06-30 10:00:00' WHERE test_id=133 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=133
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=120
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=120
2012-05-24 17:26:18	UPDATE `test` SET result='Bloody,,,Moderate,Rare,Many,0,Neutrophils,Negative,0,0,0,b8762f4af60d879b9b6858dfda391f09cc97fcd8', comments='', user_id=61, ts='2011-07-15 12:00:00' WHERE test_id=47 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=47
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=44
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=44
2012-05-24 17:26:18	UPDATE `test` SET result='450,e9640acb25d7d6e734f28492305de6dcb0d80822', comments='', user_id=61, ts='2011-07-22 04:00:00' WHERE test_id=32 
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=30
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=30
2012-05-24 17:26:18	UPDATE `test` SET result='Bloody,,,Moderate,Few,Moderate,0,Neutrophils,Positive,0,0,0,915809c074fd02d677012d2d91becd4ea303a1e2', comments='', user_id=61, ts='2011-07-22 08:00:00' WHERE test_id=127 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=127
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=114
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=114
2012-05-24 17:26:18	UPDATE `test` SET result='Colourless,,,Moderate,Few,Few,0,Lymphocytes,Positive,0,0,0,44ecfdaa9886d61525b1f6cce07efd7902a89af2', comments='', user_id=61, ts='2011-07-24 07:00:00' WHERE test_id=63 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=63
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=60
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=60
2012-05-24 17:26:18	UPDATE `test` SET result='N,33ab1cebeb112eb9963ee6937e709c0ea25ad06b', comments='', user_id=61, ts='2011-08-05 04:00:00' WHERE test_id=136 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=136
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=123
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=123
2012-05-24 17:26:18	UPDATE `test` SET result='Bloody,,,Many,Few,Absent,0,Eosinophils,Positive,0,0,0,883449417e85cbcba453612bd4b28f8cab0f9b32', comments='', user_id=61, ts='2011-08-16 04:00:00' WHERE test_id=60 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=60
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=57
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=57
2012-05-24 17:26:18	UPDATE `test` SET result='56,13f73335b7b0b68f314a6144c47a6b4cd236eddf', comments='', user_id=61, ts='2011-08-16 05:00:00' WHERE test_id=199 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=199
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=182
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=182
2012-05-24 17:26:18	UPDATE `test` SET result='Watery,Green,Absent,Offensive,Present,Many,Satisfactory,Many,Few,Few,Few,Protozoa|ova seen,2e95d76869d773e56b2eaff16124307b5cda7a41', comments='', user_id=60, ts='2011-08-20 08:00:00' WHERE test_id=193 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=193
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=176
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=176
2012-05-24 17:26:18	UPDATE `test` SET result='Trichomonas vaginalis Present,Moderate,Few,Absent,Many,Absent,Many,Many,Absent,Moderate,Many,Type III,ca69c113f6a330186be0390f4c58d8b5cee1db6d', comments='', user_id=60, ts='2011-08-21 06:00:00' WHERE test_id=208 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=208
2012-05-24 17:26:18	UPDATE `test` SET result='NO,ca69c113f6a330186be0390f4c58d8b5cee1db6d', comments='', user_id=61, ts='2011-08-21 06:00:00' WHERE test_id=209 
2012-05-24 17:26:18	UPDATE test SET verified_by=2 WHERE test_id=209
2012-05-24 17:26:18	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=189
2012-05-24 17:26:18	UPDATE specimen SET date_reported='2012-05-24 17:26:18' WHERE specimen_id=189
2012-05-24 17:26:18	UPDATE `test` SET result='Negative,145d82cfef75a33c7d0add0e3444c3c84dda4557', comments='', user_id=60, ts='2011-08-22 02:00:00' WHERE test_id=15 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=15
2012-05-24 17:26:19	UPDATE `test` SET result='Positive,145d82cfef75a33c7d0add0e3444c3c84dda4557', comments='', user_id=61, ts='2011-08-22 02:00:00' WHERE test_id=16 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=16
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=15
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=15
2012-05-24 17:26:19	UPDATE `test` SET result='Positive,87d7ee9eb2ce9f35afdc4ab22e698d13c63718eb', comments='', user_id=60, ts='2011-08-23 03:00:00' WHERE test_id=42 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=42
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=40
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=40
2012-05-24 17:26:19	UPDATE `test` SET result='Mucoid,Brown,Present,Foul,Not present,Moderate,Unsatisfactory,Many,Few,Few,Few,Protozoa|ova seen,246afb4a8ddc9962e70f93d9a1f061462e58b42c', comments='', user_id=60, ts='2011-08-30 03:00:00' WHERE test_id=128 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=128
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=115
2012-05-24 17:26:19	UPDATE `test` SET result='Watery,Brown,Present,Offensive,Not present,Many,Satisfactory,Many,Many,Few,Moderate,No ova or protozoa seen,db245b88c9e3c1c0beedea41e948efddbc1d2814', comments='', user_id=60, ts='2011-09-06 03:00:00' WHERE test_id=118 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=118
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=106
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=106
2012-05-24 17:26:19	UPDATE `test` SET result='N,f821adbf21b104935fb031080190ac1d3582ba5f', comments='', user_id=60, ts='2011-09-11 11:00:00' WHERE test_id=93 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=93
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=84
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=84
2012-05-24 17:26:19	UPDATE `test` SET result='AAFB seen,650abb799231c51e22e2e171cef33ebef70daa70', comments='', user_id=60, ts='2011-09-14 07:00:00' WHERE test_id=2 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=2
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=2
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=2
2012-05-24 17:26:19	UPDATE `test` SET result='N,491d6d845a8cf56c0267eca67b68aa9d93469a91', comments='', user_id=61, ts='2011-09-14 05:00:00' WHERE test_id=219 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=219
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=198
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=198
2012-05-24 17:26:19	UPDATE `test` SET result='Colourless,,,Few,Rare,Few,0,Neutrophils,Positive,0,0,0,d59a4177fc74853f78dbd180af7bf0e43f626e63', comments='', user_id=60, ts='2011-09-20 08:00:00' WHERE test_id=142 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=142
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=129
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=129
2012-05-24 17:26:19	UPDATE `test` SET result='Trichomonas vaginalis Absent,Many,Few,Absent,Few,Rare,Rare,Many,Moderate,Rare,Few,Type I,630d2b2a3f453247838b087f3259d8df580c8b87', comments='', user_id=61, ts='2011-09-28 02:00:00' WHERE test_id=187 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=187
2012-05-24 17:26:19	UPDATE `test` SET result='NO,630d2b2a3f453247838b087f3259d8df580c8b87', comments='', user_id=60, ts='2011-09-28 02:00:00' WHERE test_id=188 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=188
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=171
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=171
2012-05-24 17:26:19	UPDATE `test` SET result='P,4f65445039f75157f9f5d01f27badc96bcd659a5', comments='', user_id=61, ts='2011-10-01 04:00:00' WHERE test_id=186 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=186
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=170
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=170
2012-05-24 17:26:19	UPDATE `test` SET result='514,240da1a5cc0b240f63d418c3cf42414364e5ad3a', comments='', user_id=60, ts='2011-10-21 04:00:00' WHERE test_id=138 
2012-05-24 17:26:19	UPDATE test SET verified_by=2 WHERE test_id=138
2012-05-24 17:26:19	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=125
2012-05-24 17:26:19	UPDATE specimen SET date_reported='2012-05-24 17:26:19' WHERE specimen_id=125
2012-05-24 17:26:20	UPDATE `test` SET result='Trichomonas vaginalis Present,Absent,Few,Moderate,Absent,Many,Moderate,Moderate,Many,Few,Few,Type III,e691052032ea65e2b6b5cd64d5557b41b0d16229', comments='', user_id=61, ts='2011-10-26 04:00:00' WHERE test_id=37 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=37
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=35
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=35
2012-05-24 17:26:20	UPDATE `test` SET result='Positive,42bc0bf065a53399e7873aca0f25cb277d812688', comments='', user_id=61, ts='2011-10-27 07:00:00' WHERE test_id=18 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=18
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=17
2012-05-24 17:26:20	UPDATE `test` SET result='0,e5b28c3a16ef14fcaa172516a0ee16b6b90bb19a', comments='', user_id=61, ts='2011-10-31 12:00:00' WHERE test_id=217 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=217
2012-05-24 17:26:20	UPDATE `test` SET result='4,e5b28c3a16ef14fcaa172516a0ee16b6b90bb19a', comments='', user_id=60, ts='2011-10-31 12:00:00' WHERE test_id=218 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=218
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=197
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=197
2012-05-24 17:26:20	UPDATE `test` SET result='0,13e25203b10c60d641d5322908df8195a6c56608', comments='', user_id=60, ts='2011-11-03 09:00:00' WHERE test_id=66 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=66
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=63
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=63
2012-05-24 17:26:20	UPDATE `test` SET result='100 mg#dl,05a0d2a91f7b6fb042fdbcc382a910f861cf2a8b', comments='', user_id=60, ts='2011-11-22 05:00:00' WHERE test_id=144 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=144
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=131
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=131
2012-05-24 17:26:20	UPDATE `test` SET result='Trichomonas vaginalis Absent,Few,Few,Moderate,Moderate,Rare,Moderate,Few,Moderate,Moderate,Rare,Type V,9bbf8f0c2060ba3b0988d7111969445d967f99f3', comments='', user_id=60, ts='2011-11-23 11:00:00' WHERE test_id=13 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=13
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=13
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=13
2012-05-24 17:26:20	UPDATE `test` SET result='Negative,a1291bea0ea8403d2811904a2add63180319ac75', comments='', user_id=61, ts='2011-11-23 05:00:00' WHERE test_id=121 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=121
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=109
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=109
2012-05-24 17:26:20	UPDATE `test` SET result='NO,77c5709c38b5b17a33d90fdec48611606f9be953', comments='', user_id=60, ts='2011-11-30 08:00:00' WHERE test_id=120 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=120
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=108
2012-05-24 17:26:20	UPDATE specimen SET date_reported='2012-05-24 17:26:20' WHERE specimen_id=108
2012-05-24 17:26:20	UPDATE `test` SET result='Whitish,,,Few,Rare,Few,0,Neutrophils,Positive,0,0,0,35908f7720ad1f1d18e6e429876d41e605373566', comments='', user_id=61, ts='2011-11-30 01:00:00' WHERE test_id=195 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=195
2012-05-24 17:26:20	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=178
2012-05-24 17:26:20	UPDATE `test` SET result='Colourless,,,Few,Rare,Moderate,0,Basophils,Positive,0,0,0,9dc2422cd49dc59ac21278a0c2009e07c5a87f06', comments='', user_id=60, ts='2011-12-04 11:00:00' WHERE test_id=165 
2012-05-24 17:26:20	UPDATE test SET verified_by=2 WHERE test_id=165
2012-05-24 17:26:21	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=150
2012-05-24 17:26:21	UPDATE specimen SET date_reported='2012-05-24 17:26:21' WHERE specimen_id=150
2012-05-24 17:26:21	UPDATE `test` SET result='0,2740bcf71e160a69df82b30344e186ebd60071cd', comments='', user_id=61, ts='2011-12-24 10:00:00' WHERE test_id=216 
2012-05-24 17:26:21	UPDATE test SET verified_by=2 WHERE test_id=216
2012-05-24 17:26:21	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=196
2012-05-24 17:26:21	UPDATE specimen SET date_reported='2012-05-24 17:26:21' WHERE specimen_id=196
2012-05-24 17:26:21	UPDATE `test` SET result='N,62b94b0e454455d55570db8f8e4f76319d2e8570', comments='', user_id=60, ts='2011-12-25 07:00:00' WHERE test_id=25 
2012-05-24 17:26:21	UPDATE test SET verified_by=2 WHERE test_id=25
2012-05-24 17:26:21	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=24
2012-05-24 17:26:21	UPDATE specimen SET date_reported='2012-05-24 17:26:21' WHERE specimen_id=24
2012-05-24 17:26:21	UPDATE `test` SET result='P,032f5f1eb0d487807eadf013e504d08538e77ad2', comments='', user_id=60, ts='2011-12-29 01:00:00' WHERE test_id=41 
2012-05-24 17:26:21	UPDATE test SET verified_by=2 WHERE test_id=41
2012-05-24 17:26:21	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=39
2012-05-24 17:26:21	UPDATE `test` SET result='0,4e67b329641154ad34a8d36f7e7e382d19e9cdda', comments='', user_id=60, ts='2012-01-06 04:00:00' WHERE test_id=95 
2012-05-24 17:26:21	UPDATE test SET verified_by=2 WHERE test_id=95
2012-05-24 17:26:21	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=86
2012-05-24 17:26:21	UPDATE specimen SET date_reported='2012-05-24 17:26:21' WHERE specimen_id=86
2012-05-24 17:26:22	UPDATE `test` SET result='0,22cd8599e3a103a3f7422e43eefef462256d83e2', comments='', user_id=61, ts='2012-01-09 06:00:00' WHERE test_id=117 
2012-05-24 17:26:22	UPDATE test SET verified_by=2 WHERE test_id=117
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=105
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=105
2012-05-24 17:26:22	UPDATE `test` SET result='NO,34500e62856a946eafa05893ccc5bfb0dc58eec0', comments='', user_id=60, ts='2012-01-09 11:00:00' WHERE test_id=173 
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=158
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=158
2012-05-24 17:26:22	UPDATE `test` SET result='Negative,a98cbdd1e715b965496240474eb44f1468fd94ff', comments='', user_id=60, ts='2012-01-13 03:00:00' WHERE test_id=40 
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=38
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=38
2012-05-24 17:26:22	UPDATE `test` SET result='Colourless,,,Few,Rare,Absent,0,Lymphocytes,Positive,0,0,0,d989ab133368d09b388858fece4a37081629e97b', comments='', user_id=60, ts='2012-01-14 05:00:00' WHERE test_id=26 
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=25
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=25
2012-05-24 17:26:22	UPDATE `test` SET result='Negative,0994055fc14010b702d4451eb688979ecb8fd17a', comments='', user_id=60, ts='2012-01-22 05:00:00' WHERE test_id=182 
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=166
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=166
2012-05-24 17:26:22	UPDATE `test` SET result='Colourless,,,Absent,Absent,Many,0,Basophils,Positive,0,0,0,dede1f63511bc168f4dc9be512d613cf2e8b0a2c', comments='', user_id=61, ts='2012-01-25 06:00:00' WHERE test_id=190 
2012-05-24 17:26:22	UPDATE test SET verified_by=2 WHERE test_id=190
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=173
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=173
2012-05-24 17:26:22	UPDATE `test` SET result='AAFB seen,03221c0e1a03e8d9cc3330d8c6d0f9c7a5519c48', comments='', user_id=61, ts='2012-01-26 10:00:00' WHERE test_id=89 
2012-05-24 17:26:22	UPDATE test SET verified_by=2 WHERE test_id=89
2012-05-24 17:26:22	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=80
2012-05-24 17:26:22	UPDATE specimen SET date_reported='2012-05-24 17:26:22' WHERE specimen_id=80
2012-05-24 17:26:55	INSERT INTO user_rating (user_id, rating, comments) VALUES (26, 3, '')
2012-05-24 17:32:00	INSERT INTO user_rating (user_id, rating, comments) VALUES (26, 3, '')
2012-05-24 17:34:14	INSERT INTO user_rating (user_id, rating, comments) VALUES (26, 3, '')
2012-05-24 17:36:24	INSERT INTO user_rating (user_id, rating, comments) VALUES (116, 3, '')
2012-05-24 17:39:36	INSERT INTO user_rating (user_id, rating, comments) VALUES (26, 3, '')
2012-05-24 17:40:28	INSERT INTO user_rating (user_id, rating, comments) VALUES (116, 3, '')
2012-07-12 20:15:23	INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, landscape ) VALUES ('Grouped Test Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', '1', '1', '1', '1', '0', '9999009' , '0', 9999009)
2012-07-12 20:15:23	INSERT INTO report_config (header, footer, margins, p_fields, s_fields, t_fields, p_custom_fields, s_custom_fields, test_type_id, title, landscape ) VALUES ('Grouped Specimen Count Report Configuration', '0:4,4:9,9:14,14:19,19:24,24:29,29:34,34:39,39:44,44:49,49:54,54:59,59:64,64:+', '0', '1', '1', '1', '1', '0', '9999019' , '0', 9999019)
2012-07-12 20:16:51	INSERT INTO user_rating (user_id, rating, comments) VALUES (116, 3, '')
