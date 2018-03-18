<div class="news_index">

	<h2 class="home_courses">News Stories</h2>

	<div class="slider clearfix">

		<a href="#" class="prev button"><img src="images/slide-prev.gif"
			alt="Previous" /> </a> <a href="#" class="next button"><img
			src="images/slide-next.gif" alt="Next" /> </a>

		<div class="slides">

			<ul>

				<?php
				$sqltext = "SELECT * FROM news ORDER BY newsid DESC";

				$res = $dbsite->query($sqltext); # or die("Cant get news");

				foreach($res as $r) {

					?>

				<li><a href="news.php?id=<?php echo $r->newsid?>"
					title="View this news story"> <img
						src="images/news/th_<?php echo $r->newsid?>.jpg" alt="" /> <br />

						<?php echo $r->title?>
				</a>
				</li>

				<?php
				}
				?>

			</ul>
		</div>
	</div>
</div>