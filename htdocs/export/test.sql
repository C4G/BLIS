USE blis_129;

2012-04-11 22:38:57	update patient_daily set count=10 where datestring='20120411' 
2012-04-11 22:38:57	UPDATE specimen_session SET count=10 WHERE session_num='20120411'
2012-04-11 22:39:02	INSERT INTO `patient`(`patient_id`, `addl_id`, `name`, `age`, `sex`, `partial_dob`, `surr_id`, `created_by`, `hash_value`,`ts`) VALUES (29257, '', 'April11 Test12', 0, 'M', '2000-04-11', '10', 116, 'ce75078ffc068a65f683989c401a6ba4f558cd4d', '2012-04-11 00:00:00')
2012-04-11 22:39:07	BEGIN
2012-04-11 22:39:07	INSERT INTO `specimen` ( specimen_id, patient_id, specimen_type_id, date_collected, date_recvd, user_id, status_code_id, referred_to, comments, aux_id, session_num, time_collected, report_to, doctor, referred_to_name, daily_num ) VALUES ( 61713, 29257, 23, '2012-04-11', '2012-04-11', 116, 0, 0, '', '', '20120411-10', '22:39', 1, '', '', '20120411-10' )
2012-04-11 22:39:07	INSERT INTO `test` ( test_id, specimen_id, test_type_id, result, comments, verified_by, user_id ) VALUES ( 66820, 61713, 84, '', '', 0, 116 )
2012-04-11 22:39:07	COMMIT
2012-04-11 22:39:13	UPDATE `test` SET result='150,,ce75078ffc068a65f683989c401a6ba4f558cd4d', comments='', user_id=116, ts='2012-04-11 22:39:13' WHERE test_id=66820
2012-04-11 22:39:13	UPDATE `specimen` SET status_code_id=1 WHERE specimen_id=61713