<?php 

    define('_BRAINWORKS_AUTH', '_BRAINWORKS_AUTH');
    session_start();
    if (!function_exists('get_bw_session')) {
        function get_bw_session($key="")
        {
            return isset($_SESSION[$key])? $_SESSION[$key]: false;
        }
    }

    if (!function_exists('set_bw_session')) {
        function set_bw_session($key, $value="")
        {
            $_SESSION[$key] = $value;
            return $_SESSION;
        }
    }

    if (!function_exists('get_auth_session')) {
        function get_auth_session()
        {
            return get_bw_session(_BRAINWORKS_AUTH);
        }
    }

    if (!function_exists('set_auth_session')) {
        function set_auth_session ($value=[]) 
        {
            $_SESSION[_BRAINWORKS_AUTH] = $value;
            return $_SESSION;
        }
    }

    if (!function_exists('bw_user_logged_in')) {
        function bw_user_logged_in()
        {
            $user = get_auth_session();
            if ($user) {
                $login = $user['login'];
                return bw_user_check_login($login);
            } else {
                return false;
            }
        }
    }

    if (!function_exists('bw_user_experation_check')) {
        function bw_user_experation_check () 
        {
            $user = get_auth_session();

            if ($user) {
                $user_date = $user['_date'];
                $current_date = microtime(true);
                if ($current_date - $user_date >= 3600) {
                    set_auth_session(null);
                }
            }
        }

        add_action( 'init', 'bw_user_experation_check' );
    }

    if (!function_exists('bw_user_login')) {
        function bw_user_login($login='', $password='')
        {
            $user = get_user_by('login', $login);
            if ($user) {
                if (wp_check_password($password, $user->data->user_pass, $user->ID)) {
                    set_auth_session(bw_create_user_session_array($login));
                    return ['status' => true];
                } else {
                    return ['status' => false, 'message' => __('Password is incorrect!', 'brainworks')];
                }
            } else {
                return ['status' => false, 'message' => __('Login is incorrect!', 'brainworks')];
            }
        }
    }
    
    if (!function_exists('bw_user_logout')) {
        function bw_user_logout() 
        {   
            set_auth_session(null);
            return true;
        }
    }

    if (!function_exists('bw_user_check_login')) {
        function bw_user_check_login($login="")
        {
            $user = get_user_by('login', $login);
            if ($user) {
                return true;
            } else {
                return false;
            }
        }
    }

    if (!function_exists('bw_user_check_email')) {
        function bw_user_check_email($email="")
        {
            $user = get_user_by_email($email);
            if ($user) {
                return true;
            } else {
                return false;
            }
        }
    }

    if (!function_exists('bw_create_user_session_array')) {
        function bw_create_user_session_array($login='')
        {
            return [
                'login' => $login,
                'date' => date(),
                '_date' => microtime(true)
            ];
        }
    }    

    if (!function_exists('bw_user_create')) {
        function bw_user_create($login='', $password='', $email='')
        {
            $id = wp_create_user( $login, $password, $email );
            if (is_wp_error( $id )) {
                return false;
            } else {
                return bw_create_user_session_array($login);
            }
        }
    }

    if (!function_exists('bw_auth_rest_endpoint')) {
        function bw_auth_rest_endpoint(WP_REST_Request $req)
        {
            $login = filter_var($req->get_param('login'), FILTER_SANITIZE_STRING);
            $password = filter_var($req->get_param('password'), FILTER_SANITIZE_STRING);
            $redirect = filter_var($req->get_param('_redirect_url'), FILTER_SANITIZE_URL);

            if (!$redirect) {
                $redirect = '';
            }

            if (!bw_user_logged_in()) {
                $login_result = bw_user_login($login, $password);
                if (isset($login_result['status']) && $login_result['status'] === true) {
                    return wp_redirect( home_url() . $redirect . '?success_message=1' );
                } else {
                    return wp_redirect( home_url() . $redirect . '?error_message=1' );
                }
            }

            return wp_redirect( home_url() . $redirect );
        }
        add_action('init', function () {
            register_rest_route('api', 'auth/login', [
                'methods' => 'POST',
                'callback' => 'bw_auth_rest_endpoint'
            ]);
        });
    }

    if (!function_exists('bw_auth_rest_register')) {
        function bw_auth_rest_register(WP_REST_Request $req) 
        {
            $login = filter_var($req->get_param('login'), FILTER_SANITIZE_STRING);
            $email = filter_var($req->get_param('email'), FILTER_SANITIZE_EMAIL);
            $password = filter_var($req->get_param('password'), FILTER_SANITIZE_STRING);
            $retry_password = filter_var($req->get_param('retry_password'), FILTER_SANITIZE_STRING);
            $redirect = filter_var($req->get_param('_redirect_url'), FILTER_SANITIZE_URL);
            if (!$redirect) $redirect = '';


            if ($password == $retry_password) {
                
                if (!bw_user_check_login($login) && !bw_user_check_email($email)) {
                    $user = bw_user_create($login, $password, $email);
                    if ($user) {
                        set_auth_session($user);
                        return wp_redirect( home_url() . $redirect . '?success_message=1' );
                    } else {
                        return wp_redirect( home_url() . $redirect . "?error_message=3" );
                    }
                    
                } else {
                    return wp_redirect( home_url() . $redirect . "?error_message=2" );
                }

            } else {
                return wp_redirect( home_url() . $redirect . "?error_message=4" );
            }
        }

        add_action('init', function () {
            register_rest_route('api', 'auth/register', [
                'methods' => 'POST',
                'callback' => 'bw_auth_rest_register'
            ]);
        });
    }

    if (!function_exists('bw_auth_rest_logout')) {
        function bw_auth_rest_logout() 
        {
            bw_user_logout();
            return wp_redirect(home_url());
        }

        add_action('init', function () {
            register_rest_route('api', 'auth/logout', [
                'methods' => 'GET',
                'callback' => 'bw_auth_rest_logout'
            ]);
        });
    }

    if (!function_exists('bw_auth_error_reporting')) {
        function bw_auth_error_reporting ($error_code=1) 
        {
            switch ($error_code) {
                case 4: {
                    return __('Passwords must be the same!', 'brainworks');
                }
                case 3: {
                    return __('Error with creating user. Please, try again later!', 'brainworks');
                }
                case 2: {
                    return __('User with this login or email has already registered', 'brainworks');
                }
                case 1:
                default: {
                    return __('Login or password are incorrect!', 'brainworks');
                }
            }
        }
    }
    