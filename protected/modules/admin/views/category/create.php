<?php
$this->breadcrumbs = [
    $this->pluralTitle => ['index'],
    'Create ' . $this->singleTitle,
];

$this->renderBreadcrumbs('Create ' . $this->singleTitle );
?>
<div class="row">
    <div class="col-lg-12">
        <?php
        //for notify message
        $this->renderNotifyMessage();

        include "_form.php";
        ?>    
    </div>
</div>
