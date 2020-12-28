jQuery(function($) {
	var wcdb = {

		// keep a reference to the last selected Dropbox button
		lastSelectedButton: false,

		// options for the file chooser dialog
		options: {
			success: function(files) {
				wcdb.afterFileSelected(files);
			},
			linkType: 'preview',
			multiselect: true
		},

		/**
		 * Kick-off WCDB javascript. Check browser compatibility,
		 * add Choose from Dropbox buttons and attach event handlers.
		 */
		init: function() {
			if(!this.checkBrowserSupport()) {
				return;
			}

			// add button for simple product
			this.addButtons();
			this.addButtonEventHandler();

			// add buttons when variable product added
			$('#variable_product_options').on('woocommerce_variations_added', function() {
				wcdb.addButtons();
				wcdb.addButtonEventHandler();
			});

			// add buttons when variable products loaded
			$('#woocommerce-product-data').on('woocommerce_variations_loaded', function() {
				wcdb.addButtons();
				wcdb.addButtonEventHandler();
			});
		},

		/**
		 * Check if Dropbox is included in the page and if the current browser
		 * is ssupports Dropbox funcionality
		 * @return {bool}
		 */
		checkBrowserSupport: function() {
			return (typeof Dropbox !== 'undefined') && Dropbox.isBrowserSupported();
		},

		addButtons: function() {
			var button = $('<button type="button" class="button insert-dropbox">' + woocommerce_dropbox_translation.choose_from_dropbox + '</button>');

			$('.downloadable_files').each(function(index) {

				// we want our button to appear next to the insert button
				var insertButton = $(this).find('a.button.insert');

				// check if dropbox button already exists on element, bail if so
				if($(this).find('button.button.insert-dropbox').length) {
					return;
				}

				// finally clone the button to the right place
				insertButton.after(button.clone());
			});
		},

		/**
		 * Adds the click event to the dropbox buttons
		 * and opens the Dropbox chooser
		 */
		addButtonEventHandler: function() {
			$('button.button.insert-dropbox').on('click', function(e) {
				e.preventDefault();

				// save a reference to clicked button
				wcdb.lastSelectedButton = $(this);

				// open file chooser
				Dropbox.choose(wcdb.options);
			});
		},

		/**
		 * Handle selected files
		 */
		afterFileSelected: function(files) {
			var table = $(wcdb.lastSelectedButton).closest('.downloadable_files').find('tbody');
			var template = $(wcdb.lastSelectedButton).prev('.button.insert').data('row');
			var isVariableProduct = template.includes('_wc_variation_file');

			_.each(files, function(file) {
				var fileRow = $(template);
				var searchKey = isVariableProduct ? '_wc_variation_file' : '_wc_file';
				var fileNameInput = fileRow.find('.file_name > input[name^="' + searchKey + '_names"]');
				var fileUrlInput = fileRow.find('.file_url > input[name^="' + searchKey + '_urls"]');

				if (fileNameInput.length === 0 || fileUrlInput.length === 0) {
					throw new Error('Could not find input fields');
				}

				fileNameInput.val(file.name).change();
				fileUrlInput.val(file.link.replace('dl=0', 'dl=1'));

				table.append(fileRow);
			});

			// trigger change event so we can save variation
			$(table).find('input').last().change();
		},
	};

	wcdb.init();
});
