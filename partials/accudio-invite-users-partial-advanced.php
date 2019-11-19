<h1 class="wp-heading-inline">Advanced Settings</h1>

<?php Accudio_Invite_Users_Admin::messages(); ?>

<form method="POST" action="">
  <input type="hidden" name="accudioiu-advanced" value="1" />

  <div class="input-group checkbox">
    <label for="username">Allow custom username</label>
    <input id="username" type="checkbox" name="accudioiu-username"<?= Accudio_Invite_Users_Options::get('accudioiu_advanced_username') ? ' checked' : '' ?>>
  </div>

  <div class="input-group checkbox">
    <label for="email">Verify email address</label>
    <input id="email" type="checkbox" name="accudioiu-advanced-email"<?= Accudio_Invite_Users_Options::get('accudioiu_advanced_email') ? ' checked' : '' ?>>
    <p class="description">Adds additional security by requiring user to confirm email. (note this also affects previous invitations)</p>
  </div>

  <div class="input-group">
    <label for="role">Default role</label>
    <select id="role" name="accudioiu-role">
      <option value="default"<?= 'default' === Accudio_Invite_Users_Options::get('accudioiu_advanced_role') ? ' selected' : '' ?>>Default Role</option>
      <?php
      $roles = get_editable_roles();
      unset($roles['administrator']);
      foreach ($roles as $role_slug => $role) { ?>
        <option value="<?= $role_slug ?>"<?= $role_slug === Accudio_Invite_Users_Options::get('accudioiu_advanced_role') ? ' selected' : '' ?>><?= $role['name'] ?></option>
      <?php } ?>
    </select>
    <p class="description">Default role for new invited users.</p>
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
