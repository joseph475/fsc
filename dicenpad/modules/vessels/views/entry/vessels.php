<div style="margin-bottom: 50px"></div>

<div class="container-narrow accordion" id="vessel-module" style="margin-bottom: 50px;">
	<div class="page-header">
		<h2 class="crew_applicant">
			Vessel Entry
			<small>» Setup</small>
		</h2>
	</div>

	<!-- VESSEL INFORMATION -->
	<div class="section-one">
		<?php echo $this->load->view('entry/vessel-info')?>
	</div>

	<!-- SPECIAL COMMENT  -->
	<div class="section-three">
		<?php echo $this->load->view('entry/documents')?>
	</div>

	<!-- SPECIAL COMMENT  -->
	<div class="section-three">
		<?php echo $this->load->view('entry/validity')?>
	</div>

</div>