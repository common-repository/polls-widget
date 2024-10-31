<?php 

/*############ WIDGET CLASS ##################*/
class poll_widget extends WP_Widget {
	public $poll_front_end_duble;

	// Constructor //	
	function __construct() {		
		$widget_ops = array( 'classname' => 'poll_widget', 'description' => 'Add unlimited polls to your widget' ); // Widget Settings
		$control_ops = array( 'id_base' => 'poll_widget' ); // Widget Control Settings
		parent::__construct( 'poll_widget', 'Polls', $widget_ops, $control_ops ); // Create the widget
	}

	/*############ Front end function ##################*/
	function widget($args, $instance) {
		extract( $args );
		global $poll_front_end;
		$title = esc_html($instance['title']);
		$poll_answer_id = esc_html($instance['poll_id']);
		$poll_design_id = esc_html($instance['poll_theme_id']);
		// Before widget //
		echo $before_widget;
		
		// Title of widget //
		if ( $title ) { echo $before_title . esc_html($title) . $after_title; }
		global $front_end;
		// Widget output //
		echo $poll_front_end->generete_front_end_single_poll($poll_answer_id,$poll_design_id);
		// After widget //
		
		echo $after_widget;
	}

    /*############  Update function  ################*/	
	
		function update($new_instance, $old_instance) {
			
		$instance['title']	= esc_html(strip_tags($new_instance['title']));   // Title
		$instance['poll_id']	= esc_html($new_instance['poll_id']); // Polls answer
		$instance['poll_theme_id']	= esc_html($new_instance['poll_theme_id']); // Post quantity
		return $instance;  /// Return new value of parameters
		
	}

    /*############ Form function ##################*/
	
	function form($instance) {
		global $wpdb;
		$defaults = array( 'title' => '', 'poll_id' => '0', 'poll_theme_id' => '0');
		$instance = wp_parse_args( (array) $instance, $defaults );
		$poll_answers=$wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'polls_question');
		$poll_themes=$wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'polls_templates');
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		<table width="100%" class="paramlist admintable" cellspacing="1">
            <tbody>
                <tr>
                    <td class="paramlist_key">
                    	<span class="editlinktip">
                        	<label style="font-size:14px" id="paramsstandcatid-lbl" for="Category" class="hasTip">Select Poll: </label>
                        </span>
                    </td>
                    <td class="paramlist_value" >
                    <select name="<?php echo $this->get_field_name('poll_id'); ?>" id="<?php echo $this->get_field_id('poll_id') ?>" style="font-size:12px;width:100%" class="inputbox">
                    <option value="0">Select poll</option>
                    <?php                    
                    foreach($poll_answers as $poll_answer)
                    {
                       ?><option value="<?php echo $poll_answer->id?>" <?php selected($instance['poll_id'],$poll_answer->id); ?>><?php echo $poll_answer->name ?></option><?php
                    }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td class="paramlist_key">
                    	<span class="editlinktip">
                        	<label style="font-size:14px" id="paramsstandcatid-lbl" for="Category" class="hasTip">Select Poll Theme: </label>
                        </span>
                    </td>
                    <td class="paramlist_value" >
                    <select name="<?php echo $this->get_field_name('poll_theme_id'); ?>" id="<?php echo $this->get_field_id('poll_theme_id') ?>" style="font-size:12px;width:100%" class="inputbox">
                    <option value="0">Select poll theme</option>
                    <?php                    
                    foreach($poll_themes as $poll_theme)
                    {                 
                        ?><option value="<?php echo $poll_theme->id?>" <?php selected($instance['poll_theme_id'],$poll_theme->id); ?>><?php echo $poll_theme->name ?></option><?php                        
                    }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td><br /></td>
                </tr>
            </tbody>
		</table>
		<?php 
	}
}

