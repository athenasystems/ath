		</div>

		<div  class="text-center">
			<br>
			<div style="font-size:80%;margin-left: 40px;color:#555;">
			Athena Tools <?php
			if($owner->brand==0){$owner->brand='Web Minions Ltd.';}
			if($owner->brand==1){$owner->brand='Web Modules Ltd.';}
			echo 'by '.$owner->brand;

			?>
    for <?php echo $owner->co_name;?>
	<p>
		&copy; 2016 Athena Systems
	</p>
    </div>
	<br> <br>

	</div>

<?php
if(isset($siteMods['chat'])){
    echo getChatBox();
}
?>


    
    <script src="/pub/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
