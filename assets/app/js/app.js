var activateHTMLFields = function () {
	$('.wysiwyg').each(function () {
		CKEDITOR.replace( $(this).attr('id'), {
			toolbar :
			[
				[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', 'Source' ],
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
				{ name : 'Strong Emphasis', element : 'strong' },
				{ name : 'Emphasis', element : 'em' },
			
				{ name : 'Computer Code', element : 'code' },
				{ name : 'Keyboard Phrase', element : 'kbd' },
				{ name : 'Sample Text', element : 'samp' },
				{ name : 'Variable', element : 'var' },
			
				{ name : 'Deleted Text', element : 'del' },
				{ name : 'Inserted Text', element : 'ins' },
			
				{ name : 'Cited Work', element : 'cite' },
				{ name : 'Inline Quotation', element : 'q' }
			]
		});
	});
};

var repeatables = {
	init: function () {
		$('fieldset.repeatable').sortable({
			items: '.repeatable_block',
			handle: '.repeatable_buttons_drag',
			opacity: 0.8,
			//tolerance: 'pointer',
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
		clone.find('input[type=hidden]').remove();
		clone.insertAfter(block).effect('highlight', 1000);
		
		this.updateIndexes();
	},
	remove: function (block) {
		var answer = confirm('Are you sure?');
		
		if (answer == true) {
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
				
				var fields 	= $(this).find('select, input[type=text], textarea, span.cke_skin_kama, label');
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
						$(this).attr('id', field_id.replace('variables_'+name+'_'+i+'_', 'variables_'+name+'_'+index+'_'));
					}
				});
				
				$(this).attr('data-index', index);
				
				index++;
			});
		});
	}
};

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
});