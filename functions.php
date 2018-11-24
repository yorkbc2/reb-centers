<?php
/**
 * All the functions are in the PHP pages in the `inc/` folder.
 */

show_admin_bar(false);
define("HANDLER_MAXIMUM_LETTERS", 24);

require_once locate_template('/inc/helpers.php');
require_once locate_template('/inc/error-messages.php');
require_once locate_template('/inc/auth.php');
require_once locate_template('/inc/admin.php');
require_once locate_template('/inc/login.php');
require_once locate_template('/inc/customizer.php');

require_once locate_template('/inc/breadcrumbs.php');
require_once locate_template('/inc/cleanup.php');
require_once locate_template('/inc/custom-logo.php');
require_once locate_template('/inc/setup.php');
require_once locate_template('/inc/enqueues.php');
require_once locate_template('/inc/navbar.php');
require_once locate_template('/inc/widgets.php');
require_once locate_template('/inc/index-pagination.php');
require_once locate_template('/inc/split-post-pagination.php');
require_once locate_template('/inc/feedback.php');
require_once locate_template('/inc/shortcodes.php');
require_once locate_template('/inc/meta-boxes.php');
require_once locate_template('/inc/custom-post-types.php');
require_once locate_template('/inc/rehab.custom-type.php');
require_once locate_template('/inc/classes/User.php');
require_once locate_template('/inc/classes/UserController.php');
