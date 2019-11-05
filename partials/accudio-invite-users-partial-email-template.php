<h1 class="wp-heading-inline">Email Template</h1>

<?php Accudio_Invite_Users_Admin::messages(); ?>

<form method="POST" action="">
  <input type="hidden" name="accudioiu-template" value="1" />

  <div class="input-group">
    <label for="from-name">From Name:</label>
    <input id="from-name" type="text" required="true" name="accudioiu-from-name" value="<?= Accudio_Invite_Users_Options::get('accudioiu_invitation_name') ?>">
  </div>

  <div class="input-group">
    <label for="from-email">From Email:</label>
    <input id="from-email" type="email" required="true" name="accudioiu-from-email" value="<?= Accudio_Invite_Users_Options::get('accudioiu_invitation_email') ?>">
  </div>

  <div class="input-group">
    <label for="subject">Subject:</label>
    <input id="subject" type="text" required="true" name="accudioiu-subject" value="<?= Accudio_Invite_Users_Options::get('accudioiu_invitation_subject') ?>">
  </div>

  <div class="input-group">
    <label for="email-body">Email Template:</label>
    <textarea id="email-body" rows="8" cols="80" required="true" name="accudioiu-email-body" placeholder="Enter email message"><?= Accudio_Invite_Users_Options::get('accudioiu_invitation_body') ?></textarea>
  </div>

  <p>
    <strong>Shortcodes available in subject and body:</strong><br>
    <strong>[invite-link] :</strong> Invitation Link<br>
    <strong>[from-email] :</strong> Email of user that sent the invitation<br>
    <strong>[from-name] :</strong> Name of user that sent the invitation<br>
  </p>

  <input type="submit" class="button button-primary button-large" value="Update Template">
</form>
