<?php
/**
 * The plugin's cron class
 *
 */

use EmailChecker as Cron;

// добавляет новую крон задачу
add_action( 'admin_head', 'my_activation' );
function my_activation() {
  if ( ! wp_next_scheduled( 'my_daily_event' ) ) {
    wp_schedule_event( time(), 'daily', 'my_daily_event' );
  }
}

// добавляем функцию к указанному хуку
add_action( 'my_daily_event', 'do_this_daily' );
function do_this_daily() {

  $to         = 'kostiantyn.dzysiuk@boosta.co';
  $domain     = site_url();
  $subj       = 'Test subj!';
  $domain_msg = 'your email was not send!';

  $var        = new Cron\EmailChecker( $to, $subj, $domain, $domain_msg );
  $var->email_test();
}