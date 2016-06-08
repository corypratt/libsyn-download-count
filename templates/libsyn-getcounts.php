<?php

$email = 'Insert Libsyn Email';
$password = 'Insert Libsyn Password';
if ( false === ( $libsyn_transient = get_transient( '_libsyn_transient' ) ) ) {
  add_action('wp_head', 'libsyn_transient_not_found');
  function libsyn_transient_not_found() {
    echo('<!-- transient not found -->');
  }

  $libsyn_options = get_option('libsynoption');
  $showID = $libsyn_options[id];

  $url = 'https://login.libsyn.com';
  $args = array(
    'headers' => array(
      array( 'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8' ),
    ),
        'body' => array(
          'req' => 'https://four.libsyn.com/stats/ajax-export/show_id/' . $showID . '/type/downloads/target/show/id/' . $showID . '/',
          'email' => $email,
          'password' => $password
      ),
  );
  $response = wp_remote_post( $url, $args );
  if ( $response ) {
    $csv = csv_with_headers_to_array( $response['body'] );

    if ( array_key_exists('time_period', $csv[0]) ) {
    set_transient('_libsyn_transient', 'found', 60 * 60);
      set_transient('_libsyn_month', $csv[0]['time_period'], 0);
      set_transient('_libsyn_count', $csv[0]['downloads'], 0);
    } else {
      return;
    }
  } 

} else { //Transient was found
  add_action('wp_head', 'libsyn_transient_found');
  function libsyn_transient_found() {
    echo('<!-- transient found -->');
  }
}

function csv_with_headers_to_array($csv_str)
{
    $lines = explode("\n", $csv_str);
    $headers = array_shift($lines);
    $headers = str_getcsv($headers);
    $rows = array();
    foreach ($lines as $line) {
        $row = array();
        foreach (str_getcsv($line) as $n => $field) {
            $row[$headers[$n]] = $field;
        }
        $rows[] = $row;
    }
    return $rows;
}

