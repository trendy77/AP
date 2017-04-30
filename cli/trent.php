<?php

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'installer', ‘WP_CLI_Installer’, array( ‘when’ => ‘before_wp_load’ );
}

/**
 * Quickly manage WordPress installations.
 *
 * Usages:
 *
 * wp installer install
 * wp installer uninstall
 *
 */
class WP_CLI_Installer {

    /**
     * Install WordPress Core
     *
     * ## OPTIONS
     *
     * <dest>
     * : The destination for the new WordPress install.
     *
     * [--base_path=<path>]
     * : Base path to install all sites in
     *
     * [--base_url=<url>]
     * : Base URL that sites will be subdirectories of
     *
     * [--multisite]
     * : Convert the install to a Multisite installation
     *
     * [--dbuser=<user>]
     * : Database username
     *
     * [--dbpass=<pass>]
     * : Database password
     *
     * [--dbhost=<host>]
     * : Database host
     *
     * [--admin_user]
     * : Admin username
     *
     * [--admin_password]
     * : Admin password
     *
     * [--admin_email]
     * : Admin email
     */
    public function install( $args, $assoc_args ) {

    }

    /**
     * Uninstall the given WordPress install.
     *
     * ## OPTIONS
     *
     * <dest>
     * : The site that should be uninstalled.
     *
     * [--base_path=<path>]
     * : Base path that all sites are installed in
     */
    public function uninstall( $args, $assoc_args ) {

    }

}