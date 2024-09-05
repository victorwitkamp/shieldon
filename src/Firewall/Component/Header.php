<?php
/**
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * php version 7.1.0
 *
 * @category  Web-security
 * @package   Shieldon
 * @author    Terry Lin <contact@terryl.in>
 * @copyright 2019 terrylinooo
 * @license   https://github.com/terrylinooo/shieldon/blob/2.x/LICENSE MIT
 * @link      https://github.com/terrylinooo/shieldon
 * @see       https://shieldon.io
 */

declare(strict_types=1);

namespace WPShieldon\Firewall\Component;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use WPShieldon\Firewall\Component\ComponentProvider;
use WPShieldon\Firewall\Component\DeniedTrait;
use WPShieldon\Firewall\IpTrait;
use function WPShieldon\Firewall\get_request;
use WPShieldon\Firewall\Kernel\Enum;

/**
 * Header component.
 */
class Header extends ComponentProvider
{
	/**
     *   Public methods       | Desctiotion
     *  ----------------------|---------------------------------------------
     *   setIp                | Set an IP address.
     *   getIp                | Get current set IP.
     *   setRdns              | Set a RDNS record for the check.
     *   getRdns              | Get IP resolved hostname.
     *  ----------------------|---------------------------------------------
     */
	use IpTrait;

	/**
     *   Public methods       | Desctiotion
     *  ----------------------|---------------------------------------------
     *   setDeniedItems       | Add items to the blacklist pool.
     *   setDeniedItem        | Add an item to the blacklist pool.
     *   getDeniedItems       | Get items from the blacklist pool.
     *   getDeniedItem        | Get items from the blacklist pool.
     *   removeDeniedItem     | Remove a denied item if exists.
     *   removeDeniedItems    | Remove all denied items.
     *   hasDeniedItem        | Check if a denied item exists.
     *   getDenyWithPrefix    | Check if a denied item exists have the same prefix.
     *   removeDenyWithPrefix | Remove denied items with the same prefix.
     *   isDenied             | Check if an item is denied?
     *  ----------------------|---------------------------------------------
     */
	use DeniedTrait;

    /**
     * Constant
     */
	public const STATUS_CODE = Enum::REASON_COMPONENT_HEADER_DENIED;

	public Logger $psrlogger;

    /**
     * Very common requests from normal users.
     *
     * @var array
     */
	protected array $commonHeaderFields = [
		'Accept',
		'Accept-Language',
		'Accept-Encoding',
	];

    /**
     * Header information.
     *
     * @var array
     */
	protected array $headers = [];

    /**
     * Header component constructor.
     */
	public function __construct(bool $strictMode = true)
	{
          $this->headers = get_request()->getHeaders();
		$this->psrlogger = new Logger('HeaderLogger');
		$this->psrlogger->pushHandler(new StreamHandler(SHIELDON_PLUGIN_DIR . '/logs/Shieldon_Header.log', Level::Warning));
		$this->strictMode = $strictMode;
		$this->deniedList = [];
	}

    /**
     * {@inheritDoc}
     *
     * @return bool
     */
	public function isDenied(): bool
	{
		$this->psrlogger->warning('isDenied start (for IP: ' . $this->getIp() . ' - url: ' . $_SERVER['REQUEST_URI'] . ')');
		if (!empty($this->deniedList)) {
			$intersect = array_intersect_key($this->deniedList, $this->headers);
			
			foreach ($intersect as $headerName => $headerValue) {
				$requestHeader = get_request()->getHeaderLine($headerName);

                // When found a header field contains a prohibited string.
				if (stripos($requestHeader, $headerValue) !== false) {
					$this->psrlogger->warning('isDenied true prohibited string: ' . $headerValue . ' (for IP: ' . $this->getIp() . ' - url: ' . $_SERVER['REQUEST_URI'] . ')');
					return true;
				}
			}
		}

		if ($this->strictMode) {
			foreach ($this->commonHeaderFields as $fieldName) {
				// If strict mode is on, this value must be found.
				if (!isset($this->headers[$fieldName]) && empty($this->headers['referer'])) {
					$this->psrlogger->warning('isDenied(strict) true did not find fieldName: ' . $fieldName . ' or empty referer (for IP: ' . $this->getIp() . ' - url: ' . $_SERVER['REQUEST_URI'] . ')');
					return true;
				}
			}
		}
          
		$this->psrlogger->warning('isDenied false (for IP: ' . $this->getIp() . ' - url: ' . $_SERVER['REQUEST_URI'] . ')');
		return false;
	}

    /**
     * All request headers.
     *
     * @return array
     */
	public function getHeaders(): array
	{
		return $this->headers;
	}

    /**
     * Unique deny status code.
     *
     * @return string
     */
	public function getDenyStatusCode(): string
	{
		return self::STATUS_CODE;
	}
}
