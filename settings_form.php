<h1>Admin Plus Settings</h1>

<?php if ($message) : ?>
    <div class="alert <?= $message_type ?>"><?= $message ?></div>
<?php endif; ?>

<form method="post">
    <div class="form-group <?= (isset($errors['adminplus_gated_default'])) ? 'has-error' : '' ?>">
        <input class="form-check-input" type="checkbox" name="adminplus_gated_default" value="1" id="gated_default" <?= ($data['adminplus_gated_default']) ? 'checked' : '' ?>>
        <label class="form-check-label" for="gated_default">
            Gated setting for videos (must be logged in to view) is on by default.
        </label>
    </div>
    <div class="form-group <?= (isset($errors['adminplus_private_default'])) ? 'has-error' : '' ?>">
        <input class="form-check-input" type="checkbox" name="adminplus_private_default" value="1" id="private_default" <?= ($data['adminplus_private_default']) ? 'checked' : '' ?>>
        <label class="form-check-label" for="private_default">
            Video privacy setting defaults to on.
        </label>
    </div>
    <div class="form-group <?= (isset($errors['adminplus_jwplayer_enabled'])) ? 'has-error' : '' ?>">
        <input class="form-check-input" type="checkbox" name="adminplus_jwplayer_enabled" value="1" id="jwplayer_enabled" <?= ($data['adminplus_jwplayer_enabled']) ? 'checked' : '' ?>>
        <label class="form-check-label" for="jwplayer_enabled">
            Enable JWPlayer for media playback and embeds.
        </label>
    </div>
    <div class="form-group <?= (isset($errors['adminplus_jwplayer_source'])) ? 'has-error' : '' ?>">
        <label class="control-label" for="jwplayer_source">JWPlayer library source URL. (CDN or local)</label>
        <input class="form-control" id="jwplayer_source" type="text" name="adminplus_jwplayer_source" value="<?= $data['adminplus_jwplayer_source'] ?>" />
    </div>
    <div class="form-group <?= (isset($errors['adminplus_jwplayer_key'])) ? 'has-error' : '' ?>">
        <label class="control-label" for="jwplayer_key">JWPlayer Key (if <a href="https://developer.jwplayer.com/jwplayer/docs/jw8-add-a-player-library#section-self-hosted">self-hosting</a> the player library):</label>
        <input class="form-control" id="jwplayer_key" type="text" name="adminplus_jwplayer_key" value="<?= $data['adminplus_jwplayer_key'] ?>" />
    </div>

    <h2 class="mt-3">Add a Text/Language Item</h2>
    <p>Create a new text item that can be used in a theme. It can be edited in the settings under <a href="<?= BASE_URL ?>/cc-admin/languages.php">Appearance -> Languages</a>.</p>  
    <div class="form-group <?= (isset($errors['language_label'])) ? 'has-error' : '' ?>">
        <label class="control-label" for="language-label">Label (text/underscores only): </label>
        <input class="form-control" id="language-label" type="text" name="language_label" placeholder="accessibility_notice" value="" />
    </div>
    <div class="form-group <?=(isset ($errors['language_text'])) ? 'has-error' : ''?>">
      <label for="language-text">Text to display: </label>
      <textarea class="form-control" id="language-text" name="language_text" placeholder="Some text to be inserted regarding accessibility.... " style="width: 75%;" rows="6"></textarea>
    </div>

    <?php 
     // Retrieve custom language entries
     $activeLanguage = Settings::get('default_language');
     $textService = new TextService();
     $customEntries = $textService->getLanguageEntries($activeLanguage);
    ?>
     <?php if (sizeof($customEntries) > 0): ?>
    <h4 class="mt-3">Existing Custom Text Items</h3>
    <p>This is a list of the current text items that have either been created here, or edited to be different from the default.  </p>  
    <table class="table">
    <thead>
        <tr>
        <th scope="col">Label</th>
        <th scope="col">Text</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customEntries as $entry): ?>
        <tr>
        <th scope="row"><?= $entry->name ?></th>
        <td><?= htmlentities($entry->content) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
<br>
    <input type="hidden" value="yes" name="submitted" />
    <input type="hidden" name="nonce" value="<?= $formNonce ?>" />
    <input type="submit" class="button" value="Update Settings" />

</form>
