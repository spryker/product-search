<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Persistence;

use Generated\Shared\Transfer\ProductSearchAttributeCollectionTransfer;
use Generated\Shared\Transfer\ProductSearchAttributeCriteriaTransfer;
use Generated\Shared\Transfer\ProductSearchCriteriaTransfer;

interface ProductSearchRepositoryInterface
{
    /**
     * Result format:
     * [
     *     $idProduct => [$idLocale => $count],
     *     ...,
     * ]
     *
     * @param array<int> $productIds
     * @param array<int> $localeIds
     *
     * @return array<int, array<int, int>>
     */
    public function getProductSearchEntitiesCountGroupedByIdProductAndIdLocale(
        array $productIds,
        array $localeIds
    ): array;

    /**
     * @return array<string>
     */
    public function getAllProductAttributeKeys(): array;

    public function getProductSearchAttributeCollection(
        ProductSearchAttributeCriteriaTransfer $productSearchAttributeCriteriaTransfer
    ): ProductSearchAttributeCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProductSearchCriteriaTransfer $productSearchCriteriaTransfer
     *
     * @return array<\Generated\Shared\Transfer\ProductSearchTransfer>
     */
    public function getProductSearchEntityByCriteria(ProductSearchCriteriaTransfer $productSearchCriteriaTransfer): array;
}
