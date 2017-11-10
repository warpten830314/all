<?php
return [
    //应用对应的appid
    'app_id' => '2016090800466835',
    //公钥
    'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwNMOzsEXV3Eh+UxzcvCN1HY7Vww1M53s7hzj+KIhQytvJM5NTYaSqlm3x3V/XLE4wfmmxo+PC1PhekfrErOQKdwdP+hLB1p598+bZWj3vx0EKD4whQgz6j3c7QiIhY9xU4yM2btM6HAH2rsBoW3umKIpcrmXck9+3WUEFHzEgzT+NWhOwW/DAMSimquW8b49bXXyj5L0aS5mZ8+s0bAHWj0prxRuNIABJqsU1089M4ZmJ/5yX4jUFQ+rln2ZoaFbvE68yU0EgdzLZ3aG0/TYArRpVFnBN1f7iP7+LsOdtLQGlbGlOSZOCHTCm5XXKP+zLKH7UpaBa/d4VqMu0cKBPQIDAQAB',
    //字符集
    'charset' => 'UTF-8',
    //加密类型
    'sign_type' => 'RSA2',
    //网关地址
    'gatewayUrl' => 'https://openapi.alipaydev.com/gateway.do',
    //私钥
    'merchant_private_key' => 'MIIEpAIBAAKCAQEAwNMOzsEXV3Eh+UxzcvCN1HY7Vww1M53s7hzj+KIhQytvJM5NTYaSqlm3x3V/XLE4wfmmxo+PC1PhekfrErOQKdwdP+hLB1p598+bZWj3vx0EKD4whQgz6j3c7QiIhY9xU4yM2btM6HAH2rsBoW3umKIpcrmXck9+3WUEFHzEgzT+NWhOwW/DAMSimquW8b49bXXyj5L0aS5mZ8+s0bAHWj0prxRuNIABJqsU1089M4ZmJ/5yX4jUFQ+rln2ZoaFbvE68yU0EgdzLZ3aG0/TYArRpVFnBN1f7iP7+LsOdtLQGlbGlOSZOCHTCm5XXKP+zLKH7UpaBa/d4VqMu0cKBPQIDAQABAoIBAQCRhbeDKg6nm2X8c0od0JX5ZlFaXIg6MFGDUqJqHlHkE3+J03hbrdg6YANmsLIyDj27huHqsKVP8zoTwvsR3hpKvSgF9xXIsuuhrjikzBdNUGS2ylhrzckAWzfEW9BMm/j3CPezyrs8IHCNDt0oK4MKBjgpsQ8u4ffotjfiDldwfNde9kDZOdE04TAE4ERSuAd140p0cm0CUuGgn4D2zG0cQcmIJvSROl0Dq6X+eRp9mwdwiRY/2ySvGmtRiu5UITb+QRg68YEQCqR8dGieZDP3lXn3FGbuDe6r9w0f+NkY3hGvmcbH61YCZFHcwlnRn3k2g8ih731JBIyecqaJtpQxAoGBAP8QDLPZ4TnCu80uLpZRiQh/n/61xrwFsOHEZC8WxWduB7ZtIZJcFs53QCqgrfHdg1oE5j0CUCzJ97/XZhsWqVufuXZ5UlP/+1lW6XoP8UIBhBn+X56iMDYRz4oK96MmxACwazW5VqE/hHCj7ogDVvqSN2KjeJm3ymThMrt0HykPAoGBAMGIdSI0iiexlvBEAuLr4K7yNe7CULc8VyJHM0B/aDvhHgvAEo1gtVBCmJlgJTu7blP7F60rxh5Og6ERmswVKupFqJlValLA4hr4IwVsD5TzKjcMMqqNGOG3Vj8fevB2gWP20FnAb9lEnCijLogfoKxmAqs0coZVCJZ574uBGPjzAoGBAOg0pFvYL8N2FaNmN+OBt0+VYQNyWcszIyVmtg5onK7c7QiXscidLeYpirFENxfKopqBe1pvkK418OcmIj7nEqfnceD58ommsh1TkpsdiHafCrTfcA3rehi/fkIeWfSehjJaakAuyz9hpCEoHTCWWckk9GdIi7LmL8xHePhPb07hAoGAR6G7QSLTM+fuZxW1P8pwijBKOAoiGAA0fBKAbNH7gZZMKas48q0lzwQnOTW18krohhr843K9TMBgxgAfHISFMtr/kWllBiYwSi0nwT0C822hZWiVZDz/RaQ3Pvvm5BPoxlg3O9EXVQKpDf2AHpAeR1EmkbnC3eehWxjcyfTJinMCgYA4p8NdigYjDGuQPKwIu+4cSPvQ370tLIuErp3wz/GEdnpVQQ7AfV94WAyiB3LVs97XEoB+HYn3euF3kLxOr7oulCcoaMsh017Ivjapb+I2i3fwlKHhmPjbUH/iVXFUmY/kb0ofjyjJaWn7hZGioH2N2T75FYWNplkhM1gTZP80TA==',
    //服务器回调地址
    'notify_url' => 'http://o2o.local/index.php/index/notify/index',
    //前端跳转地址
    'return_url' => 'http://o2o.local/index.php/index/order/finish'
];