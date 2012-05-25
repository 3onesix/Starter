if (!Image_Manager) {
	window.image_managers = [];
	
	var Image_Manager = function (field) {
		/* Properties */
		this.field  = field;
		this.width  = this.field.attr('data-width');
		this.height = this.field.attr('data-height');
		this.destroy_url = this.field.attr('data-destroy-url');
		this.img_width  = 3230;
		this.img_height = 2153;
		var manager = this;		
		
		this.editor_scale = this.field.parent().width() > this.width ? 1.0 : (((this.field.parent().width() * this.height) / this.width) / this.height);
		
		/* Methods */
		this.change_mode = function (mode) {
			if ($.inArray(mode, ['editor', 'uploader']) == -1) mode = 'uploader';
			
			if (mode == 'editor') {
				this.uploader.hide();
				this.editor.show();
			}
			else {
				this.uploader.show();
				this.editor.hide();
			}
		};
		this.size_editor = function () {
			this.editor_scale = this.manager.parent().width() > this.width ? 1.0 : (((this.manager.parent().width() * this.height) / this.width) / this.height);
			this.editor.width(this.width * this.editor_scale);
			$('.image-manager-editor-canvas', this.editor).height(this.height * this.editor_scale);
			$('.image-manager-editor-information .scale', this.editor).text('at '+(Math.round(this.editor_scale * 1000) / 10)+'% scale');
		};
		this.scale_canvas = function () {
			var left  = $('.image-manager-editor-scale .handle', this.editor).position().left;
			var width = $('.image-manager-editor-scale', this.editor).width();
			
			var scale = left / (width / 2);
			this.canvas_scale = scale;
			
			var new_width  = this.canvas_scale * this.img_width;
			var new_height = this.canvas_scale * this.img_height;
			if (new_width < this.width) {
				new_width = this.width;
				scale = this.width / this.img_width;
				this.canvas_scale = scale;
			}
			else if (new_height < this.height) {
				new_height = this.height;
				scale = this.height / this.img_height;
				this.canvas_scale = scale;
			}
			this.set_canvas_scale(scale, true);
			new_width = new_width * this.editor_scale;
			
			this.editor.find('img').width(new_width);
		};
		this.set_canvas_scale = function (scale, end_early) {
			var width = $('.image-manager-editor-scale', this.editor).width() / 2;
			$('.image-manager-editor-scale .handle', this.editor).css('left', scale * width);
			
			if (!end_early) this.scale_canvas();
		};
		this.load_image = function (id, url, width, height) {
			this.manager.parent().find('img').remove();
			this.id 		= id;
			this.img_width  = width;
			this.img_height = height;
			this.manager.append('<input type="hidden" name="'+this.uploader.find('input[type=file]').attr('name')+'" value="'+id+'" />');
			this.editor.find('.image-manager-editor-canvas').append('<img src="'+url+'" />');
			
			var _that = this;
			this.editor.find('img').load(function () {
				_that.set_canvas_scale(1);
				_that.change_mode('editor');
			});
			var pageStartX = pageStartY = imgStartX = imgStartY = null;
			var imgID = (new Date()).getTime() * Math.floor(Math.random()*11);
			$('.image-manager-editor-canvas img', this.editor).mousedown(function (e) {
				pageStartX = e.pageX;
				pageStartY = e.pageY;
				imgStartX = $(this).position().left;
				imgStartY = $(this).position().top;
				
				$(window).bind('mousemove.'+imgID, function (e) {
					var pageX = e.pageX;
					var pageY = e.pageY;
					var diffX = pageX - pageStartX;
					var diffY = pageY - pageStartY;
					
					var x = imgStartX + diffX;
					var y = imgStartY + diffY;
					
					var img_width     = _that.canvas_scale * _that.img_width * _that.editor_scale;
					var img_height    = _that.canvas_scale * _that.img_height * _that.editor_scale;
					var editor_width  = _that.editor_scale * _that.width;
					var editor_height = _that.editor_scale * _that.height;
					var diffWidth     = img_width - editor_width;
					var diffHeight    = img_height - editor_height;
					
					if (x < 0 - diffWidth) {
						x = 0 - diffWidth;
					}
					if (y < 0 - diffHeight) {
						y = 0 - diffHeight;
					}
					
					if (x > 0) x = 0;
					if (y > 0) y = 0;
					
					_that.x = (x * _that.canvas_scale);
					_that.y = (y * _that.canvas_scale);
					
					_that.editor.find('.image-manager-editor-canvas img').css('left', x).css('top', y);
					
					_that.x = _that.x / _that.editor_scale;
					_that.y = _that.y / _that.editor_scale;
				});
				$(window).bind('mouseup.'+imgID, function () {
					$(window).unbind('mouseup.'+imgID);
					$(window).unbind('mousemove.'+imgID);
				});
			});
		};
		this.save = function () {
			if (this.id) {
				$.ajax({
					url: '/admin/images/update/'+this.id,
					type: 'POST',
					data: {
						'image': {
							x: this.x,
							y: this.y,
							width: this.width,
							height: this.height,
							scale: this.canvas_scale
						}
					},
					'success': function (data) {
						window.console.log(data);
					},
					async: false
				});
			}
		};
		
		var _that = this;
		
		/* Initialize */
		this.field.wrap('<div class="image-manager" />');
		this.manager = this.field.parent();
		this.field.wrap('<div class="image-manager-uploader" />');
		this.uploader = $('.image-manager-uploader', this.manager);
		this.uploader.append('<label class="note">image must be at least '+this.width+'x'+this.height+'</label>');
		this.uploader.append('<a href="#" class="remove">delete image</a>');

		this.uploader.find('.remove').click(function() {
			$.get(_that.destroy_url, function() {
				_that.manager.parent().find('img').remove();
				$(this).remove();
			});
			return false;
		});
	
		this.uploader.find('input[type=file]').change(function () {
			var formData = new FormData();
			formData.append('image', _that.uploader.find('input[type=file]').get(0).files[0]);
			$.ajax({
				url: '/admin/images/upload',  //server script to process data
				type: 'POST',
				//Ajax events
				success: function (data) {
					_that.load_image(data.id, data.url, data.width, data.height);
				},
				error: function () {
					alert('failed');
				},
				// Form data
				data: formData,
				//Options to tell JQuery not to process data or worry about content-type
				cache: false,
				contentType: false,
				processData: false
			});
		});
		
		this.editor = $('<div class="image-manager-editor"><div class="image-manager-editor-canvas"><div class="image-manager-editor-scale"><div class="handle"></div></div></div><div class="image-manager-editor-information"><span class="size">'+this.width+'x'+this.height+'</span><span class="scale"></span></div></div>');
		
		var pageStartX = handleStartX = null;
		var handleID = (new Date()).getTime() * Math.floor(Math.random()*11);
		
		$('.image-manager-editor-scale .handle', this.editor).mousedown(function (e) {
			pageStartX = e.pageX;
			handleStartX = $(this).position().left;
			
			$(window).bind('mousemove.'+handleID, function (e) {
				var pageX = e.pageX;
				var diff  = pageX - pageStartX;
				
				var width = $('.image-manager-editor-scale', _that.editor).width();
				var x = handleStartX + diff;
				if (x > width) x = width;
				if (x < 0) x = 0;
				_that.editor.find('.handle').css('left', x);
				_that.scale_canvas();
			})
			$(window).bind('mouseup.'+handleID, function () {
				_that.scale_canvas();
				$(window).unbind('mousemove.'+handleID);
			});
		})
		this.editor.hide().appendTo(this.manager);
		
		this.editor.parents('form').submit(function () {
			_that.save();
		});
		
		this.size_editor();
		$(window).bind('resize', function () {
			_that.size_editor();
		});
	};
	
	$(function () {
		$('input[type=file].image-manager').each(function () {
			window.image_managers.push(new Image_Manager($(this)));
		});
	});
}