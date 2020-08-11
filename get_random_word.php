<?php
function getRandomWord() {
    $word = range('a', 'z');
    shuffle($word);
    return substr(implode($word), 0, rand(3,7));
}
function getWord() {
  for ($i=0; $i < rand(2,15); $i++) { 
    echo ucfirst(getRandomWord()). ' ';
  }
}
