<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<h3 class="page-title"><?= $page_title;?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Status</th>
			<th>Klasifikasi</th>
			<th>Status Klien</th>
			<th>Nama Klien</th>
			<th>Unit Pengorder</th>
			<th>Nama Pengorder</th>
			<th>Order social media</th>
			<th>Akun social media</th>
			<th>Tanggal posting</th>
			<th>Kuantitas postingan</th>
			<th>Total biaya</th>
			<th>Brief lainnya</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

<!-- Modal -->
<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby="dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="id" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataFormLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="statusOrder">Status order <span class="text-danger">*</span></label>
								<select class="custom-select" id="statusOrder" name="status">
									<option value="" selected>--Pilih status--</option>
									<option value="Usulan">Usulan</option>
									<option value="Pesanan">Pesanan</option>
									<option value="Pelaksanaan">Pelaksanaan</option>
								</select>
							</div>
							<div class="form-group">
								<label for="tanggalOrder">Tanggal order</label>
								<div class="input-group date" id="tanggal" data-target-input="nearest">
									<input type="text" name="tanggal" class="form-control datetimepicker-input" data-target="#tanggal"/>
									<div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="klasifikasi">Klasifikasi order</label>
								<select class="custom-select" id="klasifikasi" name="klasifikasi">
									<option value="" selected>--Pilih klasifikasi--</option>
									<option value="Komersil">Komersil</option>
									<option value="Non-komersil">Non-komersil</option>
								</select>
							</div>
							<div class="form-group">
								<label for="statusKlien">Status klien</label>
								<select class="custom-select" id="statusKlien" name="client_status">
									<option value="" selected>--Pilih status klien--</option>
									<option value="Nasional">Nasional</option>
									<option value="Lokal">Lokal</option>
									<option value="Agensi Nasional">Agensi Nasional</option>
									<option value="Agensi Lokal">Agensi Lokal</option>
								</select>
							</div>
							<div class="form-group">
								<label for="namaKlien">Nama klien</label>
								<input name="client_name" type="text" class="form-control" id="namaKlien">
							</div>
							<div class="form-group">
								<label for="unitPengorder">Unit pengorder</label>
								<select class="custom-select" id="unitPengorder" name="unit">
									<option value="" selected>--Pilih unit pengorder--</option>
									<option value="Agency">Agency</option>
									<option value="Lokal & Principal">Lokal & Principal</option>
								</select>
							</div>
							<div class="form-group">
								<label for="namaPengorder">Nama pengorder</label>
								<?php $nama_pengorder = ['Ibu Endang - Manager Traffic', 'Agit - Traffic', 'Karin - Manager Marketing Agency', 'Manager Marketing Lokal & Principal', 'Aya - AE', 'Choky - AE', 'Diki - AE', 'Nino - AE', 'Ronny - AE'];?>
								<select class="custom-select" id="namaPengorder" name="reference">
									<option value="" selected>--Pilih nama pengorder--</option>
									<?php for($i = 0;$i < count($nama_pengorder);$i++) :?>
										<option value="<?= $nama_pengorder[$i];?>"><?= $nama_pengorder[$i];?></option>
									<?php endfor;?>
								</select>
							</div>

						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="orderSocialMedia">Order social media</label>
								<?php $orderSocialMedia = ['Instagram Feed', 'Instagram Story', 'Instagram Reels', 'Facebook', 'TikTok', 'Instagram / TikTok Live', 'Youtube'];?>
								<select class="custom-select" id="orderSocialMedia" name="social_media_order">
									<option value="" selected>--Pilih order social media--</option>
									<?php for($i = 0;$i < count($orderSocialMedia);$i++) :?>
										<option value="<?= $orderSocialMedia[$i];?>"><?= $orderSocialMedia[$i];?></option>
									<?php endfor;?>
								</select>
							</div>
							<div class="form-group">
								<label for="socialMediaAccount">Akun media social</label>
								<select class="custom-select" id="socialMediaAccount" name="social_media_account">
									<option value="" selected>--Pilih akun--</option>
									<option value="Ardan">Ardan</option>
									<option value="B Radio">B Radio</option>
									<option value="Cakra">Cakra</option>
								</select>
							</div>
							<div class="form-group">
								<label for="postdate">Tanggal posting</label>
								<div class="input-group date" id="postdate" data-target-input="nearest">
									<input type="text" name="postdate" class="form-control datetimepicker-input" data-target="#postdate"/>
									<div class="input-group-append" data-target="#postdate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="qtypost">Qty postingan</label>
								<input name="post_qty" type="number" class="form-control" id="qtypost">
							</div>
							<div class="form-group">
								<label for="cost">Total biaya</label>
								<input name="cost" type="number" class="form-control" id="cost">
							</div>
							<div class="form-group">
								<label for="otherBrief">Brief lainnya</label>
								<textarea name="other_brief" rows="5" class="form-control" id="otherBrief"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="loading-indicator"></div>
					<div class="form-navigation">
						<button name="submit" type="submit" class="btn btn-primary btn-save">Simpan</button>
						<button name="cancel" type="button" class="btn btn-link btn-cancel text-danger" data-dismiss="modal">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="dataDetail" tabindex="-1" aria-labelledby="dataDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataDetailLabel">Data detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6">
						<div class="item">
							<label>Status order</label>
							<div class="custDet status"></div>
						</div>
						<div class="item">
							<label>Tanggal order</label>
							<div class="custDet tanggal"></div>
						</div>
						<div class="item">
							<label>Klasifikasi order</label>
							<div class="custDet klasifikasi"></div>
						</div>
						<div class="item">
							<label>Status klien</label>
							<div class="custDet client_status"></div>
						</div>
						<div class="item">
							<label>Nama klien</label>
							<div class="custDet client_name"></div>
						</div>
						<div class="item">
							<label>Unit pengorder</label>
							<div class="custDet unit"></div>
						</div>
						<div class="item">
							<label>Nama pengorder</label>
							<div class="custDet reference"></div>
						</div>
						
					</div>
					<div class="col-6">
						<div class="item">
							<label>Order social media</label>
							<div class="custDet social_media_order"></div>
						</div>
						<div class="item">
							<label>Akun social media</label>
							<div class="custDet social_media_account"></div>
						</div>
						<div class="item">
							<label>Tanggal posting</label>
							<div class="custDet postdate"></div>
						</div>
						<div class="item">
							<label>Kuantitas postingan</label>
							<div class="custDet post_qty"></div>
						</div>
						<div class="item">
							<label>Total biaya</label>
							<div class="custDet cost"></div>
						</div>
						<div class="item">
							<label>Brief lainnya</label>
							<div class="custDet other_brief"></div>
						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button name="cancel" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection()?>