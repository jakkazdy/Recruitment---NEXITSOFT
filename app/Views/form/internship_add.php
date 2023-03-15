<?php if(!isset($number)){$number=0;}?>
<div class="form-row" id="internship<?=$number;?>">
	<div class="col">
		<label for="internshipName<?=$number;?>">Nazwa firmy:</label>
		<?=form_input([
        'type'=>'text',
        'name'=>'internship['.$number.'][name]',
        'class'=>'form-control internshipValidateName',
    	]);?>
		<div id="internship[<?=$number;?>][name]Validation" class="invalid-feedback"></div>
	</div>
	<div class="col">
		 <label for="internshipStart<?=$number;?>">Początek stażu:</label>
		<?=form_input([
            'type'=>'date',
            'name'=>'internship['.$number.'][start]',
            'class'=>'form-control dateValidation',
        ]);?>
		<div id="internship[<?=$number;?>][start]Validation" class="invalid-feedback"></div>
	</div>
	<div class="col">
		 <label for="internshipEnd<?=$number;?>">Koniec stażu:</label>
		<?=form_input([
            'type'=>'date',
            'name'=>'internship['.$number.'][end]',
            'class'=>'form-control dateValidation',
        ]);?>
		<div id="internship[<?=$number;?>][end]Validation" class="invalid-feedback"></div>
	</div>
	<div class="col">
		 <a class="form-control text-white btn btn-warning deleteInternshipButton" data-id="<?=$number;?>">Usuń pozycję</a>
	</div>
</div>