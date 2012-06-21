var activateHTMLFields = function () {
	$('.wysiwyg').each(function () {
		CKEDITOR.replace( $(this).attr('id'), {
			toolbar :
			[
				[ 'Bold', 'Italic', '-', 'Styles', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', 'PasteFromWord', 'Source' ],
				[ 'UIColor' ]
			],
			/*
			 * Style sheet for the contents
			 */
			contentsCss : '/assets/app/js/ckeditor/xhtml.css',
			
			/*
			 * Core styles.
			 */
			coreStyles_bold	: { element : 'strong' },
			coreStyles_italic	: { element : 'em'},
			coreStyles_underline	: { element : 'span', attributes : {'class': 'Underline'}},
			coreStyles_strike	: { element : 'span', attributes : {'class': 'StrikeThrough'}, overrides : 'strike' },
			
			coreStyles_subscript : { element : 'span', attributes : {'class': 'Subscript'}, overrides : 'sub' },
			coreStyles_superscript : { element : 'span', attributes : {'class': 'Superscript'}, overrides : 'sup' },
			
			/*
			 * Indentation.
			 */
			indentClasses : ['Indent1', 'Indent2', 'Indent3'],
			
			/*
			 * Paragraph justification.
			 */
			justifyClasses : [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyFull' ],
			
			/*
			 * Styles combo.
			 */
			stylesSet : [
				{ name : 'H1', element : 'h1'},
				{ name : 'H2', element : 'h2'},
				{ name : 'H3', element : 'h3'},
				{ name : 'H4', element : 'h4'},
				{ name : 'H5', element : 'h5'},
				{ name : 'H6', element : 'h6'}
			]
		});
	});
};

var repeatables = {
	init: function () {
		$('fieldset.repeatable').sortable({
			items: '.repeatable_block',
			handle: /iPad/.test( navigator.userAgent ) ? false : '.repeatable_buttons_drag',
			opacity: 0.8,
			tolerance: 'pointer',
			axis: 'y',
			stop: function(event, ui) {
				ui.item.effect('highlight', 500);
				repeatables.updateIndexes();
			}
		});
		$('.repeatable_block').each(function () {
			$(this).append('<div class="repeatable_buttons"><a href="#" class="repeatable_buttons_add">Add</a><a href="#" class="repeatable_buttons_drag">Drag</a><a href="#" class="repeatable_buttons_remove">Remove</a></div>');
			
			$(this).find('.repeatable_buttons_add').click(function () {
				var block = $(this).parent().parent();
				repeatables.duplicate(block);
				return false;
			});
			$(this).find('.repeatable_buttons_drag').click(function () {
				return false;
			});
			$(this).find('.repeatable_buttons_remove').click(function () {
				var block = $(this).parent().parent();
				repeatables.remove(block);
				return false;
			});
		});
	},
	duplicate: function (block) {
		var clone = block.clone(true);
		clone.find('input[type=hidden].remove_on_clone').remove();
		clone.find('.view_file').remove();
		clone.insertAfter(block).effect('highlight', 1000);
		
		$('input[type=file].image-manager', clone).each(function () {
			window.image_managers.push(new Image_Manager($(this)));
		});
		
		this.updateIndexes();
	},
	remove: function (block) {
		var answer = confirm('Are you sure?');
		
		if (answer == true) {
			var hidden = block.find('input[type=hidden].remove_on_clone');
			hidden.val(hidden.val()+'_remove');
			hidden.appendTo('#page_form');
			block.remove();
			
			this.updateIndexes();
		}
	},
	updateIndexes: function () {
		var repeatable = $('fieldset.repeatable');
		repeatable.each(function () {
			var blocks = $('.repeatable_block', this);
			var index  = 0;
			blocks.each(function () {
				var i 		= $(this).attr('data-index'),
					name 	= $(this).attr('data-name');
				
				var fields 	= $(this).find('select, input[type=text], input[type=file], input[type=hidden], textarea, span.cke_skin_kama, label');
				fields.each(function () {
					if ($(this).get(0).nodeName.toLowerCase() == 'label') {
						var field_for = $(this).attr('for');
						$(this).attr('for', field_for.replace('variables_'+name+'_'+i+'_', 'variables_'+name+'_'+index+'_'));
					}
					else if ($(this).get(0).nodeName.toLowerCase() == 'span') {
						
					}
					else {
						var field_name = $(this).attr('name');
						$(this).attr('name', field_name.replace('variables['+name+']['+i+']', 'variables['+name+']['+index+']'));
						
						var field_id = $(this).attr('id');
						if (field_id) {
							$(this).attr('id', field_id.replace('variables_'+name+'_'+i+'_', 'variables_'+name+'_'+index+'_'));
						}
					}
				});
				
				$(this).attr('data-index', index);
				
				index++;
			});
		});
	}
};

function activateToolTips () {
	$('.field[data-help]').each(function () {
		$(this).find('label').eq(0).append(' <div class="tooltip-help"><span class="icon">help</span> <span class="tooltip">'+$(this).attr('data-help')+'</span></div>');
	});
}

$(function () {
	$('.destroy, .delete').click('click', function() {
		var answer = confirm('Are you sure?');
		
		if ( answer == true )
		{
			location.href=$(this).attr('href');
		}
		
		return false;
	});
	
	if ($('.repeatable_block').size()) {
		repeatables.init();
	}
	
	activateHTMLFields();
	
	activateToolTips();
});