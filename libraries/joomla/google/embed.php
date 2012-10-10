<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Google
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;
jimport('joomla.environment.uri');

/**
 * Google API object class for the Joomla Platform.
 *
 * @package     Joomla.Platform
 * @subpackage  Google
 * @since       1234
 */
abstract class JGoogleEmbed
{
	/**
	 * @var    JRegistry  Options for the Google data object.
	 * @since  1234
	 */
	protected $options;

	/**
	 * @var    JURI  URI of the page being rendered.
	 * @since  1234
	 */
	protected $uri;

	/**
	 * Constructor.
	 *
	 * @param   JRegistry  $options  Google options object
	 * @param   JURI       $uri      URL of the page being rendered
	 *
	 * @since   1234
	 */
	public function __construct(JRegistry $options = null, JURI $uri = null)
	{
		$this->options = $options ? $options : new JRegistry;
		$this->uri = $uri ? $uri : new JURI;
	}

	/**
	 * Method to retrieve the javascript header for the embed API
	 *
	 * @return  string  The header
	 *
	 * @since   1234
	 */
	public function isSecure()
	{
		return $this->uri->getScheme() == 'https';
	}

	/**
	 * Method to retrieve the header for the API
	 *
	 * @return  string  The header
	 *
	 * @since   1234
	 */
	abstract public function getHeader();

	/**
	 * Method to retrieve the body for the API
	 *
	 * @return  string  The body
	 *
	 * @since   1234
	 */
	abstract public function getBody();

	/**
	 * Method to output the javascript header for the embed API
	 *
	 * @return  null
	 *
	 * @since   1234
	 */
	public function echoHeader()
	{
		echo $this->getHeader();
	}

	/**
	 * Method to output the body for the API
	 *
	 * @return  null
	 *
	 * @since   1234
	 */
	public function echoBody()
	{
		echo $this->getBody();
	}

	/**
	 * Get an option from the JGoogleEmbed instance.
	 *
	 * @param   string  $key  The name of the option to get.
	 *
	 * @return  mixed  The option value.
	 *
	 * @since   1234
	 */
	public function getOption($key)
	{
		return $this->options->get($key);
	}

	/**
	 * Set an option for the JGoogleEmbed instance.
	 *
	 * @param   string  $key    The name of the option to set.
	 * @param   mixed   $value  The option value to set.
	 *
	 * @return  JGoogleEmbed  This object for method chaining.
	 *
	 * @since   1234
	 */
	public function setOption($key, $value)
	{
		$this->options->set($key, $value);

		return $this;
	}

	/**
	 * Create a javascript array from a PHP array
	 *
	 * @param   array  $array   The array to convert to javascript
	 * @param   bool   $escape  Escape strings
	 *
	 * @return  string  The javscript code
	 *
	 * @since   1234
	 */
	static protected function arrayToJavascript($array, $escape = true)
	{
		$string = '';
		foreach ($array as $key => $value)
		{
			if (is_string($key))
			{
				$string .= $key . ':';
			}

			if ($escape && is_string($value))
			{
				$string .= '"' . str_replace('"', '\"', $value) . '"';
			}
			elseif (is_array($value))
			{
				$string .= '[' . self::arrayToJavascript($vaue) . ']';
			}
			elseif (is_bool($value))
			{
				$string .= $value ? 'true' : 'false';
			}
			elseif (is_null($value))
			{
				$string .= 'null';
			}
			else
			{
				$string .= $value;
			}

			$string .= ',';
		}

		return substr($string, 0, -1);
	}
}