<?php
/**
 * convert.php
 * Convert date formats
 * Written by battye
 */

namespace battye\date_convert;

class convert
{
	public $date = null;
	public $from = null;
	public $to = null;
	public $timezone = null;

	/**
	 * Accept a date string
	 * @param $date
	 * @return convert
	 */
	public static function date($date)
	{
		$convert = new convert;
		$convert->date = $date;
		return $convert;
	}

	/**
	 * Accept the date format of the date string
	 * @param $from
	 * @return $this
	 */
	public function from($from)
	{
		$this->from = $from;
		return $this;
	}

	/**
	 * Specify the desired date format
	 * @param $to
	 * @return $this
	 */
	public function to($to)
	{
		$this->to = $to;
		return $this;
	}

	/**
	 * Specify a desired timezone (either as a string or a DateTimeZone)
	 * @param $timezone
	 * @return $this
	 */
	public function timezone($timezone)
	{
		$this->timezone = $timezone;
		return $this;
	}

	/**
	 * Return the timestamp
	 * @return int
	 * @throws \Exception
	 */
	public function timestamp()
	{
		return $this->datetime()->getTimestamp();
	}

	/**
	 * Return the date in a format as specified from the to function
	 * @return string
	 * @throws \Exception
	 */
	public function datetext()
	{
		// Don't continue without a to format
		if (empty($this->to))
		{
			throw new \Exception('Cannot convert date without a supplied "to" format.');
		}

		return $this->datetime()->format($this->to);
	}

	/**
	 * Return the date as a DateTime object
	 * @return bool|\DateTime
	 * @throws \Exception
	 */
	public function datetime()
	{
		// Don't continue without a from format
		if (empty($this->from))
		{
			throw new \Exception('Cannot convert date without a supplied "from" format.');
		}

		$date = \DateTime::createFromFormat($this->from, $this->date);

		// Don't continue if there's a problem with the format
		if (!$date)
		{
			throw new \Exception('Cannot convert date with the supplied date string and "from" format.');
		}
	
		// Apply timezone if it has been supplied
		if (!is_null($this->timezone))
		{
			$zone = null;

			// If a time zone object was supplied, use that
			if ($this->timezone instanceof \DateTimeZone)
			{
				$zone = $this->timezone;
			}

			// Otherwise use a string
			else if (is_string($this->timezone))
			{
				$zone = new \DateTimeZone($this->timezone);
			}

			$date->setTimezone($zone);
		}

		return $date;
	}
}
