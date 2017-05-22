<?php
$this->breadcrumbs = array(
    'Dash Board',
);
$this->renderBreadcrumbs('<i class="fa fa-home"></i>Dash Board');
?>

<div class="row">
	<div class="col-sm-4">
	<h3><b>Total Images</b>: <?php echo Image::model()->count(); ?></h3>
	</div>
</div>

<div class="row">
	<div class="col-sm-4">
		<section class="panel">
          <header class="panel-heading">
              Upload in today
          </header>
          <table class="table">
              <thead>
              <tr>
                  <th>Today</th>
                  <th>Total Images</th>
              </tr>
              </thead>
              <tbody>
				<tr>
				  <td><?php echo date('Y-m-d'); ?></td>
				  <td><?php echo Image::getTotalImagesToday(); ?></td>
				</tr>
              </tbody>
          </table>
        </section>
	</div>
	<div class="col-sm-4">
		<section class="panel">
          <header class="panel-heading">
              Upload in month <?php echo date('m'); ?>
          </header>
          <table class="table">
              <thead>
              <tr>
                  <th>Day</th>
                  <th>Total Images</th>
              </tr>
              </thead>
              <tbody>
              <?php 
					$listDays = Image::getImagesThisMonth();

					foreach ($listDays as $key => $day) {
				?>
				<tr>
				  <td><?php echo $day['date']; ?></td>
				  <td><?php echo $day['total']; ?></td>
				</tr>
				<?php
					}
				?>
              </tbody>
          </table>
        </section>
	</div>
	
	<div class="col-sm-4">
		<section class="panel">
          <header class="panel-heading">
              Total Images
          </header>
          <table class="table">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Category Name</th>
                  <th>Total Images</th>
              </tr>
              </thead>
              <tbody>
              <?php 
					$listCat = Category::model()->findAll();
					foreach ($listCat as $key => $cat) {
				?>
				<tr>
				  <td><?php echo $key + 1; ?></td>
				  <td><?php echo $cat->name; ?></td>
				  <td><?php echo count($cat->rImage); ?></td>
				</tr>
				<?php
					}
				?>
              </tbody>
          </table>
        </section>
	</div>
</div>
