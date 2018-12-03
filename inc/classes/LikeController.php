<?php 

    interface ILikeController {
        
        public static function get_likes($post_id, $post_type);

        public static function user_liked($user_id, $post_id, $post_type);

        public static function set_like($user_id, $post_id, $post_type, $value);
        
        public static function toggle_like($user_id, $post_id, $post_type);
    }

    class LikeController implements ILikeController 
    {
        public static $table_name = "post_likes";

        public static function get_likes($post_id, $post_type)
        {
            global $wpdb;
            $result = [
                "likes" => 0,
                "dislikes" => 0,
                "users" => []
            ];
            $results = self::results("
                SELECT IsNegative, UserID FROM %s WHERE
                PostID = $post_id && Type = '$post_type'
            ");
            foreach ($results as $row)
            {
                if ($row->IsNegative == 1)
                {
                    $result["dislikes"] += 1;
                }
                else 
                {
                    $result["likes"] += 1;
                }
                if (!in_array($row->UserID, $result["users"]))
                {
                    $result["users"][] = $row->UserID;
                }
            }
            return $result;
        }   

        public static function set_like($user_id, $post_id, $post_type, $value)
        {
            global $wpdb;

            $rows_inserted = $wpdb->insert($wpdb->prefix . self::$table_name,
                [ 'PostID' => $post_id, 'UserID' => $user_id, 'Type' => $post_type, 'isNegative' => !$value ],
                [ '%d', '%d', '%s', '%d' ]);
            return $rows_inserted;
        }

        public static function toggle_like($user_id, $post_id, $post_type)
        {
            global $wpdb;
            $table_name = $wpdb->prefix . self::$table_name;
            $wpdb->query("UPDATE `$table_name` SET IsNegative = !IsNegative WHERE UserID = $user_id AND PostID = $post_id AND Type = '$post_type'");
        }

        public static function user_liked($user_id, $post_id, $post_type)
        {
            $results = self::results("
                SELECT IsNegative FROM %s WHERE PostID = '$post_id' AND UserID = '$user_id' AND Type = '$post_type' LIMIT 1
            ");
            if (sizeof($results) == 0) return NULL;
            $result = $results[0]->IsNegative;
            return $result;
        }

        private static function results($query)
        {
            global $wpdb;
            return $wpdb->get_results(sprintf($query, $wpdb->prefix .self::$table_name));
        }
    }