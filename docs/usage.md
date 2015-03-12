# Numword #

*Documentation may be outdated or incomplete as some URLs may no longer exist.*

*Warning! This codebase is deprecated and will no longer receive support; excluding critical issues.*

A small script that can convert a number to its word equivalent. Can work with single numbers, multiple numbers, currency and within text blocks.

Numword is a play on words for: Number Word Converter.

* Convert single or multiple numbers
* Convert USD currency
* Convert all numbers within a string
* Supports up to octillions

## Installation ##

Install by manually downloading the library or defining a [Composer dependency](http://getcomposer.org/).

```javascript
{
    "require": {
        "mjohnson/numword": "2.0.0"
    }
}
```

## Converting Numbers ##

It's rather easy to convert numbers to a word. To do so you use the `single()` or `multiple()` methods. The `single()` method will accept 1 argument &ndash; which should be an integer &ndash; and will return its word equivalent. By default, all words are separated by a dash (-), but can be changed by editing the `$sep` property.

```php
echo mjohnson\numword\Numword::single(1234); 
// one-thousand, two-hundred thirty-four
```

The `multiple()` method will take an array of integers as its first argument and will return an array with the respective words.

```php
print_r(mjohnson\numword\Numword::multiple(array(123, 5643, 64)));

/* Array
(
    [0] => one-hundred twenty-three
    [1] => five-thousand, six-hundred forty-three
    [2] => sixty-four
) */
```

 Really large numbers must be passed as strings or PHP will fail on 32bit integers.

## Converting Currency ##

As of right now, the `currency()` method will take an amount and return it to its dollar word format. This only works for USD, but you could easily edit the `currency()` method and replace the $ and "dollars" with the currency text you wish.

```php
echo mjohnson\numword\Numword::currency('$6934.34'); 
// six-thousand, nine-hundred thirty-four dollars and thirty-four cents
```

The currency() method also takes a second argument to translate the words.

```php
echo mjohnson\numword\Numword::currency('£6934.34', array('dollar' => 'pound(s)', 'cent' => 'pence')) 
// six-thousand, nine-hundred thirty-four pound(s) and thirty-four pence
```

## Converting Numbers Within A String ##

If for some reason you have a number stuck right in the middle of a string and can't convert that number by itself, you would use the `block()` method. The `block()` method will convert all numbers that are found within the given string.

```php
echo mjohnson\numword\Numword::block('I am 21 years old, but my friend is 23.');
// I am twenty-one years old, but my friend is twenty-three.
```

## Translating ##

Numword doesn't really have built in localization support (excluding `currency()`) but you can translate the output very easily. To do so, simply overwrite the static variables with your own since they are public. For example, in Spanish:

```php
mjohnson\numword\Numword::$digits = array('cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
```
