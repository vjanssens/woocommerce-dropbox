jQuery(document).ready(function($){

	if(typeof Dropbox === 'object') {
		var rawTemplate = '<tr>' +
							'<td class="sort"></td>' +
							'<td class="file_name"><input type="text" class="input_text" placeholder="<%= translation_filename %>" name="_wc_file_names[]" value="<%= filename %>"></td>' +
							'<td class="file_url"><input type="text" class="input_text" placeholder="<%= translation_url %>" name="_wc_file_urls[]" value="<%= fileurl %>"></td>' +
							'<td class="file_url_choose" width="1%"><a href="#" class="button upload_file_button" data-choose="<%= translation_choosefile %>" data-update="<%= translation_insertfileurl %>"><%= translation_choosefile %></a></td>' +
							'<td width="1%"><a href="#" class="delete"><%= translation_delete %></a></td>' +
						  '</tr>',
			tmpl = _.template(rawTemplate),
			options = {
				success: function (files) {
					$.each(files, function(key, file){
						var compiled = tmpl({
							filename: file.name,
							fileurl: file.link.replace('dl=0', 'dl=1'),

							translation_filename: woocommerce_dropbox_translation.filename,
							translation_url: woocommerce_dropbox_translation.url,
							translation_choosefile: woocommerce_dropbox_translation.choosefile,
							translation_choosefilebutton: woocommerce_dropbox_translation.choosefilebutton,
							translation_insertfileurl: woocommerce_dropbox_translation.insertfileurl,
							translation_delete: woocommerce_dropbox_translation.delete
						});
						$(compiled).appendTo('.downloadable_files .ui-sortable');
					});
				},

				linkType: "preview",
				multiselect: true
			};

		// create our button
		var button = Dropbox.createChooseButton(options);

		// insert the Choose from Dropbox button
		$('.downloadable_files .button.insert').after(button);

		// add some extra styling
		$(button).css({margin: '3px 10px 0 0', float: 'right'});
	}
});