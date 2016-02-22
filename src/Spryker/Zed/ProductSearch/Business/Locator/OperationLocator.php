<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Business\Locator;

use Spryker\Zed\ProductSearch\Business\Operation\OperationInterface;

/**
 * Class OperationLocator
 */
class OperationLocator implements OperationLocatorInterface
{

    const COPY_TO_FIELD = 'CopyToField';

    protected $registeredOperations = [];

    /**
     * @param \Spryker\Zed\ProductSearch\Business\Operation\OperationInterface $operation
     *
     * @return void
     */
    public function addOperation(OperationInterface $operation)
    {
        $this->registeredOperations[$operation->getName()] = $operation;
    }

    /**
     * @param string $name
     *
     * @return \Spryker\Zed\ProductSearch\Business\Operation\OperationInterface|null
     */
    public function findOperationByName($name = self::COPY_TO_FIELD)
    {
        if (array_key_exists($name, $this->registeredOperations)) {
            return $this->registeredOperations[$name];
        }

        return null;
    }

}
