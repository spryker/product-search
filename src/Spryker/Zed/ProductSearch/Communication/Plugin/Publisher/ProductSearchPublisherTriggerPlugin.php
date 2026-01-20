<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Zed\ProductSearch\Communication\Plugin\Publisher;

use Generated\Shared\Transfer\ProductSearchCriteriaTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductSearch\Dependency\ProductSearchEvents;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherTriggerPluginInterface;

/**
 * {@inheritDoc}
 *
 * @api
 *
 * @method \Spryker\Zed\ProductSearch\Business\ProductSearchFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductSearch\ProductSearchConfig getConfig()
 * @method \Spryker\Zed\ProductSearch\Communication\ProductSearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductSearch\Persistence\ProductSearchRepositoryInterface getRepository()
 */
class ProductSearchPublisherTriggerPlugin extends AbstractPlugin implements PublisherTriggerPluginInterface
{
    protected const COL_ID_PRODUCT_SEARCH_KEY = 'spy_product_search.id_product_search';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array<\Generated\Shared\Transfer\ProductSearchTransfer>
     */
    public function getData(int $offset, int $limit): array
    {
        $productSearchCriteriaTransfer = (new ProductSearchCriteriaTransfer())
            ->setOffset($offset)
            ->setLimit($limit);

        return $this->getRepository()->getProductSearchEntityByCriteria($productSearchCriteriaTransfer);
    }

    public function getResourceName(): string
    {
        return ProductSearchEvents::PRODUCT_SEARCH_RESOURCE_NAME;
    }

    public function getEventName(): string
    {
        return ProductSearchEvents::ENTITY_SPY_PRODUCT_SEARCH_UPDATE;
    }

    public function getIdColumnName(): ?string
    {
        return static::COL_ID_PRODUCT_SEARCH_KEY;
    }
}
