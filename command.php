<?php

class tpCLI extends WP_CLI_Command
{
	///*** THE TPCLi COMMAND SET
	
	//   WP TP GO  -- INSTALL SITE TO 'SITE_PATH
	     ///   --- CLEAN UP STARTER PLUGS AND THEMES, INSTALL DB, PLUGINS 
	// WP TP SET -- PLUGS INSTALL AND CLEAN-UP
	// WP TP POST -- POSTS A MOTHA-FUCKING POST, MOTHA-FUCKER.
	// WP TP 
	
public function go ($args, $assoc_args){
 /**
    installs wp, database, pplugs, etc
 *
	 * ## OPTIONS
	 *
	 * <dest>
	 * : The destination for the new WordPress install.
	 *
	 * [--path=<path>]
	 * : Optional path to the installation.
	 *
	 * [--url=<url>]
	 * :URL of the site
	 *
	 * [--multisite]
	 * : Convert the install to a Multisite installation.
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
	 *
	 * [--after_script]
	 * : Custom script to run after install
	 *
     * ## EXAMPLES
        *   wp tp post
       *
         * @when before_wp_load
        */
	public function install( $args, $assoc_args ) {
		$path = isset( $assoc_args['path'] ) ? $assoc_args['path'] : getcwd();
		//$site_path = $path . '/' . $args[0];
		$dbuser    = $assoc_args['dbuser'];
		$dbpass    = $assoc_args['dbpass'];
		$dbhost    = $assoc_args['dbhost'];
		 if (empty($assoc_args['dbhost'])) {
            $assoc_args['dbhost'] = '127.0.0.1';
		$dbname = str_replace( '.', '_', $args[0] );
		  $config = \WP_CLI::get_runner()->config;
        $extra_config = \WP_CLI::get_runner()->extra_config;
		// Download WordPress
		$download = "wp core download --path=%s";
		WP_CLI::log( 'Downloading WordPress...' );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( $download, $path ) );
 		// Create the wp-config file
 		$config = "wp --path=%s core config --dbname=%s --dbuser=%s --dbpass=%s --dbhost=%s";
 		WP_CLI::log( 'Creating wp-config.php...' );
    	WP_CLI::launch( \WP_CLI\Utils\esc_cmd( $config, $site_path, $dbname, $dbuser, $dbpass, $dbhost ) );
		// Create the database
		$db_create = "wp --path=%s db create";
		WP_CLI::log( 'Creating the database...' );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( $db_create, $site_path ) );
		// Install WordPress core.
		$admin_user  = $assoc_args['admin_user'];
		$admin_pass  = $assoc_args['admin_password'];
		$admin_email = $assoc_args['admin_email'];
		$subcommand  = 'install';
		$base_url    = $assoc_args['url'];
		if ( isset( $assoc_args['multisite'] ) ) {
			$subcommand = 'multisite-install';
		}
		$core_install = "wp --path=%s core %s --url=%s --title=%s --admin_user=%s --admin_password=%s --admin_email=%s";
		WP_CLI::log( 'Installing WordPress...' );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( $core_install, $site_path, $subcommand, 'https://' . $args[0], $args[0], $admin_user, $admin_pass, $admin_email ) );
		if ( isset( $assoc_args['after_script'] ) ) {
			WP_CLI::launch( $assoc_args['after_script'] . ' ' . $args[0] . '&>/dev/null' );
		}
		WP_CLI::success( "WordPress installed at $site_path" );
	}

        $mysqli = new mysqli($db_config['dbhost'], $db_config['dbuser'], $db_config['dbpass']);
        if (! $mysqli) {
            WP_CLI::error(
                sprintf(
                    "Unable to connect to database '%s' with user '%s'.",
                    $db_config['dbhost'],
                    $db_config['dbuser']
                )
            );
            return;
        }
        $sql = "CREATE DATABASE IF NOT EXISTS `".$db_config['dbname'].
            "` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
        if (! $mysqli->query($sql)) {
            WP_CLI::error(sprintf("Unable to create new schema '%s'.", $db_config['dbname']));
            return;
        }
        $mysqli->close();        WP_CLI::success(sprintf("Created '%s' database.", $db_config['dbname']));
        
       
    }
	
	 public function post($args, $assoc_args){
		// require_once '/vendor/autoload.php';
			//include '/home/organ151/Scripts/base.php';
	


	/**
			* post an article programmatically
			* wp tp post 
		* ## OPTIONS
		* <path>
		* 
		* [--number=<number>]
     * : number of lines to parse and post
	 * [--sheet=<spreadsheetId>]
     * : spreadsheet to parse from
	 * ---
     * default: success
     * options:
     *   - success
     *   - error
     * ---
     *
     * ## EXAMPLE
     *  wp @es tp post --number=2 
     *
     * @when after_wp_load

define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS))); //https://www.googleapis.com/auth/drive https://spreadsheet‌​s.google.com/feeds]‌​)));
define('APPLICATION_NAME', 'My Project');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.json');
define('CLIENT_SECRET_PATH', 'cs.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/sheets.googleapis.com-php-quickstart.json
	const DELIMITER = '|';
	/**
	 * internals
	 */
	private $_client;
	private $_title;
	private $_content;
	private $_tags;
	private $_categories;
	private $_excerpt;
	private $_postData = array();
	/**
	 * Creates a client instance for XML-RPC requests and sets the post's
	 * initial content.
	 *
	 * @param string $htmlString	Sets the post's initial content.
	 * @param string $identifier	Fetches the correct set of config data.
	 */
	
	    $config = parse_ini_file('config.ini', true);
	    if (!isset($config[$identifier])) {
	        var_dump($config);
	        echo"could not find identifier" .'$identifier';
			} else {
			$config = $config[$identifier];
			$this->_user = $config['user'];
			$this-> _pass = $config['pass'];
			$this->_url = $config['url'];
			$this->_path = $config['path'];
			$this->_identifier = $config['identifier'];
			}

	public function getSheet(){
$config = \WP_CLI::get_runner()->config;
       $extra_config = \WP_CLI::get_runner()->extra_config;
			if (!isset( $assoc_args['identifier'] )){
				WP_CLI::log( 'Error ID not found!' );
			} else { 
 

$curlUrl = $siteUrl . '/wp-json/wp/v2/posts';

$ curl -X OPTIONS -i $curlUrl 



 if ($keywords == null){
						$keywords = get_hashTags($articleUrl);
					} 
					$post_excerpt=strip_tags($row[1]);	
					$my_post = array(
						'post_title' => $title,
						'post_content' => $body,
						'post_status' => 'publish',
						'post_author' => 1,
						'post_category' => array ($catIds)
						);
	echo 'post ID is '; 
	echo $postId = wp_insert_post( $my_post );
			if (is_numeric($postId)){
			$file= $path."/success.txt";
			$linefile = $path."/line.txt";
			$woohoo = '/n'.$postId;
			$getline=$getline++;
		file_put_contents($file, $woohoo, FILE_APPEND | LOCK_EX);
		 file_put_contents($linefile,$getline);
		 $valueInputOption = 'RAW';
			$values = array(  array( $postId	),
								// Additional rows ...
							);
			$body = new Google_Service_Sheets_ValueRange(array('values' => $values	));
				$params = array(  'valueInputOption' => $valueInputOption	);
			$result = $service->spreadsheets_values->update($spreadsheetId, $range2, $body, $params);
	    	} else {
			echo 'failed.';
			}
		} 
	}
	}
	}
	 public function set($args, $assoc_args){
       /**
     * setup WP
     *sets all the plugins and theme info for my sites
     * ## OPTIONS
     *
     * <site>...
     * : The site(s) to setup. ie foldername
     *
     * [--path=<path>]
     * : path to site
     *
	 * [--plugin_list=<plugin_list>]
     * : path to plugin txt file
     * ---
     * default: success
     * options:
     *   - success
     *   - error
     * ---
     *
     * ## EXAMPLES
     *
     *     wp tp set 
     *
     * @when before_wp_load
     */ 
       $config = \WP_CLI::get_runner()->config;
       $extra_config = \WP_CLI::get_runner()->extra_config;
	
	 $(wp eval 'foreach( get_posts(array("category" => 2,"fields" => "ids")) as $id ) { echo get_post_thumbnail_id($id). " "; }');
	

	WP_CLI::log( 'Error ID not found!' );
			} 
			else { 
				$id = $assoc_args['identifier'];
 $path = isset( $assoc_args['path'] ) ? $assoc_args['path'] : getcwd();
	
	WP_CLI::log( 'Removing extra themes...' );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( 'wp --path=%s theme delete twentyfifteen', $path ) );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( 'wp --path=%s theme delete twentysixteen', $path ) );
	WP_CLI::log( 'Removing transients & regen any lost pics...' );
	WP_CLI::launch( \WP_CLI\Utils\esc_cmd( 'wp --path=%s transient delete --all', $path ) );
	WP_CLI::launch( \WP_CLI\Utils\esc_cmd( 'wp --path=%s media regenerate --only-missing --yes', $path ));
		
//   WP_CLI\Utils\report_batch_operation_results( $noun - eg plugin, $verb - whats doin, 8, $successes, $failures )
	WP_CLI::log( 'ADDING default plugins...' );	
		if ( isset( $assoc_args['plugin_list'] ) && file_exists( $assoc_args['plugin_list'] ) ) {
			$plugins = file_get_contents( $assoc_args['plugin_list'] );
			$plugins = array_filter( explode( PHP_EOL, $plugins ) );
				foreach ( $plugins as $plugin ) {
					$cmd = 'wp @%s --path=%s plugin install %s';
					$cmd = \WP_CLI\Utils\esc_cmd( $cmd, $id, $path, $plugin );
					$result = WP_CLI::launch( $cmd, false, true );
					WP_CLI::log( $result );
				} 
			echo exec('wp --path%s plugin status', $path )."\n";
			} else {
				WP_CLI::log( 'Plugin list not found' );
					}
				}
			}
	}
WP_CLI::add_command('tp', 'tpCLI');