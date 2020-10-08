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

    <input type="hidden" value="yes" name="submitted" />
    <input type="hidden" name="nonce" value="<?= $formNonce ?>" />
    <input type="submit" class="button" value="Update Settings" />

</form>