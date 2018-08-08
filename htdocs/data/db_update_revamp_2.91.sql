create table IF NOT EXISTS `user_config`(
user_id int,
    level int, 
    parameter varchar(256), 
    value varchar(256), 
    created_by varchar(256), 
    created_on date, 
    modified_by varchar(256), 
    modified_on date,
    primary key(user_id, parameter)
);

insert into user_config select user_id, level, 'rwoptions', rwoptions, 'Aishwarya', curdate(), 'Aishwarya',curdate() from user;

create table IF NOT EXISTS `user_type`(
level int primary key AUTO_INCREMENT, 
    name varchar(256), 
    defaultdisplay boolean default 0,
    created_by varchar(256),     
    created_on timestamp DEFAULT CURRENT_TIMESTAMP
);


insert into user_type(name, defaultdisplay, created_by) values('LIS_TECH_RO',1,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_ADMIN',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_SUPERADMIN',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_COUNTRYDIR',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_CLERK',1,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_001',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_010',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_011',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_100',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_101',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_110',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_111',0,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_TECH_SHOWPNAME',1,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_TECH_RW',1,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_VERIFIER',1,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('READONLYMODE',1,'Aishwarya');
insert into user_type(name, defaultdisplay, created_by)  values('LIS_PHYSICIAN',1,'Aishwarya');

create table IF NOT EXISTS `user_type_config`(
    level int,
    parameter varchar(256), 
    value varchar(256), 
    created_by varchar(256), 
    created_on date, 
    modified_by varchar(256), 
    modified_on timestamp DEFAULT CURRENT_TIMESTAMP,
    primary key(level, parameter)
);


insert into user_type_config(level, parameter, value, created_by, modified_by) values (1,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (2,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (3,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (4,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (5,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (6,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (7,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (8,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (9,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (10,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (11,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (12,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (13,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (14,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (15,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (16,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');
insert into user_type_config(level, parameter, value, created_by, modified_by) values (17,'rwoptions', '2,3,4,6,7', 'Aishwarya', 'Aishwarya');

