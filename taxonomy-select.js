
var taxonomySelectControl = elementor.modules.controls.BaseData.extend( {

	onReady: function() {

		$    = jQuery;
		self = this;

		// Save relevant elements.
		this.control_select = this.$el.find( '.taxonomy-select' );
		this.save_input     = this.$el.find( '.taxonomy-select-save-value' );
		let args            = JSON.parse( this.control_select.attr( 'data-args' ) );

		// Setup select2.
		this.control_select.select2({
			placeholder: 'Search...',
			ajax: {
				url: ajaxurl + '?action=custom_terms_query',
				method: 'POST',
				dataType: 'json',
				delay: 250,
				cache: true,
				data: function( params ) {
					// get_terms() arguments.
					// See https://developer.wordpress.org/reference/classes/wp_term_query/__construct/.
					args.search = params.term;
					return args;
				},
				processResults: function( data ) {
					return {
						results: data.results,
						pagination: data.pagination,
					}
				}
			}
		});

		// Add event listener to save value on each change.
		this.control_select.on( 'change', () => {
			this.saveValue();
		});
	},

	saveValue: function() {
		// We use built in function this.setValue
		if ( this.control_select.val() ) {
			this.setValue({
				id: this.control_select.val(),
				name: this.control_select.select2('data')[0].text
			});
		}
	},

	// Before we leave, or collapse our control, we wanna save our value.
	onBeforeDestroy: function() {
		this.saveValue();
		this.$el.find( '.taxonomy-select' ).select2( 'destroy' );
		this.$el.remove();
	},

});

// Register control with elementor js api.
elementor.addControlView( 'custom-taxonomy-select', taxonomySelectControl );
