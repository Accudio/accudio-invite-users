<h1 class="wp-heading-inline">Registration Template</h1>

<?php Accudio_Invite_Users_Admin::messages(); ?>

<form method="POST" action="">
  <input type="hidden" name="accudioiu-registration-template" value="1" />

  <div class="input-group">
    <label for="title">Title:</label>
    <input id="title" type="text" required="true" name="accudioiu-title" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_title') ?>">
  </div>

  <div class="input-group">
    <label for="email">Email Label:</label>
    <input id="email" type="text" required="true" name="accudioiu-email" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_email') ?>">
  </div>

  <div class="input-group">
    <label for="username">Username Label:</label>
    <input id="username" type="text" required="true" name="accudioiu-username" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_username') ?>">
    <p class="description">Only displayed if "Allow custom username" enabled in Advanced Options</p>
  </div>

  <div class="input-group">
    <label for="password">Password Label:</label>
    <input id="password" type="text" required="true" name="accudioiu-password" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_password') ?>">
  </div>

  <div class="input-group">
    <label for="first-name">First Name Label:</label>
    <input id="first-name" type="text" required="true" name="accudioiu-first-name" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_first_name') ?>">
  </div>

  <div class="input-group">
    <label for="last-name">Last Name Label:</label>
    <input id="last-name" type="text" required="true" name="accudioiu-last-name" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_last_name') ?>">
  </div>

  <div class="input-group">
    <label for="submit">Submit Button Label:</label>
    <input id="submit" type="text" required="true" name="accudioiu-submit" value="<?= Accudio_Invite_Users_Options::get('accudioiu_registration_submit') ?>">
  </div>

  <input type="submit" class="button button-primary button-large" value="Save Settings">
</form>
