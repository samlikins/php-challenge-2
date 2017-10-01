<?php
/* PHP Challenge 2
 * Sam Likins <sam.likins@wsi-services.com>
 */

/**
 * Extract payload from request
 * @param  string $request Encoded request
 * @param  string $secret  Secret for decoding
 * @return array           Decoded payload from request
 */
function parse_request($request, $secret)
{
    if(strpos($request, '.') != 88) return false;

    return json_decode(
        base64_decode(
            substr(
                strtr(
                    $request,
                    '-_',
                    '+/'
                ),
                89
            )
        ),
        true
    );
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
