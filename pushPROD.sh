# wp-cli alias to push a local WP database to a staging site
# see https://gist.github.com/davemac/c7e3697ba162efb45a2a318a01a67f2e

pushstage() {
    START=$(date +%s)
    # make a backup of the current local database
    # get current directory name, used for database and URL
    current=${PWD##*/}
    wp db export $current.sql
    # get the remote site URL, remove the http:// for our search replace
    push_staging_url=$(wp @stage eval '$full_url=get_site_url();$trimmed_url=str_replace("http://", "", $full_url); echo $trimmed_url;')
    # rsync the local database to staging site
    rsync $current.sql $current-s:~/
    wp @stage db export ../$push_staging_url.sql
    # reset the staging database
    wp @stage db reset
    wp @stage db import ../$current.sql
    # get the staging site URL, remove the http:// for our search replace
    wp @stage search-replace "$push_staging_url" "$current.localhost" --all-tables
    # deactivate plugins that aren't needed
    wp plugin deactivate debug-bar query-monitor acf-theme-code-pro
    END=$(date +%s)
    DIFF=$(( $END - $START ))
    echo -e "\n$current.localhost database now in use on $push_staging_url site.\nIt took $DIFF seconds, enjoy!\n"
	
	
	
	
	
	
	or 
	
	
	
	
	
	
	read -r -p "Would you really like to reset your development database and pull the latest from production? [y/N] " response
if [[ $response =~ ^([yY][eE][sS]|[yY])$ ]]
then
    wp @development db reset --yes
    wp @production db export - > sql-dump-production.sql
    wp @development db import sql-dump-production.sql
    wp @development search-replace https://example.com https://example.dev
else
    exit 0
fi

with this wp-cli.yml for settings

path: web/wp
@production:
  ssh: web@example.com/srv/www/example.com/current
@development:
ssh: vagrant@example.dev/srv/www/example.com/current