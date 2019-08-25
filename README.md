# Date Convert
A small library which uses the `DateTime` object to convert a date string from one format to another.

## Installation

Install this library with composer, using the command `composer require battye/date-convert "~1.0"`. If you notice any bugs, please raise an issue or pull request.

### Simple Usage

The original date string must be supplied in the `date()` function. 

The `from()` function should be used to indicate the format being used, while `to()` should be filled with the desired output format (in conjunction with `datetext()`).

An example usage is shown below:

    use battye\date_convert\convert;
    
    $convert = convert::date('2011-01-20 00:00:00+09')
	    ->from('Y-m-d H:i:sT')
        ->to('j F y');
        
    $datetime = $convert->datetime(); // returns a DateTime object
    $datetext = $convert->datetext(); // returns 20 January 11
    $timestamp = $convert->timestamp(); // returns 1295449200
    
### Converting Timezones

To output a format in a different timezone, it can be specified in either of the following ways prior to calling `datetime()` or `datetext()`. Timestamps are not impacted by timezone.

    $convert->timezone(new \DateTimeZone('Asia/Macau'));
    $convert->timezone('Asia/Macau');
    
## Tests

[![Build Status](https://travis-ci.com/battye/date-convert.svg?branch=master)](https://travis-ci.com/battye/date-convert)

The unit tests provide good examples of how to utilise this library and can be found in the `tests/` directory. To execute the unit tests, run:

    vendor/bin/simple-phpunit tests/
