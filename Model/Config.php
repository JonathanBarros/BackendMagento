<?php
declare(strict_types=1);

namespace Deviget\StoreWishList\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Deviget\StoreWishList\Api\Model\ConfigInterface;

/**
 * Class Config
 */
class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function getConfigValueGeneral(string $field, $scope = ScopeInterface::SCOPE_STORES, int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_WJ_LINX . self::XML_PATH_WJ_LINX_GENERAL . $field, $scope, $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getConfigValue(string $field, $scope = ScopeInterface::SCOPE_STORES, int $storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_WJ_LINX . $field, $scope, $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function isEnabled(int $storeId = null): bool
    {
        return (bool)$this->getConfigValueGeneral(
            self::XML_FIELD_ENABLED, ScopeInterface::SCOPE_STORES, $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getProductIds(int $storeId = null): string
    {
        return (string)$this->getConfigValueGeneral(
            self::XML_FIELD_PRODUCT_IDS, ScopeInterface::SCOPE_STORES, $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getStartTimeGate(int $storeId = null): string
    {
        return (string)$this->getConfigValueGeneral(
            self::XML_FIELD_START_TIME_GATE, ScopeInterface::SCOPE_STORES, $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getEndTimeGate(int $storeId = null): string
    {
        return (string)$this->getConfigValueGeneral(
            self::XML_FIELD_END_TIME_GATE, ScopeInterface::SCOPE_STORES, $storeId
        );
    }
}