<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class RestTester extends \Codeception\Actor
{
    use _generated\RestTesterActions;

    /**
     * Note:
     * On routing errors aerys does not proceed all middlewares...
     * And itself not pass x-powered header.
     * @return bool
     */
    public function isPoweredByAerys(): bool
    {
        return !$this->isPoweredByRatchet();
    }

    public function isPoweredByRatchet(): bool
    {
        $xPoweredByHeader = $this->grabHttpHeader('X-Powered-By', true);
        return strpos($xPoweredByHeader, 'Ratchet') !== false;
    }

}
