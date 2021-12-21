<?php

declare(strict_types=1);

namespace Deviget\StoreWishList\Api\Model;

use Magento\Store\Model\ScopeInterface;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface
{
    const XML_PATH_WJ_LINX = 'store_wish_list/';
    const XML_PATH_WJ_LINX_GENERAL = 'general/';
    const XML_FIELD_ENABLED = 'enabled';
    const XML_FIELD_PRODUCT_IDS = 'product_ids';
    const XML_FIELD_START_TIME_GATE = 'start_time_gate';
    const XML_FIELD_END_TIME_GATE = 'end_time_gate';

    /**
     * Function base to get any config value inside of the general section
     *
     * @param string $field
     * @param string $scope
     * @param int|null $storeId
     *
     * @return string
     */
    public function getConfigValueGeneral(
        string $field, $scope = ScopeInterface::SCOPE_STORES, int $storeId = null
    ): string;

    /**
     * Function base to get any config value out of the general section
     *
     * @param string $field
     * @param string $scope
     * @param int|null $storeId
     *
     * @return string
     */
    public function getConfigValue(
        string $field, $scope = ScopeInterface::SCOPE_STORES, int $storeId = null
    ): string;

    /**
     * get the enabled configuration
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isEnabled(int $storeId = null): bool;

    /**
     * get the product ids configuration
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getProductIds(int $storeId = null): string;

    /**
     * get the start time gate configuration
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getStartTimeGate(int $storeId = null): string;

    /**
     * get the end time gate configuration
     *
     * @param int|null $storeId
     *
     * @return string
     */
    public function getEndTimeGate(int $storeId = null): string;
}