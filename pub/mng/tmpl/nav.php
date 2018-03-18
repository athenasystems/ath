<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/" title="<?php echo $owner->co_name?>">Athena</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			
						<li><a href="/customers">Customers</a>
						</li>
				<?php
				$navs = array(
						'quotes',
						#'jobs',
						#'stock',
						'invoices',
						#'costs',
						#'diary'
				);
				foreach ($navs as $nav) {
					if (isset($siteMods[$nav])) {
						?>
				<li><a href="/<?php echo $nav?>" title="<?php echo ucfirst($nav);?>">
						<?php echo ucfirst($nav);?>
				</a>
				</li>
				<?php
					}
				}
				?>

						<li><a href="/reports/finance">Accounts</a>
						</li>
						<li><a href="/web">Web Site</a>
						</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown" role="button" aria-haspopup="true"
					aria-expanded="false">Settings <span class="caret"></span>
				</a>
					<ul class="dropdown-menu">
						<li><a href="/acc/company">Company Details</a>
						</li>
						
						<li role="separator" class="divider"></li>
						<li><a href="/acc" title="Module Store">Module Store</a>
						</li>
						<li role="separator" class="divider"></li>
						<li><a href="/reports">Site Log</a>
						</li>
						<li><a href="/pass.php?pg=logout&s=<?php echo $sitesid; ?>">Log
								Out</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
