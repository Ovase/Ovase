require 'pp'
require_relative 'docparser'

if ARGV.empty? || ARGV == ['-h'] || ARGV == ['--help']
	$stderr.puts "usage: ruby #{$PROGRAM_NAME} <dirA> <dirB>"
	$stderr.puts "       ruby #{$PROGRAM_NAME} src php > tests/JSPHP-suite.json"
else
	dir_a, dir_b = ARGV
	js = parse_any_path dir_a
	php = parse_any_path dir_b

	class_names = (js + php).map{|c| c[:name] }.sort.uniq

	tests = []
	classes = php.select{|c| class_names.include? c[:name] }

	untestable_classes = %w[DropdownInputWidget ComboBoxInputWidget
		RadioSelectInputWidget CheckboxMultiselectInputWidget]
	testable_classes = classes
		.reject{|c| c[:abstract] } # can't test abstract classes
		.reject{|c| !c[:parent] || c[:trait] || c[:parent] == 'Theme' } # can't test abstract
		.reject{|c| %w[Element Widget Layout Theme].include? c[:name] } # no toplevel
		.reject{|c| untestable_classes.include? c[:name] } # different PHP and JS implementations

	make_class_instance_placeholder = lambda do |klass, config|
		'_placeholder_' + {
			class: klass,
			config: config
		}.to_json
	end

	make_htmlsnippet_placeholder = make_class_instance_placeholder.curry['HtmlSnippet']

	# values to test for each type
	expandos = {
		'null' => [nil],
		'int' => [0, -1, 300], # PHP code
		'number' => [0, -1, 300], # JS code
		'bool' => [true, false], # PHP code
		'boolean' => [true, false], # JS code
		'string' => ['Foo bar', '<b>HTML?</b>', '', ' '],
		'HtmlSnippet' => ['Foo bar', '<b>HTML?</b>', ''].map(&make_htmlsnippet_placeholder),
	}

	# Values to test for specific config options, when not all values of given type are valid.
	# Empty array will result in no tests for this config option being generated.
	sensible_values = {
		'href' => ['http://example.com/'],
		['TextInputWidget', 'type'] => %w[text number password foo],
		['ButtonInputWidget', 'type'] => %w[button submit foo],
		['FieldLayout', 'errors'] => expandos['string'].map{|v| [v] }, # treat as string[]
		['FieldLayout', 'notices'] => expandos['string'].map{|v| [v] }, # treat as string[]
		'type' => %w[text button],
		'method' => %w[GET POST],
		'target' => ['_blank'],
		'accessKey' => ['k'],
		'tabIndex' => [-1, 0, 100],
		'maxLength' => [100],
		'icon' => ['image'],
		'indicator' => ['down'],
		'flags' => %w[constructive primary],
		'progress' => [0, 50, 100, false],
		# usually makes no sense in JS
		'autofocus' => [],
		# too simple to test?
		'action' => [],
		'enctype' => [],
		'name' => [],
		# different PHP and JS implementations
		['FieldLayout', 'help'] => [],
		['ActionFieldLayout', 'help'] => [],
		['FieldsetLayout', 'help'] => [],
		# these are defined by Element and would bloat the tests
		'classes' => [],
		'id' => [],
		'content' => [],
		'text' => [],
	}

	find_class = lambda do |klass|
		return classes.find{|c| c[:name] == klass }
	end

	expand_types_to_values = lambda do |types|
		return types.map{|t|
			as_array = true if t.sub! '[]', ''
			t = 'ButtonWidget' if t == 'Widget' # Widget is not "testable", use a subclass
			if expandos[t]
				# Primitive. Run tests with the provided values.
				vals = expandos[t]
			elsif testable_classes.find{|c| c[:name] == t }
				# OOUI object. Test suite will instantiate one and run the test with it.
				params = find_class.call(t)[:methods][0][:params] || []
				config = params.map{|config_option|
					types = config_option[:type].split '|'
					values = expand_types_to_values.call(types)
					{ config_option[:name] => values[0] }
				}
				vals = [
					make_class_instance_placeholder.call( t, config.inject({}, :merge) )
				]
			else
				# We don't know how to test this. The empty value will result in no
				# tests being generated for this combination of config values.
				vals = []
			end
			as_array ? vals.map{|v| [v] } : vals
		}.inject(:+)
	end

	find_config_sources = lambda do |klass_name|
		return [] unless klass_name
		klass_names = [klass_name]
		while klass_name
			klass = find_class.call(klass_name)
			break unless klass
			klass_names +=
				find_config_sources.call(klass[:parent]) +
				klass[:mixins].map(&find_config_sources).flatten
			klass_name = klass[:parent]
		end
		return klass_names.uniq
	end

	testable_classes.each do |klass|
		config_sources = find_config_sources.call(klass[:name])
			.map{|c| find_class.call(c)[:methods][0] }
		config = config_sources.map{|c| c[:config] }.compact.inject(:+)
		required_config = klass[:methods][0][:params] || []

		# generate every possible configuration of configuration option sets
		maxlength = [config.length, 2].min
		config_combinations = (0..maxlength).map{|l| config.combination(l).to_a }.inject(:+)
		# for each set, generate all possible values to use based on option's type
		config_combinations = config_combinations.map{|config_comb|
			config_comb += required_config
			expanded = config_comb.map{|config_option|
				types = config_option[:type].split '|'
				values =
					sensible_values[ [ klass[:name], config_option[:name] ] ] ||
					sensible_values[ config_option[:name] ] ||
					expand_types_to_values.call(types)
				values.map{|v| config_option.dup.merge(value: v) }
			}
			expanded.empty? ? [ [] ] : expanded[0].product(*expanded[1..-1])
		}.inject(:concat).uniq

		config_combinations.each do |config_comb|
			tests << {
				class: klass[:name],
				config: Hash[ config_comb.map{|c| [ c[:name], c[:value] ] } ]
			}
		end
	end

	$stderr.puts "Generated #{tests.length} test cases."
	tests = tests.group_by{|t| t[:class] }

	$stderr.puts tests.map{|class_name, class_tests| "* #{class_name}: #{class_tests.length}" }
	puts JSON.pretty_generate tests
end
