<?php $this->load->view('admin/_errors', array('errors' => $page->errors()))?>
<div id="page_variables">
	<fieldset>
		<legend>Page Info</legend>
		<div class="field">
			<?php echo $f->label('name', 'Name:'); ?>
			<?php echo $f->text_field('name'); ?>				
		</div>
		<div class="field">
			<?php echo $f->label('slug', 'Slug:'); ?>
			<?php echo $f->text_field('slug'); ?>				
		</div>
		<?php if ($page->page_id > 0): ?>
			<div class="field">
				<label>Parent Page:</label>
				<input type="text" disabled="true" value="<?=$page->page->name?>" />
			</div>
		<?php elseif($page->persisted() == FALSE): ?>
			<div class="field">
				<?php echo $f->label('page_id', 'Parent Page:'); ?>
				<?php echo $f->select('page_id', $parents); ?>
			</div>
		<?php endif; ?>
		<?php if($page->persisted() == FALSE): ?>
			<div class="field">
				<?php print $f->label('template_id', 'Template:'); ?>
				<?php print $f->select('template_id', $templates); ?>
			</div>
		<?php endif; ?>
	</fieldset>
	<?php $variables = array(); ?>
	<?php if ($page->template_id && $page->template->template_variables->count()): ?>
		<fieldset>
			<legend>Page Variables</legend>
			<?php foreach ($page->template->template_variables->all() as $variable): ?>
				<?php $variables[] = $variable->name; ?>
				<div class="field">
					<label><?=$variable->label?>:</label>
					<?php if ($variable->type == 'string'): ?>
						<input type="text" name="variables[<?=$variable->name?>]" value="<?=($page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value)?>" />
					<?php elseif ($variable->type == 'binary'): ?>
						<textarea type="text" name="variables[<?=$variable->name?>]"><?=($page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value)?></textarea>
					<?php elseif ($variable->type == 'html'): ?>
						<textarea type="text" name="variables[<?=$variable->name?>]" id="variables_<?=$variable->name?>_field"><?=($page->variable($variable->name) !== null ? $page->variable($variable->name) : $variable->value)?></textarea>
						<script type="text/javascript">
						//<![CDATA[
			
							CKEDITOR.replace( 'variables_<?=$variable->name?>_field',
								{
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
									 * Font face
									 */
									// List of fonts available in the toolbar combo. Each font definition is
									// separated by a semi-colon (;). We are using class names here, so each font
									// is defined by {Combo Label}/{Class Name}.
									font_names : 'Comic Sans MS/FontComic;Courier New/FontCourier;Times New Roman/FontTimes',
			
									// Define the way font elements will be applied to the document. The "span"
									// element will be used. When a font is selected, the font name defined in the
									// above list is passed to this definition with the name "Font", being it
									// injected in the "class" attribute.
									// We must also instruct the editor to replace span elements that are used to
									// set the font (Overrides).
									font_style :
									{
											element		: 'span',
											attributes		: { 'class' : '#(family)' }
									},
			
									/*
									 * Font sizes.
									 */
									fontSize_sizes : 'Smaller/FontSmaller;Larger/FontLarger;8pt/FontSmall;14pt/FontBig;Double Size/FontDouble',
									fontSize_style :
										{
											element		: 'span',
											attributes	: { 'class' : '#(size)' }
										} ,
			
									/*
									 * Font colors.
									 */
									colorButton_enableMore : false,
			
									colorButton_colors : 'FontColor1/FF9900,FontColor2/0066CC,FontColor3/F00',
									colorButton_foreStyle :
										{
											element : 'span',
											attributes : { 'class' : '#(color)' }
										},
			
									colorButton_backStyle :
										{
											element : 'span',
											attributes : { 'class' : '#(color)BG' }
										},
			
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
									stylesSet :
											[
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
						//]]>
						</script>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
	<?php 
		$not_used = array();
		foreach ($page->page_variables->all() as $variable) {
			if (!in_array($variable->name, $variables)) {
				$not_used[] = $variable;
			}
		}
	?>
	<?php if (count($not_used)): ?>
		<fieldset>
			<legend>Unavailable Page Variables</legend>
			<?php foreach ($not_used as $variable): ?>
				<div class="field">
					<label><?=$variable->label?>:</label>
					<?php if ($variable->type == 'string'): ?>
						<input type="text" value="<?=$variable->value?>" />
					<?php elseif ($variable->type == 'binary'): ?>
						<textarea type="text"><?=$variable->value?></textarea>
					<?php elseif ($variable->type == 'html'): ?>
						<textarea type="text" class="ckeditor"><?=$variable->value?></textarea>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
</div>
<div id="sidebar">
	<h2>Modules</h2>
	<!--
	<div class="field checkbox"><input type="checkbox" name="page_[modules][seo]" value="1" checked="checked" disabled="disabled" /> <label for="" class="disabled">SEO</label></div>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][articles]" value="1" checked="checked" disabled="disabled" /> <label for="" class="disabled">Articles</label></div>
	<div class="field checkbox"><input type="checkbox" name="page_[modules][googleanalytics]" value="1" /> <label for="">Google Analytics</label></div>
	//-->
	<?php foreach ($this->module_model->all() as $module): ?>
		<div class="field checkbox"><input type="checkbox" name="modules[<?=$module->id?>]" value="1" <?=($page->page_modules->exists(array('module_id' => $module->id)) ? 'checked="checked"' : '')?> /> <label for=""><?=$module->name?></label></div>
	<?php endforeach; ?>
</div>
<div class="actions">
	<?php echo submit_tag(); ?> or <a href="<?php echo site_url('admin/pages'); ?>">cancel</a>
</div>