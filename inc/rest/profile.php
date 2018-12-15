<?php 

    define("IMAGE_SQUARE_LIMIT", 500);

    if (!function_exists("rest_user_upload_avatar"))
    {
        function rest_user_upload_avatar(WP_REST_Request $request)
        {
            include_once( ABSPATH . 'wp-admin/includes/image.php' );
            if ( ! function_exists( 'wp_handle_upload' ) ) 
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
            global $wpdb;
            $user_id = $request->get_param("user_id");
            $user_pass = $request->get_param("user_pass");

            $user_test = UserController::test_user($user_id, $user_pass);
            if ($user_test === -1)
            {
                return ["success" => false, "error" => "User is not found"];
            }
            if ($user_test === 0)
            {
                return ["success" => false, "error" => "Please don't use devtools!"];
            }
            $overrides = array( 'test_form' => false );
            $image = $_FILES["image"];
            $movedfile = wp_handle_upload($image, $overrides);
            $file_path = $movedfile["file"];
            $file_path_info = pathinfo($file_path);
            $file_path_name = "cropped_" . $file_path_info["basename"];
            $filename = $file_path_info["dirname"] . "/" . $file_path_name;
            $fileurl = "/wp-content/uploads/" . $file_path_name;
            $sq = IMAGE_SQUARE_LIMIT;
            list($width, $height) = getimagesize($file_path);
            $ratio = $width / $height;
            if ($width > $height) {
                if ($height < $sq) {
                    $sq = $height;
                }
                $new_height = $sq;
                $new_width = $new_height / $ratio;
            } else if ($width < $height) {
                if ($width < $sq) {
                    $sq = $width;
                }
                $new_width = $sq;
                $new_height = $new_width / $ratio;
            } else {
                $new_width = $sq;
                $new_height = $new_width;
            }

            $new_width = round($new_width);
            $new_height = round($new_height);

            if ($new_width > $new_height) { 
                $y = 0;
                $x = ($new_width - $new_height) / 2;
            } else if ($new_height > $new_width) { 
                $x = 0;
                $y = ($new_height - $new_width) / 2;
            } else {
                $x = 0;
                $y = 0;
            }

            var_dump($width, $height, $new_width, $new_height, $x, $y);
            die();
        
            $avatar_image = imagecreatetruecolor($new_width, $new_height);
            $jpeg   = imagecreatefromjpeg($file_path);

            imagecopyresampled($avatar_image, $jpeg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            $avatar_image = imagecrop($avatar_image, array(
                'width' => $sq,
                'height' => $sq,
                'x' => $x,
                'y' => $y
            ));

            imagejpeg($avatar_image, $filename, 80);

            unlink($file_path);
            
            $avatar = get_user_meta($user_id, "_user_avatar", true);
            if ($avatar)
            {   
                $name = basename($avatar);
                if ($name !== $file_path_name) {
                    $upload_dir = wp_upload_dir();
                    unlink($upload_dir['basedir'] . '/' . $name);
                    update_user_meta($user_id, '_user_avatar', $fileurl);
                } 
            }
            else
            {
                add_user_meta($user_id, '_user_avatar', $fileurl); 
            }
            

            return $fileurl; 
        }

        add_action( "rest_api_init", function () {
			register_rest_route( "brainworks", "user/avatar", array(
				"methods" => "POST",
				"callback" => "rest_user_upload_avatar",
			) );
		} );
    }