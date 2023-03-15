<div class="container">
	<div class="row"><h3>Wypełnij formularz rekrutacyjny</h3></div>
	<?php if(!empty($error)){?>
		<div class="alert alert-danger" role="alert">Formularz został błędnie wypełniony. Spróbuj ponownie.</div>
	<?php };?>
		<div class="alert alert-danger" id="infoSubmit" role="alert">Uzupełnij pola podświetlone na czerwono!</div>
</div>

<div class="container">
<?=form_open('form/send',['method'=>'POST','id'=>'RecruitmentForm','enctype' => 'multipart/form-data']);?>
	<div class="form-row">
		<div class="col">
			 <label for="first_name">Imię:</label>
			<?=form_input($inputs['first_name']);?>
			<div id="first_nameValidation" class="invalid-feedback"></div>
		</div>
		<div class="col">
			 <label for="last_name">Nazwisko:</label>
			<?=form_input($inputs['last_name']);?>
			<div id="last_nameValidation" class="invalid-feedback"></div>
		</div>
	</div>
	<div class="form-row">
		<div class="col">
			 <label for="dob">Data urodzenia:</label>
			<?=form_input($inputs['dob']);?>
			<div id="dobValidation" class="invalid-feedback"></div>
		</div>
		<div class="col">
			 <label for="education">Wykształcenie:</label>
			<?=form_dropdown('education', [1=>'Podstawowe',2=>'Średnie',3=>'Wyższe'], '1',['class'=>"form-control"]);?>
		</div>
	</div>
	<div class="form-group">
		 <label for="email">Email:</label>
		<?=form_input($inputs['email']);?>
		<div id="emailValidation" class="invalid-feedback"></div>
	</div>
	<div class="form-group">
		 <label for="email">Załącznik 1(LM):</label>
		<?=form_upload('attachmentLM','',['class'=>"form-control",'accept'=>'.jpg,.pdf,.doc']);?>
			<div id="attachmentLMValidation" class="invalid-feedback"></div>
	</div>
	<div class="form-group">
		 <label for="email">Załącznik 2(CV):</label>
		<?=form_upload('attachmentCV','',['class'=>"form-control",'accept'=>'.jpg,.pdf,.doc']);?>
			<div id="attachmentCVValidation" class="invalid-feedback"></div>
	</div>
	<div class="form-group attachmentOtherView">
		 <a class="form-control text-white btn btn-primary attachmentOtherViewButton">Dodaj dodatkowy załącznik</a>
	</div>
	<div class="form-group attachmentOther">
		 <label for="email">Załącznik dodatkowy:</label>
		<?=form_upload('attachmentOther','',['class'=>"form-control",'accept'=>'.jpg,.pdf,.doc']);?>
			<div id="attachmentOtherValidation" class="invalid-feedback"></div>
	</div>
	<h5>Staż</h5>
	<?=form_hidden('internshipCount',0);?>
	<?=form_hidden('attachment_other_status',0);?>
	<div class="container formInternship">
	</div>
	<div class="form-group internshipAdd">
		 <a class="form-control text-white btn btn-primary internshipAddButton">Dodaj pozycję w stażu</a>
	</div>
	

	<div class="form-group">
		<?=form_submit('formSubmit', 'Wyślij zgłoszenie!',['class'=>"form-control btn btn-primary", 'disabled'=>true, 'hidden'=>true]);?>
		<a class="form-control text-white btn btn-primary sendButton">Wyslij</a>
	</div>

		<?=form_close();?>

</div>
