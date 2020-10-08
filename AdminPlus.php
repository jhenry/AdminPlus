<?php
class AdminPlus extends PluginAbstract
{
  /**
   * @var string Name of plugin
   */
  public $name = 'AdminPlus';

  /**
   * @var string Description of plugin
   */
  public $description = 'Provide additional settings, filters, and tools for site administration. For example, allow private video checkbox to be checked by default or toggle JWPlayer support.';

  /**
   * @var string Name of plugin author
   */
  public $author = 'Justin Henry';

  /**
   * @var string URL to plugin's website
   */
  public $url = 'https://uvm.edu/~jhenry/';

  /**
   * @var string Current version of plugin
   */
  public $version = '0.0.3';

  /**
   * Performs install operations for plugin. Called when user clicks install
   * plugin in admin panel.
   *
   */
  public function install()
  {
    Settings::set('adminplus_private_default', 0);
    Settings::set('adminplus_gated_default', 0);
    Settings::set('adminplus_jwplayer_enabled', 0);
    Settings::set('adminplus_jwplayer_source', '');
    Settings::set('adminplus_jwplayer_key', '');
  }
  /**
   * Performs uninstall operations for plugin. Called when user clicks
   * uninstall plugin in admin panel and prior to files being removed.
   *
   */
  public function uninstall()
  {
    Settings::remove('adminplus_private_default');
    Settings::set('adminplus_gated_default');
    Settings::set('adminplus_jwplayer_enabled');
    Settings::set('adminplus_jwplayer_source');
    Settings::set('adminplus_jwplayer_key');
  }

  /**
   * The plugin's gateway into codebase. Place plugin hook attachments here.
   */
  public function load()
  {
    Plugin::attachEvent('theme.head', array(__CLASS__, 'jwplayer'));
  }

  /**
   * Place jwplayer library in the head.
   */
  public static function jwplayer()
  {
    $enabled = Settings::get('adminplus_jwplayer_enabled');
    $source = Settings::get('adminplus_jwplayer_source');
    if ($enabled) {
      echo '<script src="' . $source . '"></script>';
    }
  }

  /**
   * Outputs the settings page HTML and handles form posts on the plugin's
   * settings page.
   */
  public function settings()
  {
    $data = array();
    $errors = array();
    $message = null;

    // Retrieve settings from database
    $data['adminplus_private_default'] = Settings::get('adminplus_private_default');
    $data['adminplus_gated_default'] = Settings::get('adminplus_gated_default');
    $data['adminplus_jwplayer_enabled'] = Settings::get('adminplus_jwplayer_enabled');
    $data['adminplus_jwplayer_source'] = Settings::get('adminplus_jwplayer_source');
    $data['adminplus_jwplayer_key'] = Settings::get('adminplus_jwplayer_key');

    // Handle form if submitted
    if (isset($_POST['submitted'])) {
      // Validate form nonce token and submission speed
      $is_valid_form = AdminPlus::_validate_form_nonce();

      if ($is_valid_form) {

        // Handle checkbox for default gated setting
        if (isset($_POST['adminplus_gated_default'])) {
          $data['adminplus_gated_default'] = 1;
        } else {
          $data['adminplus_gated_default'] = 0;
        }

        // Handle checkbox for default private setting
        if (isset($_POST['adminplus_private_default'])) {
          $data['adminplus_private_default'] = 1;
        } else {
          $data['adminplus_private_default'] = 0;
        }

        // Check for empty jwplayer library link if we 
        // have checked the box to enable jwplayer
        if (isset($_POST['adminplus_jwplayer_enabled']) && $_POST['adminplus_jwplayer_enabled'] == 1) {
          if (!empty($_POST['adminplus_jwplayer_source'])) {
            $data['adminplus_jwplayer_enabled'] = 1;
            $data['adminplus_jwplayer_source'] = trim($_POST['adminplus_jwplayer_source']);
          } else {
            $data['adminplus_jwplayer_enabled'] = 0;
            $errors['adminplus_jwplayer_source'] = 'If enabling JWPlayer, source/url cannot be empty.';
          }
        }


        $data['adminplus_jwplayer_key'] = trim($_POST['adminplus_jwplayer_key']);

      } else {
        $errors['session'] = 'Expired or invalid session';
      }

      // Error check and update data
      AdminPlus::_handle_settings_form($data, $errors);
    }
    // Generate new form nonce
    $formNonce = md5(uniqid(rand(), true));
    $_SESSION['formNonce'] = $formNonce;
    $_SESSION['formTime'] = time();

    // Display form
    include(dirname(__FILE__) . '/settings_form.php');
  }

  /**
   * Check for form errors and save settings
   * 
   */
  private function _handle_settings_form($data, $errors)
  {
    if (empty($errors)) {
      foreach ($data as $key => $value) {
        Settings::set($key, $value);
      }
      $message = 'Settings have been updated.';
      $message_type = 'alert-success';
    } else {
      $message = 'The following errors were found. Please correct them and try again.';
      $message .= '<br /><br /> - ' . implode('<br /> - ', $errors);
      $message_type = 'alert-danger';
    }
  }

  /**
   * Validate settings form nonce token and submission speed
   * 
   */
  private function _validate_form_nonce()
  {
    if (
      !empty($_POST['nonce'])
      && !empty($_SESSION['formNonce'])
      && !empty($_SESSION['formTime'])
      && $_POST['nonce'] == $_SESSION['formNonce']
      && time() - $_SESSION['formTime'] >= 2
    ) {
      return true;
    } else {
      return false;
    }
  }
}



