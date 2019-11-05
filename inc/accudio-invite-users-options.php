<?php

class Accudio_Invite_Users_Options {
  public static $messages;

  public static function option_handler()
  {
    // reset messages
    self::$messages = [];

    self::invitation_template();
    self::registration_template();
    self::advanced_settings();
  }

  public static function get($key)
  {
    $defaults = [
      'accudioiu_invitation_name'         => get_bloginfo('name'),
      'accudioiu_invitation_email'        => get_option('admin_email'),
      'accudioiu_invitation_subject'      => 'Invitation to create account with ' . get_bloginfo('name'),
      'accudioiu_invitation_body'         => 'Hi,&#10;&#10;You have been invited to create account with ' . get_bloginfo('name') . '. Click <a href="[invite-link]">here</a> to complete registration.&#10;&#10;Regards,&#10;' . get_bloginfo('name'),
      'accudioiu_registration_title'      => 'Complete your Registration',
      'accudioiu_registration_email'      => 'Email Address',
      'accudioiu_registration_password'   => 'Password',
      'accudioiu_registration_first_name' => 'First Name',
      'accudioiu_registration_last_name'  => 'Last Name',
      'accudioiu_registration_submit'     => 'Register',
      'accudioiu_registration_username'   => 'Username',
      'accudioiu_advanced_login'          => '/wp-admin/',
      'accudioiu_advanced_lost_password'  => '/wp-login.php?action=lostpassword',
      'accudioiu_advanced_username'       => false
    ];
    return get_option($key) ?: ($defaults[$key] ?? '');
  }

  private static function invitation_template()
  {
    if (isset($_POST['accudioiu-template'])) {
      update_option('accudioiu_invitation_name', sanitize_text_field($_POST['accudioiu-from-name']));
      update_option('accudioiu_invitation_email', sanitize_email($_POST['accudioiu-from-email']));
      update_option('accudioiu_invitation_subject', sanitize_text_field($_POST['accudioiu-subject']));
      update_option('accudioiu_invitation_body', stripslashes($_POST['accudioiu-email-body']));

      self::message();
    }
  }

  private static function registration_template()
  {
    if (isset($_POST['accudioiu-registration-template'])) {
      update_option('accudioiu_registration_title', sanitize_text_field($_POST['accudioiu-title']));
      update_option('accudioiu_registration_email', sanitize_text_field($_POST['accudioiu-email']));
      update_option('accudioiu_registration_password', sanitize_text_field($_POST['accudioiu-password']));
      update_option('accudioiu_registration_first_name', sanitize_text_field($_POST['accudioiu-first-name']));
      update_option('accudioiu_registration_last_name', sanitize_text_field($_POST['accudioiu-last-name']));
      update_option('accudioiu_registration_submit', sanitize_text_field($_POST['accudioiu-submit']));
      if (isset($_POST['accudioiu-username'])) {
        update_option('accudioiu_registration_username', sanitize_text_field($_POST['accudioiu-username']));
      }

      self::message();
    }
  }

  private static function advanced_settings()
  {
    if (isset($_POST['accudioiu-advanced'])) {
      update_option('accudioiu_advanced_username', sanitize_text_field($_POST['accudioiu-username']));
      update_option('accudioiu_advanced_redirect', sanitize_text_field($_POST['accudioiu-redirect']));
      update_option('accudioiu_advanced_login', sanitize_text_field($_POST['accudioiu-login']));
      update_option('accudioiu_advanced_lost_password', sanitize_text_field($_POST['accudioiu-lost-password']));

      self::message();
    }
  }

  private static function message()
  {
    self::$messages[] = [
      'type'    => 'success',
      'content' => 'Settings saved.'
    ];
  }
}
