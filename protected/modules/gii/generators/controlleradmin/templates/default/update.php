<?php echo "<?php\n"; ?>
$this->breadcrumbs = [$this->pluralTitle => ['index'], 'Update ' . $this->singleTitle. ': ' . $title_name];

$this->menu = array(
	['label' => $this->pluralTitle, 'url' => ['index'], 'icon' => $this->iconList],
	['label' => 'View ' . $this->singleTitle, 'url' => ['view', 'id' => $model->id]],
	['label' => 'Create ' . $this->singleTitle, 'url' => ['create']],
);
$this->renderBreadcrumbs('Update ' . $this->singleTitle. ': ' . $title_name);
?>

<div class="row">
	<div class="col-lg-12">
	<?php echo "<?php\n"; ?>
	//for notify message
	$this->renderNotifyMessage();
	//for list action button
	$this->renderControlNav();
	
    <?php echo "echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
	</div>
</div>

