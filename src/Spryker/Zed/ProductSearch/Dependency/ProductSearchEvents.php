<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Dependency;

interface ProductSearchEvents
{
    /**
     * Specification
     * - This events will be used for synchronization_filter publishing
     *
     * @api
     *
     * @var string
     */
    public const SYNCHRONIZATION_FILTER_PUBLISH = 'ProductSearch.synchronization_filter.publish';

    /**
     * Specification
     * - This events will be used for product search config publishing
     *
     * @api
     *
     * @var string
     */
    public const PRODUCT_SEARCH_CONFIG_PUBLISH = 'ProductSearch.config.publish';

    /**
     * Specification
     * - This events will be used for product search config publishing
     *
     * @api
     *
     * @var string
     */
    public const PRODUCT_SEARCH_CONFIG_UNPUBLISH = 'ProductSearch.config.unpublish';

    /**
     * Specification
     * - This events will be used for spy_product_search_attribute entity creation
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_SEARCH_ATTRIBUTE_CREATE = 'Entity.spy_product_search_attribute.create';

    /**
     * Specification
     * - This events will be used for spy_product_search_attribute entity changes
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_SEARCH_ATTRIBUTE_UPDATE = 'Entity.spy_product_search_attribute.update';

    /**
     * Specification
     * - This events will be used for spy_product_search_attribute entity deletion
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_SEARCH_ATTRIBUTE_DELETE = 'Entity.spy_product_search_attribute.delete';

    /**
     * Specification:
     * - Represents spy_product_search entity creation.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_SEARCH_CREATE = 'Entity.spy_product_search.create';

    /**
     * Specification:
     * - Represents spy_product_search entity changes.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_SEARCH_UPDATE = 'Entity.spy_product_search.update';

    /**
     * Specification:
     * - Represents spy_product_search entity deletion.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_PRODUCT_SEARCH_DELETE = 'Entity.spy_product_search.delete';
}
