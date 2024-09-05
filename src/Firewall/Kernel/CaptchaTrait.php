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

use WPShieldon\Firewall\Kernel\Enum;
use WPShieldon\Firewall\Captcha\CaptchaInterface;
use function get_class;

/*
 * Captcha Trait is loaded in Kernel instance only.
 */
trait CaptchaTrait
{
	/**
     *   Public methods       | Desctiotion
     *  ----------------------|---------------------------------------------
     *   setCaptcha           | Set a captcha.
     *   captchaResponse      | Return the result from Captchas.
     *   disableCaptcha       | Mostly be used in unit testing purpose.
     *  ----------------------|---------------------------------------------
     */

	/**
	 * Container for captcha addons.
	 * The collection of \WPShieldon\Firewall\Captcha\CaptchaInterface
	 * 
     * @var array
	 */
	public array $captcha = [];

	/**
	 * Get a class name without namespace string.
	 * 
	 * @param object $instance Class
	 * 
     * @return string
	 */
	abstract protected function getClassName($instance): string;

	/**
	 * Deal with online sessions.
	 * 
	 * @param string $statusCode The response code.
	 * 
     * @return string The response code.
	 */
	abstract protected function sessionHandler(string $statusCode): string;

	/**
	 * Save and return the result identifier.
	 * This method is for passing value from traits.
	 * 
	 * @param string $resultCode The result identifier.
	 * 
     * @return string
	 */
	abstract protected function setResultCode(string $resultCode): string;

	/**
	 * Set a captcha.
	 * 
	 * @param CaptchaInterface $instance The captcha instance.
	 * 
     * @return void
	 */
	public function setCaptcha(CaptchaInterface $instance): void
	{
		$class = $this->getClassName($instance);
		$this->captcha[$class] = $instance;
	}

    /**
     * Return the result from Captchas.
     *
     * @return bool
     */
	public function captchaResponse(): bool
	{
		foreach ($this->captcha as $captcha) {
			if (!$captcha->response()) {
				$this->psrlogger->warning('Shieldon - CaptchaTrait - CaptchaResponse - ' . get_class($captcha) . ' - return false');
				return false;
			} else {
				$this->psrlogger->warning('Shieldon - CaptchaTrait - CaptchaResponse - ' . get_class($captcha) . ' - return true');
			}
		}

		/**
		 * $sessionLimit @ SessionTrait
		 * sessionHandler() @ SessionTrait
		 */
		if (!empty($this->sessionLimit['count'])) {
			return (bool) $this->setResultCode(
				$this->sessionHandler(Enum::RESPONSE_ALLOW)
			);
		}

		return true;
	}

	/**
	 * Mostly be used in unit testing purpose.
	 * 
	 * @return void
	 */
	public function disableCaptcha(): void
	{
		$this->captcha = [];
	}
}
