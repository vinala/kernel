<body>
	<div style="height:60px"></div>
	<div class="vnl_config_icon" id="vnl_config_icon"></div>

	<div id="vnl_msg_step">
		<div class="vnl-config-text">
			<div class="vnl-config-pargraph">
				Welcome to Vinala. Before we launch, we need some information about your application. You'll have to fill the following information forms to proceed.
			</div>
			<form class="vnl-config-form" id="vnl-config-msg-form">
				<div style="margin-top:20px">
					<input type="submit" class="btn hello_button_hover hello_button_left" value="Let's go !" name="nxt" id="nxt"   />
				</div>
			</form>
		</div>
	</div>

	<div id="vnl_glob_conf_step" style="display:none">
		<div class="vnl-config-text">
			<div class="vnl-config-pargraph">
				Please provide the following information. Do not worry, you can change it later.
			</div>
		</div>

		<div class="vnl-config-cont">

		<form class="vnl-config-form vnl-config-db-form" id="vnl-glob-form">

			<div class="control_c_row">
				<div class="vnl-config-label db-input-label">Project Name</div>
				<div class="vnl-config-input db-input-input">
					<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Your project" value="">
				</div>
				<div class="vnl-config-input-desc db-input-input-desc">What's your project name ;)</div>
			</div>

			<div class="control_c_row">
				<div class="vnl-config-label db-input-label">Developer Name</div>
				<div class="vnl-config-input db-input-input">
					<input type="text" class="form-control" id="dev_name" name="dev_name" placeholder="Your name" value="">
				</div>
				<div class="vnl-config-input-desc db-input-input-desc">What's your name ;)</div>
			</div>

			<div class="control_c_row">
				<div class="vnl-config-label db-input-label">Hide from search engines</div>
				<div class="vnl-config-input db-input-input">
					<div class="switch">
					    <input type="checkbox" name="ckeck_search" class="switch-checkbox" id="chechBox6" checked>
					    <label class="switch-label switch-label-violet" for="chechBox6"></label>
					</div>
				</div>
				<div class="vnl-config-input-desc db-input-input-desc label-text-switch">Ask search engines not to index this site</div>
			</div>

			<div class="control_c_row">
				<div class="vnl-config-label db-input-label">Debugging</div>
				<div class="vnl-config-input db-input-input">
					<div class="switch">
					    <input type="checkbox" name="ckeck_loggin" class="switch-checkbox" id="chechBox1" >
					    <label class="switch-label switch-label-violet" for="chechBox1"></label>
					</div>
				</div>
				<div class="vnl-config-input-desc db-input-input-desc label-text-switch">Do you want to enable debugging</div>
			</div>

			<div class="control_c_row">
				<div class="vnl-config-label db-input-label">Maintenance</div>
				<div class="vnl-config-input db-input-input">
					<div class="switch">
					    <input type="checkbox" name="ckeck_maintenance" class="switch-checkbox" id="chechBox5">
					    <label class="switch-label switch-label-violet" for="chechBox5"></label>
					</div>
				</div>
				<div class="vnl-config-input-desc db-input-input-desc label-text-switch">You can change the error message and maintenance later in the configuration files</div>
			</div>

			<div style="margin-top:20px">
				<input type="submit" class="btn hello_button" value="Finish" name="nxt" id="nxt"   />
			</div>
		</form>

		</div>
	</div>

	<div id="welcom" style="display:none">
		<div class="text">
			<?php 
				echo trans('framework.welcome');
				//
				echo " <span id='dev_nom'>".config('app.owner')."</span>";
			?>
		</div>
	</div>

	<div class="final_link">
		<div class="final_link_owner" id="bottom_owner" style="display:none">
			<a id="fst_panel" class="final_link_owner_a" href="https://www.facebook.com/yussef.had">
				By Youssef Had
			</a>	
		</div>

		<div class="final_link_docs" id="bottom_docs" style="display:none">
			<a id="fst_panel" class="final_link_owner_a" href="https://gitlab.com/lighty/Docs">
				Docs
			</a>
		</div>
		
		<div class="final_link_version" id="bottom_panel_2" style="display:none">
			<a id="fst_panel" class="final_link_owner_a" href="https://github.com/vinala/vinala/blob/master/CHANGES.md">
				<?php echo "v".App::getVersion()->full(); ?>
			</a>
		</div>	
	</div>
</body>