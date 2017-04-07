<!--overview start-->
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i><a href="<?php echo Yii::app()->request->getBaseUrl(true); ?>">Home</a></li>
            <li><i class="fa fa-laptop"></i>Dashboard</li>                          
        </ol>
    </div>
</div>

<?php if (Yii::app()->user->hasFlash('success')) : ?>
    <div class="alert alert-block alert-success">
        <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
    </div>
<?php endif; ?>
  
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h3 class="btn-1"><b>1. Invoice APP confirmed </b></h3>
        <!--collapse end-->
    </div><!--/.col-->
</div><!--/.row-->

<div id="preview_invoice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Preview PDF</h4>
            </div>

            <div class="modal-body" style="width: 100%">
                <div style="overflow-y:hidden; height:100%;">
                    <object id="pdf-file" frameborder="0" type="application/pdf" width="100%" style="min-height: 600px" data="" style="float:center;"></object>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" >Cancel</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    function previewInvoice(_this) {
        var href = _this.attr('data-href');
        $('#pdf-file').attr('data', href);
        $('#preview_invoice').modal('show');
    }
</script>