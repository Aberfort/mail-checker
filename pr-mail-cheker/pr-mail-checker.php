<?php
/**
 * Plugin Name: Mail checker
 * Description: Periodically checking the work of the WP mail SMTP plugin, which creates a cron job, which, in case of an error, should send a message to the Slackbot.
 * Author:      Vasyliev Serhii
 * Version:     1.0.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// TODO автозагрузка классов

require_once __DIR__ . '/inc/Autoloader/NamespaceAutoloader.php';

// задаем соответствие для неймспейса Checker и регистрируем автозагрузчик
$autoloader = new NamespaceAutoloader();
$autoloader->addNamespace( 'EmailChecker', __DIR__ . '/inc/Class' );
$autoloader->addNamespace( 'Sender', __DIR__ . '/inc/Class' );
$autoloader->register();

use EmailChecker as Alias;

define( 'ET_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



$to         = 'kostiantyn.dzysiuk@boosta.co';
$domain     = site_url();
$subj       = 'Test subj!';
$domain_msg = 'your email was not send!';

$sa_email_test = new Alias\EmailChecker( $to, $subj, $domain, $domain_msg );
$sa_email_test->init();