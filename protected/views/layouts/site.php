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
<section id="container" class="">
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