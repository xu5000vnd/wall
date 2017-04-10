<!-- javascripts -->
<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-ui-1.10.4.min.js"></script>
<!-- bootstrap -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- charts scripts -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/jquery-knob/js/jquery.knob.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/owl.carousel.js" ></script>
<!-- jQuery full calendar -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/fullcalendar.min.js"></script> 
<!-- Full Google Calendar - Calendar -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
<!--script for this page only-->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/calendar-custom.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.rateit.min.js"></script>
<!-- custom select -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.customSelect.min.js" ></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/chart-master/Chart.js"></script>

<!--custome script for all page-->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/scripts.js"></script>
<!-- custom script for this page-->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/sparkline-chart.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/easy-pie-chart.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/xcharts.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.autosize.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.placeholder.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/gdp-data.js"></script>  
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/morris.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/sparklines.js"></script>  
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/charts.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.bootstrap.wizard.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/select2.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/ckeditor/ckeditor.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/request.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/select2.js"></script>
<!-- switch on off -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap-switch-org.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.datetimepicker.full.js"></script>
  

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugin.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/main.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>

<script>
    //knob
    $(function() {
      $(".knob").knob({
        'draw' : function () { 
          $(this.i).val(this.cv + '%')
        }
      })
    });

    //carousel
    $(document).ready(function() {
        $("#owl-slider").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true

        });
    });

    //custom select box

    $(function(){
        $('select.styled').customSelect();
    });
  
  /* ---------- Map ---------- */
$(function(){
  $('#map').vectorMap({
    map: 'world_mill_en',
    series: {
      regions: [{
        values: gdpData,
        scale: ['#000', '#000'],
        normalizeFunction: 'polynomial'
      }]
    },
    backgroundColor: '#eef3f7',
    onLabelShow: function(e, el, code){
      el.html(el.html()+' (GDP - '+gdpData[code]+')');
    }
  });
});

$(document).ready(function(){
  actionReq.setUrl("<?php echo url('ajax/requestHandler'); ?>");
  actionReq.setUrlAjax("<?php echo url('ajax'); ?>");
  validateNumber();

  $('.textarea-ckeditor').each(function() {
    var id = $(this).attr('id');
    CKEDITOR.replace(id);
  });

});

</script>