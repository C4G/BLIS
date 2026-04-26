<?php
#
# PASSWORD HASHING MODULE
# Drop-in replacement for the password functions in db_lib.php
#
# Changes from original:
#   - encrypt_password()        kept for backwards compatibility (legacy SHA-1)
#   - encrypt_password_v2()     new: SHA-256 with unique per-user random salt
#   - check_user_password()     tries new method first, falls back to legacy,
#                               upgrades password on successful legacy login
#   - change_user_password()    now always writes the new secure hash + salt
#   - generate_salt()           new helper
#

/**
 * LEGACY: Original SHA-1 with hardcoded global salt.
 * Kept so we can still verify old passwords during the upgrade window.
 */
function encrypt_password($password)
{
    $salt = "This comment should suffice as salt.";
    return sha1($password . $salt);
}

/**
 * NEW: SHA-256 with a unique per-user random salt.
 * The salt must be stored in the user row alongside the hash.
 */
function generate_salt()
{
    return bin2hex(random_bytes(32)); // 64-character hex string
}

function encrypt_password_v2($password, $salt)
{
    return hash('sha256', $password . $salt);
}

/**
 * Checks username and password.
 *
 * Strategy:
 *   1. If the user row has a salt, try the new SHA-256 method.
 *   2. If no salt (or new method fails), try the legacy SHA-1 method.
 *   3. If legacy succeeds, silently upgrade the stored password to the new method.
 *   4. Return the User object on success, null on failure.
 *
 * This means existing users log in normally on first use and are
 * transparently upgraded. Old database backups continue to work.
 */
function check_user_password($username, $password)
{
    global $con;
    $username = mysqli_real_escape_string($con, $username);
    $saved_db = DbUtil::switchToGlobal();

    // Fetch the full user row so we can inspect the salt column
    $query_string =
        "SELECT * FROM user " .
        "WHERE username='$username' LIMIT 1";
    $record = query_associative_one($query_string);

    DbUtil::switchRestore($saved_db);

    if ($record === null) {
        return null; // username not found
    }

    $stored_hash = $record['password'];
    $stored_salt = $record['salt'] ?? null;

    // ── Try new method first (user has been upgraded already) ──
    if (!empty($stored_salt)) {
        $candidate = encrypt_password_v2($password, $stored_salt);
        if (hash_equals($stored_hash, $candidate)) {
            return User::getObject($record); // success
        }
        // Wrong password — do NOT fall through to legacy for security
        return null;
    }

    // ── Try legacy method (user not yet upgraded) ──
    $legacy_hash = encrypt_password($password);
    if (!hash_equals($stored_hash, $legacy_hash)) {
        return null; // wrong password
    }

    // ── Legacy succeeded: upgrade to new hash transparently ──
    _upgrade_password_to_v2($username, $password);

    return User::getObject($record);
}

/**
 * Internal: upgrades a user's stored password to the new scheme.
 * Called automatically after a successful legacy login.
 */
function _upgrade_password_to_v2($username, $cleartext_password)
{
    global $con;
    $username = mysqli_real_escape_string($con, $username);
    $saved_db = DbUtil::switchToGlobal();

    $new_salt = generate_salt();
    $new_hash = encrypt_password_v2($cleartext_password, $new_salt);

    $query_string =
        "UPDATE user " .
        "SET password='$new_hash', salt='$new_salt' " .
        "WHERE username='$username'";
    query_blind($query_string);

    DbUtil::switchRestore($saved_db);
}

/**
 * Changes a user's password.
 * Always writes the new secure SHA-256 hash with a fresh random salt.
 */
function change_user_password($username, $password)
{
    global $con;
    $username = mysqli_real_escape_string($con, $username);
    $saved_db = DbUtil::switchToGlobal();

    $new_salt = generate_salt();
    $new_hash = encrypt_password_v2($password, $new_salt);

    $query_string =
        "UPDATE user " .
        "SET password='$new_hash', salt='$new_salt' " .
        "WHERE username='$username'";
    query_blind($query_string);

    DbUtil::switchRestore($saved_db);
}

/**
 * One-time password change used during the password reset flow.
 * Also writes a MISC log entry (same as the original).
 */
function change_user_password_oneTime($username, $password)
{
    global $con;
    $username = mysqli_real_escape_string($con, $username);
    $saved_db = DbUtil::switchToGlobal();

    $new_salt = generate_salt();
    $new_hash = encrypt_password_v2($password, $new_salt);

    $query_string =
        "UPDATE user " .
        "SET password='$new_hash', salt='$new_salt' " .
        "WHERE username='$username'";
    query_blind($query_string);

    $query_string_misc =
        "INSERT INTO MISC " .
        "(username, action) values ('$username', 'password reset completed')";
    query_blind($query_string_misc);

    DbUtil::switchRestore($saved_db);
}

/**
 * Adds a new user account.
 * Uses the new hashing scheme from day one for newly created accounts.
 */
function add_user($user)
{
    global $con;
    if (!check_user_exists($user->username)) {
        $saved_db = DbUtil::switchToGlobal();

        $new_salt = generate_salt();
        $password = encrypt_password_v2($user->password, $new_salt);

        $rwoptions = $user->rwoptions;
        if ($user->level == 17) {
            $user->rwoptions = LabConfig::getDoctorUserOptions();
        }

        if ($user->level == 20) {
            $query_string = "SELECT MAX(satellite_lab_id) AS max_lab_id FROM user";
            $result = mysqli_query($con, $query_string);
            $row = mysqli_fetch_assoc($result);
            $new_satellite_lab_id = $row['max_lab_id'] + 1;
        } else {
            $new_satellite_lab_id = "NULL";
        }

        $query_string =
            "INSERT INTO user(username, password, salt, actualname, level, created_by, lab_config_id, email, phone, lang_id, rwoptions, satellite_lab_id, satellite_lab_name) " .
            "VALUES ('$user->username', '$password', '$new_salt', '$user->actualName', $user->level, $user->createdBy, '$user->labConfigId', '$user->email', '$user->phone', '$user->langId','$user->rwoptions', $new_satellite_lab_id, '$user->satelliteLabName')";
        query_insert_one($query_string);
        DbUtil::switchRestore($saved_db);

        $saved_db = DbUtil::switchToGlobal();
        $query_string = "SELECT user_id FROM user WHERE username='$user->username' LIMIT 1";
        $record = query_associative_one($query_string);
        $query_string =
            "INSERT INTO user_config(user_id, level, parameter, value, created_by, created_on, modified_by, modified_on) " .
            "VALUES ('" . $record['user_id'] . "',$user->level, 'rwoptions', '$rwoptions', $user->createdBy, curdate(), $user->createdBy, curdate())";
        query_insert_one($query_string);

        if ($user->level == 2) {
            add_lab_config_access($record['user_id'], $user->labConfigId);
        }
        DbUtil::switchRestore($saved_db);
        return true;
    }
    return false;
}
