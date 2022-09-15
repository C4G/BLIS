#!/usr/bin/env ruby
# frozen_string_literal: true

# This is a hacky Ruby script I used to analyze the require_once and include_once
# statements in our PHP files and build a dependency tree between files.
# This helped me analyze where we needed to include the lang_util.php file.
# This is not a tool that is broadly useful, but I am committing it in case
# someone sees it and thinks "wow! I can use that!"

require 'byebug'
require 'pathname'
require 'ruby-graphviz'

php_files = Dir.glob('**/*.php')
               .filter { |file| !file.include?('vendor/') }
               .filter { |file| !file.include?('htdocs/tcpdf') }
               .filter { |file| !file.include?('htdocs/barcode') }
               .filter { |file| !file.include?('htdocs/sqlbuddy') }

# puts php_files

file_deps = {}

php_files.each do |file|
  filepath = Pathname.new(file).cleanpath.to_s

  uses_langutil = `grep -lnr 'LangUtil::' #{filepath}`.split("\n").length.positive?
  next unless uses_langutil

  file_deps[filepath] = [] unless file_deps.key?(filepath)

  contents = File.read(file).force_encoding('UTF-8')
  contents.split("\n").each do |line|
    matches = line.match(/(require|include)(_once)?\s?\((.+)\)/)
    next unless matches

    relpath = matches[3].gsub(/__DIR__\./, '')
                        .gsub(/dirname\(__FILE__\)\s?\.\s?/, '')
                        .gsub(/["']/, '')
    root = File.dirname(file)
    path = Pathname.new("#{root}/#{relpath}").cleanpath
    unless File.exist?(path)
      path = Pathname.new("htdocs/#{relpath}").cleanpath
      unless File.exist?(path)
        # puts "Cannot resolve file: #{relpath}"
        next
      end
    end

    file_deps[filepath].append(path.to_s)
  end
end

graph = GraphViz.new(:G, type: :digraph)
file_deps.each do |file, deps|
  node = graph.get_node(file) || graph.add_nodes(file)
  deps.each do |dep|
    dep_node = graph.get_node(dep) || graph.add_nodes(dep)
    graph.add_edges(node, dep_node)
  end
end

# use this to get a visual output
# graph.output(dot: 'depgraph.dot')

dcounts = {}

file_deps.each do |file, deps|
  uses_langutil = `grep -lnr 'LangUtil::' #{file}`.split("\n").length.positive?
  # puts "Uses LangUtil: #{file}" if uses_langutil
  next unless uses_langutil

  includes_lu = false
  search_deps = deps || []
  search_deps.each do |dep|
    if dep.include?('lang_util.php')
      includes_lu = true
      # puts "#{file} includes LangUtil eventually"
      break
    end
    (file_deps[dep] || []).each { |dep_dep| search_deps.append(dep_dep) unless search_deps.include? dep_dep }
  end

  # puts "Needs LangUtil: #{file}" if !includes_lu
  # puts " --> " + search_deps.uniq.join(", ") if !includes_lu

  if !includes_lu
    puts file
    udeps = search_deps.uniq
    udeps.each do |dep|
        dcounts[dep] ||= 0
        dcounts[dep] += 1
    end
    dcounts.each do |dep, count|
        # puts "#{dep}, #{count}"
    end
  end
end
