<?php

class Accudio_Invite_Users_Register {
  public static function handle()
  {
    if (isset($_GET['accudioiu-invite'])) {
      $invite_id = $_GET['accudioiu-invite'];
      $email = get_option('accudioiu_invite_' . $invite_id);

      if ($email) {
        $custom_username = Accudio_Invite_Users_Options::get('accudioiu_advanced_username');
        $email_verification = Accudio_Invite_Users_Options::get('accudioiu_advanced_email');
        $user_exists = false;

        if (isset($_POST['accudioiu-register'])) {
          $error = self::register($email, $custom_username, $email_verification);
          if (!$error) {
            $user_exists = true;
            delete_option('accudioiu_invite_' . $invite_id);
          }
        }

        self::page_header();

        if ($user_exists && empty($error)) {
          wp_new_user_notification(get_user_by('email', $email)->ID);
          self::confirm($email);

        } else {
          if (isset($error)) {
            echo self::error($error);
            $error = '';
          }

          self::output_form($email, $custom_username, $email_verification);
        }

        self::page_footer();
      } else {
        self::page_header();
        echo self::error('Your invitation request cannot be found. This could be because it has expired, already been used, or does not exist. Please contact your administrator for more information or for a new invite.');
        self::page_footer();
      }

      exit;
    }
  }

  private static function register($email, $custom_username, $email_verification)
  {
    if ($email_verification) {
      if (!isset($_POST['accudioiu-email']) || sanitize_email($_POST['accudioiu-email']) !== $email) {
        return 'Please confirm the email address the invite was sent to. You can change your email address once an account has been created.';
      }
    }
    $first_name = isset($_POST['accudioiu-first-name']) ? sanitize_text_field($_POST['accudioiu-first-name']) : '';
    $last_name = isset($_POST['accudioiu-last-name']) ? sanitize_text_field($_POST['accudioiu-last-name']) : '';
    $username = $custom_username ? sanitize_text_field($_POST['accudioiu-username']) : $email;
    $user_data = [
      'user_login'    => $username,
      'user_email'    => $email,
      'first_name'    => $first_name,
      'last_name'     => $last_name,
      'user_pass'     => isset($_POST['accudioiu-password']) ? sanitize_text_field($_POST['accudioiu-password']) : '',
      'nickname'      => $first_name,
      'display_name'  => $first_name . ' ' . $last_name
    ];

    $role = Accudio_Invite_Users_Options::get('accudioiu_advanced_role');
    if ($role !== 'default') {
      $user_data['role'] = $role;
    }

    $user = wp_insert_user($user_data);
    if (!is_wp_error($user)) {
      return false;
    } else {
      return $user->get_error_message();
    }
  }

  private static function page_header()
  {
    ?>
    <body class="login login-action-login wp-core-ui locale-en-us">
      <div id="login">
	      <link rel="stylesheet" href="<?= site_url() ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load%5B%5D=dashicons,buttons,forms,l10n,login&amp" type="text/css" media="all" />
	      <form name="loginform" id="loginform" action="" method="post">
          <h2><?= Accudio_Invite_Users_Options::get('accudioiu_registration_title') ?></h2>
          <hr style="border: 0;border-top: 1px solid #ddd;margin: 20px 0;">
    <?php
  }

  private static function page_footer()
  {
    ?>
      </form>
    </body>
    <?php
  }

  private static function confirm()
  {
    $redirect = Accudio_Invite_Users_Options::get('accudioiu_advanced_redirect');
    if ($redirect) {
      echo '<script>window.location.href = "' . $redirect . '";</script>';
      echo '<p><span style=color:green>Registration successful. You should be redirected in a few seconds. If you are not redirected, <a href="' . $redirect . '">click here</a>.</p>';

    } else {
      echo '<p><span style=color:green>Registration successful. You can continue to <a href="' . Accudio_Invite_Users_Options::get('accudioiu_advanced_login') . '">login here.</a></span></p>';
    }
  }

  private static function output_form($email, $custom_username, $email_verification)
  {
    ?>
    <input type="hidden" name="accudioiu-register" value="1" />
    <p>
      <label for="email"><?= Accudio_Invite_Users_Options::get('accudioiu_registration_email') ?></label><br>
      <?php if ($email_verification) { ?>
        <input id="email" type="email" name="accudioiu-email" class="input" size="20" value="<?= $_POST['accudioiu-email'] ?? '' ?>">
      <?php } else { ?>
        <input id="email" type="email" name="accudioiu-email" class="input" size="20" readonly disabled value="<?= $email ?>" style="cursor: not-allowed;">
      <?php } ?>
    </p>
    <?php if ($custom_username) { ?>
      <p>
        <label for="username"><?= Accudio_Invite_Users_Options::get('accudioiu_registration_username') ?></label><br>
        <input id="username" type="text" name="accudioiu-username" class="input" size="20" value="<?= $_POST['accudioiu-username'] ?? '' ?>" required>
      </p>
    <?php } ?>
    <p>
      <label for="password"><?= Accudio_Invite_Users_Options::get('accudioiu_registration_password') ?></label><br>
      <input id="password" type="password" name="accudioiu-password" class="input" value="" size="20" required>
    </p>
    <p>
      <label for="first-name"><?= Accudio_Invite_Users_Options::get('accudioiu_registration_first_name') ?></label><br>
      <input id="first-name" type="text" name="accudioiu-first-name" class="input" value="<?= $_POST['accudioiu-first-name'] ?? '' ?>" size="20" required>
    </p>
    <p>
      <label for="last-name"><?= Accudio_Invite_Users_Options::get('accudioiu_registration_last_name') ?></label><br>
      <input id="last-name" type="text" name="accudioiu-last-name" class="input" value="<?= $_POST['accudioiu-last-name'] ?? '' ?>" size="20" required>
    </p>
    <p class="submit">
      <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_submit') ?>" />
    </p>
    <?php
  }

  private static function error($error)
  {
    $error = str_replace('Sorry, that username already exists!', 'Sorry, a user with this email already exists. You can <a href="' . Accudio_Invite_Users_Options::get('accudioiu_advanced_lost_password') . '">reset your password here</a>.', $error);
    return '<p style="margin-bottom:1rem;"><span style=color:red>' . $error . '</span></p>';
  }
}
