<?php
/**
 * Numword - Converts a number to its word form.
 * 
 * @author 		Miles Johnson - www.milesj.me
 * @copyright	Copyright 2006-2009, Miles Johnson, Inc.
 * @license 	http://www.opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @link		www.milesj.me/resources/script/numword
 */

class Numword {

	/**
	 * Current version: www.milesj.me/resources/logs/numword
	 *
	 * @access public
	 * @var int
	 */
	public $version = '1.4';

	/**
	 * Holds the basic numbers: 1-10
	 *
	 * @access public
	 * @var array
	 * @static
	 */
	public static $digits = array('zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
	
	/**
	 * Holds all the teens: 11-19
	 *
	 * @access public
	 * @var array
	 * @static
	 */
	public static $teens = array(
		11 => 'eleven',
		12 => 'twelve',
		13 => 'thirteen',
		14 => 'fourteen',
		15 => 'fifteen',
		16 => 'sixteen',
		17 => 'seventeen',
		18 => 'eighteen',
		19 => 'nineteen'
	);
	
	/**
	 * Holds the multiples of ten: 10, 20, - 90
	 *
	 * @access public
	 * @var array
	 * @static
	 */
	public static $tens = array(
		10 => 'ten',
		20 => 'twenty',
		30 => 'thirty',
		40 => 'forty',
		50 => 'fifty',
		60 => 'sixty',
		70 => 'seventy',
		80 => 'eighty',
		90 => 'ninety'
	);
	
	/**
	 * Holds the larger numbers.
	 *
	 * @access public
	 * @var array
	 * @static
	 */
	public static $exponents = array(
		1	=> 'hundred',
		2 	=> 'thousand',
		3 	=> 'million',
		4 	=> 'billion',
		5 	=> 'trillion',
		6	=> 'quadrillion',
		7 	=> 'quintillion',
		8	=> 'sextillion',
		9	=> 'septillion',
		10	=> 'octillion',
		11 	=> 'nonillion', 
		12 	=> 'decillion',
		13	=> 'undecillion',
		14	=> 'duodecillion', 
		15	=> 'tredecillion', 
		16	=> 'quattuordecillion',
		17	=> 'quindecillion',
		18	=> 'sexdecillion', 
		19	=> 'septendecillion', 
		20	=> 'octodecillion',
		21 	=> 'novemdecillion', 
		22	=> 'vigintillion',
		23 	=> 'centillion'
	);
	
	/**
	 * The separator between words.
	 *
	 * @access public
	 * @var string
	 * @static
	 */
	public static $sep = '-'; 
	
	/**
	 * Converts a single number to its word format.
	 *
	 * @access public
	 * @param int $number
	 * @return string
	 * @static
	 */
	public static function single($number) {
		$numberClean = trim(str_replace(',', '', $number));
		
		if (is_numeric($numberClean)) {
			return self::__convert($numberClean);
		} else {
			return $number;
		}
	}
	
	/**
	 * Converts many numbers to its word format.
	 *
	 * @access public
	 * @param array $numbers
	 * @return array
	 * @static
	 */
	public static function multiple($numbers) {
		if (is_array($numbers)) {
			foreach ($numbers as $index => $number) {
				$numbers[$index] = self::single($number);
			}
		}
		
		return $numbers;
	}
	
	/**
	 * Converts any numeric instance in a block of text (sentence/string) to its word format.
	 *
	 * @access public
	 * @param string $string
	 * @return string
	 * @static
	 */
	public static function block($string) {
		$words = explode(' ', $string);
		
		foreach ($words as $index => $word) {
			if (preg_match("/[0-9]/i", $word)) {
				$fl = mb_substr($word, 0, 1);
				$ll = mb_substr($word, -1);
				$pre = '';
				$suf = '';
				
				if (!is_numeric($fl)) {
					$pre = $fl;
					$word = mb_substr($word, 1, mb_strlen($word) - 1);
				}
				
				if (!is_numeric($ll)) {
					$suf = $ll;
					$word = mb_substr($word, 0, mb_strlen($word) - 1);
				}
				
				$words[$index] = $pre . self::__convert($word) . $suf;
			} else {
				$words[$index] = $word;
			}
		}
		
		return implode(' ', $words);
	}
	
	/**
	 * Converts american currency into its word format.
	 *
	 * @access public
	 * @param int $number
	 * @return string
	 * @static
	 */
	public static function currency($number) {
		$number = trim(str_replace(array('$', ','), '', $number));
		$cents  = trim(mb_strstr($number, '.'), '.');
		$amount = mb_substr($number, 0, mb_strpos($number, '.'));
		
		$return = self::__convert($amount) .' dollars';
		
		if ($cents != '00' && mb_strlen($cents) == 2) {
			$return .= ' and '. self::__convertDoubles($cents) .' cent';
			if ($cents > 1) {
				$return .= 's';
			}
		}
		
		return $return;
	}
	
	/**
	 * Determines numbers length then converts to words.
	 *
	 * @access private
	 * @param int $number
	 * @return string
	 * @static
	 */
	private static function __convert($number) {
		$length = mb_strlen($number);
		
		if ($length > 3) {
			$return = self::__convertMultiples($number);
		} else if ($length == 3) {
			$return = self::__convertTriples($number);
		} else if ($length == 2) {
			$return = self::__convertDoubles($number);
		} else {
			$return = self::$digits[$number];
		}
		
		return $return;
	}
	
	/**
	 * Converts doubles: 10-99.
	 *
	 * @access private
	 * @param int $number
	 * @return string
	 * @static
	 */
	private static function __convertDoubles($number) {
		$fn = mb_substr($number, 0, 1);
		$ln = mb_substr($number, -1);
		
		if ($fn == 1 && $ln != 0) {
			$return = self::$teens[$number];
		} else if ($ln == 0) {
			$return = self::$tens[$number];
		} else {
			$return = self::$tens[$fn .'0'] . self::$sep . self::$digits[$ln];
		}
		
		return $return;
	}
	
	/**
	 * Converts triples: 100-999.
	 *
	 * @access private
	 * @param int $number
	 * @return string
	 * @static
	 */
	private static function __convertTriples($number) {
		$fn = mb_substr($number, 0, 1);
		$ln = mb_substr($number, -2);
		$return = '';
		
		if ($fn != 0) {
			$return = self::$digits[$fn] . self::$sep . self::$exponents[1];
		}
		
		if ($ln != '00') {
			$return .= ' '. self::__convertDoubles($ln);
		}
		
		return $return;
	}
	
	/**
	 * Converts large numbers: 1000+.
	 * 
	 * @access private
	 * @param int $number
	 * @return string
	 * @static
	 */
	private static function __convertMultiples($number) {
		$numrev = mb_strrev($number);
		$parts = str_split($numrev, 3);
		
		$cur = 1;
		$newParts = array();
		foreach ($parts as $index => $part) {
			$ret = self::__convert(mb_strrev($part));
			if ($index > 0 && $part != '000') {
				$ret .= self::$sep . self::$exponents[$cur];
			}
			if ($ret != '') {
				$newParts[$index] = $ret;
			}
			$cur++;
		}
		
		$parts = array_reverse($newParts);
		$return = implode(', ', $parts);
			
		return $return;
	}
	
}
