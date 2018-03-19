<div style="margin-bottom: 50px"></div>

<div class="container-narrow accordion" id="registration-module">
	<div class="page-header">
		<h2 class="crew_applicant">
			Registration 
			<small>» Module</small>
		</h2>
	</div>

	<!-- CREW PERSONAL INFORMATION -->
	<div class="section-one">
		<?php echo $this->load->view('registration/personal-info')?>
	</div>

	<!-- EDUCATIONAL ATTAINMENT -->
	<div class="section-two">
		<?php echo $this->load->view('registration/education')?>
	</div>	

	<!-- CHILDREN  -->
	<div class="section-three">
		<?php echo $this->load->view('registration/children')?>
	</div>
	
	<!-- WORK EXPERIENCE -->
	<div class="section-four">
		<?php echo $this->load->view('registration/works')?>
	</div>
	
	<!-- IDENTIFICATION/TRAVEL/MEDICAL DOCUMENTS  -->
	<div class="section-five">
		<?php echo $this->load->view('registration/documents')?>
	</div>

	<!-- SPECIAL COMMENT  -->
	<div class="section-six">
		<?php echo $this->load->view('registration/comment')?>
	</div>

	<!-- PERSONAL ASSESSMENT  -->
	<div class="section-seven">
		<?php echo $this->load->view('registration/assessment')?>
	</div>

	<!-- ENGLISH LEVEL  -->
	<div class="section-eight">
		<?php echo $this->load->view('registration/language')?>
	</div>

	<!-- UPLOAD FILES
	<div class="section-nine">
		?php echo $this->load->view('registration/attachment')?>
	</div> -->

	<!-- MANAGER'S REMARKS -->
	<div class="section-ten">
		<?php echo $this->load->view('registration/remarks')?>
	</div>

	<!-- MANAGER'S REMARKS -->
	<div class="section-eleven">
		<?php echo $this->load->view('registration/interview')?>
	</div>
	
</div>
