<?php

require_once(__DIR__."/composer.php");
require_once(__DIR__."/db_mysql_lib.php");

class MigrationException extends Exception { }

class LabDatabaseMigrator {
    private $lab_db_name;
    private $migration_type;
    private $migration_directory;

    function __construct($lab_db_name, $migration_type="lab") {
        $root_migration_directory = __DIR__."/../../db/migrations/";

        $this->lab_db_name = $lab_db_name;
        if ($migration_type != "lab" && $migration_type != "revamp") {
            throw new MigrationException("$migration_type is not a valid migration type.");
        }
        $this->migration_type = $migration_type;
        $this->migration_directory = $root_migration_directory . $migration_type . "/";
    }

    public function pending_migrations() {
        $available = $this->get_available_migrations();
        $applied = $this->get_applied_migrations();

        $diff = array_diff($available, $applied);

        return $diff;
    }

    public function has_pending_migrations() {
        return count($this->pending_migrations()) > 0;
    }

    public function insert_migration($migration_name) {
        query_insert_one("INSERT INTO blis_migrations (`name`) VALUES('$migration_name');");
    }

    public function delete_migration($migration_name) {
        query_delete("DELETE FROM blis_migrations WHERE `name` = '$migration_name';");
    }

    public function apply_migration($migration_name) {
        global $log;

        $filepath = $this->migration_directory . "/$migration_name";

        $result = null;

        if ($migration_name == "20240815195015_add_all_columns_and_keys.sql") {
            $log->info("First migration detected. Welcome to the new BLIS!");
            $migration_file = file_get_contents($filepath);
            $migration_lines = explode("\n", $migration_file);
            $result = $this->execute_sql_lines_and_ignore_errors($migration_lines);
        } else {
            $result = $this->execute_sql($filepath);
        }

        if ($result == true) {
            $this->insert_migration($migration_name);
            $log->info("Applied migration to " . $this->lab_db_name . ": $migration_name");
        } else {
            $log->error("Failed to apply migration: $migration_name");
            return false;
        }

        return true;
    }

    public function apply_migrations() {
        global $log;

        db_change($this->lab_db_name);

        $pending_migrations = $this->pending_migrations();

        foreach($pending_migrations as $migration) {
            $result = $this->apply_migration($migration);
            if (!$result) {
                return false;
            }
        }

        return true;
    }

    private function execute_sql($sql_file_path) {
        global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS, $log;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $target_conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $this->lab_db_name, $DB_PORT);
        $log->info("Connected to " . $this->lab_db_name);
        $log->info("Executing " . $sql_file_path);

        try {
            $migration_file = file_get_contents($sql_file_path);

            $target_conn->multi_query($migration_file);
            do {
                // Need to page through the results of the execution above so we can continue
                $result = $target_conn->store_result();
            } while ($target_conn->next_result());
        } catch (Exception $e) {
            $log->error("Exception occurred: " . $e->getMessage());
            $target_conn->close();
            return false;
        }

        $target_conn->close();
        return true;
    }

    /**
     * This is a special function made for executing a sequence of SQL statements where it doesn't
     * really matter if they all succeed.
     * This was written to support a big migration file that adds new columns to existing databases.
     * This really shouldn't be used elsewhere without a good reason.
     */
    private function execute_sql_lines_and_ignore_errors($sql_lines) {
        global $DB_HOST, $DB_PORT, $DB_USER, $DB_PASS, $log;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $target_conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $this->lab_db_name, $DB_PORT);
        $log->info("Connected to " . $this->lab_db_name);
        $log->info("Executing SQL lines with no regard for errors...");

        foreach($sql_lines as $line) {
            if($line == "") {
                continue;
            }

            try {
                $target_conn->query($line);
                echo("Executed: " . $line . "\n");
            } catch (Exception $e) {
                // Silent fail - we don't care about what didn't get executed
                // This means the column already existed, etc.
            }
        }

        $target_conn->close();

        return true;
    }

    public function get_available_migrations() {
        $migrations = array();
        foreach(scandir($this->migration_directory) as $dir) {
            if ($dir == "." || $dir == "..") {
                continue;
            } else {
                array_push($migrations, $dir);
            }
        }
        return $migrations;
    }

    public function get_applied_migrations() {
        global $log;

        db_change($this->lab_db_name);

        $query = "SELECT name FROM blis_migrations ORDER BY name ASC;";

        $results = query_associative_all($query);

        if (!$results) {
            $log->warning("Error querying migrations for database " . $this->lab_db_name);
            return array();
        }

        $migrations = array();
        foreach($results as $result) {
            array_push($migrations, $result['name']);
        }

        return $migrations;
    }
}
