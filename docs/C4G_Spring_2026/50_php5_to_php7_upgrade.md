# PHP 5 to PHP 7 Upgrade Guide

This document provides a detailed analysis of the BLIS codebase and the changes required to upgrade from PHP 5.6 to PHP 7.x. It is based on a full review of the repository.

## Current State

- The Dockerfile (`Dockerfile` and `docker/dev/Dockerfile`) both default to `PHP_VERSION="5.6"` via the ondrej/php PPA.
- The `docker/config/php.ini` is based on the default PHP 5.6 configuration and contains several directives that are removed or changed in PHP 7.
- The core database abstraction layer (`htdocs/includes/db_mysql_lib.php`) already uses `mysqli_*` functions, which is good news — the most critical migration path is already handled for the main application.
- `composer.json` requires `monolog/monolog ^1.25` and `phpoffice/phpexcel = 1.8.2`, both of which have PHP 7 compatibility concerns.

---

## Critical Changes (Will Break on PHP 7)

### 1. Removed `mysql_*` Extension

The legacy `mysql_*` extension was removed entirely in PHP 7.0. The following files still use it and will cause fatal errors:

| File | Functions Used |
|------|---------------|
| `htdocs/sqlbuddy/includes/class/Sql-php4.php` | `mysql_connect`, `mysql_close`, `mysql_select_db`, `mysql_query`, `mysql_error`, `mysql_num_rows`, `mysql_fetch_row`, `mysql_fetch_assoc`, `mysql_affected_rows`, `mysql_result`, `mysql_insert_id`, `mysql_real_escape_string`, `mysql_get_server_info` |
| `htdocs/uilog/DataTables/extras/Scroller/media/data/server_processing.php` | `mysql_pconnect`, `mysql_select_db`, `mysql_real_escape_string`, `mysql_query`, `mysql_error`, `mysql_fetch_array` |
| `htdocs/uilog/DataTables/examples/examples_support/infiniteScroll.php` | Same as above |
| `htdocs/uilog/DataTables/examples/server_side/scripts/filter_col.php` | Same as above |
| `htdocs/uilog/DataTables/examples/server_side/scripts/jsonp.php` | Same as above |
| `htdocs/uilog/DataTables/media/unit_testing/performance/large.php` | Same as above |

**Remediation:**
- `Sql-php4.php`: This file is the PHP 4 version of the SQL class. The updated `Sql.php` already uses `mysqli_*`. Confirm that nothing references `Sql-php4.php` and remove it, or migrate it to `mysqli_*`.
- DataTables server-side scripts: Replace all `mysql_*` calls with `mysqli_*` equivalents, or rewrite to use the application's existing `db_mysql_lib.php` abstraction layer.

### 2. Removed `asp_tags` Directive

The `php.ini` currently sets `asp_tags = Off`. This directive was removed in PHP 7.0 and will cause a startup warning. Remove this line from `docker/config/php.ini`.

### 3. Removed `track_errors` Directive

The `php.ini` sets `track_errors = Off`. This directive and the associated `$php_errormsg` variable were removed in PHP 7.2. Remove this line.

### 4. Removed `session.hash_bits_per_character` Directive

The `php.ini` sets `session.hash_bits_per_character = 5`. This directive was removed in PHP 7.1 (replaced by `session.sid_bits_per_character`). Update accordingly.

### 5. Deprecated `$HTTP_*_VARS` Superglobals

The following files use long-removed superglobal aliases (`$HTTP_SERVER_VARS`, `$HTTP_GET_VARS`):

- `htdocs/js/fckeditor/fckeditor_php4.php`
- `htdocs/js/fckeditor/fckeditor_php5.php`

These were removed in PHP 5.4 and will not work on PHP 7. Replace with `$_SERVER`, `$_GET`, etc., or replace the FCKEditor library entirely with a modern alternative (e.g., CKEditor 5).

### 6. Removed `get_magic_quotes_gpc()` / `get_magic_quotes_runtime()`

`htdocs/sqlbuddy/functions.php` calls `get_magic_quotes_gpc()` which was removed in PHP 7.4 (returns `false` in 7.0–7.3, fatal error in 8.0). Remove the conditional block and the `stripslashesFromArray` logic.


---

## High Priority Changes

### 7. `php.ini` Configuration Overhaul

The current `php.ini` is a PHP 5.6 default config with BLIS-specific modifications. The following directives need attention for PHP 7:

| Directive | Current Value | PHP 7 Status | Action |
|-----------|--------------|--------------|--------|
| `asp_tags` | `Off` | Removed in 7.0 | Remove line |
| `track_errors` | `Off` | Removed in 7.2 | Remove line |
| `session.hash_bits_per_character` | `5` | Removed in 7.1 | Replace with `session.sid_bits_per_character = 5` |
| `short_open_tag` | `On` | Still supported but discouraged | Keep `On` for now (see item 8) |
| `serialize_precision` | `17` | Changed default to `-1` in 7.1 | Update to `-1` for consistent float serialization |
| `error_reporting` | `E_ALL & ~E_DEPRECATED & ~E_STRICT` | `E_STRICT` merged into `E_ALL` in 7.0 | Simplify to `E_ALL & ~E_DEPRECATED` |

**BLIS-specific modifications to preserve:**
- `max_execution_time = 300`
- `max_input_vars = 100000`
- `memory_limit = 500M`
- `post_max_size = 100M`

**Recommendation:** Start from a fresh PHP 7.x `php.ini-production` template and re-apply only the BLIS-specific modifications listed above, rather than trying to patch the existing PHP 5.6 config.

### 8. Short Open Tags (`<?` instead of `<?php`)

Multiple files use the short open tag `<?` instead of `<?php`. While `short_open_tag = On` keeps these working in PHP 7, this is fragile and discouraged. The affected files include:

- `htdocs/debug/util.php`
- `htdocs/healthcheck.php`
- `htdocs/export/updateNationalDatabaseUI.php`
- `htdocs/ajax/test_list_by_site.php`
- `htdocs/includes/page_elems.php` (multiple occurrences, including `<? if`, `<? else:`, `<? endif; ?>`)
- `htdocs/regn/doctor_add_patient.php`
- `htdocs/regn/new_patient.php`

**Remediation:** Replace all `<?` with `<?php` and all `<? ` with `<?php `. The short echo tag `<?=` is always available since PHP 5.4 and does not need changing.

### 9. PHP 4-Style Class Properties (`var` keyword)

The following files use the PHP 4 `var` keyword for class properties instead of explicit visibility (`public`, `private`, `protected`):

- `htdocs/includes/new_image.php` — `SimpleImage` class: `var $image;`, `var $image_type;`
- `htdocs/sqlbuddy/includes/class/GetTextReader.php` — `var $translationIndex`, `var $basePath`
- `htdocs/sqlbuddy/includes/class/Sql-php4.php` — All properties
- `htdocs/sqlbuddy/includes/class/Sql.php` — All properties (`var $adapter`, `var $method`, `var $version`, `var $conn`, `var $options`, `var $errorMessage`, `var $db`)

**Remediation:** Replace `var` with `public` (or the appropriate visibility). While `var` still works in PHP 7 (treated as `public`), it generates `E_STRICT` notices and is considered deprecated practice.

### 10. Dockerfile Updates

Both Dockerfiles need the `PHP_VERSION` build arg updated:

```dockerfile
# Change from:
ARG PHP_VERSION="5.6"

# Change to:
ARG PHP_VERSION="7.4"
```

Also verify that all PHP extensions listed in the Dockerfiles are available for PHP 7.4:
- `php7.4-bcmath` ✓
- `php7.4-curl` ✓
- `php7.4-gd` ✓
- `php7.4-mysql` ✓
- `php7.4-zip` ✓
- `php7.4-mbstring` ✓
- `php7.4-xml` ✓

All of these are available in the ondrej/php PPA for PHP 7.4.

---

## Medium Priority Changes

### 11. Vendor Dependencies

#### `phpoffice/phpexcel = 1.8.2`
PHPExcel 1.8.2 is abandoned and has known issues with PHP 7.x:
- Uses `get_magic_quotes_runtime()` / `set_magic_quotes_runtime()` in `vendor/phpoffice/phpexcel/Classes/PHPExcel/Shared/PCLZip/pclzip.lib.php` (lines 4841–4887). These are removed in PHP 7.4+.
- The library is officially deprecated in favor of [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet).

**Remediation:** Migrate from `phpoffice/phpexcel` to `phpoffice/phpspreadsheet`. This requires updating all import/export code that uses PHPExcel classes. The PhpSpreadsheet library provides a [migration guide](https://phpspreadsheet.readthedocs.io/en/latest/topics/migration-from-PHPExcel/).

#### `monolog/monolog ^1.25`
Monolog 1.x is compatible with PHP 7 but is end-of-life. Consider upgrading to Monolog 2.x or 3.x for long-term support.

### 12. Password Hashing

The application uses `sha1()` with a hardcoded salt for password hashing (`htdocs/includes/db_lib.php`, line 5747):

```php
$salt = "This comment should suffice as salt.";
return sha1($password.$salt);
```

While `sha1()` still works in PHP 7, this is a significant security concern. PHP 7 provides `password_hash()` and `password_verify()` with bcrypt/argon2 support.

**Remediation:** Migrate to `password_hash()`/`password_verify()`. This requires a migration strategy for existing password hashes (e.g., re-hash on next login).

### 13. SQLBuddy Tool

The `htdocs/sqlbuddy/` directory contains a bundled database management tool with multiple PHP 5 compatibility issues:
- `Sql-php4.php` uses entirely `mysql_*` functions (fatal on PHP 7)
- `Sql.php` already uses `mysqli_*` (good)
- `functions.php` uses `get_magic_quotes_gpc()` (removed in 7.4)
- `GetTextReader.php` uses `var` keyword for properties
- `functions.php` sets `error_reporting(E_ALL)` which will surface more warnings in PHP 7

**Remediation:** Either update SQLBuddy to be PHP 7 compatible, or replace it with PHPMyAdmin (which is already available in the dev docker-compose setup).

### 14. FCKEditor Library

The `htdocs/js/fckeditor/` directory contains an extremely outdated editor library:
- `fckeditor_php4.php` and `fckeditor_php5.php` use `$HTTP_SERVER_VARS` and `$HTTP_GET_VARS`
- FCKEditor has been replaced by CKEditor since 2009

**Remediation:** Replace FCKEditor with CKEditor 5 or another modern rich text editor. If the editor is not actively used, remove the directory entirely.

---

## Low Priority / Informational

### 15. Behavioral Changes in PHP 7

These won't cause fatal errors but may change application behavior:

- **Integer division by zero** now throws `DivisionByZeroError` instead of returning `false`
- **Invalid octal literals** (e.g., `0128`) now cause parse errors instead of being silently truncated
- **`list()` assignment order** changed — assignments now happen left-to-right instead of right-to-left
- **Uniform variable syntax** — expressions like `$$foo['bar']` are now interpreted as `($$foo)['bar']` instead of `${$foo['bar']}`
- **`foreach` no longer modifies the internal array pointer** — code relying on `current()`/`next()` after `foreach` may behave differently
- **Strings containing hexadecimal** are no longer considered numeric (e.g., `"0x1A" == 26` is now `false`)

### 16. Error Handling Changes

PHP 7 converts many fatal errors to `Error` exceptions. Code that uses custom error handlers or relies on `set_error_handler()` may need updates. The application should be tested for:
- Type errors (passing wrong types to built-in functions)
- Undefined variable/index notices (now more strictly enforced)

### 17. Reserved Keywords

PHP 7.0 added new reserved keywords. Verify no classes, interfaces, or traits use these names:
- `int`, `float`, `bool`, `string`, `true`, `false`, `null`
- `void` (7.1), `iterable` (7.1), `object` (7.2)

---

## Recommended Upgrade Strategy

### Phase 1: Infrastructure
1. Create a new branch for the PHP 7 upgrade
2. Update both Dockerfiles to `PHP_VERSION="7.4"`
3. Generate a fresh `php.ini` from PHP 7.4 defaults and re-apply BLIS modifications
4. Build and verify the container starts

### Phase 2: Critical Fixes
5. Remove or update `Sql-php4.php` (mysql_* removal)
6. Update DataTables server-side PHP scripts to use `mysqli_*`
7. Fix short open tags across all affected files
8. Update `htdocs/sqlbuddy/functions.php` to remove `get_magic_quotes_gpc()` block

### Phase 3: Dependency Updates
9. Replace `phpoffice/phpexcel` with `phpoffice/phpspreadsheet` in `composer.json`
10. Run `composer update` and resolve any dependency conflicts
11. Update all PHPExcel class references to PhpSpreadsheet equivalents

### Phase 4: Cleanup and Modernization
12. Replace or remove FCKEditor
13. Replace `var` with proper visibility keywords
14. Evaluate replacing SQLBuddy with PHPMyAdmin
15. Migrate password hashing to `password_hash()`/`password_verify()`

### Phase 5: Testing
16. Run the full application through all major workflows (patient registration, specimen entry, results entry, reporting)
17. Test the BLIS 4.0 Registration Workflow specifically (known high-priority bug)
18. Verify backup/restore functionality
19. Test import/export features (PHPExcel migration)
20. Run any existing automated tests

---

## Files Summary

| Category | Count | Key Files |
|----------|-------|-----------|
| `mysql_*` usage (fatal) | 6 files | `Sql-php4.php`, DataTables scripts |
| Short open tags | 7+ files | `page_elems.php`, `new_patient.php`, `healthcheck.php` |
| Deprecated superglobals | 2 files | `fckeditor_php4.php`, `fckeditor_php5.php` |
| `var` keyword properties | 4 files | `SimpleImage`, `GetTextReader`, `SQL` classes |
| `get_magic_quotes_*` | 1 file | `sqlbuddy/functions.php` |
| Vendor issues | 1 package | `phpoffice/phpexcel` (PCLZip magic quotes) |
| php.ini directives | 3 directives | `asp_tags`, `track_errors`, `session.hash_bits_per_character` |
| Weak password hashing | 1 file | `db_lib.php` (sha1 with static salt) |

The core application code (`db_mysql_lib.php`, `db_lib.php`, and the main `htdocs/` PHP files) is in relatively good shape for the upgrade since the database layer already uses `mysqli_*`. The majority of breaking changes are in bundled third-party tools (SQLBuddy, FCKEditor, DataTables server scripts) and the vendor dependency on PHPExcel.
