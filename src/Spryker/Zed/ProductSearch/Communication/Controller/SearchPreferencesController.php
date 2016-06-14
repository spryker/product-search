<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSearch\Communication\Controller;

use Generated\Shared\Transfer\ProductSearchPreferencesTransfer;
use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\ProductSearch\Communication\ProductSearchCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductSearch\Business\ProductSearchFacade getFacade()
 */
class SearchPreferencesController extends AbstractController
{

    const PARAM_ID = 'id';

    /**
     * @return array
     */
    public function indexAction()
    {
        $searchPreferencesTable = $this->getFactory()->createSearchPreferencesTable();

        return $this->viewResponse([
            'searchPreferencesTable' => $searchPreferencesTable->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $table = $this->getFactory()->createSearchPreferencesTable();

        return $this->jsonResponse(
            $table->fetchData()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function editAction(Request $request)
    {
        $idAttributesMetadata = $this->castId($request->query->get(self::PARAM_ID));

        $dataProvider = $this
            ->getFactory()
            ->createSearchPreferencesDataProvider();

        $form = $this->getFactory()
            ->createSearchPreferencesForm(
                $dataProvider->getData($idAttributesMetadata),
                $dataProvider->getOptions()
            )
            ->handleRequest($request);

        if ($form->isValid()) {
            $productSearchPreferencesTransfer = new ProductSearchPreferencesTransfer();
            $productSearchPreferencesTransfer
                ->setIdProductAttributesMetadata($idAttributesMetadata)
                ->fromArray($form->getData(), true);

            $this->getFacade()->saveProductSearchPreferences($productSearchPreferencesTransfer);

            $this->addSuccessMessage('Search Preferences has been saved successfully');
        }

        return $this->viewResponse([
            'form' => $form->createView(),
        ]);
    }

}
