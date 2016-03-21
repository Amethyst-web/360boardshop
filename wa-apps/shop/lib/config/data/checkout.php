<?php

return array(
    'contactinfo' => array(
        'name' => _w('Contact info'),
        'description' => _w('Configure the list of fields requested during the checkout.'),
        'fields' => array(
            'firstname' => array(),
            'lastname' => array(),
            'phone' => array(),
            'email' => array(),
            'address.shipping' => array()
        ),
        'icon' => 'fa-map-marker'
    ),
    'shipping' => array(
        'name' => _w('Shipping'),
        'description' => _w('The shipping checkout step prompts customer to select preferable shipping option from the list configured on the <a class="inline" href="#/shipping/">Shipping</a> settings screen.'),
        'icon' => 'fa-truck'
    ),
    'payment' => array(
        'name' => _w('Payment'),
        'description' => _w('The payment checkout step prompts customer to select preferable payment option from the list configured on the <a class="inline" href="#/payment/">Payment</a> settings screen.'),
        'icon' => 'fa-money'
    ),
    'confirmation' => array(
        'name' => _w('Confirmation'),
        'description' => _w('The confirmation checkout step presents overall order information including cart content, shipping and tax rates, total amount.'),
        'icon' => 'fa-eye'
    )
);