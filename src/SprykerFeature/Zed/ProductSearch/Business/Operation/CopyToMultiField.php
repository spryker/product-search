<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\ProductSearch\Business\Operation;

class CopyToMultiField implements OperationInterface
{
    /**
     * @param array     $sourceDocument
     * @param array     $targetDocument
     * @param mixed     $sourceField
     * @param string    $targetField
     *
     * @return array
     */
    public function enrichDocument(array $sourceDocument, array $targetDocument, $sourceField, $targetField)
    {
        if (isset($sourceDocument[$sourceField]) && !empty($sourceDocument[$sourceField])) {
            $targetDocument[$targetField][$sourceField] = $sourceDocument[$sourceField];
        }

        return $targetDocument;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'CopyToMultiField';
    }
}
