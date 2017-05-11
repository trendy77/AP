<?php
/**
 * APposter
 */
 if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( tpost, tpPost, array( when =>after_wp_load );
	}

class tpost extends WP_CLI_Command
{
/**
* post to WP
*
* ## OPTIONS
*
* <site>...
* : The site(s) to post to
*
* [--type=<type>]
* : Whether or not to greet the person with success or error.
* ---
* default: success
* options:
*   - success
*   - error
* ---
*
* ## EXAMPLES
*
*     wp tp post
*
* @when before_wp_load
*/

    public function go($args, $assoc_args)
    {
     /**
     * setup WP
     *
     * ## OPTIONS
     *
     * <site>...
     * : The site(s) to setup.
     *
     * [--type=<type>]
     * : Whether or not to greet the person with success or error.
     * ---
     * default: success
     * options:
     *   - success
     *   - error
     * ---
     *
     * ## EXAMPLES
     *
     *     wp tp post
     *
     * @when before_wp_load
     */
	 $rescue_directory = getcwd();
        // Get config
        $config = \WP_CLI::get_runner()->config;
        // get extra config
        $extra_config = \WP_CLI::get_runner()->extra_config;
        // 1) download ...
        WP_CLI::run_command(array('core', 'download'));
        // 2) create database ...
        $db_config = $extra_config['core config'];
        if (empty($db_config['dbhost'])) {
            $db_config['dbhost'] = '127.0.0.1';
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
        $mysqli->close();
        WP_CLI::success(sprintf("Created '%s' database.", $db_config['dbname']));
        // 3) config ...
        WP_CLI::run_command(array('core', 'config'));
        // 4) install ..
        echo exec('wp core install')."\n";
        // 5) Remove default plugins and themes
        WP_CLI::line('Deleting list of skipped plugins...');
        foreach ($config['skip-plugins'] as $plugin) {
            echo exec('wp plugin delete '.$plugin)."\n";
        }
        // 6) plugin install
        WP_CLI::line('Installing list of plugins...');
        foreach ($extra_config['plugin install'] as $plugin) {
            echo exec('wp plugin install '.$plugin. ' --activate')."\n";
        }
        // 7) Activate theme and delete others
        WP_CLI::line('Activating theme name...');
        echo exec('wp theme activate '.$extra_config['theme-name'])."\n";
        WP_CLI::line('Deleting list of skipped themes...');
        foreach ($config['skip-themes'] as $theme) {
            echo exec('wp theme delete '.$theme)."\n";
        }
        chdir($rescue_directory);
        if (isset($config['url'])) {
  WP_CLI::launch('open ' . $config['url']);
        }
    }
		
	 public function set($args, $assoc_args)
    {
     /**
 * Add plugins from the provided file.
 * 
 * ## OPTIONS
 *
 * <dest>
 * : The site to add plugins to.
 *
 * [--plugin_list]
 * : The path to the file containing the list of plugins to install.
 *
 *[--path]
 * : The path to the file containing the list of plugins to install.
 **
 *
 * @when after_wp_load
 */   
 // site to do this time
       $rescue_directory = getcwd();
        // Get config
        $config = \WP_CLI::get_runner()->config;
   // get extra config
        $extra_config = \WP_CLI::get_runner()->extra_config;
        // 1) plugin instal
	 $path = isset( $assoc_args['path'] ) ? $assoc_args['path'] : getcwd();
		WP_CLI::log( 'Removing extra themes...' );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( 'wp --path=%s theme delete twentyfifteen', $path ) );
		WP_CLI::launch( \WP_CLI\Utils\esc_cmd( 'wp --path=%s theme delete twentysixteen', $path ) );
		WP_CLI::log( 'Removing default plugins...' );
		
		if ( isset( $assoc_args['plugin_list'] ) && file_exists( $assoc_args['plugin_list'] ) ) {
			$plugins = file_get_contents( $assoc_args['plugin_list'] );
			$plugins = array_filter( explode( PHP_EOL, $plugins ) );
			foreach ( $plugins as $plugin ) {
				$cmd = 'wp --path=%s plugin install %s';
				$cmd = \WP_CLI\Utils\esc_cmd( $cmd, $path, $plugin );
				$result = WP_CLI::launch( $cmd, false, true );
				WP_CLI::log( $result );
			}
		} else {
			WP_CLI::log( 'Plugin list not found' );
		}
		echo exec('wp --path=%s plugin status')."\n";
        }
	 public function post($args, $assoc_args)
    {
     /**
 *post a post to WP.
 * 
 * ## OPTIONS
 *
 * <dest>...
 * : The site to post to
 *
 * [--identifier]
 * : The id for the site to post to 
 *
 *[--path]
 * : The path to the file containing the install.
 *
 *[--$category] 
 * : category
 *
 * [--$title]
 * : title
 * [--$keywords]
 * : tags
 * [--$post_excerpt]
 * : excerpt
 * [--$body]
 * : body
 * [-- $image]
 *  : img or not
 *[--admin_pass]
 * : user pass
 *
 *[--url]
 * : url of site
 *
 * @when after_wp_load
 */   
      $config = \WP_CLI::get_runner()->config;
   // get extra config
        $extra_config = \WP_CLI::get_runner()->extra_config;
    if (!isset($assoc_args['$identifier'])) {
		echo 'error';
	}
	else {
		$this->_identifier = ($assoc_args['$identifier']);
	$this->_path =  ($assoc_args['path']);
	 $this->_user = ($assoc_args['admin_user']);
    $this->_pass =  ($assoc_args['admin_pass']);
    $this->_title =  ($assoc_args['title']);   
	$this->_body =  ($assoc_args['body']);   
	$this->_tags =  ($assoc_args['tags']);
	
	const DELIMITER = '|';
	private $_client;
	private $_title;
	private $_content;
	private $_tags;
	private $_categories;
	private $_excerpt;
	private $_postData = array();
		   
	 foreach ($values as $row) {
	   $title=$row[0];
    	$body=$row[1];
    	$articleUrl=$row[2];
    	$category=$row[3].$row[4];
    	$image=$row[5];
	    $identifier = $row[6];
	    $keywords=$row[7];
		}
		$catIds = array();
		foreach ($category as $cat) {
		    $idObj = get_category_by_slug($cat);
		    $zid = $idObj->term_id;
		    array_push($catIds, $zid);
		  }	
			if ($keywords == null){
			 $keywords = get_hashTags($articleUrl);
			 } 
	       	$post_excerpt=strip_tags($row[1]);	
	$my_post = array(
						'post_title' => $title,
						'post_content' => $body,
						'post_status' => 'publish',
						'post_author' => 1,
						'post_category' => $catIds
				);
		$postId = wp_insert_post( $my_post );
  echo $postId;
	}
	}

WP_CLI::add_command('tp', 'tpCLI');