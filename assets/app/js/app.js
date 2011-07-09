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
			coreStyles_bold	: { element : 'span', attributes : {'class': 'Bold'} },
			coreStyles_italic	: { element : 'span', attributes : {'class': 'Italic'}},
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

$(function () {
	$('.destroy, .delete').click('click', function() {
		var answer = confirm('Are you sure?');
		
		if ( answer == true )
		{
			location.href=$(this).attr('href');
		}
		
		return false;
	});
});