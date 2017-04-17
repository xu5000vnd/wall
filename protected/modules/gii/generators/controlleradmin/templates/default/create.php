<?php echo "<?php "; ?>
$this->breadcrumbs = [$this->pluralTitle => ['index'], 'Create ' . $this->singleTitle];

$this->menu = [
    ['label' => $this->pluralTitle , 'url' => ['index'], 'icon' => $this->iconList],
];
$this->renderBreadcrumbs('Create ' . $this->singleTitle );
?>
<div class="row">
    <div class="col-lg-12">
        <?php echo "<?php\n"; ?>
        //for notify message
        $this->renderNotifyMessage();
        //for list action button
        $this->renderControlNav();
        <?php echo "\n"; ?>
        <?php echo "echo \$this->renderPartial('_form', ['model'=>\$model]); ?>"; ?>
    </div>
</div>

