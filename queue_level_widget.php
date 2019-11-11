<?php
/**
* Plugin Name: Queue Level Widget
* Plugin URI:
* Description: Creates sidebar widget that will display queue level dial
* Version: 1.0
* Author: Nick Green
* Author URI:
**/

function queue_level_load_widget() {
  register_widget( 'queue_level_widget' );
}
add_action( 'widgets_init', 'queue_level_load_widget' );

class queue_level_widget extends WP_Widget {
  // Initialize Widget with Options
  public function __construct() {
      parent::__construct(
          'queue_level_widget',
          'Queue Level Widget',
          array(
              'classname'   => 'queue-level-widget',
              'description' => 'Display Queue Level Dial'
          )
      );
  }

  // Widget Front End
  public function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );
      echo $before_widget;
      /* Widget Content Below */
      if ( ISSET($level) ) {
          echo "<img alt='" . $level . "' src='" . plugins_url( 'img/' . $level . '.png' , __FILE__ ) . "' style='max-width:100%;'>";
      } else {
        echo "No queue level set.";
      }
      /* Widget Content Above */
      echo $after_widget;
  }

  // Widget Admin Form
  public function form( $instance ) { ?>
      <?php extract( $instance );
      if ( ! ISSET($level) ) {
        $level = 'low';
      } ?>
      <?php echo "<img alt='" . $level . "' src='" . plugins_url( 'img/' . $level . '.png' , __FILE__ ) . "' style='max-width:100%;'>"; ?>
      <p>
          <label>
              <input type="radio" value="low" name="<?php echo $this->get_field_name( 'level' ); ?>" <?php checked( $level, 'low' ); ?> id="<?php echo $this->get_field_id( 'level' ); ?>" />
              <?php esc_attr_e( 'Low', 'text_domain' ); ?>
          </label>
      </p>
      <p>
          <label>
              <input type="radio" value="moderate" name="<?php echo $this->get_field_name( 'level' ); ?>" <?php checked( $level, 'moderate' ); ?> id="<?php echo $this->get_field_id( 'level' ); ?>" />
              <?php esc_attr_e( 'Moderate', 'text_domain' ); ?>
          </label>
      </p>
      <p>
          <label>
              <input type="radio" value="high" name="<?php echo $this->get_field_name( 'level' ); ?>" <?php checked( $level, 'high' ); ?> id="<?php echo $this->get_field_id( 'level' ); ?>" />
              <?php esc_attr_e( 'High', 'text_domain' ); ?>
          </label>
      </p>
      <p>
          <label>
              <input type="radio" value="very_high" name="<?php echo $this->get_field_name( 'level' ); ?>" <?php checked( $level, 'very_high' ); ?> id="<?php echo $this->get_field_id( 'level' ); ?>" />
              <?php esc_attr_e( 'Very High', 'text_domain' ); ?>
          </label>
      </p>
  <?php }

  // Sanitize and Save Options
  public function update( $new_instance, $old_instance ) {
      extract( $new_instance );
      $instance = array();

      $instance['level'] = ( !empty( $level ) ) ? sanitize_text_field( $level ) : null;

      return $instance;
  }
}
