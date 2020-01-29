<?php
return [
    'token_duration_second' => 864000, //token 有效时长（秒）
    'token_refresh_gap_second' => 86400 //登录后的每次请求，如果请求时间距离 token 失效时间小于指定秒且大于0，则延长 token 有效期
];