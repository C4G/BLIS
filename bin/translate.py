#!/usr/bin/env python

#####
#
# translate.py
#
# Usage:
#    ./translate.py en fr
#
# Using the argostranslate Python library, translate missing terms within BLIS localization files.

import argostranslate.package
import argostranslate.translate
import sys
import xml.etree.ElementTree as ET

from_code = sys.argv[1]
to_code = sys.argv[2]

# Download and install Argos Translate package
argostranslate.package.update_package_index()
available_packages = argostranslate.package.get_available_packages()
package_to_install = next(
    filter(
        lambda x: x.from_code == from_code and x.to_code == to_code, available_packages
    )
)
argostranslate.package.install_from_path(package_to_install.download())

from_tree = ET.parse(f'htdocs/Language/{from_code}.xml')
from_root = from_tree.getroot()

to_tree = ET.parse(f'htdocs/Language/{to_code}.xml')
to_root = to_tree.getroot()

from_pages = from_root.findall("./page")
for page in from_pages:
    page_id = page.attrib['id']
    to_pages = to_root.findall(f"./page[@id='{page_id}']")
    if (len(to_pages) > 0):
        to_page = to_pages[0]
    else:
        to_page = ET.SubElement(to_root, 'page')
        to_page.set('id', page.attrib['id'])

    if 'descr' in page.attrib and ('descr' not in to_page.attrib or page.attrib['descr'] == to_page.attrib['descr']):
        translated = argostranslate.translate.translate(page.attrib['descr'], from_code, to_code)
        to_page.set('descr', translated)

    from_term_els = page.findall("term")
    for from_term in from_term_els:
        term = from_term.find('key').text
        val = from_term.find('value').text

        to_term = to_page.findall(f"term[key='{term}']")
        if (len(to_term) > 0):
            continue

        print(f"{page_id}:{term}")
        print(f"{from_code}: {val}")

        # Translate
        if val is not None:
            translatedText = argostranslate.translate.translate(val, from_code, to_code)

        print(f"{to_code}: {translatedText}")

        to_term = ET.SubElement(to_page, "term")
        to_key = ET.SubElement(to_term, "key")
        to_val = ET.SubElement(to_term, "value")
        to_key.text = term
        to_val.text = translatedText

ET.indent(to_tree, space="    ", level=0)
to_tree.write(f'htdocs/Language/{to_code}.xml', encoding="utf-8", xml_declaration=True)
