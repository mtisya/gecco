<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Africas Talking Integration in Codeigniter</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/bootstrap.min.js" />
	
</head>
<body>

<!-- Bootstrap 4 Navbar  -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	<a href="<?php echo base_url(); ?>" class="navbar-brand">Africas Talking SMS Gateway</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
	
</nav>
<!-- End Bootstrap 4 Navbar -->

<div class="container mt-5">
	<div class="row">	
		<div class="col-md-12">
			<div class="card">
				<h2 class="card-header bg-primary text-red">Africas Talking SMS Area</h2>
				<div class="card-body">
					<?php if (validation_errors()): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Error!</strong> <?php echo validation_errors(); ?>
						</div>
					<?php endif ?>

					<?php if ($this->session->userdata('update_status')): ?>
						<?php echo $this->session->userdata('update_status'); ?>
					<?php endif ?>
					<div id="device-init-container">
				<fieldset class="scheduler-border">
					<legend class="scheduler-border">ETIMS Device Initialization</legend>
					<input type="hidden" name="token" value="{CSRF_TOKEN}">
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
							<?= lang('tin', 'tin'); ?>
							<?= form_input('tin', '', 'class="form-control tip" id="tin" data-key="tin"'); ?>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
							<?= lang('bhfId', 'bhfId'); ?>
							<?= form_input('bhfId', '', 'class="form-control tip" id="bhfId" data-key="bhfId" '); ?>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="form-group">
							<?= lang('dvcSrlNo', 'dvcSrlNo'); ?>
							<?= form_input('dvcSrlNo', '', 'class="form-control tip" id="dvcSrlNo" data-key="dvcSrlNo"'); ?>
						</div>
					</div>

					<!-- Button to initialize the device -->
					<button class="btn btn-primary" id="init-device-btn">Initialize Device</button>
				</fieldset>

				</div>
			</div>
		</div>
        
    </div>
   
</div> 

</body>
</html>