<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\ProductSearch\Business\ProductSearchFacade;

use Codeception\TestCase\Test;
use Orm\Zed\Locale\Persistence\SpyLocale;
use Orm\Zed\Product\Persistence\SpyProduct;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributes;
use Orm\Zed\Product\Persistence\SpyProductAttributeKey;
use Orm\Zed\Product\Persistence\SpyProductLocalizedAttributes;
use Spryker\Zed\ProductSearch\Business\ProductSearchFacade;
use Spryker\Zed\Product\Business\ProductFacade;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group ProductSearch
 * @group Business
 * @group ProductSearchFacade
 * @group AbstractProductSearchFacadeTest
 */
abstract class AbstractProductSearchFacadeTest extends Test
{

    /**
     * @var \Spryker\Zed\ProductSearch\Business\ProductSearchFacade
     */
    protected $productSearchFacade;

    /**
     * @var \Spryker\Zed\Product\Business\ProductFacade
     */
    protected $productFacade;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->productSearchFacade = new ProductSearchFacade();
        $this->productFacade = new ProductFacade();
    }

    /**
     * @param string $key
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAttributeKey
     */
    protected function createProductAttributeKeyEntity($key)
    {
        $productAttributeKeyEntity = new SpyProductAttributeKey();
        $productAttributeKeyEntity->setKey($key);
        $productAttributeKeyEntity->save();

        return $productAttributeKeyEntity;
    }

    /**
     * @param array $abstractAttrs
     * @param array $abstractLocalizedAttrs
     * @param array $concreteAttrs
     * @param array $concreteLocalizedAttrs
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstract
     */
    protected function createProduct(array $abstractAttrs, array $abstractLocalizedAttrs, array $concreteAttrs, array $concreteLocalizedAttrs)
    {
        $productAbstractEntity = new SpyProductAbstract();
        $productAbstractEntity
            ->setSku('touchProductAbstractByAsynchronousAttributesOnCreate')
            ->setAttributes($this->productFacade->encodeProductAttributes($abstractAttrs))
            ->save();

        $productConcreteEntity = new SpyProduct();
        $productConcreteEntity
            ->setSku('touchProductAbstractByAsynchronousAttributesOnCreate-1')
            ->setAttributes($this->productFacade->encodeProductAttributes($concreteAttrs))
            ->setFkProductAbstract($productAbstractEntity->getIdProductAbstract())
            ->save();

        $localeEntity = new SpyLocale();
        $localeEntity->setLocaleName('ab_CD');
        $localeEntity->save();

        $localizedProductAbstractEntity = new SpyProductAbstractLocalizedAttributes();
        $localizedProductAbstractEntity
            ->setName('touchProductAbstractByAsynchronousAttributesOnCreate')
            ->setAttributes($this->productFacade->encodeProductAttributes($abstractLocalizedAttrs))
            ->setFkLocale($localeEntity->getIdLocale())
            ->setFkProductAbstract($productAbstractEntity->getIdProductAbstract())
            ->save();

        $localizedProductEntity = new SpyProductLocalizedAttributes();
        $localizedProductEntity
            ->setName('touchProductAbstractByAsynchronousAttributesOnCreate-1')
            ->setAttributes($this->productFacade->encodeProductAttributes($concreteLocalizedAttrs))
            ->setFkLocale($localeEntity->getIdLocale())
            ->setFkProduct($productConcreteEntity->getIdProduct())
            ->save();

        return $productAbstractEntity;
    }

}
