<?php
define('IN_EZRPG', true);
define('CUR_DIR', realpath(dirname(__FILE__)));

// Including a library to help generate random secret key
include './lib/func.rand.php';


// Here goes the installation header template
function displayHeader() {

echo <<<HEAD
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>EzRPG Installation</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.2.0/pure-min.css" />
	<style>
	
	body,html{
		height:100%;
	}

	#content {
		min-height:100%;
		height:100%;
		background: #a90329; /* Old browsers */
		background: -moz-linear-gradient(top,  #a90329 0%, #8f0222 44%, #6d0019 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a90329), color-stop(44%,#8f0222), color-stop(100%,#6d0019)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #a90329 0%,#8f0222 44%,#6d0019 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=0 ); /* IE6-9 */
	}
	
	#main {
		width:500px;
		height:300px;
		position:absolute;
		left:50%;
		top:50%;
		margin:-350px 0 0 -300px;
		background-color: #FFFFFF;
		padding:50px;
		font-size:12px;
	}
	
	h1 {
		border-bottom:1px solid #bbb;
	}
	
        .pure-button-success,
        .pure-button-error,
        .pure-button-warning,
        .pure-button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .pure-button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }

        .pure-button-error {
            background: rgb(202, 60, 60); /* this is a maroon */
        }

        .pure-button-warning {
            background: rgb(223, 117, 20); /* this is an orange */
        }

        .pure-button-secondary {
            background: rgb(66, 184, 221); /* this is a light blue */
        }
	
	</style>
	
	
</head>

<body>

	<div id="content">
	<div id="main">
	<h1>ezRPG Installation</h1>
	

HEAD;

}

// The installation footer template
function displayFooter()
{
    echo <<<FOOT
</div>
</div>
</body>
</html>
FOOT;
}

displayHeader();

// Step 1 - initial stage with greetings and some brief info about engine
if (!isset($_GET['act'])) {
        echo "<p>Hello there, noble sir!<br /><br /> It seems like you've just downloaded a fresh <strong>\"simple\"</strong> version of <strong>ezRPG</strong>!<br /> This one package counts as a legacy one, but it's a good start-off for an RPG developers!<br /> If you have any questions or support for this engine, please visit <a href='http://ezrpgproject.net/' target='_blank'>ezRPG Official Site</a></p>";
        echo "<p>In this version you will find only basic stuff to start your own RPG with. If you're seeking for more advanced version, check out GitHub repos for new versions.</p>";
		echo "<p>For now, you need to create a <strong>configuration file</strong> for your engine and connect it with DB.</p>";
		echo "<p><a href='install.php?act=2' class='pure-button pure-button-success'>Let's do this!</a></p>";
}

// Step 2 - checking DIR permissions and creating configuration file
else if ($_GET['act'] == '2') {

		// The check itself
		$files = array();
		if (is_writable(CUR_DIR.'/config.php')){
			$fh = fopen(CUR_DIR.'/config.php', 'w+');
			if(!$fh){
				$files[] = CUR_DIR."/config.php";
			}
			fclose($fh);
		}
		
		if (is_writable(CUR_DIR.'/tpl/cache/')){
			$files[] = CUR_DIR."/tpl/cache/";
		}
		
		if (!empty($files)){
				echo '<strong>The following file(s) need to be writable:</strong><br />';
				foreach($files as $file){
					echo '<p>'.$file.'</p>';
				}
				echo "<a href='install.php?act=2' class='pure-button pure-button-error'>Check again</a>";
		} else {
				echo "<p>Good news, sir! All files have needed permissions! We can move on now to the next step.";
				echo "<a href='install.php?act=3' class='pure-button pure-button-success'>Setup DB information</a>.";
		}
	return;
    echo '<h2>Step 2</h2>';
    
    if (!isset($_POST['submit']))
    {
        $dbhost = 'localhost';
        $dbname = 'ezrpg';
        $dbuser = '';
        $dbpass = '';
        $dbprefix = '';
    }
    else
    {
        $errors = 0;
        $msg = '';
        
        if (isset($_POST['dbhost']) && empty($_POST['dbhost']))
        {
            $errors = 1;
            $msg .= 'You need to enter a host name!<br />';
        }
        if (isset($_POST['dbname']) && empty($_POST['dbname']))
        {
            $errors = 1;
            $msg .= 'You need to enter a database name!<br />';
        }
        if (isset($_POST['dbuser']) && empty($_POST['dbuser']))
        {
            $errors = 1;
            $msg .= 'You need to enter a database user!<br />';
        }
        
        //so far so good...
        if ($errors == 0)
        {
            //let's test the connection
            $db = mysql_connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass']);
            if (!$db)
            {
                $errors = 1;
                $msg .= 'ezRPG could not connect to the database with the details you entered!<br />';
            }
            else
            {
                $db_selected = mysql_select_db($_POST['dbname']);
                if (!$db_selected)
                {
                    $errors = 1;
                    $msg .= 'ezRPG could not select the database with the database name you entered!<br />';
                }
            }
        }
        
        if ($errors == 0)
        {
            //No problesm connecting and selecting the database
            //Save details to the config file and fill the database
            $dbhost = $_POST['dbhost'];
            $dbname = $_POST['dbname'];
            $dbuser = $_POST['dbuser'];
            $dbpass = $_POST['dbpass'];
            $dbprefix = $_POST['dbprefix'];
            //fill the database first
            $query1 = <<<QUERY
CREATE TABLE IF NOT EXISTS `{$dbprefix}players` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(30) default NULL,
  `password` varchar(40) default NULL,
  `email` varchar(255) default NULL,
  `secret_key` text,
  `rank` smallint(5) unsigned NOT NULL default '1',
  `registered` int(11) unsigned default NULL,
  `last_active` int(11) unsigned default '0',
  `last_login` int(11) unsigned default '0',
  `money` int(11) unsigned default '100',
  `level` int(11) unsigned default '1',
  `stat_points` int(11) unsigned default '10',
  `exp` int(11) unsigned default '0',
  `max_exp` int(11) unsigned default '10',
  `hp` int(11) unsigned default '20',
  `max_hp` int(11) unsigned default '20',
  `energy` int(11) unsigned NOT NULL default '10',
  `max_energy` int(11) unsigned NOT NULL default '10',
  `strength` int(11) unsigned default '5',
  `vitality` int(11) unsigned default '5',
  `agility` int(11) unsigned default '5',
  `dexterity` int(11) unsigned default '5',
  `damage` int(11) unsigned default '0',
  `kills` int(11) unsigned NOT NULL default '0',
  `deaths` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
QUERY;
            mysql_query($query1) or die('Something went wrong.');
            
            $query2 = <<<QUERY
CREATE TABLE IF NOT EXISTS `{$dbprefix}player_log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `player` int(11) unsigned NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `player_log` (`player`,`time`),
  KEY `new_logs` (`player`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
QUERY;
            mysql_query($query2) or die('Something went wrong.');
            
            echo '<p>Tables installed.</p>';
            
            //Save data to config file
            $secret_key = createKey(24);
            $config = <<<CONF
<?php
//This file cannot be viewed, it must be included
defined('IN_EZRPG') or exit;

/*
  Title: Config
  The most important settings for the game are set here.
*/

/*
  Variables: Database Connection
  Connection settings for the database.
  
  \$config_server - Database server
  \$config_dbname - Database name
  \$config_username - Username to login to server with
  \$config_password - Password to login to server with
  \$config_driver - Contains the database driver to use to connect to the database.
*/
\$config_server = '{$dbhost}';
\$config_dbname = '{$dbname}';
\$config_username = '{$dbuser}';
\$config_password = '{$dbpass}';
\$config_driver = 'mysql';

/*
  Constant:
  This secret key is used in the hashing of player passwords and other important data.
  Secret keys can be of any length, however longer keys are more effective.
  
  This should only ever be set ONCE! Any changes to it will cause your game to break!
  You should save a copy of the key on your computer, just in case the secret key is lost or accidentally changed,.
  
  SECRET_KEY - A long string of random characters.
*/
define('SECRET_KEY', '{$secret_key}');


/*
  Constants: Settings
  Various settings used in ezRPG.
  
  DB_PREFIX - Prefix to the table names
  VERSION - Version of ezRPG
  SHOW_ERRORS - Turn on to show PHP errors.
  DEBUG_MODE - Turn on to show database errors and debug information.
*/
define('DB_PREFIX', '{$dbprefix}');
define('VERSION', '1.0');
define('SHOW_ERRORS', 0);
define('DEBUG_MODE', 0);
?>
CONF;
            file_put_contents('config.php', $config);
            echo '<p>Config file written.</p>';
            echo '<p><a href="install.php?act=3">Continue to next step</a></p>';
            displayFooter();
            exit;
        }
        else
        {
            echo '<p><strong>Sorry, there were some problems:</strong><br />', $msg, '</p>';
            
            $dbhost = $_POST['dbhost'];
            $dbname = $_POST['dbname'];
            $dbuser = $_POST['dbuser'];
            $dbpass = $_POST['dbpass'];
            $dbprefix = $_POST['dbprefix'];
        }
    }
    
    echo '<p>Please fill in the database access details here.</p>';
    echo '<form method="post" action="install.php?act=2">';
    echo '<label>Host</label>';
    echo '<input type="text" name="dbhost" value="', $dbhost, '" />';
    echo '<label>Database Name</label>';
    echo '<input type="text" name="dbname" value="', $dbname, '" />';
    echo '<label>User</label>';
    echo '<input type="text" name="dbuser" value="', $dbuser, '" />';
    echo '<label>Password</label>';
    echo '<input type="password" name="dbpass" value="', $dbpass, '" />';
    echo '<label>Table Prefix (Optional)</label>';
    echo '<input type="text" name="dbprefix" value="', $dbprefix, '" />';
    echo '<p>You can enter a prefix for your table names if you like.<br />This can be useful if you will be sharing the database with other applications, or if you are running more than one ezRPG instance in a single database.</p>';
    echo '<input type="submit" name="submit" value="Submit"  class="button" />';
    echo '</form>';
    displayFooter();
    exit;
}

else if ($_GET['act'] == '3')
{
    displayHeader();
    echo '<h1>Step 3</h1>';
    
    if (isset($_POST['submit']))
    {
        $errors = 0;
        $msg = '';
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password']))
        {
            $errors = 1;
            $msg .= 'You forgot to fill in something!';
        }
        if ($_POST['password'] != $_POST['password2'])
        {
            $errors = 1;
            $msg .= 'You didn\'t verify your password correctly.';
        }
        
        if ($errors == 0)
        {
            include 'config.php';
            mysql_connect($config_server, $config_username, $config_password);
            mysql_select_db($config_dbname);
            
            $secret_key = createKey(16);
            $query = 'INSERT INTO `' . DB_PREFIX . 'players` (`username`, `password`, `email`, `secret_key`, `registered`, `rank`) VALUES(\'' . mysql_real_escape_string($_POST['username']) . '\', \'' . mysql_real_escape_string(sha1($secret_key . $_POST['password'] . SECRET_KEY)) . '\', \'' . mysql_real_escape_string($_POST['email']) . '\', \'' . mysql_real_escape_string($secret_key) . '\', ' . time() . ', 10)';
            mysql_query($query);
            
            echo '<p>Your admin account has been created! You may now login to the game. You can access the admin panel at <em>/admin</em>.</p>';
            echo '<p><strong>Please delete install.php immediately!</strong></p>';
            echo '<p><a href="index.php">Visit your ezRPG!</a></p>';
            displayFooter();
            exit;
        }
        else
        {
            echo '<p><strong>Sorry, there were some problems:</strong><br />', $msg, '</p>';
        }
    }
    
    echo '<p>Create your admin account for ezRPG.</p>';
    echo '<form method="post" action="install.php?act=3">';
    echo '<label>Username</label>';
    echo '<input type="text" name="username" value="', $_POST['username'], '" />';
    echo '<label>Email</label>';
    echo '<input type="text" name="email" value="', $_POST['email'], '" />';
    echo '<label>Password</label>';
    echo '<input type="password" name="password" />';
    echo '<label>Verify Password</label>';
    echo '<input type="password" name="password2" />';
    echo '<br />';
    echo '<input type="submit" value="Create" name="submit" class="button" />';
    echo '</form>';
    displayFooter();
    exit;
}

displayFooter();
?>