<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductSearch\Presentation\SearchPreferences;

use SprykerTest\Zed\ProductSearch\PageObject\SearchPreferencesPage;
use SprykerTest\Zed\ProductSearch\ProductSearchPresentationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductSearch
 * @group Presentation
 * @group SearchPreferences
 * @group SearchPreferencesCest
 * Add your own group annotations below this line
 */
class SearchPreferencesCest
{
    /**
     * @param \SprykerTest\Zed\ProductSearch\ProductSearchPresentationTester $i
     *
     * @return void
     */
    public function showListOfFilters(ProductSearchPresentationTester $i): void
    {
        $i->amOnPage(SearchPreferencesPage::URL_LIST);
        $i->seeElement(SearchPreferencesPage::SELECTOR_SEARCH_PREFERENCES_LIST);
    }

    /**
     * @skip This test was temporarily skipped due to flikerness. See {@link https://spryker.atlassian.net/browse/CC-25718} for details
     *
     * @param \SprykerTest\Zed\ProductSearch\ProductSearchPresentationTester $i
     *
     * @return void
     */
    public function addAndEditAndDeactivateAttributeToSearch(ProductSearchPresentationTester $i): void
    {
        $attributeKey = 'foooooo_' . rand(100, 999);
        $i->addAttributeToSearch($attributeKey);
        $i->updateAttributeToSearch($attributeKey);
        $i->deactivateAttributeToSearch($attributeKey);
    }

    /**
     * @skip This test was temporarily skipped due to flikerness. See {@link https://spryker.atlassian.net/browse/CC-25718} for details
     *
     * @param \SprykerTest\Zed\ProductSearch\ProductSearchPresentationTester $i
     *
     * @return void
     */
    public function synchronizeFilterPreferences(ProductSearchPresentationTester $i): void
    {
        $attributeKey = 'foooooo_' . rand(100, 999);
        $i->addAttributeToSearch($attributeKey);

        $i->amOnPage(SearchPreferencesPage::URL_LIST);

        $i->waitForElementVisible('.dataTables_scrollBody');

        $i->click('#syncSearchPreferences');

        $i->canSeeCurrentUrlEquals(SearchPreferencesPage::URL_LIST);

        $i->waitForJS('return document.readyState == "complete"');
        $i->canSee('Search preferences synchronization was successful.');

        // TODO: don't need to delete, after we have clean test state after each test case
        $i->deactivateAttributeToSearch($attributeKey);
    }
}
