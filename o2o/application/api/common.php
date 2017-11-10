<?php
function show($code,$message,$data)
{
    return json([
        'code' => $code,
        'message' => $message,
        'data' => $data
    ]);
}