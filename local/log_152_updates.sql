USE blis_152;

update patient_daily set count=4 where datestring='20111215' ;
UPDATE specimen_session SET count=4 WHERE session_num='20111215';
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
			5, 
			2, 
			23, 
			'2011-12-15', 
			'2011-12-15', 
			339, 
			0, 
			0, 
			'', 
			'', 
			'20111215-4', 
			'09:05', 
			1, 
			'', 
			'', 
			'20111215-4'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			24,  
			5, 
			'', 
			'', 
			0, 
			339 );
COMMIT;
UPDATE test SET result='P,N,P,N,P,N,P,N,P,N,P,,0fad57264dbc0378ff92349beaf906cc027c521a', comments='', user_id=339, ts='2011-12-15 09:06:28' WHERE test_id=5 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=5;
INSERT INTO user_rating (user_id, rating) VALUES (339, 6);
UPDATE report_config SET header='Patient Report??left', footer='#', title='', margins='2,0,10,0', landscape=0, p_fields='1,1,1,1,0,1,0,0', s_fields='1,1,1,1,1,1,0', t_fields='1,1,1,1,1,0,1,1,0', p_custom_fields='', s_custom_fields='' WHERE report_id=1;
INSERT INTO measure(name, range, unit) VALUES ('Measure1', ':', 'gm/dl');
INSERT INTO measure(name, range, unit) VALUES ('Measure2', ':', '');
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (14, 15);
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (14, 16);
UPDATE test_type SET name='Mg2+', description='magnesium', clinical_data='', test_category_id='3', hide_patient_name='0' WHERE test_type_id=14;
INSERT INTO specimen_test (specimen_type_id, test_type_id) VALUES (11, 14);
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (15, '0', '100', 'B', '1', '20');
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (15, '0', '100', 'B', '50', '70');
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (16, '0', '100', 'M', '1', '100');
INSERT INTO patient_daily (datestring, count) VALUES ('20111216', 1);
INSERT INTO specimen_session(session_num, count) VALUES ('20111216', 1);
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (3, '', 'Dec16test2', 0, 'M', '2009-12', '', 339, 'f83af87acb07257c8d7c11cfb4b62e5d93aed191', '2011-12-16 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 3, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 3, 'abcdefghijklmnopqr');
UPDATE specimen_type SET name='Urine', description='' WHERE specimen_type_id=11;
DELETE from specimen_test WHERE test_type_id=56 AND specimen_type_id=11;
update patient_daily set count=2 where datestring='20111216' ;
UPDATE specimen_session SET count=2 WHERE session_num='20111216';
UPDATE measure SET name='Testing', range='Positive_Negative', unit='' WHERE measure_id=3;
UPDATE test_type SET name='Urine Analysis', description='', clinical_data='', test_category_id='5', hide_patient_name='0' WHERE test_type_id=56;
INSERT INTO specimen_test (specimen_type_id, test_type_id) VALUES (11, 56);
update patient_daily set count=3 where datestring='20111216' ;
UPDATE specimen_session SET count=3 WHERE session_num='20111216';
UPDATE specimen_type SET name='Urine', description='' WHERE specimen_type_id=11;
INSERT INTO specimen_test (specimen_type_id, test_type_id) VALUES (11, 38);
update patient_daily set count=4 where datestring='20111216' ;
UPDATE specimen_session SET count=4 WHERE session_num='20111216';
INSERT INTO measure(name, range, unit) VALUES ('Measure1', ':', 'gm/dl');
INSERT INTO measure(name, range, unit) VALUES ('Measure2', ':', 'gm/dl');
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (38, 17);
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (38, 18);
UPDATE test_type SET name='MP', description='MALARIA PARASITE', clinical_data='', test_category_id='5', hide_patient_name='0' WHERE test_type_id=38;
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (17, '0', '100', 'B', '1', '100');
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (18, '0', '100', 'B', '1', '50');
update patient_daily set count=5 where datestring='20111216' ;
UPDATE specimen_session SET count=5 WHERE session_num='20111216';
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
			6, 
			3, 
			11, 
			'2011-12-16', 
			'2011-12-16', 
			339, 
			0, 
			0, 
			'', 
			'', 
			'20111216-5', 
			'08:37', 
			1, 
			'', 
			'', 
			'20111216-5'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			38,  
			6, 
			'', 
			'', 
			0, 
			339 );
COMMIT;
UPDATE test SET result='50,20,,f83af87acb07257c8d7c11cfb4b62e5d93aed191', comments='', user_id=339, ts='2011-12-16 08:38:19' WHERE test_id=6 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=6;
DELETE FROM reference_range WHERE measure_id=17;
UPDATE measure SET name='Measure1', range=':', unit='gm/dl' WHERE measure_id=17;
DELETE FROM reference_range WHERE measure_id=18;
UPDATE measure SET name='Measure2', range=':', unit='gm/dl' WHERE measure_id=18;
INSERT INTO measure(name, range, unit) VALUES ('Measure3', 'A/B', 'gm/dl');
INSERT INTO measure(name, range, unit) VALUES ('Measure4', 'Lol1_Lol2', '');
INSERT INTO measure(name, range, unit) VALUES ('Measure5', '20/30', '');
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (38, 19);
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (38, 20);
INSERT INTO test_type_measure(test_type_id, measure_id) VALUES (38, 21);
UPDATE test_type SET name='MP', description='MALARIA PARASITE', clinical_data='', test_category_id='5', hide_patient_name='0' WHERE test_type_id=38;
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (17, '0', '100', 'B', '1', '100');
INSERT INTO reference_range (measure_id, age_min, age_max, sex, range_lower, range_upper) VALUES (18, '0', '100', 'B', '1', '50');
update patient_daily set count=6 where datestring='20111216' ;
UPDATE specimen_session SET count=6 WHERE session_num='20111216';
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (4, '', 'Dec16test3', 0, 'M', '2008-12', '', 339, '4ba50650615151770fe70a8c1a49e230e810a286', '2011-12-16 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 4, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 4, 'abcdefghijklmnopqrstuvwxyz');
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
			7, 
			4, 
			11, 
			'2011-12-16', 
			'2011-12-16', 
			339, 
			0, 
			0, 
			'', 
			'', 
			'20111216-6', 
			'08:55', 
			1, 
			'', 
			'', 
			'20111216-6'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			38,  
			7, 
			'', 
			'', 
			0, 
			339 );
COMMIT;
UPDATE test SET result='50,60,B,Lol2,30,,4ba50650615151770fe70a8c1a49e230e810a286', comments='Measure3:B, Measure5:30', user_id=339, ts='2011-12-16 08:56:30' WHERE test_id=7 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=7;
update patient_daily set count=7 where datestring='20111216' ;
UPDATE specimen_session SET count=7 WHERE session_num='20111216';
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
			8, 
			4, 
			11, 
			'2011-12-16', 
			'2011-12-16', 
			339, 
			0, 
			0, 
			'', 
			'', 
			'20111216-7', 
			'13:15', 
			1, 
			'', 
			'', 
			'20111216-7'
		);
INSERT INTO test (
			test_type_id, 
			specimen_id, 
			result, 
			comments,
			verified_by,
			user_id ) 
		VALUES (
			56,  
			8, 
			'', 
			'', 
			0, 
			339 );
COMMIT;
UPDATE test SET result='Positive,,4ba50650615151770fe70a8c1a49e230e810a286', comments='', user_id=339, ts='2011-12-16 13:16:21' WHERE test_id=8 ;
UPDATE specimen SET status_code_id=1 WHERE specimen_id=8;
UPDATE report_config SET header='Patient Report??left', footer='#', title='', margins='2,0,10,0', landscape=0, p_fields='0,1,0,0,0,0,0,0', s_fields='1,1,1,0,0,0,0', t_fields='1,1,1,1,1,0,1,1,0', p_custom_fields='', s_custom_fields='' WHERE report_id=1;
INSERT INTO user_rating (user_id, rating) VALUES (339, 6);
INSERT INTO patient_daily (datestring, count) VALUES ('20111219', 1);
INSERT INTO specimen_session(session_num, count) VALUES ('20111219', 1);
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (5, '', 'Dec19test1', 0, 'M', '1999-12', '', 339, 'ef66d331ce7292f4b16d5654f969fc73de4f2587', '2011-12-19 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 5, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 5, 'abcdefghijklmnopqrstuvwxyz');
update patient_daily set count=2 where datestring='20111219' ;
UPDATE specimen_session SET count=2 WHERE session_num='20111219';
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (6, '', 'Dec19test2', 0, 'M', '2009-12', '', 339, 'e6b88a87650856605b509388748249e261533784', '2011-12-19 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 6, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 6, 'abcdefghijklmnopqrstuvwxyz');
update patient_daily set count=3 where datestring='20111219' ;
UPDATE specimen_session SET count=3 WHERE session_num='20111219';
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (7, '', 'Dec19test3', 0, 'M', '2010-12', '', 339, 'cec2a450a53f9ea86c8e02a9bfa1cc8e6371b806', '2011-12-19 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 7, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 7, 'abcdefghijklmnopqrstuvwxyz');
update patient_daily set count=4 where datestring='20111219' ;
UPDATE specimen_session SET count=4 WHERE session_num='20111219';
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (8, '', 'Dec19test4', 0, 'M', '2007-12-19', '', 339, '80881c2b71a8f8f5900b5461454c1518c3ad4ed5', '2011-12-19 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 8, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 8, 'abcdefghijklmnopqrstuvwxyz');
update patient_daily set count=5 where datestring='20111219' ;
UPDATE specimen_session SET count=5 WHERE session_num='20111219';
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (9, '', 'Dec19test5', 0, 'M', '2011-07-19', '', 339, '15ff9ae850a9eaf2f594db20917eae6e930aec76', '2011-12-19 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 9, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 9, 'abcdefghijklmnopqrstuvwxyz');
update patient_daily set count=6 where datestring='20111219' ;
UPDATE specimen_session SET count=6 WHERE session_num='20111219';
INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (10, '', 'Dec19test6', 0, 'M', '2011-11-07', '', 339, '4eded461caa3786e9ea31b8724688d04e5b54e24', '2011-12-19 00:00:00');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (1, 10, '');
INSERT INTO patient_custom_data (field_id, patient_id, field_value) VALUES (4, 10, 'abcdefghijklmnopqrstuvwxyz');
INSERT INTO user_rating (user_id, rating) VALUES (339, 6);
INSERT INTO user_rating (user_id, rating) VALUES (339, 6);
INSERT INTO user_rating (user_id, rating) VALUES (339, 6);
UPDATE test SET result='No MP,e91d2cb3e9559f391819335485cabc92276c4a0c', comments='', user_id=341, ts='2012-03-01 09:21:24' WHERE test_id=6036 ;
UPDATE test SET result='MP,58d1b49eedabd275cc380cc0ee6c2468c1fc80e8', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=6131 ;
UPDATE test SET result='MP,b13b110525b88824087f4d223547cf339334eb74', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=6525 ;
UPDATE test SET result='MP,b24095688e1e4405d9d5c115b9a621b6d0279c44', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=6973 ;
UPDATE test SET result='MP,0d06498b5ee5b2cad30b640f5a1d1dc7bc2b3e6e', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=7394 ;
UPDATE test SET result='MP,4f861de552c79abb3d35fabd40e33c55c8b1c40e', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=7752 ;
UPDATE test SET result='MP,ce0639b6e23314cfc899f88bf25938b4e2993c05', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=8205 ;
UPDATE test SET result='MP,461324c6f8e7618c3cb253d7dfd735881ef0654b', comments='', user_id=341, ts='2012-03-01 09:21:25' WHERE test_id=8210 ;
INSERT INTO user_rating (user_id, rating) VALUES (341, 6);
INSERT INTO user_rating (user_id, rating) VALUES (339, 6);
