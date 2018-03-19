<div style="margin-bottom: 50px"></div>

<div class="container-narrow accordion" id="schedule-module">
	<div class="page-header">
		<h2 class="crew_applicant">
			Flight Scheduling 
			<small>» For Flight Assignment</small>
		</h2>
	</div>
	
	<!-- CREW PERSONAL INFORMATION -->
	<div class="section-one" style="margin-bottom: 15px;" >
		<?php echo $this->load->view('flight/schedule-info')?>
	</div>

	<?php if(isset($id)): ?>
	<!-- JOINING  -->
	<div class="section-two" style="margin-bottom: 15px;">
		<?php echo $this->load->view('flight/joining')?>
	</div>

	<!-- REPAT  -->
	<div class="section-three" style="margin-bottom: 15px;">
		<?php echo $this->load->view('flight/repat')?>
	</div>

	<!-- FOR PROMOTION -->
	<div class="section-four">
		<?php echo $this->load->view('flight/promotion')?>
	</div>	
	<?php endif; ?>
</div>
