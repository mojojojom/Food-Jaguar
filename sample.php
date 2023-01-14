<?php
add_shortcode('table_code', function() {
	ob_start();
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	
	$args = [
		'post_type'				=>		array('clinic-directory'),
		'nopaging'				=>		false,
		'posts_per_page'		=>		20,
		'ignore_sticky_posts'	=>		false,
		'paged' => $paged
	];
	
	$loop = new WP_Query($args);
	
?>
<div id="clinic__list-container">
	<table class="clinic__table" id="clinics-table">
			<thead>
				<tr>
					<th>Website</th>
					<th class="mobileP-hidden">First Name</th>
					<th class="mobileP-hidden">Last Name</th>
					<th>Clinic Name</th>
					<th class="mobileT-hidden">Address</th>
					<th class="mobileT-hidden">Contact Number</th>
					<th>Area of Expertise</th>
					<th class="mobileT-hidden">Book an Appointment</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($loop->have_posts()) {
					while($loop->have_posts()) {
						$loop->the_post();
						
						$link = get_field('website');
				?>
						<tr>
							<th class="clinic__data clinic__site-link"><span class="table__link-wrap"><span class="dashicons dashicons-admin-site-alt3 clinic__modal-trigger" data-c-val="<?= the_ID(); ?>"></span>&nbsp;<a class="tdata_clinic_website" href="<?= esc_url($link) ?>"><?=get_field('website')?></a></span></th>
							<th class="clinic__data mobileP-hidden"><p class="tdata_first_name"><?=get_field('first_name')?></p></th>
							<th class="clinic__data mobileP-hidden"><p class="tdata_last_name"><?=get_field('last_name')?></p></th>
							<th class="clinic__data"><p class="clinic__cname tdata_clinic_name"><?=get_field('clinic_name')?></p></th>
							<th class="clinic__data mobileT-hidden"><p class="tdata_clinic_address"><?=get_field('address')?></p></th>
							<th class="clinic__data mobileT-hidden"><p class="tdata_clinic_contact"><?=get_field('contact_number')?></p></th>
							<th class="clinic__data"><p class="clinic__aoe clinic_aoe"><?=get_field('areas_of_expertise')?></p></th>
							<th class="clinic__data mobileT-hidden"><button type="button" class="clinic__book-now-btn">BOOK NOW</button></th>
						</tr>
				<?php
					}
				} else {
					?>
					<tr>
						<th class="clinic__no-data">NO DATA AVAILABLE</th>
					</tr>
				<?php
					}
				?>
				
			</tbody>
		</table>

		<?php
			$big = 99999999999;
	
			$pagination = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'prev_text' => __('&laquo;'),
			'next_text' => __('&raquo;'),
			'total' =>  $loop->max_num_pages
			));
		?>
		<div id="clinic-table-paginate">
			
			<?= $pagination;?>
		
		</div>
</div>

<?php
return ob_get_clean();
});

add_action('wp_footer', function () {
	$id = "test_id";

  ?>
<script>
	jQuery(function($){
		
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		
		$(document).on('keyup', '#searchclinic', function(e) {
			
			$.ajax({
				
				type: 'POST',
				url: ajaxurl,
				data: {
					
					location: $(this).val(),
					action: 'clinic_filter_search'
					
				},
				success: function(response) {
					$('#clinic__list-container').empty().html(response);
				}
				
			})
			
		})
		
	})
</script>
  <?php
});



add_action('wp_ajax_clinic_filter_search', 'clinic_filter_search');
add_action('wp_ajax_nopriv_clinic_filter_search', 'clinic_filter_search');


function clinic_filter_search(){
	
	$args = [
		'post_type'				=>		array('clinic-directory'),
		'nopaging'				=>		false,
		'posts_per_page'		=>		20,
		'ignore_sticky_posts'	=>		false,
		'meta_query'    => array(
			array(
				'key'       => array('website','first_name','last_name','clinic_name','address', 'contact_number', 'areas_of_expertise'),
				'value'     => $_POST['location'],
				'compare'   => 'LIKE'
			),
		)
	];
	
	$loop = new WP_Query($args);
	
?>
<table class="clinic__table" id="clinics-table">
			<thead>
				<tr>
					<th>Website</th>
					<th class="mobileP-hidden">First Name</th>
					<th class="mobileP-hidden">Last Name</th>
					<th>Clinic Name</th>
					<th class="mobileT-hidden">Address</th>
					<th class="mobileT-hidden">Contact Number</th>
					<th>Area of Expertise</th>
					<th class="mobileT-hidden">Book an Appointment</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($loop->have_posts()) {
					while($loop->have_posts()) {
						$loop->the_post();
						
						$link = get_field('website');
				?>
						<tr>
							<th class="clinic__data clinic__site-link"><span class="table__link-wrap"><span class="dashicons dashicons-admin-site-alt3 clinic__modal-trigger" data-c-val="<?= the_ID(); ?>"></span>&nbsp;<a href="<?= esc_url($link) ?>"><?=get_field('website')?></a></span></th>
							<th class="clinic__data mobileP-hidden"><p><?=get_field('first_name')?></p></th>
							<th class="clinic__data mobileP-hidden"><p><?=get_field('last_name')?></p></th>
							<th class="clinic__data"><p class="clinic__cname"><?=get_field('clinic_name')?></p></th>
							<th class="clinic__data mobileT-hidden"><p><?=get_field('address')?></p></th>
							<th class="clinic__data mobileT-hidden"><p><?=get_field('contact_number')?></p></th>
							<th class="clinic__data"><p class="clinic__aoe"><?=get_field('areas_of_expertise')?></p></th>
							<th class="clinic__data mobileT-hidden"><button type="button" class="clinic__book-now-btn">BOOK NOW</button></th>
						</tr>
				<?php
					}
				} else {
					?>
					<tr>
						<th class="clinic__no-data">NO DATA AVAILABLE</th>
					</tr>
				<?php
					}
				?>
				
			</tbody>
		</table>
		<?php
			$big = 99999999999;
	
			$pagination = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $_POST['page'] ),
			'prev_text' => __('&laquo;'),
			'next_text' => __('&raquo;'),
			'total' =>  $loop->max_num_pages
			));
		?>
		<div id="clinic-table-paginate">
			
			<span><?= $pagination;?></span>
		
		</div>

<?php
	wp_die();
}
