<?php
/* PHP Challenge 2
 * Sam Likins <sam.likins@wsi-services.com>
 */

function parse_request($request, $secret)
{
    // $payload   = json_encode($payload);
    // $signature = hash_hmac('sha256', $payload, $secret);
    // $request   = base64_encode($signature).'.'.base64_encode($payload);

    // return strtr($request, '+/', '-_');

    $request = strtr($request, '-_', '+/');
    echo 'Request: '.$request.PHP_EOL;

    $payload = substr($request, 89);
    echo 'Payload: '.$payload.PHP_EOL;

    $payload = base64_decode($payload);
    echo 'Payload: '.$payload.PHP_EOL;

    $payload = json_decode($payload, true);
    echo 'Payload: '.var_export($payload, true).PHP_EOL;

    return $payload;
}

function dates_with_at_least_n_scores($pdo, $n)
{
    // YOUR CODE GOES HERE
}

function users_with_top_score_on_date($pdo, $date)
{
    // YOUR CODE GOES HERE
}

function dates_when_user_was_in_top_n($pdo, $user_id, $n)
{
    // YOUR CODE GOES HERE
}
