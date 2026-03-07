# Fix: Add Patient Not Working

## Problem

The "Add Patient" feature was returning no data and failing silently. After adding a patient, the app redirected to the specimen registration page which displayed:

```
Error: Patient ID 3034 Not Found.
```

## Root Causes

Two issues were stacked on top of each other:

### 1. Undefined variable in `htdocs/ajax/patient_add.php`

The file had this at the end:

```php
$patient_added = add_patient($patient);
echo json_encode($patient_data);  // $patient_data was never defined
```

`$patient_data` doesn't exist anywhere in the file. The `add_patient()` function in `db_lib.php` uses `print $query_string` to output the raw SQL, which the JavaScript in `new_patient.php` parses to extract the actual patient ID. The stray `echo json_encode($patient_data)` appended `null` to the response.

**Fix:** Removed the `echo json_encode($patient_data);` line.

### 2. Missing database columns (the real blocker)

The `add_patient()` function in `db_lib.php` builds an INSERT query that includes `satellite_lab_id` and `satellite_lab_name` columns. However, the `patient` table in the `blis_127` and `blis_12` databases did not have these columns.

The migration files existed:
- `db/migrations/lab/20250310000000_addsatellitelabidtopatient.sql`
- `db/migrations/lab/20250406000000_addsatellitelabnametopatient.sql`

But they had never been applied. The `blis_migrations` table didn't even exist in these databases, meaning no migrations had ever been run.

The INSERT would fail with `Unknown column 'satellite_lab_id'`, calling `die()` — but because `print $query_string` already output the SQL before the `die()`, the JavaScript parsed the patient ID from that output and redirected, never knowing the insert actually failed.

**Fix:** Applied the pending migrations to add the missing columns, and updated the Docker seed database dumps (`docker/database/`) so new developers get the correct schema out of the box.

## Fix 2: Specimen Registration Submit Button Missing

### Problem

The specimen registration page (`new_specimen.php`) was not rendering the submit button. The page would cut off partway through with no visible error (PHP `display_errors` is Off).

### Root Cause

Same migration pattern as the patient bug. The `user` table in `blis_revamp` was missing `satellite_lab_id` and `satellite_lab_name` columns. The function `get_user_by_id()` in `db_lib.php` queries `a.satellite_lab_name` from the user table. When the column didn't exist, the query failed, returning null.

This caused a chain of failures:
1. `get_user_by_id(53)` → null
2. `is_admin_check(null)` → tries `$user->level` on null → PHP notice, returns false
3. Falls into technician branch → `get_lab_config_by_id($user->labConfigId)` → null
4. `$lab_config->getSiteName()` → **PHP Fatal error** (call to member function on null)

The fatal error killed page rendering before the submit button HTML was output.

### Fix

Applied all pending migrations from `db/migrations/revamp/` to the `blis_revamp` database:
- Added `satellite_lab_id` and `satellite_lab_name` columns to `user` table
- Added `satellite_lab_name` user type
- Created `blis_cloud_connections` table
- Added cloud-related columns to `lab_config` table

Also applied remaining lab migrations (`blis_backups` table, `keys` table) to `blis_127` and `blis_12`.

## Files Changed

- `htdocs/ajax/patient_add.php` — removed undefined `$patient_data` echo
- `docker/database/dump-blis_12-202202091919.sql` — refreshed seed dump (all migrations applied)
- `docker/database/dump-blis_127-202202091919.sql` — refreshed seed dump (all migrations applied)
- `docker/database/dump-blis_revamp-20220704.sql` — refreshed seed dump (all migrations applied)

## How to Apply if You Have an Existing Database

If you already have a running database volume, the updated seed dumps won't take effect automatically. Either:

1. Wipe your database volume and recreate: `docker compose -f docker/dev/docker-compose.yml down -v` then `docker compose up`
2. Or run migrations via the BLIS update page at `/update/blis_update.php`
3. Or manually apply the SQL:

```sql
CREATE TABLE IF NOT EXISTS blis_migrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE patient ADD COLUMN satellite_lab_id int(11) DEFAULT NULL;
ALTER TABLE patient ADD COLUMN satellite_lab_name varchar(45) DEFAULT NULL;
```

## Debugging Notes

- The dev Apache error log lives at `/workspaces/BLIS/log/apache2_error.log` inside the container (not `/var/log/apache2/error.log` — that's the release config path)
- PHP `display_errors` is Off by default in `docker/config/php.ini`, so errors are only visible in the Apache error log
- The `db_lib.php` `add_patient()` function uses `print $query_string` to output raw SQL, which the JS client parses to extract the patient ID — a fragile pattern worth noting
