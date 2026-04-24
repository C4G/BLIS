# PHP 5 to PHP 7 Upgrade

## Dockerfile Changes (commit: 8f552ed)

Both Dockerfiles (`Dockerfile` and `docker/dev/Dockerfile`) had their `PHP_VERSION` build arg updated from `5.6` to `7.4`:

```dockerfile
# Before
ARG PHP_VERSION="5.6"

# After
ARG PHP_VERSION="7.4"
```

`docker/config/php.ini` was also updated to remove directives that were removed in PHP 7 (`asp_tags`, `track_errors`, `session.hash_bits_per_character`) and update others to PHP 7 defaults.

---

## Bug Fixes

### Fix: Empty Satellite Lab ID in Patient Registration (commit: d92f307)

Merged via PR #185. Fixes a bug where the satellite lab ID was empty during patient registration, causing the insert to fail silently. Added logging to `query_insert_one` to surface these failures.

Files changed: `htdocs/includes/db_lib.php`, `htdocs/includes/db_mysql_lib.php`

### Fix: Excel Export Not Working (commit: 0a01423)

Merged via PR (Excel-Bug branch). Fixes two issues with the "Export to Excel" feature on the reports page.

**Problem 1: 404 on custom field endpoints**

Two AJAX endpoints called by `htdocs/reports/reports.php` were returning 404 because `.htaccess` rewrite rules were missing for them. The files exist at `htdocs/export/export_to_excel_get_custom_patient_fields.php` and `htdocs/export/export_to_excel_get_custom_specimen_fields.php` but BLIS's flat-URL routing had no rules to reach them.

Fix: Added two rewrite rules to `htdocs/.htaccess` in the `## /export folder` section.

**Problem 2: Wrong `Content-Type` / corrupt file**

The `header()` calls in `htdocs/export/export_to_excel.php` were inside the `foreach` loop over test types. If no results were found, headers were never sent and the browser received `text/html`. When all test types had no data, `removeSheetByIndex(0)` removed the only worksheet, producing a corrupt workbook.

Fix: Moved `Content-Type`, `Content-Disposition`, and `Cache-Control` headers before the loop. Replaced the unconditional `removeSheetByIndex(0)` with a guard that keeps a "No Data" sheet when no results are found.

Additional fixes in the same commit:
- `export_to_excel_get_custom_patient_fields.php` — fixed malformed JSON (missing opening `[`, undefined `$output_fields` variable)
- `export_to_excel_get_custom_specimen_fields.php` — same JSON fix, plus replaced undefined `$lab_ids` with `$lab_id` in the auth check
- `htdocs/includes/composer.php` — removed closing `?>` tag to prevent accidental whitespace output before headers

Files changed: `htdocs/.htaccess`, `htdocs/export/export_to_excel.php`, `htdocs/export/export_to_excel_get_custom_patient_fields.php`, `htdocs/export/export_to_excel_get_custom_specimen_fields.php`, `htdocs/includes/composer.php`

### Fix: PHPExcel → PhpSpreadsheet Migration (PR #209, pending merge)

Replaces the abandoned `phpoffice/phpexcel 1.8.2` with `phpoffice/phpspreadsheet 1.30.2`. PHPExcel uses `get_magic_quotes_runtime()` / `set_magic_quotes_runtime()` internally (via PCLZip), which were removed in PHP 7.4, making it incompatible with the upgraded runtime.

Changes included in the PR:
- `composer.json` / `composer.lock` — swapped dependency
- `htdocs/export/export_to_excel.php` — migrated to PhpSpreadsheet API (`new Spreadsheet()`, `PhpOffice\PhpSpreadsheet\IOFactory`, 1-based column indexing)
- `htdocs/export/export_excel_dailylog.php` — updated HTML reader string (`'HTML'` → `'Html'`) and writer format (`'Excel2007'` → `'Xlsx'`)
- `Dockerfile` — added `composer install` step and `unzip` apt dependency
- Guarded against missing `test_types`/`specimen_custom_fields` in request

### Fix: Word Export Modernization (`word_export_lib.php`) (commits: d61d5d1e, 4e1b93d1)

In the `PHP-7-Upgrade` branch, Word export was refactored to use a shared helper library at `htdocs/export/word_export_lib.php` and to improve PHP 7 compatibility and export reliability.

What changed:

- Added `htdocs/export/word_export_lib.php` with reusable helpers:
- `blis_word_normalize_html_fragment()` to safely normalize posted HTML payloads
- `blis_word_sanitize_filename_segment()` to sanitize dynamic filename parts
- `blis_word_export_docx()` to generate real `.docx` files using `pandoc`
- `blis_word_send_legacy_doc()` fallback for legacy `.doc` export when `pandoc` is unavailable
- `blis_word_sanitize_legacy_html()` to strip high-risk HTML/JS before legacy export
- `blis_word_find_pandoc_bin()` to locate `pandoc` on Windows/Linux/macOS

Integration updates:

- `htdocs/export/export_word.php`
- switched to `require_once` includes
- validates and normalizes request inputs (`lab_id`, `data`)
- adds logo only if lab logo file exists
- attempts `.docx` export first, then falls back to legacy `.doc`
- `htdocs/export/export_word_aggregate.php`
- includes shared helper library
- sanitizes `report_type` for safe filenames
- normalizes posted HTML data
- attempts `.docx` export first, then falls back to legacy `.doc`

Why this matters for PHP 7:

- Removes brittle inline export logic duplicated across multiple files
- Prevents malformed/unsafe filenames and improves request handling
- Reduces risk of corrupted binary output by clearing output buffers before streaming `.docx`
- Keeps backward compatibility via `.doc` fallback when `pandoc` is not present

Files changed: `htdocs/export/word_export_lib.php`, `htdocs/export/export_word.php`, `htdocs/export/export_word_aggregate.php`

---

## Remaining Work (not yet addressed)

The items below were identified during the PHP 7 upgrade analysis but have not been fixed yet.

### Critical (will break on PHP 7)

- `htdocs/sqlbuddy/includes/class/Sql-php4.php` — uses `mysql_*` functions (fatal on PHP 7). The updated `Sql.php` already uses `mysqli_*`; confirm nothing references `Sql-php4.php` and remove it.
- DataTables server-side scripts in `htdocs/uilog/DataTables/` — several use `mysql_pconnect`, `mysql_query`, etc. Replace with `mysqli_*` or the app's `db_mysql_lib.php` abstraction.
- `htdocs/js/fckeditor/fckeditor_php4.php` and `fckeditor_php5.php` — use removed `$HTTP_SERVER_VARS` / `$HTTP_GET_VARS`. Replace with `$_SERVER` / `$_GET`, or replace FCKEditor with a modern editor (CKEditor 5).

### High Priority

- Short open tags (`<?` instead of `<?php`) in `htdocs/debug/util.php`, `htdocs/healthcheck.php`, `htdocs/export/updateNationalDatabaseUI.php`, `htdocs/ajax/test_list_by_site.php`, `htdocs/includes/page_elems.php`, `htdocs/regn/doctor_add_patient.php`, `htdocs/regn/new_patient.php`. Works with `short_open_tag = On` but fragile.
- `htdocs/sqlbuddy/functions.php` — calls `get_magic_quotes_gpc()` (removed in PHP 7.4).
- PHP 4-style `var` keyword for class properties in `htdocs/includes/new_image.php`, `htdocs/sqlbuddy/includes/class/GetTextReader.php`, `htdocs/sqlbuddy/includes/class/Sql.php`.

### Medium Priority

- `monolog/monolog ^1.25` — compatible with PHP 7 but end-of-life. Consider upgrading to Monolog 2.x or 3.x.
- Password hashing in `htdocs/includes/db_lib.php` uses `sha1()` with a hardcoded salt. Migrate to `password_hash()` / `password_verify()`.
- SQLBuddy (`htdocs/sqlbuddy/`) has multiple PHP 5 issues. Either update it or replace with PHPMyAdmin (already in the dev docker-compose).
