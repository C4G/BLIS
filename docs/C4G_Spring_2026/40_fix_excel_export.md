# Fix: Excel Export Not Working

## Problem

The "Export to Excel" feature on the reports page has two issues:

1. The exported `.xlsx` file is served with `Content-Type: text/html` instead of `application/vnd.openxmlformats-officedocument.spreadsheetml.sheet`, so the browser renders binary xlsx content as an HTML page instead of triggering a file download.
2. Two AJAX requests for custom patient/specimen fields return 404:
   - `GET /export_to_excel_get_custom_patient_fields.php?lab_config_id=1` → 404
   - `GET /export_to_excel_get_custom_specimen_fields.php?lab_config_id=127` → 404

## Root Causes

### 1. Missing `.htaccess` rewrite rules (404s)

The files exist at their real paths:
- `htdocs/export/export_to_excel_get_custom_patient_fields.php`
- `htdocs/export/export_to_excel_get_custom_specimen_fields.php`

BLIS uses `.htaccess` rewrite rules to map flat URLs (e.g. `/export_to_excel.php`) to their actual locations in subdirectories (e.g. `export/export_to_excel.php`). The `## /export folder` section in `htdocs/.htaccess` has rules for `export_to_excel.php` and `export_to_excel_get_test_types.php`, but is missing rules for the two custom field endpoints.

The JavaScript in `htdocs/reports/reports.php` (around line 2965-2975) calls these endpoints via `$.getJSON()`:

```js
$.getJSON("export_to_excel_get_custom_patient_fields.php", {lab_config_id: selectEl.val()}, function(j){ ... });
$.getJSON("export_to_excel_get_custom_specimen_fields.php", {lab_config_id: selectEl.val()}, function(j){ ... });
```

Without rewrite rules, Apache can't find the files and returns 404.

### 2. Wrong `Content-Type` on the Excel response

The response headers show `Content-Type: text/html; charset=UTF-8` even though the PHP code in `htdocs/export/export_to_excel.php` does set the correct header:

```php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
```

However, this `header()` call is inside the `foreach($test_type_ids ...)` loop, meaning:
- If no test results are found for any test type (the `if(count($results) == 0) continue;` check), the headers are never sent.
- Even when results exist, the headers are set inside the loop body after the query runs. If any included file (e.g. `composer.php`, `db_lib.php`) outputs anything to the browser before this point — even a UTF-8 BOM, a stray newline, or a PHP warning — the headers will silently fail because PHP has already started sending the response body. The file itself warns about this in its comments at the top.

Additionally, the `composer.php` include file has a closing `?>` tag followed by potential whitespace, which is a known source of accidental output in PHP.

## Fix

### Fix 1: Add missing rewrite rules

Add these two lines to `htdocs/.htaccess` in the `## /export folder` section, after the existing `export_to_excel` rules:

```apache
RewriteRule ^export_to_excel_get_custom_patient_fields\.php$ export/export_to_excel_get_custom_patient_fields.php
RewriteRule ^export_to_excel_get_custom_specimen_fields\.php$ export/export_to_excel_get_custom_specimen_fields.php
```

### Fix 2: Move response headers before the loop

In `htdocs/export/export_to_excel.php`, move the `header()` calls outside and before the `foreach` loop so they are always sent regardless of query results:

```php
// Set headers BEFORE the loop — must be sent before any output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
header('Cache-Control: max-age=0');

foreach($test_type_ids as $tt_idx => $test_type_id) {
    // ... existing query and sheet-building logic ...
    // REMOVE the header() calls that were here
}
```

### Fix 3 (optional): Remove closing `?>` tag from included files

The PHP docs recommend omitting the closing `?>` tag in files that contain only PHP. This prevents accidental whitespace output. `htdocs/includes/composer.php` currently ends with `?>` — removing it would eliminate one potential source of premature output.

## Files to Change

- `htdocs/.htaccess` — add two rewrite rules
- `htdocs/export/export_to_excel.php` — move `header()` calls before the loop
- `htdocs/includes/composer.php` — (optional) remove closing `?>` tag

## Additional Notes

- The custom field endpoint files (`export_to_excel_get_custom_patient_fields.php` and `export_to_excel_get_custom_specimen_fields.php`) also have a bug: they reference an undefined variable `$output_fields` in the JSON output loop, and they echo `"\n]"` without ever echoing an opening `[`. This means the JSON response is malformed. This is a pre-existing issue and not the cause of the 404s, but should be fixed separately.
- The `export_to_excel_get_custom_specimen_fields.php` file references an undefined variable `$lab_ids` in its authorization check (line: `if (count($lab_ids) == 1 ...`). It should use `$lab_id` instead.

## Problem 2: Exported Excel File Is Corrupt When No Results Match

After the initial fixes above, the export correctly triggers a file download, but the resulting `report.xlsx` file is reported as corrupt by Excel and cannot be opened when the selected test types have no data in the given date range.

### Root Cause

`new PHPExcel()` automatically creates a default empty worksheet ("Worksheet") at index 0. The export loop calls `$objPHPExcel->createSheet()` to add a new sheet for each test type that has results. At the end of the script, `$objPHPExcel->removeSheetByIndex(0)` removes the default empty sheet so it doesn't appear in the final file.

The problem: if none of the selected test types have any results (every loop iteration hits `if(count($results) == 0) continue;`), no sheets are ever created via `createSheet()`. The only sheet in the workbook is the default one at index 0, and `removeSheetByIndex(0)` removes it — producing a workbook with zero worksheets. This is invalid xlsx and Excel correctly rejects it as corrupt.

### Fix 4: Guard the default sheet removal

In `htdocs/export/export_to_excel.php`, replace the unconditional `removeSheetByIndex(0)` with a check:

```php
if ($objPHPExcel->getSheetCount() > 1) {
    $objPHPExcel->removeSheetByIndex(0);
} else if ($objPHPExcel->getSheetCount() == 1 && $objPHPExcel->getSheet(0)->getTitle() == 'Worksheet') {
    $objPHPExcel->getSheet(0)->setTitle('No Data');
    $objPHPExcel->getSheet(0)->setCellValue('A1', 'No results found for the selected test types and date range.');
}
```

When the loop adds at least one data sheet, the default empty sheet is removed as before. When no data is found, the default sheet is kept, renamed to "No Data", and given a user-friendly message in cell A1 so the file is valid and informative.

### File Changed

- `htdocs/export/export_to_excel.php` — replaced unconditional `removeSheetByIndex(0)` with a guarded check

## Summary of Changes

Six files were modified across both fixes:

- `htdocs/.htaccess` — added rewrite rules for `export_to_excel_get_custom_patient_fields.php` and `export_to_excel_get_custom_specimen_fields.php`, resolving the 404 errors on custom field lookups.
- `htdocs/export/export_to_excel.php` — moved the `Content-Type`, `Content-Disposition`, and `Cache-Control` headers out of the per-test-type loop and before it, so the browser always receives the correct xlsx MIME type and triggers a file download. Also replaced the unconditional `removeSheetByIndex(0)` with a guarded check that keeps a "No Data" sheet when no results are found, preventing a corrupt empty workbook.
- `htdocs/export/export_to_excel_get_custom_patient_fields.php` — added the missing opening `[` for valid JSON output and fixed the loop counter to use `$custom_field_list` instead of the undefined `$output_fields`.
- `htdocs/export/export_to_excel_get_custom_specimen_fields.php` — same JSON fix as above, plus replaced the undefined `$lab_ids` variable with `$lab_id` in the authorization check.
- `htdocs/includes/composer.php` — removed the closing `?>` tag to prevent accidental whitespace output that could interfere with HTTP headers set later by the export script.

All fixes confirmed working as of March 11, 2026.
