create table KeyMgmt(
id int auto_increment primary key,
lab_name varchar(200),
pub_key varchar(8000),
last_modified timestamp,
added_by int
);
create table encryption_setting(
enc_enabled int);
insert into encryption_setting(enc_enabled) values(0);