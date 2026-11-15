#!/usr/bin/env python

#####
#
# translate.py
#
# Usage:
#    ./translate.py en fr [page name] [term name]
#
# Using the argostranslate Python library, translate specific terms within BLIS localization files.

import argostranslate.package
import argostranslate.translate
import sys
import xml.etree.ElementTree as ET

from_code = sys.argv[1]
to_code = sys.argv[2]
page = sys.argv[3]
term = sys.argv[4]

# Download and install Argos Translate package
argostranslate.package.update_package_index()
available_packages = argostranslate.package.get_available_packages()
package_to_install = next(
    filter(
        lambda x: x.from_code == from_code and x.to_code == to_code, available_packages
    )
)
argostranslate.package.install_from_path(package_to_install.download())

tree = ET.parse(f'htdocs/Language/{from_code}.xml')
root = tree.getroot()

term_el = root.findall(f"./page[@id='{page}']/term[key='{term}']")[0]
value_el = term_el.findall('value')[0]

# Translate
translatedText = argostranslate.translate.translate(value_el.text, from_code, to_code)

print(f"{from_code}:\t{value_el.text}")
print(f"{to_code}:\t{translatedText}")

