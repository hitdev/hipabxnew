<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo $_SESSION['BASE_URL'].'index.php'; ?>">HITPabx</a>
			
			<?php if (end(explode("/", $_SERVER['PHP_SELF'])) != 'index.php') { ?>
			<div class="nav-collapse">
				<ul class="nav">
					<li><a href="<?php echo $_SESSION['BASE_URL'].'modules/dashboard/dashboard.php'; ?>">Home</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Extensions <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a tabindex="-1" href="<?php echo $_SESSION['BASE_URL'].'modules/extensions/extensions-register.php'; ?>">Register</a></li>
							<li><a tabindex="-1" href="<?php echo $_SESSION['BASE_URL'].'modules/extensions/extensions-list.php'; ?>">List</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo $_SESSION['BASE_URL'].'modules/extensions/extensions-groups.php'; ?>">Groups</a></li>
						</ul>
					</li>
					<li><a href="billing.php">Billing</a></li>
                                        <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Queues <b class="caret"></b></a>
                                                  <ul class="dropdown-menu">
							<li><a tabindex="-1" href="<?php echo $_SESSION['BASE_URL'].'modules/queues/queues-list.php'; ?>">Queues list</a></li>
                                                        <li><a tabindex="-1" href="<?php echo $_SESSION['BASE_URL'].'modules/queues/queues-add.php'; ?>">Queues add</a></li>
                                                        <li><a tabindex="-1" href="<?php echo $_SESSION['BASE_URL'].'modules/queues/agents-add.php'; ?>">Agents list</a></li>
                                                        <li><a tabindex="-1" href="<?php echo $_SESSION['BASE_URL'].'modules/queues/agents-add.php'; ?>">Agent add</a></li>
                                                  </ul>             
                                        </li>
			</div>
			<?php } ?>
			
		</div>
	</div>
</div>