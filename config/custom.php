<?php
//自定义配置
return [
    //等级推荐
    "tuijian" => [
        "0"=>"不推荐",
        "1"=>"一级推荐",
        "2"=>"二级推荐",
        "3"=>"三级推荐",
        "4"=>"四级推荐"
    ],
    //微信支付
    'weixin_payment' => [
        'app_id' => 'wxc9296a5edc62bfdf',
        // payment
        'payment' => [
            'merchant_id'        => '1484410482',
            'key'                => '1a4128be0f3855c9ebc65de69736cad4',
            //'cert_path'          => storage_path() . '/wechat/apiclient_cert.pem', // XXX: 绝对路径！！！！
            //'key_path'           => storage_path() . '/wechat/apiclient_key.pem',      // XXX: 绝对路径！！！！
            'notify_url'         => 'http://testapi.52danchuang.com/payment/notify/app_weixin_pay/',       // 你也可以在下单时单独设置来想覆盖它
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ],
    ],
    //支付宝app支付
    'alipay_app' => [
        'appId' => '2017070707673008',
        'rsaPrivateKey' => 'MIIEpAIBAAKCAQEA5Eccv1+NjMMEMYC9ePnldw8MgCvIsXq1A4VUTlfzCpLpEAe8Losf4lDqZhcwJOhk6+ZC6dWi1rKE7P+huG0Mh88PpXQAy9zPcbbdFqcuijZFxLNj0qcZGhurS6m0cWofAJxVcuSYpHNwJF24kCPrUje46mpNd3J8hsGXjZQBQpU3BdB4DM0hRA7BopR8WTaiGrNIzJSrAi6hIwDqjMFez3AYD4RhQRt9k7NPY04uKI7UR0D6Me+f6Cu0exodB87L1EXTm/ICG/F8rj+4xUXgqWOWw0QuUHMEYB0S5dSxy2sQg/2A67PogsxIUkOB+UdcsI0W2ZmpO5MKSusPlV6VwwIDAQABAoIBAQCscwBHnkLLtMNlNjFsw7PSln7GEM2DLgSzDTUcHhrPwR3p6z4BFz7V9HSu/RN0vk8HWqLwDWD/ukrq007ziQXvTsAuKI01dLEN4avxoghphwh7yV0+1NcEvyRPe3uCNj4HcxKmQgUCLubnwhlcYpYyPUAnbnjpJIboMjVwUgAFsFBlm5aQ1cCTR2aPg/KkC+VlxWOEBaY6Y2RH59sMon+G2LPIvzYJW8Ive+rccyZ0ly7dqEiaW5+dhcLRUC7z/Z4R9ZZm5zrzwFhI+v4vDN+oaTUSjijVbRkZN4U+PGvNYj+OyYd3rQvGS41EmCiO1L23jI7ve0XnbfXYpnpILVN5AoGBAPRF/4uc2ug3HFfP7jgmxuZHJR6GXZz9S9Au6CFi6SQ3D5bgvIN4RiZ8kIXnf1FAJ+/Gi97QPFpozAbNWgBj42w25FRXCe60HKV7K89ovSyeKcbKQ/PhV4MQnsyUU+bkqVzTK5uCedwYPG9rDGHkS3t0kvtvL+QtaK5FRXjtmmHnAoGBAO88iQsw3cE6Xf4B5byj1C3NaIvW7G8ZqLLKc190aNrMtDym8HPw4H2h0MrQ12fRIU/v06DzKII2SbywaICEpMQnAg2WS+X9oeiFGwVB8L2npHz6TX+TGgC8zjJuzW2wVX5NYATP5nSUbZE5oVEYh44gyE4JkY/iwesupO1PGunFAoGAW81qytd6VcdQeZgFmUjJe4XFZ4Fr8TIoqebXCqUXpaqjyzpO3sH260PpNMnZyXlpCO3/Zw+vfvLfqrbGWlsv/11p1mCXtQQvt+lgf6SHZBtU7AbcHu3Ta8h1RcGA/sd09xPN0bXpglQBcoYysx+PVqhrDN+uifye2M/j2hzB5oUCgYBns13UNAJr19kWWcwz0PAQSpGezDMAlabCmW8ZWWR6M3GNOO/R0f/9dT8EKzK0FbrS46pgggZ1KwMbf3xM+TJStHX3XcbYkvCz0b68sLCiBSEP64/cVO9Ykn7u7Yium1jzvqZ4b4X90rkL0mdSt8dKnHs3GH64WBqmzzk+hKOt4QKBgQCwAPwnlLiZmtORdja3rNFrTTXvjua8HVTemMdp2rUuSFB2FXS3suRhqkH2ilMRvbdiP/GlaCOyOTMSOVis88KZKie5Dy26TUgWUMsvG/7d21meRP6SCqpFhw5tkNkTzX+7ul5Si7iabmMtdlhw1OiD7yv4bo3Sw4YTWMa4s4D2ag==',
        'alipayrsaPublicKey' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmLo5catqqLXWcf+LhRs/WDziyCAB+HPb/+xls2BAtNtvfLHCM9xej5VGTzX7mw6e5/Et3yVAhFnnTZ9U9RWq1m3MiEv19n17/yIbGMXpxSSujYnL0drFBY6Z4f19tzfqWQPETpEf1atFSHbcJQfpaslyr9W2NmS5dbWIe+sJVmZjRN5cYEhFY7U0JHqIPr653XSDzsQ152rHZIb0wJmEVfkr0yyOZl1ja0sx+Gv3/BcHDK1brK94mi9I6J78dDXQS6WSQY7mup9l74Z78FLHf22LtS9GvpkzlL5zAKh0LzTVsgGlyJNMnh0/aRYK4p4IKiSAvQRhLXjfbWLc9XFAzQIDAQAB',
        'signType' => 'RSA2',
    ],
];