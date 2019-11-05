<h1 class="wp-heading-inline">Advanced Settings</h1>

<?php Accudio_Invite_Users_Admin::messages(); ?>

<form method="POST" action="">
  <input type="hidden" name="accudioiu-advanced" value="1" />

  <div class="input-group checkbox">
    <label for="username">Allow custom username</label>
    <input id="username" type="checkbox" name="accudioiu-username"<?= Accudio_Invite_Users_Options::get('accudioiu_advanced_username') ? ' checked' : '' ?>>
  </div>

  <div class="input-group">
    <label for="redirect-url">Redirect URL</label>
    <input id="redirect-url" type="text" name="accudioiu-redirect" value="<?= Accudio_Invite_Users_Options::get('accudioiu_advanced_redirect') ?>">
    <p class="description">URL user is redirected to on successful registration.</p>
  </div>

  <div class="input-group">
    <label for="login-url">Login URL</label>
    <input id="login-url" type="text" name="accudioiu-login" value="<?= Accudio_Invite_Users_Options::get('accudioiu_advanced_login') ?>">
    <p class="description">Relative link to login page.</p>
  </div>

  <div class="input-group">
    <label for="lost-password">Lost password URL</label>
    <input id="lost-password" type="text" name="accudioiu-lost-password" value="<?= Accudio_Invite_Users_Options::get('accudioiu_advanced_lost_password') ?>">
    <p class="description">Relative link to lost password page.</p>
  </div>

  <input type="submit" class="button button-primary button-large" value="Save Settings">
</form>
