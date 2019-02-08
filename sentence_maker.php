<?php
# Make word arrays from text files
$s = file("words/subject.txt", FILE_IGNORE_NEW_LINES);
$v = file("words/verb.txt", FILE_IGNORE_NEW_LINES);
$ar = file("words/article.txt", FILE_IGNORE_NEW_LINES);
$n = file("words/noun.txt", FILE_IGNORE_NEW_LINES);

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
  "o"
);

# Starting to make our sentence

# Pick a subject
$subject = pick($s);

# check if third person test
if (($subject=="he") or ($subject=="she")){
  $third_person = true;
} else {
  $third_person = false;
}

# Pick a verb
$verb = pick($v);

# Conjugate verb (third person present continous)
if ($third_person){
  $verb_ending = "";
  $vLastChar = $verb[strlen($verb)-1];
  $vPenulChar = $verb[strlen($verb)-2];
  if (($vLastChar == "y") and
    in_array($vPenulChar, $vowels)) {
    # When verb ends with [vowel]-[y] do nothing
  } elseif (in_array($vLastChar, $special_verb_endings)) {
    if ($vLastChar == "y") {
        # Otherwise replace [y] for [i]
        $verb = substr($verb, 0, -1)."i";
      }
    # Special verb endings take [e]
    $verb_ending .= "e";
  }
  # Every verb takes [s]
  $verb_ending .= "s";
  $verb .= $verb_ending;
}

# Pick an article
$article = pick($ar);

# Pick a noun
$noun = pick($n);

# Adapt article
$nFirstChar = $noun[0];
if (($article == "a") and
  (in_array($nFirstChar, $vowels))) {
  $article = "an";
}

# Make an array of words
$sentence_array = array (
  $subject,
  $verb,
  $article,
  $noun
);

# Put the words together around spaces
# removing the last space
$sentence = trim(implode($sentence_array, " "));

# Capitalize and add period
echo ucfirst($sentence).".";


# flip a coin
mt_rand(0,1);
?>
