<?php

if ( ! function_exists('analytics_view') )
{
	function analytics_view($title, $method, $options = array()) {
		$time = time();
		?>
			<div class="googleanalytics_view" id="ga-<?=$time?>" style="margin-bottom: 10px"><h2 style="margin-bottom: 10px"><?=$title?></h2><ul style="position: relative; height: 200px; list-style: none; border: 4px solid #fff; background: #f1f1f1; box-shadow: 0 2px 3px rgba(0, 0, 0, .3), inset 0 3px 5px rgba(0, 0, 0, .2);"></ul></div>
			<script type="text/javascript">
				var activateGAView = function (view) {
					var ul = view.find('ul');
					var lis = ul.find('li');
					var li_width = Math.floor(((ul.width() - 18) - ((lis.size() - 1) * 10)) / (lis.size()));
					
					lis.css({
						'position': 'absolute',
						'bottom': 0,
						'width': li_width - 4,
						'height': 0,
						'background': '#9dbed9',
						'border': '2px solid #fff',
						'border-bottom': 'none'
					});
					
					var max = 0;
					var min = null;
					
					lis.each(function (i) {
						var li = $(this);
						if (max < li.attr('data-visits')) max = parseInt(li.attr('data-visits'));
						if (min === null || li.attr('data-visits') < min) min = parseInt(li.attr('data-visits'));
						li.css({
							'left': (i * (li_width + 10)) + 10
						});
					}).each(function (i) {
						var li = $(this);
						var percent = (li.attr('data-visits') - min) / (max - min);
						
						setTimeout(function () {
							li.animate({
								'height': percent > 0 ? Math.floor(percent * 190) - 2 : 10
							})
						}, i * 20);
					});
				};
				$(function () {
					$.getJSON('/admin/google/api/<?=$method?>', {
						<?php if (isset($options['path'])): ?>
						'path': '<?=$options['path']?>',
						<?php endif; ?>
						<?php if (isset($options['range'])): ?>
						'range': '<?=$options['range']?>',
						<?php endif; ?>
					}, function (data) {
						var view = $('#ga-<?=$time?>');
						var html = '';
						for (var i in data)
						{
							<?php if ($method == 'page' || $method == 'visits'): ?>
							html += '<li title="'+i.substring(0, 4)+'-'+i.substring(4, 6)+'-'+i.substring(6, 8)+': '+data[i]['ga:visits']+' visits" data-visits="'+data[i]['ga:visits']+'"></li>';
							<?php endif; ?>
						}
						view.find('ul').append(html);
						
						activateGAView(view);
					});
				});
			</script>
		<?php
	}
}