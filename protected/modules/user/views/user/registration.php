<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	
<?php if (CHtml::errorSummary($model)): ?>
	<div class="alert alert-error">
    	<?php echo CHtml::errorSummary($model); ?>
    </div>
<?php endif; ?>
	
	<div class="form-actions">
		<?php echo CHtml::activeLabelEx($model,'username'); ?>

		<?php echo CHtml::activeTextField($model,'username'); ?>

		<?php if (CHtml::error($model,'username')): ?>
			<div class="alert alert-error">
				<?php echo CHtml::error($model,'username'); ?>
			</div>
		<?php endif; ?>

		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password'); ?>
			<p class="hint">
				<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
			</p>

		<?php echo CHtml::activeLabelEx($model,'verifyPassword'); ?>
		<?php echo CHtml::activePasswordField($model,'verifyPassword'); ?>

		<?php echo CHtml::activeLabelEx($model,'email'); ?>
		<?php echo CHtml::activeTextField($model,'email'); ?>

		<?php 
			$profileFields=$profile->getFields();
			if ($profileFields) {
				foreach($profileFields as $field) {
		?>
				<?php echo CHtml::activeLabelEx($profile,$field->varname); ?>
				<?php 
				if ($field->widgetEdit($profile)) {
					echo $field->widgetEdit($profile);
				} elseif ($field->range) {
					echo CHtml::activeDropDownList($profile,$field->varname,Profile::range($field->range));
				} elseif ($field->field_type=="TEXT") {
					echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
				} else {
					echo CHtml::activeTextField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
				}
				 ?>
				<?php echo CHtml::error($profile,$field->varname); ?>
		<?php
					}
				}
		?>


			<?php if (UserModule::doCaptcha('registration')): ?>
					<?php echo CHtml::activeLabelEx($model,'verifyCode'); ?>
					<div>
					<?php $this->widget('CCaptcha'); ?>
					<?php echo CHtml::activeTextField($model,'verifyCode'); ?>
					</div>
					<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
					<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
			<?php endif; ?>
			<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
			
	</div>

	</div>



<?php echo CHtml::endForm(); ?>

<?php endif; ?>