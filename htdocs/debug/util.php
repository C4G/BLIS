<?

require_once(__DIR__."/../includes/composer.php");

require_once(__DIR__."/../includes/db_lib.php");
require_once(__DIR__."/../includes/user_lib.php");

function require_admin_or_401() {
    $current_user_id = $_SESSION['user_id'];
    $current_user = get_user_by_id($current_user_id);

    $unauthorized = true;

    if (is_super_admin($current_user) || is_country_dir($current_user)) {
        $unauthorized = false;
    }

    if ($unauthorized) {
        header('HTTP/1.1 401 Unauthorized', true, 401);
        echo "You do not have permission to view this page.";
        exit;
    }
}

function available_log_files() {
    global $log;

    $log_files = array();

    $application_log = __DIR__."/../../log/application.log";
    if (file_exists($application_log)) {
        $log_files["application.log"] = $application_log;
    }

    $database_log = __DIR__."/../../log/database.log";
    if (file_exists($database_log)) {
        $log_files["database.log"] = $database_log;
    }

    $php_error_log = __DIR__."/../../log/php_error.log";
    if (file_exists($php_error_log)) {
        $log_files["php_error.log"] = $php_error_log;
    }

    $apache2_local_error = __DIR__."/../../log/apache2_error.log";
    if (file_exists($apache2_local_error)) {
        $log_files["apache2_error.log"] = $apache2_local_error;
    }

    $apache2_local_access = __DIR__."/../../log/apache2_access.log";
    if (file_exists($apache2_local_access)) {
        $log_files["apache2_access.log"] = $apache2_local_access;
    }

    $apache2_docker_error = "/var/log/apache2/error.log";
    if (file_exists($apache2_docker_error)) {
        $log->error("it do exist");
        $log_files["apache2_var_log_error.log"] = $apache2_docker_error;
    }

    $apache2_docker_access = "/var/log/apache2/access.log";
    if (file_exists($apache2_docker_access)) {
        $log_files["apache2_var_log_access.log"] = $apache2_docker_access;
    }

    return $log_files;
}

function list_files_like($directory, $pattern) {
    $listing = scandir($directory);
    $results = array();

    if (!$listing) {
        return $results;
    }

    foreach($listing as $filename) {
        $matches = null;
        if (preg_match($pattern, $filename, $matches) == 1) {
            array_push($results, $filename);
        }
    }

    return $results;
}
