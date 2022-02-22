<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Communication\Table;

use Orm\Zed\Product\Persistence\Map\SpyProductAttributeKeyTableMap;
use Orm\Zed\Product\Persistence\SpyProductAttributeKey;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\ProductSearch\Communication\Controller\SearchPreferencesController;
use Spryker\Zed\ProductSearch\Communication\Form\CleanSearchPreferencesForm;
use Spryker\Zed\ProductSearch\Persistence\ProductSearchQueryContainerInterface;

class SearchPreferencesTable extends AbstractTable
{
    public const COL_NAME = SpyProductAttributeKeyTableMap::COL_KEY;

    /**
     * @var string
     */
    public const COL_SUGGESTION_TERMS = 'suggestionTerms';

    /**
     * @var string
     */
    public const COL_COMPLETION_TERMS = 'completionTerms';

    /**
     * @var string
     */
    public const COL_FULL_TEXT = 'full_Text';

    /**
     * @var string
     */
    public const COL_FULL_TEXT_BOOSTED = 'fullTextBoosted';

    /**
     * @var string
     */
    public const ACTIONS = 'actions';

    /**
     * @var \Spryker\Zed\ProductSearch\Persistence\ProductSearchQueryContainerInterface
     */
    protected $productSearchQueryContainer;

    /**
     * @param \Spryker\Zed\ProductSearch\Persistence\ProductSearchQueryContainerInterface $productSearchQueryContainer
     */
    public function __construct(ProductSearchQueryContainerInterface $productSearchQueryContainer)
    {
        $this->productSearchQueryContainer = $productSearchQueryContainer;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader($this->getHeaderFields());
        $config->setSearchable($this->getSearchableFields());
        $config->setSortable($this->getSortableFields());

        $config->setRawColumns([
            static::COL_FULL_TEXT,
            static::COL_FULL_TEXT_BOOSTED,
            static::COL_SUGGESTION_TERMS,
            static::COL_COMPLETION_TERMS,
            static::ACTIONS,
        ]);

        return $config;
    }

    /**
     * @return array
     */
    protected function getHeaderFields()
    {
        return [
            static::COL_NAME => 'Attribute key',
            static::COL_FULL_TEXT => 'Include for full text',
            static::COL_FULL_TEXT_BOOSTED => 'Include for full text boosted',
            static::COL_SUGGESTION_TERMS => 'Include for suggestion',
            static::COL_COMPLETION_TERMS => 'Include for completion',
            static::ACTIONS => 'Actions',
        ];
    }

    /**
     * @return array
     */
    protected function getSearchableFields()
    {
        return [
            static::COL_NAME,
        ];
    }

    /**
     * @return array
     */
    protected function getSortableFields()
    {
        return [
            static::COL_NAME,
            static::COL_FULL_TEXT,
            static::COL_FULL_TEXT_BOOSTED,
            static::COL_SUGGESTION_TERMS,
            static::COL_COMPLETION_TERMS,
        ];
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $result = [];

        $productAttributeKeys = $this->getProductAttributeKeys($config);

        foreach ($productAttributeKeys as $productAttributeKeyEntity) {
            $result[] = [
                static::COL_NAME => $productAttributeKeyEntity->getKey(),
                static::COL_FULL_TEXT => $this->boolToString($productAttributeKeyEntity->getVirtualColumn(static::COL_FULL_TEXT)),
                static::COL_FULL_TEXT_BOOSTED => $this->boolToString($productAttributeKeyEntity->getVirtualColumn(static::COL_FULL_TEXT_BOOSTED)),
                static::COL_SUGGESTION_TERMS => $this->boolToString($productAttributeKeyEntity->getVirtualColumn(static::COL_SUGGESTION_TERMS)),
                static::COL_COMPLETION_TERMS => $this->boolToString($productAttributeKeyEntity->getVirtualColumn(static::COL_COMPLETION_TERMS)),
                static::ACTIONS => $this->getActions($productAttributeKeyEntity),
            ];
        }

        return $result;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<\Orm\Zed\Product\Persistence\SpyProductAttributeKey>
     */
    protected function getProductAttributeKeys(TableConfiguration $config)
    {
        $query = $this
            ->productSearchQueryContainer
            ->querySearchPreferencesTable();

        /** @var array<\Orm\Zed\Product\Persistence\SpyProductAttributeKey> $productAttributeKey */
        $productAttributeKey = $this->runQuery($query, $config, true);

        /** @phpstan-var array<\Orm\Zed\Product\Persistence\SpyProductAttributeKey> */
        return $productAttributeKey;
    }

    /**
     * @param bool $boolValue
     *
     * @return string
     */
    protected function boolToString($boolValue)
    {
        return $this->generateLabel(
            $boolValue ? 'yes' : 'no',
            null,
        );
    }

    /**
     * @param \Orm\Zed\Product\Persistence\SpyProductAttributeKey $productAttributeKeyEntity
     *
     * @return string
     */
    protected function getActions(SpyProductAttributeKey $productAttributeKeyEntity)
    {
        $actions = [
            $this->generateEditButton(
                sprintf(
                    '/product-search/search-preferences/edit?%s=%d',
                    SearchPreferencesController::PARAM_ID,
                    $productAttributeKeyEntity->getIdProductAttributeKey(),
                ),
                'Edit',
            ),
            $this->generateRemoveButton(
                sprintf(
                    '/product-search/search-preferences/clean?%s=%d',
                    SearchPreferencesController::PARAM_ID,
                    $productAttributeKeyEntity->getIdProductAttributeKey(),
                ),
                'Deactivate all',
                [],
                CleanSearchPreferencesForm::class,
            ),
        ];

        return implode(' ', $actions);
    }
}
