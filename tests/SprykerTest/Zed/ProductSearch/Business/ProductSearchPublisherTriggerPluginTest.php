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

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanupProductSearchEntities();
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
    public function testPluginShouldReturnEmptyArrayWhenNoEntitiesExist(): void
    {
        // Act
        $result = $this->createProductSearchPublisherTriggerPlugin()->getData(2, 3);

        // Assert
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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

    /**
     * @param int $idProduct
     * @param int $idLocale
     * @param bool $isSearchable
     *
     * @return void
     */
    protected function createProductSearchEntity(int $idProduct, int $idLocale, bool $isSearchable): void
    {
        $productSearchEntity = new SpyProductSearch();

        $productSearchEntity
            ->setFkProduct($idProduct)
            ->setFkLocale($idLocale)
            ->setIsSearchable($isSearchable)
            ->save();
    }

    /**
     * @return void
     */
    protected function cleanupProductSearchEntities(): void
    {
        SpyProductSearchQuery::create()->deleteAll();
    }

    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstract
     */
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

    /**
     * @param string $sku
     *
     * @return \Orm\Zed\Product\Persistence\SpyProduct
     */
    protected function createProductConcrete(string $sku): SpyProduct
    {
        $productConcreteEntity = new SpyProduct();
        $productConcreteEntity
            ->setSku($sku)
            ->setAttributes('[]');

        return $productConcreteEntity;
    }

    /**
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
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
