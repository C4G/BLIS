<?php
#
# Exports the given HTML content as word document
#
include("../includes/db_lib.php");
require_once(__DIR__."/word_export_lib.php");
putUILog('export_word_aggregate', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$report_type = isset($_REQUEST['report_type']) ? $_REQUEST['report_type'] : '';
$safe_report_type = blis_word_sanitize_filename_segment($report_type);
$html_payload = isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
$html_content = blis_word_normalize_html_fragment($html_payload);

$file_prefix = "blisreport";
if($safe_report_type !== '')
{
	$file_prefix .= "_".$safe_report_type;
}

$exported = blis_word_export_docx($html_content, $file_prefix);
if($exported === false)
{
	# Keep backward compatibility if pandoc is unavailable.
	blis_word_send_legacy_doc($html_content, $file_prefix);
}
