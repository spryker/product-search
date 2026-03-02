<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductSearch\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\ProductSearchCriteriaTransfer;
use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Orm\Zed\Product\Persistence\SpyProduct;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\ProductSearch\Persistence\SpyProductSearch;
use Orm\Zed\ProductSearch\Persistence\SpyProductSearchQuery;
use Spryker\Zed\ProductSearch\Communication\Plugin\Publisher\ProductSearchPublisherTriggerPlugin;
use SprykerTest\Zed\ProductSearch\ProductSearchBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductSearch
 * @group Business
 * @group ProductSearchPublisherTriggerPluginTest
 *
 * Add your own group annotations below this line
 */
class ProductSearchPublisherTriggerPluginTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\ProductSearch\ProductSearchBusinessTester
     */
    protected ProductSearchBusinessTester $tester;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanupProductSearchEntities();
    }

    public function testPluginShouldReturnEntitiesWithinLimitAndOffset(): void
    {
        // Arrange
        $localeTransfer = $this->createLocale('en_US');
        $productAbstractEntity = $this->createProductAbstract();
        $productConcreteEntity = $productAbstractEntity->getSpyProducts()->getFirst();

        $totalCount = 10;
        for ($i = 0; $i < $totalCount; $i++) {
            $this->createProductSearchEntity(
                $productConcreteEntity->getIdProduct(),
                $localeTransfer->getIdLocale(),
                true,
            );
        }

        // Act
        $result = $this->createProductSearchPublisherTriggerPlugin()->getData(2, 3);

        // Assert
        $this->assertCount(3, $result);
    }

    public function testPluginShouldReturnEmptyArrayWhenNoEntitiesExist(): void
    {
        // Act
        $result = $this->createProductSearchPublisherTriggerPlugin()->getData(2, 3);

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testPluginShouldReturnEmptyArrayWhenOffsetExceedsTotalCount(): void
    {
        // Arrange
        $localeTransfer = $this->createLocale('en_US');
        $productAbstractEntity = $this->createProductAbstract();
        $productConcreteEntity = $productAbstractEntity->getSpyProducts()->getFirst();

        $totalCount = 5;
        for ($i = 0; $i < $totalCount; $i++) {
            $this->createProductSearchEntity(
                $productConcreteEntity->getIdProduct(),
                $localeTransfer->getIdLocale(),
                true,
            );
        }

        // Act
        $result = $this->createProductSearchPublisherTriggerPlugin()->getData(10, 5);

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testPluginShouldReturnCorrectDataStructure(): void
    {
        // Arrange
        $localeTransfer = $this->createLocale('en_US');
        $productAbstractEntity = $this->createProductAbstract();
        $productConcreteEntity = $productAbstractEntity->getSpyProducts()->getFirst();

        $this->createProductSearchEntity(
            $productConcreteEntity->getIdProduct(),
            $localeTransfer->getIdLocale(),
            true,
        );

        $productSearchCriteriaTransfer = (new ProductSearchCriteriaTransfer())
            ->setLimit(1);

        // Act
        $result = $this->createProductSearchPublisherTriggerPlugin()->getData(0, 1);

        // Assert
        $this->assertCount(1, $result);
        $productSearchEntityTransfer = $result[0];
        $this->assertNotNull($productSearchEntityTransfer->getIdProductSearch());
        $this->assertEquals($productConcreteEntity->getIdProduct(), $productSearchEntityTransfer->getFkProduct());
        $this->assertEquals($localeTransfer->getIdLocale(), $productSearchEntityTransfer->getFkLocale());
        $this->assertTrue($productSearchEntityTransfer->getIsSearchable());
    }

    public function testPluginShouldHandleZeroLimitAsUnlimited(): void
    {
        // Arrange
        $localeTransfer = $this->createLocale('en_US');
        $productAbstractEntity = $this->createProductAbstract();
        $productConcreteEntity = $productAbstractEntity->getSpyProducts()->getFirst();

        $totalCount = 5;
        for ($i = 0; $i < $totalCount; $i++) {
            $this->createProductSearchEntity(
                $productConcreteEntity->getIdProduct(),
                $localeTransfer->getIdLocale(),
                true,
            );
        }

        // Act
        $result = $this->createProductSearchPublisherTriggerPlugin()->getData(0, 0);

        // Assert
        $this->assertCount($totalCount, $result);
    }

    protected function createProductSearchEntity(int $idProduct, int $idLocale, bool $isSearchable): void
    {
        $productSearchEntity = new SpyProductSearch();

        $productSearchEntity
            ->setFkProduct($idProduct)
            ->setFkLocale($idLocale)
            ->setIsSearchable($isSearchable)
            ->save();
    }

    protected function cleanupProductSearchEntities(): void
    {
        SpyProductSearchQuery::create()->deleteAll();
    }

    protected function createProductAbstract(): SpyProductAbstract
    {
        $sku = uniqid('sku_');

        $productAbstractEntity = new SpyProductAbstract();
        $productAbstractEntity
            ->setSku($sku)
            ->setAttributes('[]')
            ->addSpyProduct($this->createProductConcrete($sku . '-1'))
            ->addSpyProduct($this->createProductConcrete($sku . '-2'));

        $productAbstractEntity->save();

        return $productAbstractEntity;
    }

    protected function createProductConcrete(string $sku): SpyProduct
    {
        $productConcreteEntity = new SpyProduct();
        $productConcreteEntity
            ->setSku($sku)
            ->setAttributes('[]');

        return $productConcreteEntity;
    }

    protected function createLocale(string $localeName): LocaleTransfer
    {
        $localeEntity = SpyLocaleQuery::create()
            ->filterByLocaleName($localeName)
            ->findOneOrCreate();

        $localeEntity->save();

        $localeTransfer = (new LocaleTransfer())->fromArray($localeEntity->toArray(), true);

        return $localeTransfer;
    }

    protected function createProductSearchPublisherTriggerPlugin(): ProductSearchPublisherTriggerPlugin
    {
        return new ProductSearchPublisherTriggerPlugin();
    }
}
