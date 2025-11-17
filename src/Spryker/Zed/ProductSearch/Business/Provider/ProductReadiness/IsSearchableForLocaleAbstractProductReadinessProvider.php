<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Business\Provider\ProductReadiness;

use ArrayObject;
use Generated\Shared\Transfer\ProductAbstractReadinessRequestTransfer;
use Generated\Shared\Transfer\ProductReadinessTransfer;

class IsSearchableForLocaleAbstractProductReadinessProvider implements ProductAbstractReadinessProviderInterface
{
    /**
     * @var string
     */
    protected const TITLE_AT_LEAST_ONE_CONCRETE_HAS_SEARCHABLE_FLAG_IN_LOCALES = 'At least one concrete has searchable flag in locales';

    /**
     * @var string
     */
    protected const TITLE_NO_CONCRETE_HAS_SEARCHABLE_FLAG_IN_LOCALES = 'No concrete has searchable flag in locales';

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractReadinessRequestTransfer $productAbstractReadinessRequestTransfer
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer> $productReadinessTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer>
     */
    public function provide(
        ProductAbstractReadinessRequestTransfer $productAbstractReadinessRequestTransfer,
        ArrayObject $productReadinessTransfers
    ): ArrayObject {
        if (!$productAbstractReadinessRequestTransfer->getProductConcretes()->count()) {
            return $productReadinessTransfers;
        }

        $isSearchableForLocaleList = [];
        foreach ($productAbstractReadinessRequestTransfer->getProductConcretes() as $productConcreteTransfer) {
            foreach ($productConcreteTransfer->getLocalizedAttributes() as $localizedAttributeTransfer) {
                $localeName = $localizedAttributeTransfer->getLocale()->getLocaleName();
                if (!isset($isSearchableForLocaleList[$localeName]) || !$isSearchableForLocaleList[$localeName]) {
                    $isSearchableForLocaleList[$localeName] = $localizedAttributeTransfer->getIsSearchable();
                }
            }
        }

        $searchableInLocaleReadiness = (new ProductReadinessTransfer())
            ->setTitle(static::TITLE_AT_LEAST_ONE_CONCRETE_HAS_SEARCHABLE_FLAG_IN_LOCALES);

        $notSearchableInLocaleReadiness = (new ProductReadinessTransfer())
            ->setTitle(static::TITLE_NO_CONCRETE_HAS_SEARCHABLE_FLAG_IN_LOCALES);

        foreach ($isSearchableForLocaleList as $localeName => $isSearchable) {
            if ($isSearchable) {
                $searchableInLocaleReadiness->addValue($localeName);
            } else {
                $notSearchableInLocaleReadiness->addValue($localeName);
            }
        }

        $productReadinessTransfers->append($searchableInLocaleReadiness);
        $productReadinessTransfers->append($notSearchableInLocaleReadiness);

        return $productReadinessTransfers;
    }
}
