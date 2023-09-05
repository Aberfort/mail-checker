<?php
// TODO namespace ?
// TODO Автозагрузка классов
// TODO расставить public, private, protected

namespace EmailChecker;
use Sender as SendEmail;

/**
 * The plugin's main class
 *
 */

// Exits if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


class EmailChecker {
  private $to;
  private $subj;
  private $domain;
  private $domain_msg;

  public function __construct( $to, $subj, $domain, $domain_msg ) {
    $this->to         = $to;
    $this->subj       = $subj;
    $this->domain     = $domain;
    $this->domain_msg = $domain_msg;
  }

  /**
   * Initializes our plugin
   */
  public function init() {
    $this->load_hooks();

    // TODO тут нужно подключить крон inc/func/email-cron.php
    require_once ET_PLUGIN_DIR . 'inc/func/email-cron.php';
  }

  /**
   * Adds in any plugin-wide hooks
   *
   */
  public function load_hooks() {
    add_action( 'admin_menu', array( $this, 'setup_admin_menu' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'reports_admin_scripts' ) );
    add_action( 'wp_ajax_get_ajax', array( $this, 'email_test' ) );
    add_action( 'wp_ajax_nopriv_get_ajax', array( $this, 'email_test' ) );
  }

  /**
   * Sets up our page in the admin menu
   *
   */
  public function setup_admin_menu() {
    add_management_page( 'Email Checker', 'Email Checker', 'manage_options', 'email-test', array(
      $this,
      'generate_admin_page'
    ) );
  }

  /**
   * Add css and scripts
   *
   */
  public function reports_admin_scripts() {
    // add the script and style on our plugin only
    if ( isset( $_GET['page'] ) && $_GET['page'] === 'email-test' ) {

      // # load style
      wp_enqueue_style( 'email_test_styles', plugins_url( '../../css/email-checker.css', __FILE__ ) );

      // # load scripts
      wp_register_script( 'ajaxHandle', plugins_url( '../../js/ajax.js', __FILE__ ), array( 'jquery' ), time(), true );
      wp_enqueue_script( 'ajaxHandle' );
      wp_localize_script( 'ajaxHandle', 'simple_ajax_url_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
  }

  /**
   * Attempts to send an email from WordPress to supplied email address
   *
   */
  public function email_test() {
    $success = wp_mail( $this->to, $this->subj, __( 'Your email was send successfully!', 'email-test' ) );

    if ( ! $success ) {
      SendEmail\Sender::send( __( $this->domain . ' , ' . $this->domain_msg , 'email-test' ) );

      return false;
    }

    return true;
  }

  /**
   * Generates our admin page
   *
   */
  public function generate_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }

    require_once ET_PLUGIN_DIR . 'views/form.php';
  }
}
