import os
from s3_mysql_backup import download_last_db_backup
from s3_mysql_backup import mkdirs
from fabric.api import task
from fabric.context_managers import cd
from fabric.operations import local
from sherees_commissions import cache_comm_items

CItemDir = 'data/transactions/invoices/invoice_items/commissions_items/'

@task
def cache_comm_items(data_dir=CItemDir):
    """
    replaces cake cache commissions items
    """
    cache_comm_items(data_dir)

@task
def get_last_db_backup(db_backups_dir='backups', project_name='biz'):
    """
    download last project db backup from S3
    """
    download_last_db_backup(db_backups_dir=db_backups_dir, project_name=project_name)

@task
def test():
   """
   tests fabric load on circle ci
   """
   return 1
            

rrg_core_php = """<?php
/* SVN FILE: $Id: core.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

    Configure::write('epoch', mktime(0,0,0,6,1,2009)); // 6/1/2009


    if (getcwd() == '/var/www/html/cake.rocketsredglare.com/rrg/app/webroot'){
        Configure::write('xml_home', '/var/www/html/cake.rocketsredglare.com/rrg/data/');
    } else{

        Configure::write('xml_home', '/php-apps/cake.rocketsredglare.com/rrg/data/');
    }
    Configure::write('site_title', 'RRG DB');
    Configure::write('co_name', 'ROCKETS REDGLARE');
    Configure::write('co_street1', '1082 VIEW WAY');
    Configure::write('co_street2', '');
    Configure::write('co_city', 'PACIFICA');
    Configure::write('co_state', 'CA');
    Configure::write('co_zip', '94044');
    Configure::write('invoice_prefix', 'rocketsredglare_');
    Configure::write('cookie_name','cakerrgdev');

    Configure::write('email_user','marc@rocketsredglare.com');
    Configure::write('email_password','F1amingred');
    Configure::write('email_host','smtp.gmail.com');
    Configure::write('email_port', 587);
    Configure::write('server', 'cake.rocketsredglare.com/rrg/');


    Configure::write('server', 'cake.rocketsredglare.com/biz/');

/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 *      0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 *      1: Errors and warnings shown, model caches refreshed, flash messages halted.
 *      2: As in 1, but also with full debug messages and SQL output.
 *      3: As in 2, but also with full controller dump.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
        Configure::write('debug', 0);
/**
 * Application wide charset encoding
 */
        Configure::write('App.encoding', 'UTF-8');
/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
        //Configure::write('App.baseUrl', env('SCRIPT_NAME'));
/**
 * Uncomment the define below to use CakePHP admin routes.
 *
 * The value of the define determines the name of the route
 * and its associated controller actions:
 *
 * 'admin'              -> admin_index() and /admin/controller/index
 * 'superuser' -> superuser_index() and /superuser/controller/index
 */
        //Configure::write('Routing.admin', 'admin');

/**
 * Turn off all caching application-wide.
 *
 */
        //Configure::write('Cache.disable', true);
/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * var $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting var $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
        //Configure::write('Cache.check', true);
/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
        define('LOG_ERROR', 2);
/**
 * The preferred session handling method. Valid values:
 *
 * 'php'                        Uses settings defined in your php.ini.
 * 'cake'               Saves session files in CakePHP's /tmp directory.
 * 'database'   Uses CakePHP's database sessions.
 *
 * To define a custom session handler, save it at /app/config/<name>.php.
 * Set the value of 'Session.save' to <name> to utilize it in CakePHP.
 *
 * To use database sessions, execute the SQL file found at /app/config/sql/sessions.sql.
 *
 */
        //Configure::write('Session.save', 'database');
/**
 * The name of the table used to store CakePHP database sessions.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The table name set here should *not* include any table prefix defined elsewhere.
 */
        //Configure::write('Session.table', 'cake_sessions');
/**
 * The DATABASE_CONFIG::$var to use for database session handling.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 */
        Configure::write('Session.database', 'default');
/**
 * The name of CakePHP's session cookie.
 */
        Configure::write('Session.cookie', 'CAKEPHP');
/**
 * Session time out time (in seconds).
 * Actual value depends on 'Security.level' setting.
 */
        Configure::write('Session.timeout', '2160');
/**
 * If set to false, sessions are not automatically started.
 */
        Configure::write('Session.start', true);
/**
 * When set to false, HTTP_USER_AGENT will not be checked
 * in the session
 */
        Configure::write('Session.checkAgent', true);
/**
 * The level of CakePHP security. The session timeout time defined
 * in 'Session.timeout' is multiplied according to the settings here.
 * Valid values:
 *
 * 'high'       Session timeout in 'Session.timeout' x 10
 * 'medium'     Session timeout in 'Session.timeout' x 100
 * 'low'                Session timeout in 'Session.timeout' x 300
 *
 * CakePHP session IDs are also regenerated between requests if
 * 'Security.level' is set to 'high'.
 */
        Configure::write('Security.level', 'high');
/**
 * A random string used in security hashing methods.
 */
        Configure::write('Security.salt', '23e363639e227b16abd938f453c5df8c86d7afc7');
/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
        //Configure::write('Asset.filter.css', 'css.php');
/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
        //Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
        Configure::write('Acl.classname', 'DbAcl');
        Configure::write('Acl.database', 'default');
/**
 *
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 *       Cache::config('default', array(
 *              'engine' => 'File', //[required]
 *              'duration'=> 3600, //[optional]
 *              'probability'=> 100, //[optional]
 *              'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 *              'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 *              'lock' => false, //[optional]  use file locking
 *              'serialize' => true, [optional]
 *      ));
 *
 *
 * APC (http://pecl.php.net/package/APC)
 *
 *       Cache::config('default', array(
 *              'engine' => 'Apc', //[required]
 *              'duration'=> 3600, //[optional]
 *              'probability'=> 100, //[optional]
 *              'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *      ));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 *       Cache::config('default', array(
 *              'engine' => 'Xcache', //[required]
 *              'duration'=> 3600, //[optional]
 *              'probability'=> 100, //[optional]
 *              'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *              'user' => 'user', //user from xcache.admin.user settings
 *      'password' => 'password', //plaintext password (xcache.admin.pass)
 *      ));
 *
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 *       Cache::config('default', array(
 *              'engine' => 'Memcache', //[required]
 *              'duration'=> 3600, //[optional]
 *              'probability'=> 100, //[optional]
 *              'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *              'servers' => array(
 *                      '127.0.0.1:11211' // localhost, default port 11211
 *              ), //[optional]
 *              'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *      ));
 *
 */
        Cache::config('default', array('engine' => 'File'));
 /**
  * If you are on PHP 5.3 uncomment this line and correct your server timezone
  * to fix the date & time related errors.
  */
       date_default_timezone_set('UTC');
?>
"""

biz_core_php = """<?php
/* SVN FILE: $Id: core.php 7945 2008-12-19 02:16:01Z gwoo $ */
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

    Configure::write('epoch', mktime(0,0,0,6,1,2009)); // 6/1/2009

    if (getcwd() == '/var/www/html/cake.rocketsredglare.com/biz/app/webroot'){
        Configure::write('xml_home', '/var/www/html/cake.rocketsredglare.com/biz/data/');
    } else{

        Configure::write('xml_home', '/php-apps/cake.rocketsredglare.com/biz/data/');
    }

    Configure::write('site_title', 'RRG DB'); 
    Configure::write('co_name', 'ROCKETS REDGLARE'); 
    Configure::write('co_street1', '1082 VIEW WAY'); 
    Configure::write('co_street2', ''); 
    Configure::write('co_city', 'PACIFICA'); 
    Configure::write('co_state', 'CA'); 
    Configure::write('co_zip', '94044'); 
    Configure::write('invoice_prefix', 'rocketsredglare_');
    Configure::write('cookie_name','cakerrgdev');

    Configure::write('email_user','marc@rocketsredglare.com');
    Configure::write('email_password','F1amingred');
    Configure::write('email_host','smtp.gmail.com');
    Configure::write('email_port', 587);
    Configure::write('server', 'cake.rocketsredglare.com/rrg/');


    Configure::write('server', 'cake.rocketsredglare.com/biz/');

/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 * 	3: As in 2, but also with full controller dump.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
	Configure::write('debug', 0);
/**
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');
/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));
/**
 * Uncomment the define below to use CakePHP admin routes.
 *
 * The value of the define determines the name of the route
 * and its associated controller actions:
 *
 * 'admin' 		-> admin_index() and /admin/controller/index
 * 'superuser' -> superuser_index() and /superuser/controller/index
 */
	//Configure::write('Routing.admin', 'admin');

/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);
/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * var $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting var $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	//Configure::write('Cache.check', true);
/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
	define('LOG_ERROR', 2);
/**
 * The preferred session handling method. Valid values:
 *
 * 'php'	 		Uses settings defined in your php.ini.
 * 'cake'		Saves session files in CakePHP's /tmp directory.
 * 'database'	Uses CakePHP's database sessions.
 *
 * To define a custom session handler, save it at /app/config/<name>.php.
 * Set the value of 'Session.save' to <name> to utilize it in CakePHP.
 *
 * To use database sessions, execute the SQL file found at /app/config/sql/sessions.sql.
 *
 */
	//Configure::write('Session.save', 'database');
/**
 * The name of the table used to store CakePHP database sessions.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The table name set here should *not* include any table prefix defined elsewhere.
 */
	//Configure::write('Session.table', 'cake_sessions');
/**
 * The DATABASE_CONFIG::$var to use for database session handling.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 */
	Configure::write('Session.database', 'default');
/**
 * The name of CakePHP's session cookie.
 */
	Configure::write('Session.cookie', 'CAKEPHP');
/**
 * Session time out time (in seconds).
 * Actual value depends on 'Security.level' setting.
 */
	Configure::write('Session.timeout', '2160');
/**
 * If set to false, sessions are not automatically started.
 */
	Configure::write('Session.start', true);
/**
 * When set to false, HTTP_USER_AGENT will not be checked
 * in the session
 */
	Configure::write('Session.checkAgent', true);
/**
 * The level of CakePHP security. The session timeout time defined
 * in 'Session.timeout' is multiplied according to the settings here.
 * Valid values:
 *
 * 'high'	Session timeout in 'Session.timeout' x 10
 * 'medium'	Session timeout in 'Session.timeout' x 100
 * 'low'		Session timeout in 'Session.timeout' x 300
 *
 * CakePHP session IDs are also regenerated between requests if
 * 'Security.level' is set to 'high'.
 */
	Configure::write('Security.level', 'high');
/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', '23e363639e227b16abd938f453c5df8c86d7afc7');
/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');
/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');
/**
 *
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'File', //[required]
 *		'duration'=> 3600, //[optional]
 *		'probability'=> 100, //[optional]
 * 		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 * 		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 		'lock' => false, //[optional]  use file locking
 * 		'serialize' => true, [optional]
 *	));
 *
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Apc', //[required]
 *		'duration'=> 3600, //[optional]
 *		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Xcache', //[required]
 *		'duration'=> 3600, //[optional]
 *		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *		'user' => 'user', //user from xcache.admin.user settings
 *      'password' => 'password', //plaintext password (xcache.admin.pass)
 *	));
 *
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Memcache', //[required]
 *		'duration'=> 3600, //[optional]
 *		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *	));
 *
 */
	Cache::config('default', array('engine' => 'File'));
 /**
  * If you are on PHP 5.3 uncomment this line and correct your server timezone
  * to fix the date & time related errors.
  */
       date_default_timezone_set('UTC');
?>
"""

data_dirs = ["vendors", "invoices",
             "transactions/invoices/invoice_items/commissions_items",
             "transactions/invoices/invoice_items",
             "transactions/invoices",
             "transactions/checks", "transactions/commissions_payments",
             "states", "vendors_memos", "expenses",
             "clients/managers", "clients/open_invoices", "clients/statements",
             "clients/memos", "clients", "commissions_reports",
             "employees/logs", "employees/payments", "employees/letters",
             "employees/profiles", "employees/memos", "employees",
             "reminders", "contractscontracts_items", "contracts",
             "contracts/contracts_items",
             "employees_memos", "payrolls/paystub_transmittals", "payrolls"]

@task
def make_data_dirs(mp='/mnt/src/', project_name='biz'):
    data_dir_base = '%scake.rocketsredglare.com/%s/data' % (mp, project_name)

    mkdirs(data_dir_base)
    print 'Made dir %s' % data_dir_base
    for d in data_dirs:
        ddest = os.path.join(data_dir_base, d)
        mkdirs(ddest, True)
        print 'Made dir %s' % ddest
    local('chmod -R 777 %s' % data_dir_base)

@task
def deploy_to_nginx(mp='/mnt/src/', project_name='biz'):
    """
    deploy to host volume, source and last database backup
    called in ecs container
    """
    
    dest = '%scake.rocketsredglare.com/%s/' % (mp, project_name)

    # write to host os
    mkdirs(dest)
    print 'made dir %s' % dest
    make_data_dirs(mp=mp, project_name=project_name)

        
    # copy every thing except .git
    # still leaving deleted from source files
    local('rsync -rhv --exclude ".git" . %s' % dest)
    local('chmod -R 777 %sapp/tmp' % dest)
    setup_config(project_name)


def setup_config(mp='/mnt/src/', project_name='biz'):
    """
    puts config.php and database.php into outgoing source tree
    called in dockerfile
    """
    DB_USER = 'DB_USER'
    DB_PASS = 'DB_PASS'
    db_user = os.getenv('DB_USER')
    db_pass = os.getenv('DB_PASS')
    MYSQL_SERVER = 'MYSQL_SERVER'
    mysql_server = os.getenv('MYSQL_SERVER')
    if not db_user or not db_pass or not mysql_server:
        print 'either %s or %s or %sis not set' % (DB_USER, DB_PASS, MYSQL_SERVER)
        quit()
    dest = '%scake.rocketsredglare.com/%s/' % (mp, project_name)
    cfg_db = os.path.join(dest, 'app', 'config', 'database.php')
    # database.php
    database_php = """<?php
class DATABASE_CONFIG {

    var $default = array(
        'driver' => 'mysql',
        'persistent' => false,
        'host' => '%s',
        'login' => '%s',
        'password' => '%s',
        'database' => '%s',
        'prefix' => '',
        );
}
?>
""" % (mysql_server, db_user, db_pass, project_name)
    print('Writing %s' % cfg_db)
    with open(cfg_db, 'wb+') as f:
        f.write(database_php)

    # core.php
    cfg_core = os.path.join(dest, 'app', 'config', 'core.php')
    print('writing %s' % cfg_core)
    with open(cfg_core, 'wb+') as f:
        if project_name == 'biz':
        
            f.write(biz_core_php)
        elif project_name == 'rrg':
            f.write(rrg_core_php)

@task
def cake_daily(mp='/mnt/src/', project_name='biz'):
    dest = '%scake.rocketsredglare.com/%s/' % (mp, project_name)
    with cd(dest):
        local('./daily.sh')
