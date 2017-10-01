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

/**
 * Return array of dates containing a specified number of scores or more
 * @param  PDO   $pdo Database handle
 * @param  int   $n   Number of scores to check for
 * @return array      Array of dates containing specified number of scores
 */
function dates_with_at_least_n_scores($pdo, $n)
{
    $statement = $pdo->prepare(
        'SELECT `date`
        FROM `scores`
        GROUP BY `date`
        HAVING COUNT (`date`) >= :count
        ORDER BY `date` DESC;'
    );

    $statement->bindParam(':count', $n, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
}

/**
 * Return user id with top score for specified date
 * @param  PDO    $pdo  Database handle
 * @param  string $date Date to return user of top score
 * @return int          Id of user with top score of specified date
 */
function users_with_top_score_on_date($pdo, $date)
{
    $statement = $pdo->prepare(
        'SELECT `user_id`
        FROM `scores`
        WHERE `date` = :date
            AND `score` = (
                SELECT MAX(`score`)
                FROM `scores`
                WHERE `date` = :date
            );'
    );

    $statement->bindParam(':date', $date, PDO::PARAM_STR);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
}

// $statement = $pdo->prepare('SELECT `id`, `user_id`, `score`, `date` FROM `scores`;');
function dates_when_user_was_in_top_n($pdo, $user_id, $n)
{
    $statement = $pdo->prepare(
        'SELECT `scores`.`date`
        FROM `scores`
        WHERE `scores`.`user_id` = :userId
            AND (
                SELECT `s`.`score`
                    FROM `scores` AS `s`
                    WHERE `s`.`date` = `scores`.`date`
                    ORDER BY `s`.`score` DESC
                    LIMIT :topCount
            ) <= `scores`.`score`
        ORDER BY `scores`.`date` DESC;'
    );

    $statement->bindParam(':userId', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':topCount', $n, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
}
