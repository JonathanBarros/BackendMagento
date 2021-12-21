<?php

declare(strict_types=1);

namespace Deviget\StoreWishList\Controller\Add;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Checkout\Model\SessionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Deviget\StoreWishList\Api\Model\ConfigInterface;
use Deviget\StoreWishList\Helper\Data as DevigetHelper;

/**
 * Class Product
 */
class Product extends Action
{
    /**
     * @var PageFactory $pageFactory
     */
    protected $pageFactory;

    /**
     * @var CartRepositoryInterface $cartRepository
     */
    protected $cartRepository;

    /**
     * @var ProductRepositoryInterface $productRepository
     */
    protected $productRepository;

    /**
     * @var SessionFactory $sessionFactory
     */
    protected $sessionFactory;

    /**
     * @var ConfigInterface $configInterface
     */
    protected $configInterface;

    protected $devigetHelper;

    /**
     * Product constructor.
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CartRepositoryInterface $cartRepository
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ProductRepositoryInterface $productRepository,
        CartRepositoryInterface $cartRepository,
        SessionFactory $sessionFactory,
        ConfigInterface $configInterface,
        DevigetHelper $devigetHelper

    ) {
        $this->pageFactory = $pageFactory;
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->sessionFactory = $sessionFactory;
        $this->configInterface = $configInterface;
        $this->devigetHelper = $devigetHelper;
        return parent::__construct($context);
    }

    /**
     * Add param product(s) to the cart.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->configInterface->isEnabled()) {
            return $this->getResponse()->setRedirect('/');
        }
        $startTimeGate = $this->configInterface->getStartTimeGate();
        $endTimeGate = $this->configInterface->getEndTimeGate();

        if (!$this->devigetHelper->validateTimeGate($startTimeGate, $endTimeGate)) {
            return $this->getResponse()->setRedirect('/');
        }

        $ids = explode(',', $this->getRequest()->getParam('ids', ''));
        $countOnCart = 0;
        $productIds = explode(',', trim($this->configInterface->getProductIds()));

        foreach($ids as $id) {
            try {
                if (!in_array($id, $productIds)) {
                    continue;
                }

                $product = $this->productRepository->getById($id);
                if ($product) {
                    $session = $this->sessionFactory->create();
                    $quote = $session->getQuote();
                    $quote->addProduct($product, 1);
                    $this->cartRepository->save($quote);
                    $session->replaceQuote($quote)->unsLastRealOrderId();
                    $countOnCart++;
                }
            } catch (LocalizedException $e) {
            }
        }

        if (empty($countOnCart)) {
            return $this->getResponse()->setRedirect('/');
        }
        return $this->getResponse()->setRedirect('/checkout/cart/');
    }
}