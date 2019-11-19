<?php

/**
 * @link        https://accudio.com/development
 * @since       1.0.0
 * @package     Accudio_Invite_Users
 *
 * @wordpress-plugin
 * Plugin Name:       Accudio Invite Users
 * Plugin URI:        https://github.com/Accudio/accudio-invite-users
 * Description:       Adds customisable interface for inviting users by email to create an account.
 * Version:           1.1.0
 * Author:            Alistair Shepherd — Accudio
 * Author URI:        https://alistairshepherd.uk
 * License:           MPL-2.0
 * License URI:       https://www.mozilla.org/en-US/MPL/2.0/
 * GitHub Plugin URI: https://github.com/Accudio/accudio-invite-users
 */

require_once 'inc/accudio-invite-users-options.php';
require_once 'inc/accudio-invite-users-invite.php';
require_once 'inc/accudio-invite-users-register.php';
require_once 'inc/accudio-invite-users-admin.php';

class Accudio_Invite_Users {
  const CAP = 'invite_users';

  public static function install()
  {
    $admin = get_role('administrator');
    $admin->add_cap(self::CAP);
  }

  public static function uninstall()
  {
    $admin = get_role('administrator');
    $admin->remove_cap(self::CAP);
  }

  public static function init()
  {
    Accudio_Invite_Users_Register::handle();
  }

  public static function admin_init()
  {
    Accudio_Invite_Users_Invite::handle();
  }
}

register_activation_hook(__FILE__, ['Accudio_Invite_Users', 'install']);
register_deactivation_hook(__FILE__, ['Accudio_Invite_Users', 'uninstall']);

add_action('init', 'Accudio_Invite_Users::init');
add_action('admin_init', 'Accudio_Invite_Users::admin_init');
add_action('admin_menu', 'Accudio_Invite_Users_Admin::add_menus', 90);
