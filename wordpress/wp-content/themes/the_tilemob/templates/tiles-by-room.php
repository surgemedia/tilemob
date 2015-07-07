<?php get_template_part('templates/banner'); ?>
<div class="clearfix white_bg ">
	<div class="col-lg-12 ">
        <?php get_template_part('templates/two-col', 'h1'); ?>
		<div class="two-col">
			<div>
        		<?php the_field('content') ?>
        	</div>
        </div>
    </div>
    <div class="col-lg-6">
    	<img src="<?php the_field('floor_plan') ?>" width="293" height="400" alt="Planets" usemap="#Map">

		<map name="Map">
		  <area shape="rect" coords="183,145,241,236" href="bedroom-1.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Bedroom">
			<area shape="rect" coords="84,145,175,203" href="lounge.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Lounge">
			<area shape="rect" coords="25,145,84,218" href="bath.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Bathroom">
			<area shape="rect" coords="7,105,182,137" href="patio.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Patio">
			<area shape="rect" coords="106,307,172,356" href="study.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Study">
			<area shape="rect" coords="108,258,174,305" href="kitchen.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Kitchen">
			<area shape="rect" coords="245,144,281,237" href="ensuite.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Ensuite">
			<area shape="rect" coords="86,258,106,357" href="hallway.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Hallway">
			<area shape="poly" coords="197,354,212,396,273,395,257,352,197,353" href="driveway.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Driveway">
			<area shape="rect" coords="177,239,280,356" href="garage.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Garage">
			<area shape="rect" coords="85,204,176,257" href="dining-room.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Dining">
			<area shape="rect" coords="117,9,280,90" href="pool.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Pool" />
		</map>
    </div>
</div>


