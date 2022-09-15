#!/usr/bin/env ruby

# Small Ruby script to fix mixed file encodings.
# Attempts to open each PHP file and convert it to UTF-8.
# Primarily assumes that the encoding of problematic files is ISO-8859-1.

php_files = Dir.glob("**/*.php")
               .filter { |file| !file.include?("vendor/") }
               .filter { |file| !file.include?("htdocs/tcpdf") }
               .filter { |file| !file.include?("htdocs/barcode") }
               .filter { |file| !file.include?("htdocs/sqlbuddy") }

# puts php_files

php_files.each do |file|
    contents = File.read(file).force_encoding("UTF-8")
    begin
        contents.split("\n")
    rescue ArgumentError => e
        new_cnts = contents.force_encoding(Encoding::ISO_8859_1).encode("UTF-8")
        File.write(file, new_cnts)
        puts 'Processed: ' + file
    end
end
