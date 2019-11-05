<h1 class="wp-heading-inline">Invite Users</h1>

<?php Accudio_Invite_Users_Admin::messages(); ?>

<form  method="POST" action="">
  <div class="input-group">
    <input type="hidden" name="accudioiu-invite-users" value="1" />
    <label for="accudio-invite-users">Emails to send invites to (seperated by new line)</label>
    <textarea id="accudio-invite-users" rows="8" cols="80" required="true" name="emails" placeholder="List of email addresses, each on new line" value=""></textarea>
    </div>
  <input type="submit" class="button button-primary button-large" value="Send Invitation">
</form>
