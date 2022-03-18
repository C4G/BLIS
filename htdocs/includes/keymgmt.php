<?php

require_once(dirname(__FILE__).'/../../htdocs/includes/db_lib.php');

class KeyMgmt
{
    public $ID;
    public $LabName;
    public $PubKey;
    public $AddedBy;
    public $ModOn;

    public static function read_enc_setting()
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_config = "SELECT max(enc_enabled) as enc_enabled from encryption_setting";
        $record = query_associative_one($query_config);
        DbUtil::switchRestore($saved_db);
        return $record['enc_enabled'];
    }

    public static function write_enc_setting($val)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_config = "update encryption_setting set enc_enabled=".$val;
        query_blind($query_config);
        DbUtil::switchRestore($saved_db);
    }

    public static function getByLabName($labName)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_config = "SELECT * FROM keymgmt WHERE lab_name ='$labName' LIMIT 1";
        $record = query_associative_one($query_config);
        DbUtil::switchRestore($saved_db);
        return KeyMgmt::getObject($record);
    }

    public static function getById($keyID)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_config = "SELECT * FROM keymgmt WHERE id =$keyID  LIMIT 1";
        $record = query_associative_one($query_config);
        DbUtil::switchRestore($saved_db);
        return KeyMgmt::getObject($record);
    }

    public static function getAllKeys()
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_configs = "SELECT id,'' as pub_key,lab_name,added_by,last_modified FROM keymgmt ORDER BY lab_name";
        $resultset = query_associative_all($query_configs);
        $retval = array();
        if ($resultset == null) {
            DbUtil::switchRestore($saved_db);
            return $retval;
        }
        foreach ($resultset as $record) {
            $r=KeyMgmt::getObject($record);
            $r->AddedBy=User::getByUserId($r->AddedBy)->username;
            $retval[] = $r;
        }
        DbUtil::switchRestore($saved_db);
        return $retval;
    }

    public static function create($lab_name, $key_text, $user_id) {
        $key = new KeyMgmt();
        $key->LabName = $lab_name;
        $key->PubKey = $key_text;
        $key->AddedBy = $user_id;
        return $key;
    }

    public static function add_key_mgmt($keyMgmt)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_check = "SELECT count(*) as cnt from keymgmt where lab_name='".$keyMgmt->LabName."'";
        $record = query_associative_one($query_check);
        if ($record['cnt']!=0) {
            return "Key For This Lab Already Exists";
        }
        $query="insert into keymgmt(lab_name,pub_key,added_by,last_modified) values('";
        $query=$query.$keyMgmt->LabName."','".$keyMgmt->PubKey."',".$keyMgmt->AddedBy.",now())";
        query_insert_one($query);
        DbUtil::switchRestore($saved_db);
        return "Key added successfully";
    }

    public static function update_key_mgmt($keyMgmt)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query_check = "SELECT count(*) as cnt from keymgmt where id=".$keyMgmt->ID;
        $record = query_associative_one($query_check);
        if ($record['cnt']<1) {
            return "Lab " . $keyMgmt->ID . " does not exist.";
        }
        $query="update keymgmt set lab_name='";
        $query=$query.$keyMgmt->LabName."',pub_key='".$keyMgmt->PubKey."',added_by=".$keyMgmt->AddedBy.",last_modified=now() where id=".$keyMgmt->ID;
        query_blind($query);
        DbUtil::switchRestore($saved_db);
        return "Key updated successfully.";
    }

    public static function delete_key_mgmt($keyID)
    {
        $saved_db = DbUtil::switchToGlobal();
        $query="delete from keymgmt where id=".$keyID;
        query_blind($query);
        DbUtil::switchRestore($saved_db);
        return "Key deleted successfully.";
    }

    private static function getObject($record)
    {
        if ($record == null) {
            return null;
        }
        $keyMgmt=new KeyMgmt();
        if (isset($record['id'])) {
            $keyMgmt->ID=$record['id'];
            $keyMgmt->LabName=$record['lab_name'];
            $keyMgmt->PubKey=$record['pub_key'];
            $keyMgmt->AddedBy=$record['added_by'];
            $keyMgmt->ModOn=$record['last_modified'];
            return $keyMgmt;
        }
        return null;
    }
}
