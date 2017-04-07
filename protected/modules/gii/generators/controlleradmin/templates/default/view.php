<?php echo "<?php\n"; ?>
$this->breadcrumbs = [$this->pluralTitle => ['index'], 'View ' . $this->singleTitle . ' : ' . $title_name];

$this->menu = [
    ['label' => $this->pluralTitle, 'url' =>['index'], 'icon' => $this->iconList],  
    ['label' => 'Update '. $this->singleTitle, 'url' => ['update', 'id'=>$model->id]],
    ['label' => 'Create ' . $this->singleTitle, 'url' => ['create']],
];   
$this->renderBreadcrumbs('View ' . $this->singleTitle . ' : ' . $title_name);
?>
<?php echo "
<?php
//for notify message
\$this->renderNotifyMessage(); 
//for list action button
\$this->renderControlNav();
?>";?>
<div class="panel panel-default">
    <div class="panel-body">
    <?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', [
    'data'=>$model,
    'attributes'=>[ 
        <?php
            $link_img = 'CHtml::image(Yii::app()->request->baseUrl."/upload/listings/".\$model->id."/187x140/".\$model->image, "image", array("class"=>"b_img", "height" => "100px"))';
            if (isset($this->type_option['view'])){
            foreach ($this->type_option['view'] as $key_index => $val_index) {
                if ($val_index == 'string') {
                    echo "\n";
                    echo "\t\t\t\t'".$key_index."',\n";
                } elseif ($val_index == 'date') {
                    echo "\t\t\t\t['name' => '{$key_index}', 'type' => 'date'],\n";
                } elseif ($val_index == 'datetime') {
                    echo "\t\t\t\t['name' => '{$key_index}', 'type' => 'datetime'],\n";
                } elseif ($val_index == 'html') {
                    echo "\t\t\t\t['name' => '{$key_index}', 'type' => 'html'],\n";
                } elseif ($val_index == 'image') {
                    echo "\t\t\t\t['name' => '{$key_index}', 'type'=>'html', 'value' => \$model->getImageByField('{$key_index}')],\n";
                } elseif ($val_index == 'file') {
                    echo "\t\t\t\t['name' => '{$key_index}', 'type'=>'html', 'value' => \$model->getFilesByField('{$key_index}')],\n";
                } elseif (isset($key_index) && $key_index == 'extend_attributes') {
                    foreach ($this->type_option['view']['extend_attributes'] as $ke => $ex) {
                        if ($ex["relation_type"] == 'string') {
                            echo "\t\t\t\t['name' => '{$ex["attr_name"]}', 'value' => \$model->{$ex["relation_name"]}->{$ex["attr_name"]}],\n";
                        } elseif ($ex["relation_type"] == 'number') {
                            echo "\t\t\t\t['name' => '{$ex["attr_name"]}', 'value' => \$model->{$ex["relation_name"]}->{$ex["attr_name"]}],\n";
                        } elseif ($ex["relation_type"] == 'html') {
                            echo "\t\t\t\t['name' => '{$ex["attr_name"]}', 'value' => \$model->{$ex["relation_name"]}->{$ex["attr_name"]}, 'type' => 'html'],\n";
                        } elseif ($ex["relation_type"] == 'date') {
                            echo "\t\t\t\t['name' => '{$ex["attr_name"]}', 'value' => \$model->{$ex["relation_name"]}->{$ex["attr_name"]}, 'type' => 'date'],\n";
                        } elseif ($ex["relation_type"] == 'datetime') {
                            echo "\t\t\t\t['name' => '{$ex["attr_name"]}', 'value' => \$model->{$ex["relation_name"]}->{$ex["attr_name"]}, 'type' => 'datetime'],\n";
                        } elseif ($ex["relation_type"] == 'status') {
                            echo "\t\t\t\t['name' => '{$ex["attr_name"]}', 'value' => \$model->{$ex["relation_name"]}->{$ex["attr_name"]}, 'type' => 'status'],\n";
                        }
                    }
                }
            } 
            }
            ?>
        ],
    ]); ?>
    <div class="well">
        <?php echo "<?php echo CHtml::htmlButton('<span class=\"' . \$this->iconBack . '\"></span> Back', ['class' => 'btn btn-default', 'onclick' => 'javascript: location.href=\''.  \$this->baseControllerIndexUrl() . '\'']); ?>"; ?>
    </div>
    </div>
</div>
