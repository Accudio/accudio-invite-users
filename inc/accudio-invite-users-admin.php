<?php

class Accudio_Invite_Users_Admin {
  private const SLUG = 'accudio_invite_users';

  public static function add_menus()
  {
    $submenu = add_submenu_page('users.php', __('Invite Users', 'accudio'), __('Invite Users', 'accudio'), Accudio_Invite_Users::CAP, self::SLUG, array('Accudio_Invite_Users_Admin', 'page_wrap'));
    add_action('load-' . $submenu, 'Accudio_Invite_Users_Admin::page_load');
  }

  public static function page_load()
  {
    Accudio_Invite_Users_Options::option_handler();
    add_action('admin_head', 'Accudio_Invite_Users_Admin::admin_styles');
  }

  public static function admin_styles()
  {
    ?>
    <style>
      .accudio-invite-users .input-group {
        margin: 1rem 0;
      }
      .accudio-invite-users .input-group.checkbox {
        width: 300px;
      }
      .accudio-invite-users label {
        display: block;
        font-size: .9rem;
        font-weight: 600;
        padding-left: .2rem;
      }
      .accudio-invite-users .checkbox label {
        display: inline-block;
        margin-right: 4rem;
      }
      .accudio-invite-users input:not([type="checkbox"]), .accudio-invite-users select {
        display: block;
        min-width: 300px;
      }
      .accudio-invite-users input[type="checkbox"] {
        float: right;
        margin-top: 1px;
      }
      .accudio-invite-users textarea {
        display: block;
      }
      .accudio-invite-users .description {
        margin: 0;
        font-style: italic;
        font-size: .8rem;
        padding-left: .2rem;
      }
    </style>
    <?php
  }

  public static function page_wrap()
  {
    $active = $_GET[ 'tab' ] ?? 'invite';
    ?>
    <div class="wrap accudio-invite-users">
      <?php
      self::tab_nav($active);
      self::tab_wrap($active)
      ?>
    </div>
    <?php
  }

  private static function tab_nav($active_tab)
  {
    $tabs = [
      'invite'        => 'Send Invitation',
      'template'      => 'Email Template',
      'registration'  => 'Registration Template',
      'advanced'      => 'Advanced'
    ];
    ?>
    <div class="nav-tab-wrapper">
      <?php foreach ($tabs as $slug => $title) { ?>
        <a href="?page=<?= self::SLUG ?>&tab=<?= $slug ?>" class="nav-tab<?= $active_tab === $slug ? ' nav-tab-active' : '' ?>"><?= $title ?></a>
      <?php } ?>
    </div>
    <?php
  }

  private static function tab_wrap($active)
  {
    switch ($active) {
      case 'invite':
        require_once __DIR__ . '/../partials/accudio-invite-users-partial-invite.php';
        break;
      case 'template':
        require_once __DIR__ . '/../partials/accudio-invite-users-partial-email-template.php';
        break;
      case 'registration':
        require_once __DIR__ . '/../partials/accudio-invite-users-partial-registration-template.php';
        break;
      case 'advanced':
        require_once __DIR__ . '/../partials/accudio-invite-users-partial-advanced.php';
        break;
    }
  }

  public static function messages()
  {
    $messages = [];
    if (Accudio_Invite_Users_Invite::$messages) {
      $messages = array_merge($messages, Accudio_Invite_Users_Invite::$messages);
    }
    if (Accudio_Invite_Users_Options::$messages) {
      $messages = array_merge($messages, Accudio_Invite_Users_Options::$messages);
    }

    if ($messages) { ?>
      <h2 style="display:none">Messages</h2>
      <?php foreach ($messages as $message) { ?>
        <div class="notice notice-<?= $message['type'] ?> is-dismissible"><p><?= $message['content'] ?></p></div>
      <?php } ?>
    <?php }
  }
}
