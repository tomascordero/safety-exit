<?php


class Lib_Calendar_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'lib_calendar',
			'description' => 'A Calendar Widget',
		);
		// add_action('wp_ajax_lib_calendar_getImages', array(&$this, 'getLibGalleryImages'));

		parent::__construct( 'lib_calendar', 'LiB Calendar', $widget_ops );
	}

	public function cmp($a, $b){
		return strcmp($a->order, $b->order);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		$startDate = !empty($instance['startDate']) ? $instance['startDate'] : '';
		$endDate = !empty($instance['endDate']) ? $instance['endDate'] : '';

		wp_enqueue_style( 'lib-calendar_frontend' );
		wp_enqueue_script('lib-calendar_frontend');
		// print_r(date_parse($startDate)['month']);
		$parsedStartDate = date_parse($startDate);
		$parsedEndDate = date_parse($endDate);
		$objDate = DateTime::createFromFormat('!m', $parsedStartDate['month']);
		$monthName = $objDate->format('F');
		// print_r($parsedStartDate['day']);
		// print_r($parsedEndDate['day']);
		?>
		<script>
			$(function () {
				$('.lib-calendar').html(displayCalendar(['<?php echo $startDate; ?>', '<?php echo $endDate; ?>']));
			})
		</script>
		<div class="lib-calendar-header-block">
			<p class="title">
				Event Dates<br/>
				<?php echo $parsedStartDate['year']; ?>
			</p>
			<p class="dates">
				<?php echo $monthName; ?> <?php echo $parsedStartDate['day']; ?> - <?php echo $parsedEndDate['day']; ?>
			</p>
		</div>
		<div class="lib-calendar"></div>
		<?php

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$startDate = !empty($instance['startDate']) ? $instance['startDate'] : '';
		$endDate = !empty($instance['endDate']) ? $instance['endDate'] : '';
		$uniqueID = uniqid();
		wp_enqueue_script( 'lib-calendar_jqueryui' );
		wp_enqueue_style( 'lib-calendar_jqueryui' );
		?>
		<script>
			$(function(){
				$('#lib_calendar_form_<?php echo $uniqueID; ?> #libCalendarStartDate, #lib_calendar_form_<?php echo $uniqueID; ?> #libCalendarEndDate').datepicker({
					showOn: "both",
					beforeShow: customRange,
					dateFormat: "mm/dd/yy",
				});
			})
			function customRange(input) {

				if (input.id == 'libCalendarEndDate') {
					var minDate = new Date($('#lib_calendar_form_<?php echo $uniqueID; ?> #libCalendarStartDate').val());
					minDate.setDate(minDate.getDate() + 1)

					return {
						minDate: minDate

					};
				}

				return {}

			}
		</script>
		<div id="lib_calendar_form_<?php echo $uniqueID; ?>" class="lib_calendar_form_container grid-container">
			<div class="grid-x grid-padding-x">
				<div class="cell">
					<h3>Please select the start and end dates of the event.</h3>
				</div>
				<div class="cell medium-6">
					<label>Start Date
						<input type="text" id="libCalendarStartDate" name="<?php echo $this->get_field_name('startDate'); ?>" value="<?php echo $startDate; ?>" placeholder="Start Date" />
					</label>
				</div>
				<div class="cell medium-6">
					<label>End Date
						<input type="text" id="libCalendarEndDate" name="<?php echo $this->get_field_name('endDate'); ?>" value="<?php echo $endDate; ?>" placeholder="End Date" />
					</label>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['startDate'] = ( ! empty( $new_instance['startDate'] ) ) ? strip_tags( $new_instance['startDate'] ) : '';
		$instance['endDate'] = ( ! empty( $new_instance['endDate'] ) ) ? strip_tags( $new_instance['endDate'] ) : '';

		return $instance;
	}


}