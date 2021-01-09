<?php
class ElementorLWIHPlugin extends \Elementor\Widget_Base {

	public function get_name() {
		return 'LWIHWidget';
    }
    
	public function get_title() {
		return __( 'LWIHWidget', 'elementor-LWIH-plugin' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return array('basic', 'testcategory');
	}

	protected function _register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'elementor-LWIH-plugin' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
        );

        
		
		$this->end_controls_section();

	}

	protected function render(){
		$settings = $this->get_settings_for_display();
		
	}

	protected function _content_template(){
		?>
			
		<?php
	}

}

