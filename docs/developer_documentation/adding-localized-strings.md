# Adding Localized Strings

If you are adding a new BLIS feature, or modifying the text that is on an existing feature, you
probably want to add or change strings.

## Files & Directories

BLIS uses XML and PHP files to store strings. These are located in a few places.

```plain
[root]
  - htdocs/
    - Language/
      - default.xml
      - en.xml
      - fr.xml
      - default.php
      - en.php
      - fr.php
      - ...
  - local/
    - langdata_[lab ID]/
      - default.xml
      - en.xml
      - fr.xml
      - default.php
      - en.php
      - fr.php
      - ...
```

### `htdocs/Language` Folder

The `Language` folder is the base template from which all labs are created. When a new lab is created, or a lab is updated, files from
[this folder are copied to the `local/langdata_` folder](https://github.com/C4G/BLIS/blob/9d2a26fa3773cce22c8cb619ea16fd7cd5983221/htdocs/includes/db_lib.php#L14161-L14181).

### `local/langdata_[lab ID]` Folder

The files in this folder are what is actually used to render the text on the pages that you visit in BLIS. These files
are required conditionally [depending on what your session's language is set to.](https://github.com/C4G/BLIS/blob/9d2a26fa3773cce22c8cb619ea16fd7cd5983221/htdocs/includes/db_lib.php#L42-L60).

## How to Use Localized Strings

Because the logic for requiring the correct language file is handled in `db_lib.php`, you must require it in your
file if it is not already required (it probably already is.)

```php
require_once("../includes/db_lib.php");
```

Once that is done, you can use the `LangUtil` class like so:

```php
<?php
  echo LangUtil::$generalTerms['NAME'];
?>
```

There are several "pages" of localized strings. These sections are organized in the XML file. You can set the current 
page ID and then use the `pageTerms` array.

```php
<?php
  LangUtil::setPageId("stocks");
  echo LangUtil::$pageTerms["Reagents"];
?>
```

## How to Add or Change a String

It is important to keep the strings in BLIS consistent so we can make it easy to maintain these strings for future
generations of contributors.

Here is the process for adding or changing a string:

1. In `htdocs/Language/`, for **each** `en.xml`, `fr.xml`, `default.xml`, add or change the string.
    1. Identify the correct page to place the string under (adding it to "general" is acceptable)
    1. Decide on a name for the string (like `CMD_EXIT`, `UPDATE_PATIENT`, etc.) and ensure it is not already taken
    1. Add a value for the string
    1. If you don't speak or understand French, judicious use of Google Translate or other services is reasonable. BLIS administrators will be able to change this value.
1. Run the `update-lang.php` utility. This will copy your changes to the corresponding PHP file.
    - **If you are using the BLIS devcontainer:** You can run:
        ```bash
        vscode@14ba082a42d1:/workspace$ php bin/update-lang.php htdocs/Language/en.xml
        Generating PHP file: /workspaces/BLIS/htdocs/Language/en.php
        From XML file:       /workspaces/BLIS/htdocs/Language/en.xml
        Calling: lang_xml2php("en", "/workspaces/BLIS/htdocs/Language/")
        Calling: require_once("/workspaces/BLIS/htdocs/Language/en.php") to ensure valid PHP syntax...
        ```

    - **If you are on Windows:** You can run:
        ```cmd
        C:\Users\c4g\BLIS>server\php\php.exe bin\update-lang.php htdocs\Language\en.xml
        Generating PHP file: /workspaces/BLIS/htdocs/Language/en.php
        From XML file:       /workspaces/BLIS/htdocs/Language/en.xml
        Calling: lang_xml2php("en", "/workspaces/BLIS/htdocs/Language/")
        Calling: require_once("/workspaces/BLIS/htdocs/Language/en.php") to ensure valid PHP syntax...
        ```
1. Copy all your changes from the `htdocs/Language` folder to the `local/langdata_` folders.
    ```bash
    $ cp htdocs/Language/en.* local/langdata_127/
    $ cp htdocs/Language/fr.* local/langdata_127/
    $ cp htdocs/Language/default.* local/langdata_127/

    # Repeat for local/langdata_12/, local/langdata_revamp/
    # These folders are distributed with BLIS as test labs.
    ```