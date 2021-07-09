<?php

return [
    'disks' => [
        'obs' => [
            'driver' => 'obs',
            'key' => env('OBS_ACCESS_ID'), // <Your Huawei OBS AccessKeyId>
            'secret' => env('OBS_ACCESS_KEY'), // <Your Huawei OBS AccessKeySecret>
            'bucket' => env('OBS_BUCKET'), // <OBS bucket name>
            'endpoint' => env('OBS_ENDPOINT'), // <the endpoint of OBS, E.g: (https:// or http://).obs.cn-east-2.myhuaweicloud.com | custom domain, E.g:img.abc.com> OBS 外网节点或自定义外部域名
            'cdn_domain' => env('OBS_CDN_DOMAIN'), //<CDN domain, cdn域名> 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
            'ssl_verify' => env('OBS_SSL_VERIFY'), // <true|false> true to use 'https://' and false to use 'http://'. default is false,
            'debug' => env('APP_DEBUG'), // <true|false>
        ],
    ]
];
