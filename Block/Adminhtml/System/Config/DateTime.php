<?php

declare(strict_types=1);

namespace Deviget\StoreWishList\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Stdlib\DateTime as StdlibDateTime;

/**
 * Class DateTime
 */
class DateTime extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->setDateFormat(StdlibDateTime::DATE_INTERNAL_FORMAT)
        ->setTimeFormat('HH:mm:ss')
        ->setShowsTime(true);

        return parent::render($element);
    }
}