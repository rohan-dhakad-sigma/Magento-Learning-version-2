<?php

namespace Task\UpdateCompanyNameGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Validator\EmailAddress as EmailValidator;
use MageDigest\DemoGraphQl\Model\Customer\Order as CustomerOrder;
use Magento\Framework\Exception\NoSuchEntityException;

class UpdateCompany implements ResolverInterface
{
    public $_customerRepositoryInterface;

    public $_customerFactory;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_customerFactory = $customerFactory;
    }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $customerId = $args['id'];
        $customerCompany['company_name'] = $args['company_name'];
        $customer = $this->_customerFactory->create()->load($customerId)->getDataModel();
        $customer->setCustomAttribute('customer_company_name', $args['company_name']);
        $this->_customerRepositoryInterface->save($customer);
        return $customerCompany;
    }
}