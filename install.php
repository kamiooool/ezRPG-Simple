<?php
define('IN_EZRPG', true);
define('CUR_DIR', realpath(dirname(__FILE__)));
error_reporting(0);

// Including a library to help generate random secret key
include './lib/func.rand.php';
include './lib/func.validate.php';

// Perform a check, if user abandoned a process on the file permission checking and config creation
$install_step = $_GET['act'];

if (file_exists(CUR_DIR.'/config.php') && !$install_step) {
	header('Location: install.php?act=2');
}

// Performing a check for last step and install file removal
if ($install_step == 5) {
	header('Location: index.php?act=deleteinstaller');
}

// Here goes the installation header template
function displayHeader() {

global $install_step;
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
	
	a {
		color:#f20;
	}

	#content {
		min-height:100%;
		height:100%;
		background: #a90329;
		background: -moz-linear-gradient(top,  #a90329 0%, #8f0222 44%, #6d0019 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a90329), color-stop(44%,#8f0222), color-stop(100%,#6d0019));
		background: -webkit-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%);
		background: -o-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%);
		background: -ms-linear-gradient(top,  #a90329 0%,#8f0222 44%,#6d0019 100%);
		background: linear-gradient(to bottom,  #a90329 0%,#8f0222 44%,#6d0019 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=0 );
	}
	
	#main {
		width:500px;
		height:500px;
		position:absolute;
		left:50%;
		top:50%;
		margin:-430px 0 0 -300px;
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
            background: rgb(28, 184, 65);
        }

        .pure-button-error {
            background: rgb(202, 60, 60);
        }

        .pure-button-warning {
            background: rgb(223, 117, 20);
        }

        .pure-button-secondary {
            background: rgb(66, 184, 221);
        }
	
	</style>
	
	
</head>

<body>

	<div id="content">
	<div id="main">
	<h1>ezRPG Installation - Step {$install_step}</h1>
	

HEAD;

}

// The installation footer template
function displayFooter() {

echo <<<FOOT
</div>
</div>
</body>
</html>
FOOT;

}

displayHeader();

// Step 1 - initial stage with greetings and some brief info about engine
if (empty($install_step)) {
        echo "<p>Hello there, noble sir!<br /><br /> It seems like you've just downloaded a fresh <strong>\"simple\"</strong> version of <strong>ezRPG</strong>!<br /> This one package counts as a legacy one, but it's a good start-off for an RPG developers!<br /> If you have any questions or support for this engine, please visit <a href='http://ezrpgproject.net/' target='_blank'>ezRPG Official Site</a></p>";
        echo "<p>In this version you will find only basic stuff to start your own RPG with. If you're seeking for more advanced version, check out GitHub repos for new versions.</p>";
		echo "<p>For now, you need to create a <strong>configuration file</strong> for your engine and connect it with DB.</p>";
		echo "<p><a href='install.php?act=2' class='pure-button pure-button-success'>Let's do this!</a></p>";
}

// Step 2 - checking DIR permissions and creating configuration file
else if ($install_step == 2) {

		// The check itself
		$files = array();
		if (!is_writable(CUR_DIR.'/config.php')){
			$fh = fopen(CUR_DIR.'/config.php', 'w+');
			if(!$fh){
				$files[] = CUR_DIR."/config.php";
			}
			fclose($fh);
		}
		
		if (!is_writable(CUR_DIR.'/tpl/cache/')){
			$files[] = CUR_DIR."/tpl/cache/";
		}
		
		if (!is_writable(CUR_DIR.'/install.php')){
			$files[] = CUR_DIR."/install.php";
		}
		
		if (!empty($files)){
				echo '<strong>The following file(s) and folders need to be writable (CHMOD 777):</strong><br />';
				foreach($files as $file){
					echo '<p>'.$file.'</p>';
				}
				echo "<a href='install.php?act=2' class='pure-button pure-button-error'>Check again</a>";
		} else {
				echo "<p>Good news, sir! All files have needed permissions! We can move on now to the next step.</p>";
				echo "<a href='install.php?act=3' class='pure-button pure-button-success'>Setup DB information</a>";
		}
}

// Step 3 - setting up database and filling it with data
else if ($install_step == 3) {

    if (!isset($_POST['submit'])) {
		
		// This is the initial values, filled in by default
        $dbhost = 'localhost';
        $dbname = '';
        $dbuser = '';
        $dbpass = '';
        $dbprefix = 'ezrpg_';
		
    } else {
	
		// Here we are checking user entered values for errors
        $errors = 0;
        $msg = '';
        
        if (isset($_POST['dbhost']) && empty($_POST['dbhost'])) {
            $errors = 1;
            $msg .= 'You need to enter a host name!<br />';
        }
		
        if (isset($_POST['dbname']) && empty($_POST['dbname'])) {
            $errors = 1;
            $msg .= 'You need to enter a database name!<br />';
        }
		
        if (isset($_POST['dbuser']) && empty($_POST['dbuser'])) {
            $errors = 1;
            $msg .= 'You need to enter a database user!<br />';
        }
        
        if ($errors == 0) {
            // Let's test the connection
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
        
        if ($errors == 0) {
		
            // Seems that there is no problems with DB connection, so move on and save the config file + fill the DB
            $dbhost = $_POST['dbhost'];
            $dbname = $_POST['dbname'];
            $dbuser = $_POST['dbuser'];
            $dbpass = $_POST['dbpass'];
            $dbprefix = $_POST['dbprefix'];
			
            // First to fill the DB. You can change the initial values here, but better to do it via phphMyAdmin or etc, after the fill in process
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
) ENGINE=InnoDB  DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
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
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
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
  This is the configuration file.
  The most important settings for the game are set here.
*/

/*
  Here goes your DB connection info.
  You can change it at any time here.
*/

\$config_server = '{$dbhost}'; // Database server
\$config_dbname = '{$dbname}'; // Database name
\$config_username = '{$dbuser}'; // Username to login to server with
\$config_password = '{$dbpass}'; // Password to login to server with
\$config_driver = 'mysql'; // Contains the database driver to use to connect to the database.

/*
  Constant:
  This secret key is used in the hashing of player passwords and other important data.
  Secret keys can be of any length, however longer keys are more effective.
  
  This should only ever be set ONCE! Any changes to it will cause your game to break!
  You should save a copy of the key on your computer, just in case the secret key is lost or accidentally changed,.
  
  SECRET_KEY - A long string of random characters. It is already randomly generated only for your instance of ezRPG.
*/

define('SECRET_KEY', '{$secret_key}');

/*
  Here goes various settings, that are used in ezRPG.
*/

define('DB_PREFIX', '{$dbprefix}'); // Prefix to the table names
define('VERSION', '1.0.2'); // Version of ezRPG
define('PACKAGE', 'SIMPLE'); // Name of the package, since it is a custom build over legacy 1.0 version. This constant is needed for some modules compatibility check.
define('SHOW_ERRORS', 0);
define('DEBUG_MODE', 0);
?>
CONF;
            file_put_contents('config.php', $config);
            echo '<p>Config file written.</p>';
            echo '<p><a href="install.php?act=4" class="pure-button pure-button-success">Continue to next step</a></p>';
			displayFooter();
			exit();
        } else {
            echo '<p><strong>Sorry, there were some problems:</strong><br /><span style="color:#f20">'.$msg.'</span></p>';
            
            $dbhost = $_POST['dbhost'];
            $dbname = $_POST['dbname'];
            $dbuser = $_POST['dbuser'];
            $dbpass = $_POST['dbpass'];
            $dbprefix = $_POST['dbprefix'];
        }
    }

    echo '<p>Please fill in the database access details here:</p>';
	echo '<form class="pure-form pure-form-stacked" method="post" action="install.php?act='.$install_step.'">';
echo <<<DBFORM
		<fieldset>
		
			<label for="dbhost">Host</label>
			<input id="dbhost" type="text" name="dbhost" value="{$dbhost}">
			
			<label for="dbname">Database Name</label>
			<input id="dbname" type="text" name="dbname" value="{$dbname}">
			
			<label for="dbuser">User</label>
			<input id="dbuser" type="text" name="dbuser" value="{$dbuser}">

			<label for="password">Password</label>
			<input id="password" type="password" name="dbpass" value="{$dbpass}">
			
			<label for="dbprefix">Table Prefix (optional)</label>
			<input id="dbprefix" type="text" name="dbprefix" value="{$dbprefix}">
			
			<p>You can enter a prefix for your table names if you like.<br />This can be useful if you will be sharing the database with other applications, or if you are running more than one ezRPG instance in a single database.</p>
		
			<input type="submit" name="submit" class="pure-button pure-button-success" value="Submit">
		</fieldset>
DBFORM;
	echo '</form>';
}

// Step 4 - populate the DB, creating admin account
else if ($install_step == 4) {

    if (isset($_POST['submit'])) {
	
        $errors = 0;
        $msg = '';
		
// Check username
        if (empty($_POST['username'])) {
			$errors = 1;
            $msg .= 'Please enter username!<br />';
			
        } else if (!isUsername($_POST['username'])) {
		
			// If username is too short...
			$errors = 1;
			$msg .= 'Your username must be longer than 3 characters and may only contain alphanumerical characters!<br />';
			
        }
		
        //Check password
        if (empty($_POST['password']))
        {
			$errors = 1;
            $msg .= 'Please enter your password!<br />';
        }
        else if (!isPassword($_POST['password']))
        { 
			//If password is too short...
			$errors = 1;
			$msg .= 'Your password is too short!<br />';
        }
	
        if ($_POST['password2'] != $_POST['password'])
        {
            //If passwords didn't match
			$errors = 1;
			$msg .= 'You didn\'t verified your password correctly!<br />';
        }
	
        //Check email
        if (empty($_POST['email']))
        {
			$errors = 1;
            $msg .= 'Please enter your correct email!<br />';
        }
        else if (!isEmail($_POST['email']))
        {
			$errors = 1;
			$msg .= 'Your email format is wrong!<br />';
        }
        
        if ($errors == 0) {
		
			// If there is no errors, we create administrator's account and deleting install.php file
            include 'config.php';
            mysql_connect($config_server, $config_username, $config_password);
            mysql_select_db($config_dbname);
            
            $secret_key = createKey(16);
            $query = 'INSERT INTO `' . DB_PREFIX . 'players` (`username`, `password`, `email`, `secret_key`, `registered`, `rank`) VALUES(\'' . mysql_real_escape_string($_POST['username']) . '\', \'' . mysql_real_escape_string(sha1($secret_key . $_POST['password'] . SECRET_KEY)) . '\', \'' . mysql_real_escape_string($_POST['email']) . '\', \'' . mysql_real_escape_string($secret_key) . '\', ' . time() . ', 10)';
            mysql_query($query);
			
			echo "<p>Admin user has been successfully created!</p>";
			echo "<p>Now all you need to do, kind sir, is to press that red button below. You won't be able to return to installation process anymore, since the <strong>install.php</strong> file will be deleted. You can always get a new one from <a href=\"https://github.com/scsmash3r/ezRPG-Simple\" target=\"_blank\">ezRPG Simple GitHub Repository</a>.</p>";
			echo "<a href='install.php?act=5' class='pure-button pure-button-error'>Delete installer and proceed to ezRPG!</a>";
			
			displayFooter();
			exit();
			
        } else {
		
            echo '<p><strong>Sorry, there were some problems:</strong><br />', $msg, '</p>';
			
        }
    }
    
    echo '<p>Create your admin account for ezRPG.</p>';
	
	echo '<form class="pure-form pure-form-stacked" method="post" action="install.php?act='.$install_step.'">';
echo <<<ADMFORM
		<fieldset>
		
			<label for="username">Username</label>
			<input id="username" type="text" name="username" value="{$_POST['username']}">
			
			<label for="email">Email</label>
			<input id="email" type="text" name="email" value="{$_POST['email']}">
			
			<label for="password">Password</label>
			<input id="password" type="password" name="password">
			
			<label for="password2">Verify password</label>
			<input id="password2" type="password" name="password2">
			
			<p><strong>WARNING:</strong> Don't ever name your account "admin" - be more creative, try to choose your very own admin name.</p>
		
			<input type="submit" name="submit" class="pure-button pure-button-success" value="Submit">
			
		</fieldset>
ADMFORM;
	echo '</form>';
	
}

displayFooter();
?>