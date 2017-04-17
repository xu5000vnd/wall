<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'head.php'; ?>
</head>
<?php
$controllerName = Yii::app()->controller->id;
$actionName = Yii::app()->controller->action->id;
if($actionName == 'login') :
?>
<body class="login-img3-body">
    <?php echo $content; ?>
</body>

<?php else :?>

<body>
<?php 
	$classToggle = '';
	if(isset($_SESSION['TOGGLE']) && $_SESSION['TOGGLE'] == 'close') {
    	$classToggle = 'sidebar-closed';
	}
?>
<section id="container" class="<?php echo $classToggle; ?>">
    <?php include_once 'header.php'; ?>
    <?php include_once 'nav.php'; ?>

    <section id="main-content">
        <section class="wrapper">
            <?= $content ?>
        </section>
    </section>
</section>
<?php include_once 'footer.php'; ?>

</body>
<?php endif;?>
</html>