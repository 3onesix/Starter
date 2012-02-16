function StarterEditable(el) {
	this.el = el;
	this.variable = this.el.attr('data-variable');
	var editable = this;
	
	this.el.addClass('starter_editable');
	this.el.append('<a href="#" class="starter_editable_launch">edit</a>');
	
	this.el.click(function () {
		editable.show();
	});
	
	this.show = function () {
		var editor = $('<div id="starter_frontend_editor"><form method="post" action="/admin/pages/update/'+starter_page_id+'"></form></div>');
		editor.hide();
		$('body').prepend(editor);
		
		$.ajax('/admin/pages/edit/'+starter_page_id+'/'+this.variable, {'success': function (data) {
			editor.find('form').append(data);
			editor.find('form').append('<input type="submit" value="Save" /> or <a href="#" id="starter_frontend_editor_cancel">cancel</a>');
			editor.slideDown();
			editor.find('#starter_frontend_editor_cancel').click(function () {
				editor.slideUp(function () {
					editor.remove();
				});
				return false;
			});
		}});
	};
}

$(function () {
	var editables = $('[data-variable]');
	editables.each(function () {
		new StarterEditable($(this));
	});
});