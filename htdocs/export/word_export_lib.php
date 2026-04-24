<?php
#
# Shared helpers to export posted HTML as a real .docx file.
#

function blis_word_normalize_html_fragment($html_fragment)
{
	if(!is_string($html_fragment))
	{
		return '';
	}

	# Some callers still pass slashed payloads.
	$normalized = stripcslashes($html_fragment);
	return str_replace("\0", '', $normalized);
}

function blis_word_sanitize_filename_segment($segment)
{
	$clean = preg_replace('/[^A-Za-z0-9_.-]/', '_', (string)$segment);
	if($clean === '' || $clean === null)
	{
		return 'blisreport';
	}
	return $clean;
}

function blis_word_send_legacy_doc($html_fragment, $file_prefix)
{
	$date = date('YmdHi');
	$file_name = blis_word_sanitize_filename_segment($file_prefix).'_'.$date.'.doc';
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename="'.$file_name.'"');
	$safe_html = blis_word_sanitize_legacy_html($html_fragment);
	echo "<!DOCTYPE html>\n<html><head><meta charset=\"UTF-8\"></head><body>";
	echo $safe_html;
	echo "</body></html>";
	exit;
}

function blis_word_sanitize_legacy_html($html_fragment)
{
	$safe = (string)$html_fragment;

	# Remove high-risk executable elements.
	$safe = preg_replace('/<\s*(script|iframe|object|embed|applet|meta|link|style)\b[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $safe);
	$safe = preg_replace('/<\s*(script|iframe|object|embed|applet|meta|link|style)\b[^>]*\/?\s*>/is', '', $safe);

	# Remove inline JS event handlers (onclick, onload, etc.).
	$safe = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/is', '', $safe);

	# Remove javascript: and data: URL payloads from common attributes.
	$safe = preg_replace('/\s+(href|src|xlink:href)\s*=\s*("|\')\s*(javascript:|data:)[^"\']*\2/is', '', $safe);
	$safe = preg_replace('/\s+(href|src|xlink:href)\s*=\s*(javascript:|data:)[^\s>]*/is', '', $safe);

	return $safe;
}

function blis_word_export_docx($html_fragment, $file_prefix)
{
	$pandoc_bin = blis_word_find_pandoc_bin();
	if($pandoc_bin === '')
	{
		return false;
	}

	$tmp_html = tempnam(sys_get_temp_dir(), 'blis_word_html_');
	$tmp_docx_base = tempnam(sys_get_temp_dir(), 'blis_word_docx_');
	if($tmp_html === false || $tmp_docx_base === false)
	{
		return false;
	}

	$tmp_docx = $tmp_docx_base.'.docx';
	@unlink($tmp_docx_base);

	$full_html = "<!DOCTYPE html>\n<html><head><meta charset=\"UTF-8\"></head><body>".$html_fragment."</body></html>";
	$write_ok = (file_put_contents($tmp_html, $full_html) !== false);
	if(!$write_ok)
	{
		@unlink($tmp_html);
		return false;
	}

	$cmd = escapeshellarg($pandoc_bin)
		." -f html -t docx"
		." -o ".escapeshellarg($tmp_docx)
		." ".escapeshellarg($tmp_html)
		." 2>&1";

	$command_output = array();
	$exit_code = 0;
	exec($cmd, $command_output, $exit_code);

	@unlink($tmp_html);

	if($exit_code !== 0 || !is_file($tmp_docx))
	{
		@unlink($tmp_docx);
		return false;
	}

	$date = date('YmdHi');
	$file_name = blis_word_sanitize_filename_segment($file_prefix).'_'.$date.'.docx';
	header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	header('Content-Disposition: attachment; filename="'.$file_name.'"');
	header('Content-Length: '.filesize($tmp_docx));

	# Prevent buffered warnings/whitespace from corrupting binary docx output.
	while(ob_get_level() > 0)
	{
		ob_end_clean();
	}

	readfile($tmp_docx);
	@unlink($tmp_docx);
	exit;
}

function blis_word_find_pandoc_bin()
{
	if(PHP_OS_FAMILY === 'Windows')
	{
		$output = array();
		$exit_code = 0;
		exec('where pandoc', $output, $exit_code);
		if($exit_code === 0 && isset($output[0]))
		{
			return trim($output[0]);
		}
		return '';
	}

	return trim((string)shell_exec('command -v pandoc'));
}
