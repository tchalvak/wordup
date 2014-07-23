<?php

// Simple, simple test script to ensure that the functions and includable code do what we want them to.
// Someday it'd be better to use phpunit, but for now we'll use a hack.

if(!defined('ROOT')){
	define('ROOT', realpath(__DIR__.'/../').'/');
}
require_once(ROOT.'core/lib_wordup.php'); // Get the reusable functions.

// Using a testing class just for consistency with php testing frameworks.
class WordupTests{
	function testHtmlEscapingOfSpecialCharacters(){
		$dirty_string = '<>&"\'';
		$escaped = hesc($dirty_string);
		assert(strpos($escaped, '<') === false);
		assert(strpos($escaped, '>') === false);
		assert(strpos($escaped, '"') === false);
		assert(strpos($escaped, '&amp;') !== false); // The ampersand will be used to escape the original ampersand!
		assert(strpos($escaped, '\'') === false);
	}

	function testTagLineFunctionIncorporatesParameters(){
		$url = 'bling';
		$site_name = 'example.com';
		$output = tag_line($url, $site_name);
		// Find these words in the output.
		assert(strpos($output, 'bling') !== false);
		assert(strpos($output, 'example.com') !== false);
	}

	function testDictionaryHeaderUsesParameters(){
		$word = 'someWord';
		$year = '1999';
		$header = dictionary_header($word,$year);
		assert(strpos($header, 'someWord') !== false);
		assert(strpos($header, '1999') !== false);
	}

	function testThatGettingADictionaryResultForCommonWordWorks(){
		$word = 'hat';
		$encoded_word = urlencode($word);
		$entry = get_dictionary($word,$encoded_word);
		assert(strpos($entry, 'hat') !== false);
		assert(strpos($entry, 'merriam-webster') !== false);
		// Todo: should probably check that some kind of definition of hat is returned too.
	}

	function testThatGettingSlangResultWorks(){
		$word = 'sex'; // You know urban dictionary has some defintions for that.
		$query = urlencode($word);
		$entry = get_slang($query);
		assert(strpos($entry, 'sex') !== false);
		assert(strpos($entry, 'urban dictionary') !== false);
		// TODO: Probably need some way to ensure that a result is actually being returned, not just parrotted back.
	}

	function testThatGettingAnAlternateWordWorks(){
		$word = 'code';
		$query = urlencode($word);
		$entry = get_thesaurus($query);
		assert(strpos($entry, 'code') !== false);
		assert(strpos($entry, 'wikisaurus') !== false);
	}
}
// Create an instance of the object.
$tests = new WordupTests();
// Run the test methods.
$tests->testHtmlEscapingOfSpecialCharacters();
$tests->testTagLineFunctionIncorporatesParameters();
$tests->testDictionaryHeaderUsesParameters();
$tests->testThatGettingADictionaryResultForCommonWordWorks();
$tests->testThatGettingSlangResultWorks();
$tests->testThatGettingAnAlternateWordWorks();

// Test that the rendering functions include their passed arguments.
