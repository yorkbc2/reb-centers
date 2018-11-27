<?php 
    interface IUserAvatar {

        /**
         * @param string $filepath Path to file
         * @param number $user_id User's id
         */
        public function __construct(
            $filepath,
            $user_id
        );
    

        /**
         * Save avatar as custom post
         * @return number The image id
         */
        public function save();

        /**
         * @return string|null Url of the file
         */
        public function get();
    }

    class UserAvatar implements IUserAvatar {
        public function __construct($filepath="", $user_id=0)
        {
            $this->uri = $filepath;
            $this->user_id = $user_id;
        }


        public function save()
        {
            if ($posts = $this->get())
            {
                foreach ($posts as $post)
                {
                    wp_delete_post($post->ID, false);
                }
            }
            $post_args = array(
                "post_type" => "user_image",
                "post_content" => $this->uri,
                "post_author" => $this->user_id,
                "post_date" => date("d.m.Y"),
                "post_status" => "publish"
            );

            $id = wp_insert_post($post_args);

            if (!is_wp_error($id))
            {
                return $id;
            }
            die($id);
            return false;
        }

        public function get($return_posts=false)
        {
            $posts = get_posts([
                "post_type" => "user_image",
                "post_author" => $this->user_id,
                "post_status" => array("draft", "publish")
            ]);
            if (sizeof($posts) > 0)
            {
                
                return $return_posts === false ? $posts[0]->post_conten : $posts;
            }
            return false;
        }
    }