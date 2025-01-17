<?php

namespace Obs\Internal\Common;


/**
 * JSON Schema formatter class
 */
class SchemaFormatter
{
    /** @var \DateTimeZone */
    protected static $utcTimeZone;

    /**
     * Format a value by a registered format name
     *
     * @param string $format Registered format used to format the value
     * @param mixed $value Value being formatted
     *
     * @return mixed
     * @throws \Exception
     */
    public static function format($format, $value)
    {
        switch ($format) {
            case 'date-time':
                return self::formatDateTime($value);
            case 'date-time-http':
                return self::formatDateTimeHttp($value);
            case 'date':
                return self::formatDate($value);
            case 'time':
                return self::formatTime($value);
            case 'timestamp':
                return self::formatTimestamp($value);
            case 'boolean-string':
                return self::formatBooleanAsString($value);
            case 'date-time-middle':
                return self::formatDateTimeMiddle($value);
            default:
                return $value;
        }
    }

    /**
     * Treat $dateTime as UTC time
     * @param mixed $dateTime
     * @return mixed
     * @throws \Exception
     */
    public static function formatDateTimeMiddle($dateTime)
    {
        if (is_string($dateTime)) {
            $dateTime = new \DateTime($dateTime);
        }

        if ($dateTime instanceof \DateTime) {
            return $dateTime->format('Y-m-d\T00:00:00\Z');
        }
        return null;
    }

    /**
     * Create a ISO 8601 (YYYY-MM-DDThh:mm:ssZ) formatted date time value in UTC time
     *
     * @param string|integer|\DateTime $value Date time value
     *
     * @return string
     * @throws \Exception
     */
    public static function formatDateTime($value)
    {
        return self::dateFormatter($value, 'Y-m-d\TH:i:s\Z');
    }

    /**
     * Create an HTTP date (RFC 1123 / RFC 822) formatted UTC date-time string
     *
     * @param string|integer|\DateTime $value Date time value
     *
     * @return string
     * @throws \Exception
     */
    public static function formatDateTimeHttp($value)
    {
        return self::dateFormatter($value, 'D, d M Y H:i:s \G\M\T');
    }

    /**
     * Create a YYYY-MM-DD formatted string
     *
     * @param string|integer|\DateTime $value Date time value
     *
     * @return string
     * @throws \Exception
     */
    public static function formatDate($value)
    {
        return self::dateFormatter($value, 'Y-m-d');
    }

    /**
     * Create a hh:mm:ss formatted string
     *
     * @param string|integer|\DateTime $value Date time value
     *
     * @return string
     * @throws \Exception
     */
    public static function formatTime($value)
    {
        return self::dateFormatter($value, 'H:i:s');
    }

    /**
     * Formats a boolean value as a string
     *
     * @param string|integer|bool $value Value to convert to a boolean 'true' / 'false' value
     *
     * @return string
     */
    public static function formatBooleanAsString($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    }

    /**
     * Return a UNIX timestamp in the UTC timezone
     *
     * @param string|integer|\DateTime $value Time value
     *
     * @return int
     * @throws \Exception
     */
    public static function formatTimestamp($value)
    {
        return (int)self::dateFormatter($value, 'U');
    }

    /**
     * Get a UTC DateTimeZone object
     *
     * @return \DateTimeZone
     */
    protected static function getUtcTimeZone()
    {
        // @codeCoverageIgnoreStart
        if (!self::$utcTimeZone) {
            self::$utcTimeZone = new \DateTimeZone('UTC');
        }
        // @codeCoverageIgnoreEnd

        return self::$utcTimeZone;
    }

    /**
     * Perform the actual DateTime formatting
     *
     * @param int|string|\DateTime $dateTime Date time value
     * @param string $format Format of the result
     *
     * @return string
     * @throws \Exception
     */
    protected static function dateFormatter($dateTime, $format)
    {
        if (is_numeric($dateTime)) {
            return gmdate($format, (int)$dateTime);
        }

        if (is_string($dateTime)) {
            $dateTime = new \DateTime($dateTime);
        }

        if ($dateTime instanceof \DateTime) {
            return $dateTime->setTimezone(self::getUtcTimeZone())->format($format);
        }

        return null;
    }
}
