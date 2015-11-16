<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\ProductSearch\Business\Internal;

use Elastica\Client;
use Elastica\Type\Mapping;
use SprykerFeature\Zed\Installer\Business\Model\AbstractInstaller;

class InstallProductSearch extends AbstractInstaller
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $indexName;

    /**
     * @var string
     */
    protected $indexType;

    /**
     * @param Client $client
     * @param string $indexName
     * @param string $indexType
     */
    public function __construct(
        Client $client,
        $indexName,
        $indexType
    ) {
        $this->client = $client;
        $this->indexName = $indexName;
        $this->indexType = $indexType;
    }

    public function install()
    {
        $this->messenger->info('Install ProductSearch');
        $this->createProductType();
    }

    protected function createProductType()
    {
        $index = $this->client->getIndex($this->indexName);

        if (!$index->exists()) {
            throw new \RuntimeException(sprintf('Index %s is missing', $this->indexName));
        }

        $type = $index->getType($this->indexType);

        if (!$type->exists()) {
            $mapping = new Mapping($type);
            $mapping->setProperties([
                'store' => [
                    'type' => 'string',
                    'include_in_all' => false,
                ],
                'locale' => [
                    'type' => 'string',
                    'include_in_all' => false,
                ],
                'full-text' => [
                    'type' => 'string',
                    'include_in_all' => false,
                ],
                'full-text-boosted' => [
                    'type' => 'string',
                    'include_in_all' => false,
                ],
                'search-result-data' => [
                    'type' => 'object',
                    'include_in_all' => false,
                    'properties' => [
                        'sku' => [
                            'type' => 'string',
                            'index' => 'not_analyzed',
                        ],
                        'name' => [
                            'type' => 'string',
                        ],
                        'url' => [
                            'type' => 'string',
                            'index' => 'not_analyzed',
                        ],
                    ],
                ],
                'string-facet' => [
                    'type' => 'nested',
                    'include_in_all' => false,
                    'properties' => [
                        'facet-name' => ['type' => 'string', 'index' => 'not_analyzed'],
                        'facet-value' => ['type' => 'string', 'index' => 'not_analyzed'],
                    ],
                ],
                'integer-facet' => [
                    'type' => 'nested',
                    'include_in_all' => false,
                    'properties' => [
                        'facet-name' => ['type' => 'string', 'index' => 'not_analyzed'],
                        'facet-value' => ['type' => 'integer'],
                    ],
                ],
                'float-facet' => [
                    'type' => 'nested',
                    'include_in_all' => false,
                    'properties' => [
                        'facet-name' => [
                            'type' => 'string', 'index' => 'not_analyzed',
                        ],
                        'facet-value' => ['type' => 'float'],
                    ],
                ],
                'completion-terms' => [
                    'type' => 'string',
                    'include_in_all' => false,
                ],
                'suggestion-terms' => [
                    'type' => 'string',
                    'include_in_all' => false,
                ],
                'string-sort' => [
                    'type' => 'object',
                    'include_in_all' => false,
                    'properties' => [
                        'name' => [
                            'type' => 'string',
                            'index' => 'not_analyzed',
                        ],
                    ],
                ],
                'integer-sort' => [
                    'type' => 'object',
                    'include_in_all' => false,
                    'properties' => [
                        'name' => ['type' => 'integer'],
                    ],
                ],
                'float-sort' => [
                    'type' => 'object',
                    'include_in_all' => false,
                    'properties' => [
                        'name' => ['type' => 'float'],
                    ],
                ],
                'bool-sort' => [
                    'type' => 'object',
                    'include_in_all' => false,
                    'properties' => [
                        'name' => ['type' => 'boolean'],
                    ],
                ],
                'category' => [
                    'type' => 'object',
                    'include_in_all' => false,
                    'properties' => [
                        'direct_parents' => ['type' => 'integer'],
                        'all_parents' => ['type' => 'integer'],
                    ],
                ],
            ]);
            $mapping->send();
        }
    }

}
