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

namespace WPShieldon\Firewall\Kernel;

/**
 * The constants of Shieldon Firewall.
 */
class Enum
{
	/**
	 * HTTP Status Codes
	 */
	
	public const HTTP_STATUS_OK                = 200;
	public const HTTP_STATUS_SEE_OTHER         = 303;
	public const HTTP_STATUS_BAD_REQUEST       = 400;
	public const HTTP_STATUS_FORBIDDEN         = 403;
	public const HTTP_STATUS_TOO_MANY_REQUESTS = 429;

	/**
	 * Reason Codes (ALLOW)
	 */

	public const REASON_IS_SEARCH_ENGINE_ALLOWED  = 'REASON_IS_SEARCH_ENGINE_ALLOWED';
	public const REASON_IS_GOOGLE_ALLOWED         = 'REASON_IS_GOOGLE_ALLOWED';
	public const REASON_IS_BING_ALLOWED           = 'REASON_IS_BING_ALLOWED';
	public const REASON_IS_YAHOO_ALLOWED          = 'REASON_IS_YAHOO_ALLOWED';
	public const REASON_IS_SOCIAL_NETWORK_ALLOWED = 'REASON_IS_SOCIAL_NETWORK_ALLOWED';
	public const REASON_IS_FACEBOOK_ALLOWED       = 'REASON_IS_FACEBOOK_ALLOWED';
	public const REASON_IS_TWITTER_ALLOWED        = 'REASON_IS_TWITTER_ALLOWED';

	/**
	 * Reason Codes (DENY)
	 */

	public const REASON_TOO_MANY_SESSIONS_DENIED       = 'REASON_TOO_MANY_SESSIONS_DENIED';
	public const REASON_TOO_MANY_ACCESSE_DENIED        = 'REASON_TOO_MANY_ACCESSE_DENIED'; // (not used)
	public const REASON_EMPTY_JS_COOKIE_DENIED         = 'REASON_EMPTY_JS_COOKIE_DENIED';
	public const REASON_EMPTY_REFERER_DENIED           = 'REASON_EMPTY_REFERER_DENIED';
	public const REASON_REACH_DAILY_LIMIT_DENIED       = 'REASON_REACH_DAILY_LIMIT_DENIED';
	public const REASON_REACH_HOURLY_LIMIT_DENIED      = 'REASON_REACH_HOURLY_LIMIT_DENIED';
	public const REASON_REACH_MINUTELY_LIMIT_DENIED    = 'REASON_REACH_MINUTELY_LIMIT_DENIED';
	public const REASON_REACH_SECONDLY_LIMIT_DENIED    = 'REASON_REACH_SECONDLY_LIMIT_DENIED';
	public const REASON_INVALID_IP_DENIED              = 'REASON_INVALID_IP_DENIED';
	public const REASON_DENY_IP_DENIED                 = 'REASON_DENY_IP_DENIED';
	public const REASON_ALLOW_IP_DENIED                = 'REASON_ALLOW_IP_DENIED';
	public const REASON_COMPONENT_IP_DENIED            = 'REASON_COMPONENT_IP_DENIED';
	public const REASON_COMPONENT_RDNS_DENIED          = 'REASON_COMPONENT_RDNS_DENIED';
	public const REASON_COMPONENT_HEADER_DENIED        = 'REASON_COMPONENT_HEADER_DENIED';
	public const REASON_COMPONENT_USERAGENT_DENIED     = 'REASON_COMPONENT_USERAGENT_DENIED';
	public const REASON_COMPONENT_TRUSTED_ROBOT_DENIED = 'REASON_COMPONENT_TRUSTED_ROBOT_DENIED';
	public const REASON_MANUAL_BAN_DENIED              = 'REASON_MANUAL_BAN_DENIED';

	/**
	 * Action Codes
	 */

	public const ACTION_DENY             = 'ACTION_DENY';
	public const ACTION_ALLOW            = 'ACTION_ALLOW';
	public const ACTION_TEMPORARILY_DENY = 'ACTION_TEMPORARILY_DENY';
	public const ACTION_UNBAN            = 'ACTION_UNBAN';

	/**
	 * Result Codes
	 */
	public const RESPONSE_DENY             = 'RESPONSE_DENY';
	public const RESPONSE_ALLOW            = 'RESPONSE_ALLOW';
	public const RESPONSE_TEMPORARILY_DENY = 'RESPONSE_TEMPORARILY_DENY';
	public const RESPONSE_LIMIT_SESSION    = 'RESPONSE_LIMIT_SESSION';

	/**
	 * Logger Codes
	 */

	public const LOG_LIMIT     = 'LOG_LIMIT';
	public const LOG_PAGEVIEW  = 'LOG_PAGEVIEW';
	public const LOG_BLACKLIST = 'LOG_BLACKLIST';
	public const LOG_CAPTCHA   = 'LOG_CAPTCHA';

	public const KERNEL_DIR    = __DIR__ . '/../';
}
