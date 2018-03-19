<div style="margin-bottom: 50px"></div>
<div class="container-narrow" id="about-tab">

	<div class="row-section ">  
		<!-- CREW PERSONAL INFORMATION -->
		<div class="section-one">
			<?php echo $this->load->view('resume/personal-info')?>
		</div>

		<!-- EDUCATIONAL ATTAINMENT -->
		<div class="section-two">
			<?php echo $this->load->view('resume/education')?>
		</div>	

		<!-- IDENTIFICATION/TRAVEL/MEDICAL DOCUMENTS  -->
		<div class="section-three">
			<?php echo $this->load->view('resume/children')?>
		</div>

		<!-- WORK EXPERIENCE -->
		<div class="section-four">
			<?php echo $this->load->view('resume/works')?>
		</div>

		<!-- IDENTIFICATION/TRAVEL/MEDICAL DOCUMENTS  -->
		<div class="section-five">
			<?php echo $this->load->view('resume/documents')?>
		</div>	

		<!--ENGLISH LEVEL  -->
		<div class="section-six">
			<?php echo $this->load->view('resume/language')?>
		</div>	

		<!-- PERSONAL ASSESSMENT  -->
		<div class="section-seven">
			<?php echo $this->load->view('resume/assessment')?>
		</div>	

		<?php if(!$principal_id) { ?>
		<!-- MANAGER'S REMARKS  -->
		<div class="section-eight">
			<?php echo $this->load->view('resume/remarks')?>
		</div>
		<?php } ?>

		<!-- CREW INTERVIEW  -->
		<div class="section-nine">
			<?php echo $this->load->view('resume/interview')?>
		</div>
	</div>

</div>