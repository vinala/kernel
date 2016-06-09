<?php 
	use Lighty\Kernel\Translator\Lang;
?>

<div class="bg" id="bg"></div>
<div class="content" id="content">

	<div style="height:60px"></div>
	<div class="fst_config_icon" id="fst_config_icon"></div>
	
	<div id="fst_db_msg_step">
		<div class="fst-config-text">
			<div class="fst-config-pargraph">
				Welcome to Lighty. Before we launch, we need some information about your database. You'll have to fill the following information to proceed.
			</div>
			<div class="fst-config-pargraph">
				<li>Name of the database</li>
				<li>User name</li>
				<li>User password</li>
				<li>Server of the database</li>
				<li>Table Prefix</li>
			</div>
			<div class="fst-config-pargraph">
				You would normally have received these information from your host. If you do not, you should contact your hosting provider to continue. If you are ready...
			</div>
			<form class="fst-config-form" id="fst-config-msg-form">
				<div style="margin-top:20px">
					<input type="submit" class="btn hello_button_hover hello_button_left" value="Let's go !" name="nxt" id="nxt"   />
				</div>
			</form>
		</div>
	</div>

	<div id="fst_db_conf_step" style="display:none">
		<!-- <h1 class="conf_title">Database</h1>
		<div class="progres"><div class="progres_2"></div></div> -->
		<div class="fst-config-text">
			<div class="fst-config-pargraph">
				You must enter below the login details to your database. If you do not know them, contact your host.
			</div>
		</div>

		<!-- <form class="config_form" id="form_2"> -->
		<div class="fst-config-cont">
		<form class="fst-config-form fst-config-db-form" id="fst-config-db-form">
			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Database server</div>
				<div class="fst-config-input db-input-input">
					<input type="text" class="form-control" id="migname" name="db_host" placeholder="Server" value="">
				</div>
				<div class="fst-config-input-desc db-input-input-desc">The name of server where you host your database</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Database Name</div>
				<div class="fst-config-input db-input-input">
					<input type="text" class="form-control" id="migname" name="db_name" placeholder="Database" value="">
				</div>
				<div class="fst-config-input-desc db-input-input-desc">The name of the database that you want to use Lighty.</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Database user</div>
				<div class="fst-config-input db-input-input">
					<input type="text" class="form-control" id="migname" name="db_usr" placeholder="User" value="">
				</div>
				<div class="fst-config-input-desc db-input-input-desc">The database user identifier to login to database.</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Database password</div>
				<div class="fst-config-input db-input-input">
					<input type="text" class="form-control" id="migname" name="db_pass" placeholder="Password" value="">
				</div>
				<div class="fst-config-input-desc db-input-input-desc">The password of database user to login to database.</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Tables prefix</div>
				<div class="fst-config-input db-input-input">
					<input type="text" class="form-control" id="migname" name="db_prefix" placeholder="Prefixe" value="<?php $str=str_shuffle("azertyuiopqsdfghjklmwxcvbn");echo substr($str, 0, 3); ?>">
					<p class="conf_input_note">If you keep it blank, prefixing will be disabled</p>
				</div>
				<div class="fst-config-input-desc db-input-input-desc">To secure your database and mark all tables of that project .</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-error" id="fst_db_config_error">
					<div class="fst-config-error-title">Error connecting to the database</div>
					This means that either the username or the password you filled is incorrect or we can not contact the database server at localhost. This may mean that your database server is down.
				</div>
			</div>
			
			<div style="margin-top:20px">
				<input type="submit" class="btn hello_button" value="Validate" name="nxt" id="nxt"   />
			</div>
		
			
		</form>
		</div>
	</div>

	<div id="fst_pass_msg_step" style="display:none">
		<div class="fst-config-text">
			<div class="fst-config-pargraph">
				Perfect ! You spent the first part of the installation. Lighty can now communicate with your database. If you are ready, it is now time to ...
			</div>
		</div>
		<div class="fst-lonly-left-buttun-cont">
			<input type="submit" class="btn hello_button lonely_button hello_button_hover" value="Continue" name="nxt" id="nxt_to_glob"   />
		</div>
	</div>

	<div id="fst_glob_conf_step" style="display:none">
		<div class="fst-config-text">
			<div class="fst-config-pargraph">
				Please provide the following information. Do not worry, you can change it later.
			</div>
		</div>

		<div class="fst-config-cont">

		<form class="fst-config-form fst-config-db-form" id="fst-glob-db-form">

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Developer Name</div>
				<div class="fst-config-input db-input-input">
					<input type="text" class="form-control" id="dev_name" name="dev_name" placeholder="Your name" value="">
				</div>
				<div class="fst-config-input-desc db-input-input-desc">What's your name ;)</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Language</div>
				<div class="fst-config-input db-input-input">
					<select class="form-control" id="sel1" name="langue">
					    <option value="fr">Français</option>
						<option value="ar">العربية</option>
						<option value="en" selected>English</option>
			        </select>
				</div>
				<div class="fst-config-input-desc db-input-input-desc">What's your application default language</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Hide from search engines</div>
				<div class="fst-config-input db-input-input">
					<div class="switch">
					    <input type="checkbox" name="ckeck_search" class="switch-checkbox" id="chechBox6" checked>
					    <label class="switch-label switch-label-violet" for="chechBox6"></label>
					</div>
				</div>
				<div class="fst-config-input-desc db-input-input-desc label-text-switch">Ask search engines not to index this site</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Debugging</div>
				<div class="fst-config-input db-input-input">
					<div class="switch">
					    <input type="checkbox" name="ckeck_loggin" class="switch-checkbox" id="chechBox1" >
					    <label class="switch-label switch-label-violet" for="chechBox1"></label>
					</div>
				</div>
				<div class="fst-config-input-desc db-input-input-desc label-text-switch">Do you want to enable debugging</div>
			</div>

			<div class="control_c_row">
				<div class="fst-config-label db-input-label">Maintenance</div>
				<div class="fst-config-input db-input-input">
					<div class="switch">
					    <input type="checkbox" name="ckeck_maintenance" class="switch-checkbox" id="chechBox5">
					    <label class="switch-label switch-label-violet" for="chechBox5"></label>
					</div>
				</div>
				<div class="fst-config-input-desc db-input-input-desc label-text-switch">You can change the error message and maintenance later in the configuration files</div>
			</div>

			<div style="margin-top:20px">
				<input type="submit" class="btn hello_button" value="Next" name="nxt" id="nxt"   />
			</div>
		</form>

		</div>
	</div>

	<div id="fst_sec_conf_step" style="display:none">

		<div class="fst-config-text">
			<div class="fst-config-pargraph">
			These are the secret keys of your application, they provide the security for your secret data like saved password..., Lighty generate them automatically.
			</div>
		</div>

		<div class="fst-config-cont">
			<form class="fst-config-form fst-config-db-form" id="fst-sec-db-form">
				<div class="control_c_row">
					<div class="fst-config-label db-input-label">First security key</div>
					<div class="fst-config-input db-input-input">
						<input type="text" class="form-control" name="sec_1" value="<?php echo md5(uniqid(rand(), TRUE)) ?>" readonly>
					</div>
					<div class="fst-config-input-desc db-input-input-desc">The first token</div>
				</div>

				<div class="control_c_row">
					<div class="fst-config-label db-input-label">Second security key</div>
					<div class="fst-config-input db-input-input">
						<input type="text" class="form-control" name="sec_2" value="<?php echo md5(uniqid(rand(), TRUE)) ?>" readonly>
					</div>
					<div class="fst-config-input-desc db-input-input-desc">The second token</div>
				</div>

				<div style="margin-top:20px">
					<input type="submit" class="btn hello_button" value="Next" name="nxt" id="nxt"   />
				</div>
			</form>
		</div>
	</div>

	<div id="fst_pnl_conf_step" style="display:none">

		<div class="fst-config-text">
			<div class="fst-config-pargraph">
			Almost completed, Lighty uses a quite simple panel to create the necessary ingredients and execute most important operations, you need to configure this panel
			</div>
		</div>

		<div class="fst-config-cont">
			<form class="fst-config-form fst-config-db-form" id="fst-pnl-db-form">

				<div class="control_c_row">
					<div class="fst-config-label db-input-label">Activation</div>
					<div class="fst-config-input db-input-input">
						<div class="switch">
						    <input type="checkbox" name="stat" class="switch-checkbox" id="myswitch-violet" checked>
						    <label class="switch-label switch-label-violet" for="myswitch-violet"></label>
						</div>
					</div>
					<div class="fst-config-input-desc db-input-input-desc">Do you want activate panel ?</div>
				</div>

				<div class="control_c_row">
					<div class="fst-config-label db-input-label">Route</div>
					<div class="fst-config-input db-input-input">
						    <input type="text" class="form-control" id="pnl_route" name="route" placeholder="HTTP" value="" >
							<p class="conf_input_note">By default : Lighty</p>
					</div>
					<div class="fst-config-input-desc db-input-input-desc">what's HTTP access for panel ?</div>
				</div>

				<div class="control_c_row">
					<div class="fst-config-label db-input-label">First password</div>
					<div class="fst-config-input db-input-input">
						<input type="text" class="form-control" name="pass_1" placeholder="Password 1" value="">
						<p class="conf_input_note">By default : 1234</p>
					</div>
					<div class="fst-config-input-desc db-input-input-desc">the first password to access to panel</div>
				</div>

				<div class="control_c_row">
					<div class="fst-config-label db-input-label">Second password</div>
					<div class="fst-config-input db-input-input">
						<input type="text" class="form-control" name="pass_2" placeholder="Password 2" value="">
						<p class="conf_input_note">By default : 1234</p>
					</div>
					<div class="fst-config-input-desc db-input-input-desc">the second password to access to panel</div>
				</div>

				<div style="margin-top:20px">
					<input type="submit" class="btn hello_button" value="Finish" name="nxt" id="nxt"   />
				</div>

			</form>
		</div>
	</div>


	<img src="<?php echo "app/resources/images/lighty_logo.png" ?>" class="img" id="hello_logo" style="display:none">

	<div id="welcom" style="display:none">
	
		<div class="text">
			<?php 
				echo Lang::get('welcome');
				//
				//if(Base::full(Config::get('app.owner'))) 
						echo " <span id='dev_nom'>".Config::get('app.owner')."</span>";
			?>
		</div>
	</div>
	
	<div class="bottom_panel bottom_panel_2" id="bottom_panel_2" style="display:none">
		<?php echo "v ".App::fullVersion(); ?>
	</div>
	<div class="bottom_panel" id="bottom_panel" style="display:none">
		<a id="fst_panel" href="<?php echo Config::get("panel.route") ?>"><div class="btn hello_button" id="login">Lighty Panel</div></a>
	</div>
</div>