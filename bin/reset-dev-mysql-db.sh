#!/bin/bash

DIR="$(dirname "$0")"

function mysql_exec {
    DB="$1"
    SQL="$2"

    CMD="mysql -hdb -uroot -pblis123 $DB $SQL"
    echo "$CMD"
    bash -c "$CMD"
    return $?
}

if [[ $* == *--clean* ]]; then
    CLEAN_DBS="true"    
fi

echo Dropping ALL MySQL databases! Press any key to continue or Ctrl-C to quit.

if [[ "$CLEAN_DBS" == "true" ]]; then
    echo Creating empty databases.
else
    echo Creating prepopulated databases with data from BLIS 3.72.
fi

read -rn1

if ! mysql_exec "blis_revamp" "-e 'DROP DATABASE blis_revamp;'"; then
    echo "Failed to drop blis_revamp"
fi
if ! mysql_exec "blis_12" "-e 'DROP DATABASE blis_12;'"; then
    echo "Failed to drop blis_12"
fi
if ! mysql_exec "blis_127" "-e 'DROP DATABASE blis_127;'"; then
    echo "Failed to drop blis_127"
fi

if ! [[ "$CLEAN_DBS" == "true" ]]; then
    for f in "$DIR"/../docker/database/*.sql; do
        [ -f "$f" ] || break
        mysql_exec "" "< $f"
    done
else
    for f in "$DIR"/../docker/db_3.8/*.sql; do
        [ -f "$f" ] || break
        mysql_exec "" "< $f"
    done
fi
