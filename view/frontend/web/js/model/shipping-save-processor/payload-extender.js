define(['jquery'], function ($) {
    'use strict';

    return function (payload) {
        payload.addressInformation['extension_attributes'] = {
            'custom_shipping_address_type': $('[name="custom_shipping_address_type"]').val()
        };

        return payload;
    };
});