<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Communication\Plugin\ProductManagement;

use ArrayObject;
use Generated\Shared\Transfer\ProductAbstractReadinessRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractReadinessProviderPluginInterface;

/**
 * @method \Spryker\Zed\ProductSearch\Business\ProductSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductSearch\Business\ProductSearchBusinessFactory getBusinessFactory()
 * @method \Spryker\Zed\ProductSearch\Communication\ProductSearchBusinessFactory getFactory()
 * @method \Spryker\Zed\ProductSearch\ProductSearchConfig getConfig()
 */
class IsSearchableForLocaleAbstractProductReadinessProviderPlugin extends AbstractPlugin implements ProductAbstractReadinessProviderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands readiness collection with locales where concrete products are searchable / not searchable.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAbstractReadinessRequestTransfer $productAbstractReadinessRequestTransfer
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer> $productReadinessTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer>
     */
    public function provide(
        ProductAbstractReadinessRequestTransfer $productAbstractReadinessRequestTransfer,
        ArrayObject $productReadinessTransfers
    ): ArrayObject {
        return $this->getBusinessFactory()
            ->createIsSearchableForLocaleAbstractProductReadinessProvider()
            ->provide($productAbstractReadinessRequestTransfer, $productReadinessTransfers);
    }
}
