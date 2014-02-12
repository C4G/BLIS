<?php
#
# Enables redirect via .htaccess by appending root to PATH
#
$path = "../";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
?>