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

echo Dropping ALL MySQL databases! Press any key to continue or Ctrl-C to quit.
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

for f in "$DIR"/../docker/database/*.sql; do
    [ -f "$f" ] || break
    mysql_exec "" "< $f"
done

