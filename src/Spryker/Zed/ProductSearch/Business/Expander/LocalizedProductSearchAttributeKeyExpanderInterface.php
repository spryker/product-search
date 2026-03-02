<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Business\Expander;

use Generated\Shared\Transfer\ProductSearchAttributeCollectionTransfer;

interface LocalizedProductSearchAttributeKeyExpanderInterface
{
    public function expandProductSearchAttributeCollectionWithLocalizedKeys(
        ProductSearchAttributeCollectionTransfer $productSearchAttributeCollectionTransfer
    ): ProductSearchAttributeCollectionTransfer;
}
