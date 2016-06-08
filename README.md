# libsyn-download-count
Simple Wordpress plugin to get download counts from Libsyn.

This plugin will simply pull and store the current month's latest download count for a specific Libsyn episode and store the count in the database. The counts are stored as transients and will be updated once an hour.

To Install:

1. Upload directly to /wp-content/plugins
2. Edit the templates/libsyn-getcounts.php and edit the $email and $password variables with your unique Libsyn credentials
3. Active plugin
4. Add a show ID in the Libsyn settings page in the Wordpress Admin
5. Use <?php echo get_transient( '_libsyn_count' ); ?> or <?php echo get_transient( '_eof_libsyn_month' ); ?> in your template files to display the numbers
