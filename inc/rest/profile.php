<?php 

    if (!function_exists("rest_user_upload_avatar"))
    {
        function rest_user_upload_avatar(WP_REST_Request $request)
        {
            // if( wp_verify_nonce( $request->get_param("fileup_nonce"), 'user_file_upload' ) ) 
            // {
                if ( ! function_exists( 'wp_handle_upload' ) ) 
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
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

                $picture = new UserAvatar($movedfile["url"], $user_id);
                $id = $picture->save();

                if ($id)
                    return $movedfile["url"];
                else
                    die("cannot upload image in database!");
                
            // } 
            // else
            // {
            //     return array("success" => false, "error" => "Please, use secured forms with wp nonce!");
            // }
        }

        add_action( "rest_api_init", function () {
			register_rest_route( "brainworks", "user/avatar", array(
				"methods" => "POST",
				"callback" => "rest_user_upload_avatar",
			) );
		} );
    }