<?php

// Load Numword
require('numword.php');

// one-thousand, two-hundred thirty-four
echo Numword::single(1234);

// six-thousand, nine-hundred thirty-four dollars and thirty-four cents
echo Numword::currency('$6934.34');

// That movie is three years old.
echo Numword::block('That movie is 3 years old.');
