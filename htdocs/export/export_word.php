<?php
#
# Exports the given HTML content as word document
#
require_once("../includes/db_lib.php");
require_once(__DIR__."/word_export_lib.php");
putUILog('export_word', 'X', basename($_SERVER['REQUEST_URI'], ".php"), 'X', 'X', 'X');

$id = isset($_REQUEST['lab_id']) ? intval($_REQUEST['lab_id']) : 0;
$html_payload = isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
$html_content = blis_word_normalize_html_fragment($html_payload);

if($id > 0)
{
	$logo_file = __DIR__."/../logos/logo_".$id.".jpg";
	if(is_file($logo_file))
	{
		# Pandoc handles local filesystem image references from HTML.
		$html_content = "<img src=\"".$logo_file."\" height=\"140\" width=\"140\" />\n".$html_content;
	}
}

$exported = blis_word_export_docx($html_content, "blisreport");
if($exported === false)
{
	# Keep backward compatibility if pandoc is unavailable.
	blis_word_send_legacy_doc($html_content, "blisreport");
}
