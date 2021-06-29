<?php

class Custom_Taxonomy_Select extends \Elementor\Base_Data_Control {

	public function get_type()
	{
		return 'custom-taxonomy-select';
	}

	public function enqueue()
	{
		wp_enqueue_style( 'select2', get_stylesheet_directory_uri() . '/css/elementor/select2.css', '1.0.0' );
		wp_enqueue_script( 'taxonomy-select', get_stylesheet_directory_uri() . '/js/elementor/taxonomy-select.js', array( 'jquery'), '', true );
	}

	protected function get_default_settings() {
		return array(
			'label_block' => true,
			'args'        => array(), // arguments passed to WP_Query in custom_terms_query().
			'options'     => array(),
			'callback'    => '',
		);
	}

	public function content_template()
	{
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title" for="<?php echo $control_uid; ?>">{{data.label}}</label>

			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# let args = JSON.stringify( data.args ); #>
				<select id="<?php echo $control_uid; ?>" class="taxonomy-select elementor-select2" type="select2" data-args="{{args}}">
					<# if ( data.controlValue ) { #>
					<option selected value="{{ data.controlValue.id }}">{{{ data.controlValue.name }}}</option>
					<# } #>
				</select>

				<input class="taxonomy-select-save-value" data-setting="{{data.name}}" type="hidden" />
			</div>
		</div>

		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
