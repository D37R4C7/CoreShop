<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Core\Model\CarrierInterface;
use CoreShop\Component\Core\Repository\CarrierRepositoryInterface;
use CoreShop\Component\Resource\Repository\RepositoryInterface;
use CoreShop\Component\Shipping\Model\ShippingRuleInterface;
use Webmozart\Assert\Assert;

final class ShippingContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private CarrierRepositoryInterface $carrierRepository, private RepositoryInterface $shippingRuleRepository)
    {
    }

    /**
     * @Transform /^carrier "([^"]+)"$/
     */
    public function getCarrierByName(string $name): CarrierInterface
    {
        /**
         * @var CarrierInterface[] $carriers
         */
        $carriers = $this->carrierRepository->findBy(['identifier' => $name]);

        Assert::eq(
            count($carriers),
            1,
            sprintf('%d carriers has been found with name "%s".', count($carriers), $name)
        );

        return reset($carriers);
    }

    /**
     * @Transform /^carrier$/
     */
    public function getLatestCarrier(): CarrierInterface
    {
        return $this->sharedStorage->get('carrier');
    }

    /**
     * @Transform /^shipping rule "([^"]+)"$/
     */
    public function getShippingRuleByName(string $ruleName): ShippingRuleInterface
    {
        $rule = $this->shippingRuleRepository->findOneBy(['name' => $ruleName]);

        Assert::isInstanceOf($rule, ShippingRuleInterface::class);

        return $rule;
    }

    /**
     * @Transform /^(shipping rule)$/
     */
    public function getLatestShippingRule(): ShippingRuleInterface
    {
        $resource = $this->sharedStorage->get('shipping-rule');

        Assert::isInstanceOf($resource, ShippingRuleInterface::class);

        return $resource;
    }
}
