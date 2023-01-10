<?php

namespace Sigma\DemoGraphQl\Model\Customer;

use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;


/**
 * Class Order
 * @package MageDigest\DemoGraphQl\Model\Customer
 */
class Order
{

    /**
     * @var OrderFactory
     */
    public $orderFactory;

    /**
     * @var CollectionFactory
     */
    public $orderCollectionFactory;

    /**
     * Order constructor.
     * @param OrderFactory $orderFactory
     * @param CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        OrderFactory $orderFactory,
        CollectionFactory $orderCollectionFactory
    )
    {
        $this->orderFactory = $orderFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }


    /**
     * @param string $email
     * @return array
     */
    public function getLatestOrder($email)
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/temp1.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $orderCollection = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_email', $email)->setOrder('created_at', 'DESC')->getFirstItem();
        $result = array();
        $order = $this->orderFactory->create()->loadByIncrementId($orderCollection->getIncrementId());
        foreach ($order->getAllItems() as $item) {
            $result[] = array('name' => $item->getName(), 'sku' => $item->getSku());
        }
        $logger->info($result);
        return $result;

    }
}