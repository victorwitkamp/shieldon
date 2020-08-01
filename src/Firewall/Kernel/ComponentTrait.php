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

namespace Shieldon\Firewall\Kernel;

use Shieldon\Firewall\Kernel;
use Shieldon\Firewall\Component\ComponentInterface;
use Shieldon\Firewall\Component\ComponentProvider;

/*
 * @since 1.0.0
 */
trait ComponentTrait
{
    /**
     * Container for Shieldon components.
     *
     * @var array
     */
    public $component = [];

    /**
     * Set a commponent.
     *
     * @param ComponentProvider $instance The component instance.
     *
     * @return void
     */
    public function setComponent(ComponentProvider $instance): void
    {
        $class = $this->getClassName($instance);
        $this->component[$class] = $instance;
    }

    /**
     * Get a component instance from component's container.
     *
     * @param string $name The component's class name.
     *
     * @return ComponentInterface|null
     */
    public function getComponent(string $name)
    {
        if (!isset($this->component[$name])) {
            return null;
        }

        return $this->component[$name];
    }

    /**
     * Disable all components.
     *
     * @return void
     */
    public function disableComponents(): void
    {
        $this->component = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Stage in Kernel
    |--------------------------------------------------------------------------
    | The below methods are used in "process" method in Kernel.
    */

    /**
     * Initialize components.
     *
     * @return void
     */
    protected function initComponents()
    {
        foreach (array_keys($this->component) as $name) {
            $this->component[$name]->setIp($this->ip);
            $this->component[$name]->setRdns($this->rdns);

            // Apply global strict mode to all components by `strictMode()` if nesscessary.
            if (isset($this->strictMode)) {
                $this->component[$name]->setStrict($this->strictMode);
            }
        }
    }

    /**
     * Check if current IP is trusted or not.
     *
     * @return bool
     */
    protected function isTrustedBot()
    {
        if ($this->getComponent('TrustedBot')) {

            // We want to put all the allowed robot into the rule list, so that the checking of IP's resolved hostname 
            // is no more needed for that IP.
            if ($this->getComponent('TrustedBot')->isAllowed()) {

                if ($this->getComponent('TrustedBot')->isGoogle()) {
                    // Add current IP into allowed list, because it is from real Google domain.
                    $this->action(
                        Kernel::ACTION_ALLOW,
                        Kernel::REASON_IS_GOOGLE
                    );

                } elseif ($this->getComponent('TrustedBot')->isBing()) {
                    // Add current IP into allowed list, because it is from real Bing domain.
                    $this->action(
                        Kernel::ACTION_ALLOW,
                        Kernel::REASON_IS_BING
                    );

                } elseif ($this->getComponent('TrustedBot')->isYahoo()) {
                    // Add current IP into allowed list, because it is from real Yahoo domain.
                    $this->action(
                        Kernel::ACTION_ALLOW,
                        Kernel::REASON_IS_YAHOO
                    );

                } else {
                    // Add current IP into allowed list, because you trust it.
                    // You have already defined it in the settings.
                    $this->action(
                        Kernel::ACTION_ALLOW,
                        Kernel::REASON_IS_SEARCH_ENGINE
                    );
                }
                // Allowed robots not join to our traffic handler.
                $this->result = Kernel::RESPONSE_ALLOW;
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether the IP is fake search engine or not.
     * The method "isTrustedBot()" must be executed before this method.
     *
     * @return bool
     */
    protected function isFakeRobot(): bool
    {
        if ($this->getComponent('TrustedBot')) {
            if ($this->getComponent('TrustedBot')->isFakeRobot()) {
                $this->action(
                    Kernel::ACTION_DENY,
                    Kernel::REASON_COMPONENT_TRUSTED_ROBOT
                );
                $this->result = Kernel::RESPONSE_DENY;
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether the IP is handled by IP compoent or not.
     *
     * @return bool
     */
    protected function isIpComponent(): bool
    {
        if ($this->getComponent('Ip')) {

            $result = $this->getComponent('Ip')->check($this->ip);

            $actionCode = Kernel::ACTION_DENY;

            if (!empty($result)) {

                switch ($result['status']) {

                    case 'allow':
                        $actionCode = Kernel::ACTION_ALLOW;
                        $reasonCode = $result['code'];
                        break;
    
                    case 'deny':
                        $actionCode = Kernel::ACTION_DENY;
                        $reasonCode = $result['code']; 
                        break;
                }

                $this->action($actionCode, $reasonCode);

                // $resultCode = $actionCode
                $this->result = $this->sessionHandler($actionCode);
                return true;
            }
        }
        return false;
    }

    /**
     * Check other compoents.
     *
     * @return bool
     */
    protected function isComponents()
    {
        foreach ($this->component as $component) {

            if ($component->isDenied()) {

                $this->action(
                    Kernel::ACTION_DENY,
                    $component->getDenyStatusCode()
                );

                $this->result = Kernel::RESPONSE_DENY;
                return true;
            }
        }
        return false;
    }
}
