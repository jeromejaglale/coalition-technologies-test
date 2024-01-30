<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title', 'Untitled')@yield('base_title', ' | Tasks')</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.2/extensions/reorder-rows/bootstrap-table-reorder-rows.min.css" integrity="sha512-be9kYIsVXciiuD2PUN4IYGxJPTQ4VM/gJJqQQj5pv1DP45Z6l+GFc/6luUoGp8BHolzmHoAiU/yLJy4EyMSPug==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link href="/css/main.css?v=1" rel="stylesheet" />
	</head>

	<body>
		<div class="container">
			@yield('content')
		</div>

		<!-- Javascript -->
		<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.js"></script>		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.22.2/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js" integrity="sha512-DCj7ndgkqddgKq0go3mFR63Z4G3vk7ct8zgpGSf7JqwyzD1VEwhZyzeeCJDH4pKXqZi/qkjI8eATqhsMg0U/1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script>
		 	$(function() {
		 		// send Laravel CSRF token when doing AJAX requests
	 			$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

	 			// enable table rows to be re-ordered by drag and drop
			  	$('table').bootstrapTable().on('reorder-row.bs.table', function (e, tableData, oldRow, newRow) {
			  		const oldIndex = oldRow[0];
			  		const newIndex = newRow[0];

					if(oldIndex != newIndex) {
						$.ajax({
								url: '/update-priorities',
								type: 'POST',
								data: {
								old_priority: oldIndex,
								new_priority: newIndex
							},
							success: function (response) {
								location.reload();
							},
							error: function (error) {
								console.log('Error:', error);
							}
						});						
					}
			  	});
    		});
		</script>
	</body>
</html>