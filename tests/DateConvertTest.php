<?php
/**
 * Class DateConvertTest
 * Test date string conversions
 */

use battye\date_convert\convert;

class DateConvertTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * Test a simple conversion
	 */
	public function testSimpleConvert()
	{
		$convert = convert::date('2011-01-20 00:00:00+09')
			->from('Y-m-d H:i:sT')
			->to('j F y');

		// Check we get a DateTime
		$this->assertInstanceOf('DateTime', $convert->datetime());

		// ... and that it's the right value
		$this->assertEquals('1295449200', $convert->timestamp());

		// Check our from function works
		$this->assertEquals('20 January 11', $convert->datetext());
	}

	/**
	 * Test a time zone conversion
	 */
	public function testTimeZoneConvert()
	{
		$convert = convert::date('2011-01-20 00:00:00+09')
			->from('Y-m-d H:i:sT')
			->to('Y-m-d H:i:s');

		// Check timezone conversion
		$timeZoneUsingObject = $convert->timezone(new \DateTimeZone('Asia/Macau'))->datetext();
		$timeZoneUsingString = $convert->timezone('Asia/Macau')->datetext();

		// They should be the same
		$this->assertEquals($timeZoneUsingObject, $timeZoneUsingString);

		// They should be an hour backwards
		$this->assertEquals('2011-01-19 23:00:00', $timeZoneUsingString);
	}

	/**
	 * Test execution without the from argument
	 * @throws Exception
	 */
	public function testExceptionNoFrom()
	{
		$this->expectExceptionMessage('Cannot convert date without a supplied "from" format.');
		convert::date('2011-01-20 00:00:00+09')->timestamp();
	}

	/**
	 * Test execution with a bad from argument
	 * @throws Exception
	 */
	public function testExceptionBadFrom()
	{
		$this->expectExceptionMessage('Cannot convert date with the supplied date string and "from" format.');
		convert::date('2011-01-20 00:00:00+09')->from('wrong format')->datetime();
	}

	/**
	 * Test execution without the to argument
	 * @throws Exception
	 */
	public function testExceptionNoTo()
	{
		$this->expectExceptionMessage('Cannot convert date without a supplied "to" format.');
		convert::date('2011-01-20 00:00:00+09')->from('Y-m-d H:i:sT')->datetext();
	}
}
