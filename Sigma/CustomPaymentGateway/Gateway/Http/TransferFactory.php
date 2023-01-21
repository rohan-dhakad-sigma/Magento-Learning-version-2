<?php
/**
 * Created by Ashish Ranade
 * Developed by Ashish Ranade
 * File: TransferFactory.php
 * Date: 5/9/2021
 * Time: 11:47 AM
 */

namespace Sigma\CustomPaymentGateway\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferInterface;
use Sigma\CustomPaymentGateway\Gateway\Request\MockDataRequest;

// TransferFactory class will be used to save our request to the payment gateway.
class TransferFactory implements \Magento\Payment\Gateway\Http\TransferFactoryInterface
{
    /**
     * Created By: Ashish Ranade
     * @var TransferBuilder
     */
    private $transferBuilder;

    /**
     * TransferFactory constructor.
     * @param TransferBuilder $transferBuilder
     */
    public function __construct(TransferBuilder $transferBuilder)
    {
        $this->transferBuilder = $transferBuilder;
    }

    /**
     * @inheritDoc
     */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setBody($request)
            ->setMethod('POST')
            ->setHeaders(
                [
                    'force_result' => $request[MockDataRequest::FORCE_RESULT] ?? null
                ]
            )
            ->build();
    }
}