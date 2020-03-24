<?php
//https://stackoverflow.com/questions/1783089/array-splice-for-associative-arrays

$oldArray = array(
    "color" => "red",
    "taste" => "sweet",
    "season" => "summer"
);

# Insert at offset 2
$offset = 2;
$newArray = array_slice($oldArray, 0, $offset, true) +
            array('texture' => 'bumpy') +
            array_slice($oldArray, $offset, NULL, true);

print_r($newArray);
print_r(array_insert($oldArray, array('texture' => array(1,2,3,4)), 2));

function array_insert($array,$values,$offset) {
    return array_slice($array, 0, $offset, true) + $values + array_slice($array, $offset, NULL, true);  
}
