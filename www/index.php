<?php
DEFINE('ROOT', __DIR__.'/../'); // Defined the path to the ROOT directory for reuse, usually you'll get this defined elsewhere from the start.
require_once(ROOT.'core/lib_wordup.php');
// All the php functions are now in the separate core/lib_wordup.php



if (isset($_GET["q"])) {
    $theWord = $_GET["q"]; // This is the dangerous part, where the changable user input comes in, so it has to be watched like a hawk, 
    // and never used without proper escaping or sanitation.
    $theQuery = urlencode($_GET["q"]);
} else {
  $theWord = "what word would you like to look up?";
}

$dictionary_section = $slang_section = $thesaurus_section = null;
if($theQuery){
  $dictionary_section = get_dictionary($theQuery, $theWord);
  $slang_section = get_slang($theQuery);
  $thesaurus_section = get_thesaurus($theQuery);
}

$query_present = null;
if($theQuery){ // Just for the purposes of this example, let's move the if here so that the template can just output the query-present
  // html class if it's set.
  $query_present = 'query-present';
}


// Here we use a simple, simple approach to separate php files as a template!
include(ROOT.'templates/main.php'); 
