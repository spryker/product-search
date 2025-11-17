<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Business\Provider\ProductReadiness;

use ArrayObject;
use Generated\Shared\Transfer\ProductConcreteReadinessRequestTransfer;
use Generated\Shared\Transfer\ProductReadinessTransfer;

class IsSearchableForLocaleConcreteProductReadinessProvider implements ProductConcreteReadinessProviderInterface
{
    /**
     * @var string
     */
    protected const TITLE_HAS_SEARCHABLE_FLAG_IN_LOCALES = 'Has searchable flag in locales';

    /**
     * @var string
     */
    protected const TITLE_NO_SEARCHABLE_FLAG_IN_LOCALES = 'No searchable flag in locales';

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteReadinessRequestTransfer $productConcreteReadinessRequestTransfer
     * @param \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer> $productReadinessTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\ProductReadinessTransfer>
     */
    public function provide(
        ProductConcreteReadinessRequestTransfer $productConcreteReadinessRequestTransfer,
        ArrayObject $productReadinessTransfers
    ): ArrayObject {
        if (!$productConcreteReadinessRequestTransfer->getProductConcrete()) {
            return $productReadinessTransfers;
        }

        $searchableInLocaleReadiness = (new ProductReadinessTransfer())
            ->setTitle(static::TITLE_HAS_SEARCHABLE_FLAG_IN_LOCALES);

        $notSearchableInLocaleReadiness = (new ProductReadinessTransfer())
            ->setTitle(static::TITLE_NO_SEARCHABLE_FLAG_IN_LOCALES);

        foreach ($productConcreteReadinessRequestTransfer->getProductConcrete()->getLocalizedAttributes() as $localizedAttributeTransfer) {
            $localeName = $localizedAttributeTransfer->getLocale()->getLocaleName();
            if ($localizedAttributeTransfer->getIsSearchable()) {
                $searchableInLocaleReadiness->addValue($localeName);

                continue;
            }
            $notSearchableInLocaleReadiness->addValue($localeName);
        }

        $productReadinessTransfers->append($searchableInLocaleReadiness);
        $productReadinessTransfers->append($notSearchableInLocaleReadiness);

        return $productReadinessTransfers;
    }
}
