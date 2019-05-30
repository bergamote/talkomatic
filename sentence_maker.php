<?php
# Make word arrays from text files
$s_file = file("words/subject.txt", FILE_IGNORE_NEW_LINES);
$v_file = file("words/verb.txt", FILE_IGNORE_NEW_LINES);
$ar_file = file("words/article.txt", FILE_IGNORE_NEW_LINES);
$n_file = file("words/noun.txt", FILE_IGNORE_NEW_LINES);
$loc_file = file("words/location.txt", FILE_IGNORE_NEW_LINES);

# Function to pick random words from array
function pick($x){
  $y = $x[array_rand($x)];
  return $y;
}
# Vowels
$vowels = array(
  "a",
  "e",
  "i",
  "o",
  "u"
);

# Verbs endings that take extra "e" at third person
$special_verb_endings = array (
  "x",
  "y",
  "o",
  "h"
);

# Adapt article (a / an)
function adapt_article($article, $noun) {
  global $vowels;
  $nFirstChar = $noun[0];
  if (($article == "a") and
    (in_array($nFirstChar, $vowels))) {
    return "an";
  } else {
    return $article;
  }
}

# Check for third person 
function check_third_person($s) {
  if (( $s == "he" ) or ( $s == "she" )){
    return true; 
  } else { 
    return false;
  }
}

# Conjugate verb (when third person, present continous)
function conjugate($subject ,$verb) {
  global $vowels, $special_verb_endings;
  if (check_third_person($subject)){
    # If third person, find out the last two letters of the verb
    $verb_ending = "";
    $vLastChar = $verb[strlen($verb)-1];
    $vPenulChar = $verb[strlen($verb)-2];
    if (($vLastChar == "y") and
      in_array( $vPenulChar , $vowels )) {
      # When verb ends with [vowel]-[y] do nothing
    } elseif (in_array($vLastChar, $special_verb_endings)) {
      if ($vLastChar == "y") {
          # Otherwise replace [y] for [i]
          $verb = substr( $verb , 0 , -1 )."i";
        }
      # Special verb endings take [e]
      $verb_ending .= "e";
    }
    # Every verb takes [s]
    $verb_ending .= "s";
    $verb .= $verb_ending;
  }
  return $verb;
}


### Starting to make our sentence

# Pick a subject
$subject = pick($s_file);

# Pick and conjugate the verb
$verb = conjugate( $subject , pick($v_file) );

# Pick a noun
$noun = pick($n_file);

# Pick and adapt the article
$article = adapt_article( pick($ar_file) , $noun );


# Make an array of words
$sentence_array = array (
  $subject,
  $verb,
  $article,
  $noun
);

# Put the words together around spaces
# removing the last space
$sentence = trim(implode( $sentence_array , " " ));

# Capitalize and add period
echo ucfirst($sentence).".";


# flip a coin
mt_rand(0,1);
?>
