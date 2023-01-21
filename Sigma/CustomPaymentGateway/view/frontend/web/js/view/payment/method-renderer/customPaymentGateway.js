define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            defaults: {
                // we are setting a template file which will be used to show a payment form on checkout page.
                template: 'Sigma_CustomPaymentGateway/payment/form',
                transactionResult: ''
            },

            initObservable: function () {
                this._super()
                    .observe([
                        'transactionResult'
                    ]);
                return this;
            },

            getCode: function () {
                return 'customPaymentGateway';
            },

            getData: function () {
                return {
                    'method': this.item.method,
                    'additional_data': {
                        'transaction_result': this.transactionResult()
                    }
                };
            },

            // getTransactionResults function is used to display mock values on the payment page.
            getTransactionResults: function () {
                return _.map(window.checkoutConfig.payment.customPaymentGateway.transactionResults, function (value, key) {
                    // window.checkoutConfig.payment.customPaymentGateway.transactionResults is fetched from the ConfigProvide Class.
                    return {
                        'value': key,
                        'transaction_result': value
                    }
                });
            }
        });
    }
);