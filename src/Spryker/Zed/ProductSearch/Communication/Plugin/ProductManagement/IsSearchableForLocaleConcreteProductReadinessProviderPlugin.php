<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Communication\Plugin\ProductManagement;

use ArrayObject;
use Generated\Shared\Transfer\ProductConcreteReadinessRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductConcreteReadinessProviderPluginInterface;

/**
 * @method \Spryker\Zed\ProductSearch\Business\ProductSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductSearch\Business\ProductSearchBusinessFactory getBusinessFactory()
 * @method \Spryker\Zed\ProductSearch\Communication\ProductSearchBusinessFactory getFactory()
 * @method \Spryker\Zed\ProductSearch\ProductSearchConfig getConfig()
 */
class IsSearchableForLocaleConcreteProductReadinessProviderPlugin extends AbstractPlugin implements ProductConcreteReadinessProviderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Adds readiness entries showing locales where a concrete product is searchable / not searchable.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductConcreteReadinessRequestTransfer $productConcreteReadinessRequestTransfer
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer> $productReadinessTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer>
     */
    public function provide(
        ProductConcreteReadinessRequestTransfer $productConcreteReadinessRequestTransfer,
        ArrayObject $productReadinessTransfers
    ): ArrayObject {
        return $this->getBusinessFactory()
            ->createIsSearchableForLocaleConcreteProductReadinessProvider()
            ->provide($productConcreteReadinessRequestTransfer, $productReadinessTransfers);
    }
}
