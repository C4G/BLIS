#!/usr/bin/env python3

##########
# Sets the Apache2 ServerName property based on the environment.

import os, re

if 'BLIS_APACHE2_CONFIG' not in os.environ:
    print('BLIS_APACHE2_CONFIG environment variable is not set.')
    exit(1)

if 'BLIS_SERVER_NAME' not in os.environ:
    print('BLIS_SERVER_NAME environment variable is not set; skipping update.')
    exit(0)

apache2_cfg = os.environ['BLIS_APACHE2_CONFIG']
servername = os.environ['BLIS_SERVER_NAME']

# read entire apache2 config file into memory
with open(apache2_cfg) as file:
    lines = file.readlines()

# search for the ServerName directive,
# and when it is found, replace the value with whatever we want it to be.
server_name_regex = re.compile('(\s*)(#?)ServerName(.*)')
for l in range(0, len(lines)):
    line = lines[l]
    match = server_name_regex.match(line)
    if match:
        lines[l] = match.group(1) + f'ServerName {servername}\n'
        break

# write the result lines back to disk.
with open(apache2_cfg, 'w') as file:
    file.writelines(lines)

print(f'ServerName updated to {servername}')