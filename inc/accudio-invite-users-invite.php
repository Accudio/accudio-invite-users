<?php

class Accudio_Invite_Users_Invite {
  public static $messages;

  public static function handle()
  {
    if (isset($_POST['accudioiu-invite-users']) && isset($_POST['emails'])) {
      // reset messages
      self::$messages = [];

      $emails = self::email_list($_POST['emails']);
      $config = self::email_config();

      $headers = ['Content-Type: text/html; charset=UTF-8'];
      if (isset($config['from_name']) && isset($config['from_email'])) {
        $headers[] = 'From: ' . $config['from_name'] . ' <' . $config['from_email'] . '>';
      }

      if (count($emails) > 0) {
        foreach ($emails as $email) {
          if (empty($email)) {
            continue;
          } else if (email_exists($email)) {
            self::$messages[] = [
              'type'    => 'error',
              'content' => 'User with email ' . $email . ' already exists'
            ];
            continue;
          }
          do {
            $invite_key = self::gen_key();
          } while (get_option('accudioiu_invite_' . $invite_key));
          update_option('accudioiu_invite_' . $invite_key, $email);

          $email_content = self::prep_email($config, $invite_key);

          $success = wp_mail($email, $email_content['subject'], $email_content['body'], $headers);

          if ($success) {
            self::$messages[] = [
              'type'    => 'success',
              'content' => 'Sent invitation to ' . $email
            ];
          } else {
            global $phpmailer;
            if (isset($phpmailer)) {
              self::$messages[] = [
                'type'  => 'error',
                'content' => 'Error sending mail to ' . $email . '. Error: ' . $phpmailer->ErrorInfo
              ];
            }
          }
        }
      } else {
        self::$messages[] = [
          'type'    => 'error',
          'content' => 'Please enter at least one valid email'
        ];
      }
    }
  }

  private static function email_list($emails)
  {
    $input_emails = preg_split('/\r\n|[\r\n]/', $_POST['emails']);
    $emails = [];
    foreach ($input_emails as $input_email) {
      $sanitised_email = sanitize_email($input_email);
      if ($sanitised_email) {
        $emails[] = $sanitised_email;
      } else {
        self::$messages[] = [
          'type'    => 'error',
          'content' => '\'' . $input_email . '\' is not a valid email address'
        ];
      }
    }
    return $emails;
  }

  private static function email_config()
  {
    $email_body = Accudio_Invite_Users_Options::get('accudioiu_invitation_body');
    $email_body = str_replace(PHP_EOL, '<br>', $email_body);
    return [
      'body'        => $email_body,
      'subject'     => Accudio_Invite_Users_Options::get('accudioiu_invitation_subject'),
      'from_name'   => Accudio_Invite_Users_Options::get('accudioiu_invitation_name'),
      'from_email'  => Accudio_Invite_Users_Options::get('accudioiu_invitation_email'),
    ];
  }

  private static function gen_key()
  {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(32 / strlen($x)))), 1, 32);
  }

  private static function prep_email($config, $key)
  {
    $body = $config['body'];
    $subject = $config['subject'];

    $body = str_replace('[invite-link]', site_url() . '?' . http_build_query(['accudioiu-invite' => $key]), $body);
    $body = str_replace('[from-email]', $config['from_email'], $body);
    $body = str_replace('[from-name]', $config['from_name'], $body);

    $subject = str_replace('[from-email]', $config['from_email'], $subject);
    $subject = str_replace('[from-name]', $config['from_name'], $subject);

    return [
      'subject' => $subject,
      'body'    => $body
    ];
  }
}
