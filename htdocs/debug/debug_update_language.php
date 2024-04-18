<?php

require_once(__DIR__."/util.php");

require_admin_or_401();

try {
    # This method is defined in db_lib.php.
    update_language_files();
    $_SESSION['DEBUG_FLASH'] = "Language files were reset successfully.";
} catch (Exception $e) {
    $_SESSION['DEBUG_FLASH'] = "Language files could not be updated: $e";
}

header("Location: /debug.php");
exit();