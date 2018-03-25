<?php
/**
 * This example enables the devel module when a database is cloned to a dev environment.
 *
 * This script should be configured into the clone_database operation in pantheon.yml
 */

// The clone_database may be triggered on any environment, but we only want
// to automatically disable and uninstall the views_ui and devel modules when
// this event happens on test or live environment.
if (isset($_POST['environment']) && in_array($_POST['environment'], array('test', 'live'))) {
  // First, let's retrieve a list of disabled modules with drush pm-list.
  // shell_exec() will return the output of an executable as a string.
  // Pass the --format=json flag into the drush command so the output can be converted into an array with json_decode().
  $modules = json_decode(shell_exec('drush pm-list --format=json'));

  // Now let's disable Devel if it is installed.
  if (isset($modules->devel) && $modules->devel->status === 'Enabled') {
    // This time let's just passthru() to run the drush command so the command output prints to the workflow log.
    passthru('drush pm-disable -y devel');
    passthru('drush pm-uninstall -y devel');
  }

  // Now let's disable Views UI if it is installed.
  if (isset($modules->views_ui) && $modules->views_ui->status === 'Enabled') {
    // This time let's just passthru() to run the drush command so the command output prints to the workflow log.
    passthru('drush pm-disable -y views_ui');
    passthru('drush pm-uninstall -y views_ui');
  }
}
