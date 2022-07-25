<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<h3 class="page-title"><?= $page_title;?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>
<?php if (session()->has('error')) : ?>
	<div class="alert alert-danger"><?= session()->get('error'); ?></div>
<?php endif; ?>

<ul class="nav nav-tabs" id="settingTab" role="tablist">
	<li class="nav-item">
		<button class="nav-link active" id="recipients-tab" data-toggle="tab" data-target="#recipients" type="button" role="tab" aria-controls="recipients" aria-selected="true">Recipients</button>
	</li>
	<li class="nav-item">
		<button class="nav-link" id="specificrecipients-tab" data-toggle="tab" data-target="#specificrecipients" type="button" role="tab" aria-controls="specificrecipients" aria-selected="false">Spesifik Recipients</button>
	</li>
	<li class="nav-item">
		<button class="nav-link" id="smtp-tab" data-toggle="tab" data-target="#smtp" type="button" role="tab" aria-controls="smtp" aria-selected="false">SMTP</button>
	</li>
</ul>
<div class="tab-content" id="settingTabContent">
	<div class="tab-pane fade show active" id="recipients" role="tabpanel" aria-labelledby="recipients-tab">
		<form name="submit-recipients">
			<div class="recipients-wrapper mt-4">
				<div class="mb-3">
					<button class="btn btn-primary btn-add add-recipient" type="button">Add Recepient</button>
					<button class="btn btn-success btn-save" type="submit">Simpan perubahan</button>
					<input type="hidden" name="recipients_id" value="">
				</div>
				<div class="recipients">
				</div>
			</div>
		</form>
	</div>
	<div class="tab-pane fade" id="specificrecipients" role="tabpanel" aria-labelledby="specificrecipients-tab">
		<form name="submit-specific" class="mt-4">
			<input type="hidden" name="specifics_id" value="<?= $specifics['id'];?>">
			<div class="row mb-2">
				<div class="col-2">
					Ardan
				</div>
				<div class="col-3">
					<input type="text" name="ardan_recipient" class="form-control" value="<?= $specifics['data']['ardan_recipient'];?>">
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					B Radio
				</div>
				<div class="col-3">
					<input type="text" name="bradio_recipient" class="form-control" value="<?= $specifics['data']['bradio_recipient'];?>">
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					Cakra
				</div>
				<div class="col-3">
					<input type="text" name="cakra_recipient" class="form-control" value="<?= $specifics['data']['cakra_recipient'];?>">
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-5">
					<button type="submit" class="btn btn-primary btn-save">Simpan</button>
				</div>
			</div>
		</form>
	</div>
	<div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
		<form name="submit-smtp" class="mt-4">
			<input type="hidden" name="smtp_id" value="">
			<div class="row mb-2">
				<div class="col-12">
					<div class="button-wrapper">
						<button class="btn btn-primary change-smtp" type="button">Ubah</button>
					</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					Host
				</div>
				<div class="col-3">
					<div class="smtp-host">...</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					Email
				</div>
				<div class="col-3">
					<div class="smtp-user">...</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					Password
				</div>
				<div class="col-3">
					<div class="smtp-password">...</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					Port
				</div>
				<div class="col-3">
					<div class="smtp-port">...</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-2">
					Enkripsi
				</div>
				<div class="col-3">
					<div class="smtp-encryption">...</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?= $this->endSection()?>