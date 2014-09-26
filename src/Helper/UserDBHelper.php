<?php 

/**
 * 
 **/
class UserDBHelper 
{
    
    function __construct()
    {
    }

    /*
     * ユーザ名からモデルを取得
     */
    static public function findByName($name) {
        $user = ORM::for_table('users')
            ->where_equal('name', $name)
            ->find_one();

        return $user;
    }

    /*
     * ユーザのtweetを取得
     */
    static public function findTweetByUserName($user_name) {
        $tweet_objs = ORM::for_table('tweet')
            ->select('tweet.*')
            ->join('users', array(
                'users.id', '=', 'tweet.user_id'
            ))
            ->where_equal('users.name', $user_name)
            ->find_many();

        $tweets = array_map(function ($x) {
            return $x->tweet;
        }, $tweet_objs);

        return $tweets;
    }

}
