<!DOCTYPE html>
<html>
<head>
	<title>test API</title>
<?php Yii::app()->getClientScript()->registerCoreScript('jquery'); ?>
</head>
<body>
	<div>List Image</div>
	<div id="content-load"></div>
	<form id="form-load" method="post">
		<input type="hidden" value="1" name="page" id="input-page"/>
		<input type="hidden" value="index" name="model" />
	</form>
	<button type="button" id="btnCLick">Load</button>

<script type="text/template" data-template="listitem">
    <image src="{URL_IMAGE}" alt="{IMAGE_NAME}" />
</script>

<script type="text/javascript">
$(document).ready(function() {
	function loadPage() {
		let page = $('#input-page');
		if(page.val() == 'noPage') {
			return false;
		}

		let form = $('form#form-load');
		$.ajax({
			url: "<?php echo url('api/v1/list'); ?>",
			data: form.serialize(),
			method: 'post'
		}).done(function(res) {
			if(res.status == 'success') {
				let templateItem = $('script[data-template="listitem"]').text();

				page.val(res.data.nextPage); 
				for(let row of res.data.rows) {
					if(row.url_image != null) {
						let html = templateItem;
						html = html.replace('{URL_IMAGE}', row.url_image);
						html = html.replace('{IMAGE_NAME}', row.name);
						$('div#content-load').append(html);
					}
				}
			}
		});
	}

	loadPage();
	$('#btnCLick').on('click',function() {
		loadPage();
	});
});	
</script>

</body>
</html>


