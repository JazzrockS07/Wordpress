<?php

require_once __DIR__.'/vendor/autoload.php';

/**
 * Change number of products that are displayed per page (shop page)
 */

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
	// $cols contains the current number of products per page based on the value stored on Options -> Reading
	// Return the number of products you wanna show per page.
	$cols = 500;
	return $cols;
}

function misha_print_all_fields ($fields)  {

	// if (! current_user_can ('manage_options'))
	// return; // если ваш сайт работает

	echo '<pre>'.print_r($fields,1).'</pre>' ; // оборачиваем результаты в тег pre html, чтобы сделать его более понятным
	exit;

}

// WooCommerce Change Checkout Fields
add_filter( 'woocommerce_checkout_fields' , 'custom_change_wc_checkout_fields' );

// Change label text and add JS
function custom_change_wc_checkout_fields( $fields ) {
	$fields['billing']['billing_first_name']['custom_attributes']['onblur'] = 'onblur_first_name()';
	$fields['billing']['billing_last_name']['custom_attributes']['onblur'] = 'onblur_last_name()';
	$fields['billing']['billing_state']['label'] = 'State';
	$fields['billing']['billing_state']['custom_attributes']['onblur'] = 'onblur_location()';
	return $fields;
}

add_action( 'wp_footer', 'misha_checkout_js' );
function misha_checkout_js(){

	// we need it only on our checkout page
/*	if( !is_checkout() ) return;

	?>
	<script xmlns="http://www.w3.org/1999/html">
			function onblur_first_name() {
				var y = document.getElementById("my_field_first_name").value;
				var x = document.getElementById("1").value;
				if (y === "") {
					document.getElementById("my_field_first_name").value = x;
				}
			}
			function onblur_last_name() {
				var y = document.getElementById("my_field_last_name").value;
				var x = document.getElementById("2").value;
				if (y === "") {
					document.getElementById("my_field_last_name").value = x;
				}
			}
			function onblur_location() {
				var y = document.getElementById("my_field_location").value;
				var x = document.getElementById("10").value;
				if (y === "") {
					document.getElementById("my_field_location").value = x;
				}
			}
	</script>
	<?php
*/

	//we need it only on our product page
	if (!is_product() ) return;

	?>

	<script type="text/javascript">
		function countChar(val) {
			var len = val.value.length;
			if (len > 150) {
				val.value = val.value.substring(0, 150);
			} else {
				$('#left').text(" left ");
				$('#charNum').text(150 - len);
				$('#symbols').text(" symbols");
			}
		}
	</script>
	<script type="text/javascript">
		function escapeHtml(text) {
			return text
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}
		function view_comment() {
			var comment = $('#pr-field').val().replace(/([^>])\n/g, '$1<br/>');
			document.getElementById("image-comment").innerHTML = escapeHtml(comment);
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
		}

		function view_name() {
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
			var fname = escapeHtml($('#pr-field-first-name').val());
			var lname = escapeHtml($('#pr-field-last-name').val());
			var how = escapeHtml($('#pr-field-how').val());
			if (fname ||lname) {
				if (how === 'Full') {
					document.getElementById("image-name").innerHTML = fname+' '+lname;
				} else if (how === 'First') {
					document.getElementById("image-name").innerHTML = fname+' '+lname.substring(0,1)+'.';
				} else if (how === 'Initials') {
					document.getElementById("image-name").innerHTML = fname.substring(0,1)+'.'+lname.substring(0,1)+'.';
				} else if (how === 'Anonymous') {
					document.getElementById("image-name").innerHTML = 'Anonymous';
				} else {
					document.getElementById("image-name").innerHTML = fname+' '+lname;
				}
			} else {
				document.getElementById("image-name").innerHTML = '';
			}
		}

		function view_city() {
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
			var city = escapeHtml($('#pr-field-city').val());
			if (city) {
				document.getElementById('image-city').innerHTML = city+',';
			} else {
				document.getElementById('image-city').innerHTML = '';
			}
		}

		function view_location() {
			document.getElementById("img-single-product").style.opacity='0.3';
//			document.getElementById("img-single-product").style.filter="grayscale(100%)";
			document.getElementById('image-location').innerHTML = escapeHtml($('#pr-field-state').val());
		}

		function view_how() {
			var fname = escapeHtml($('#pr-field-first-name').val());
			var lname = escapeHtml($('#pr-field-last-name').val());
			var how = escapeHtml($('#pr-field-how').val());
			if (how === 'Full') {
				document.getElementById("image-name").innerHTML = fname+' '+lname;
			} else if (how === 'First') {
				document.getElementById("image-name").innerHTML = fname+' '+lname.substring(0,1)+'.';
			} else if (how === 'Initials') {
				document.getElementById("image-name").innerHTML = fname.substring(0,1)+'.'+lname.substring(0,1)+'.';
			} else if (how === 'Anonymous') {
				document.getElementById("image-name").innerHTML = 'Anonymous';
			}
		}


	</script>


	<?php
}


/**
 * Add the field to the checkout
 */
/*
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function my_custom_checkout_field( $checkout ) {

	echo '<div id="my_custom_checkout_field">';

	woocommerce_form_field( 'my_field_first_name', array(
		'type'          => 'text',
		'class'         => array('my_field_first_name form-row-wide'),
		'label'         => __('First Name'),
		'placeholder'   => __('Enter First Name'),
		'required'		=> true,
	), $checkout->get_value( 'my_field_first_name' ));

	woocommerce_form_field( 'my_field_last_name', array(
		'type'          => 'text',
		'class'         => array('my_field_last_name form-row-wide'),
		'label'         => __('Last Name'),
		'placeholder'   => __('Enter Last Name'),
		'required'		=> true,
	), $checkout->get_value( 'my_field_last_name' ));

	woocommerce_form_field( 'my_field_location', array(
		'type'          => 'text',
		'class'         => array('my_field_location form-row-wide'),
		'label'         => __('Location'),
		'placeholder'   => __('Enter Location'),
		'required'		=> true,
	), $checkout->get_value( 'my_field_location' ));

	woocommerce_form_field( 'my_field_how', array(
		'type'          => 'select',
		'class'         => array('my_field_how form-row-wide'),
		'label'         => __('How to show'),
		'options'     => array(
							'Initials' => __('Initials (John S.)'),
							'Full' => __('Full Name (John Smith)'),
							'Anonymous' => __('Anonymous')
						),
		'default' => 'Initials',
		'required'		=> true,
	), $checkout->get_value( 'my_field_how' ));

	echo '</div>';

}
*/

/**
 * Process the checkout
 */
/*
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
	// Check if set, if its not set add an error.
	if ( ! $_POST['my_field_first_name'] )
		wc_add_notice( __( 'Please enter First Name field in addiitional information.' ), 'error' );
	if ( ! $_POST['my_field_last_name'] )
		wc_add_notice( __( 'Please enter Last Name field in addiitional information.' ), 'error' );
	if ( ! $_POST['my_field_last_name'] )
		wc_add_notice( __( 'Please enter Last Name field in addiitional information.' ), 'error' );
	if ( ! $_POST['my_field_how'] )
		wc_add_notice( __( 'Please enter how to show field in addiitional information.' ), 'error' );
	require_once __DIR__.'/vendor/autoload.php';

}
*/
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
/*	if ( ! empty( $_POST['my_field_first_name'] ) | ! empty( $_POST['my_field_last_name'] )|! empty( $_POST['my_field_how'] )|!empty($_POST['my_field_location'])) {
		update_post_meta( $order_id, 'First Name', sanitize_text_field( $_POST['my_field_first_name'] ) );
		update_post_meta( $order_id, 'Last Name', sanitize_text_field( $_POST['my_field_last_name'] ) );
		update_post_meta( $order_id, 'Location', sanitize_text_field( $_POST['my_field_location'] ) );
		update_post_meta( $order_id, 'How to show', sanitize_text_field( $_POST['my_field_how'] ) );
*/

		// Getting an instance of the order object

		$order = new WC_Order( $order_id );
		$items = $order->get_items();

		//Loop through them, you can get all the relevant data:
/*		$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];
		$mpdf = new \Mpdf\Mpdf([
			'fontDir' => array_merge($fontDirs, [
				__DIR__ . '/pdf/fontDir',
			]),
			'fontdata' => $fontData + [
					'Pinyon' => [
						'R' => 'PinyonScript-Regular.ttf'
					]
				]

		]);
*/
		$mpdf = new \Mpdf\Mpdf(
			['format'=>'A4-L']

		);
	// подключаем стили
		// подключаем файл стилей
		$stylesheet = file_get_contents(__DIR__.'/pdf/style_pdf.css');
		$mpdf->WriteHTML($stylesheet,1);
		$i=0;


		//$mpdf->WriteHTML('<pre>'.print_r($items,1).'</pre>','',false,false); debug WC_ORDER

		foreach ( $items as $item ) {
			$i=$i+1;
			if ($i>1) {
				$mpdf->AddPage();
			}
			$product_id = $item['product_id'];
			$product = $item['name'];
			$comment = $item['Dedication'];
			$first = $item['First Name'];
			$last = $item['Last Name'];
			$state = $item['City'].', '.$item['State/Country'];
			$how = $item['How to show'];
			$imagefile = get_post_meta($product_id,'imagefile',true);
			date_default_timezone_set('UTC');
			$date=date('F j, Y');

			update_post_meta($product_id, "owner", $first);
			update_post_meta($product_id, "owner_last_name", $last);
			update_post_meta($product_id, "location", $state);
			update_post_meta($product_id, "how_to_show", $how);
			update_post_meta($product_id, "owner_comment", $comment);
//			$html = file_get_contents(__DIR__.'/pdf/Certificate.html');
			$mpdf->WriteHTML('

<body style="position:relative; margin: 0; padding: 0;">
<div style="position:absolute; height: 20cm; margin: auto; z-index: 1"><img src="/wp-content/themes/charitab-wp/img/s-1.png" width="100%" height="100%" alt=""/></div>
<div style="position:absolute; width: 30cm; height: 20cm; margin: auto; z-index: 2">
	<div style="position: relative; padding: 2.3cm 3.7cm;  height: 20cm; margin: auto;">
	
		<div style="position:relative; width:2.2cm; margin: auto; border:solid 0.15cm #ffffff;"><img src="/wp-content/themes/charitab-wp/img/WB_Foundation_LogoRGB144_2019-1.jpg" width="100%" height="auto" alt=""/></div>
		
		<div style="position:relative; text-align: center; width:22cm"><!--border:solid 0.1cm #b29201;  height: 12.8cm; -->
			
			<div style="font-family:\'amiri\', serif; font-size: 1.7cm; text-transform: uppercase; padding:0.8cm 0 0; color:#004588; letter-spacing: 0.3cm; line-height: 1.6cm;">Certificate</div>
			<div style="font-family:\'amiri\', serif; font-size:0.36cm; color:#004588;  text-transform: uppercase; letter-spacing: 0.1cm; line-height: 0.55cm; font-style: italic;">OF THE WIEDMANN BIBLE FAMILY <br>PICTURE ADOPTION</div>
			<div style="font-family: \'pinyon\', cursive; font-size: 0.6cm; padding:0.7cm 0 0.2cm; color:#004588; letter-spacing: 0.03cm;">This Sertifies that</div>
			<div style="font-family: \'pinyon\', cursive; font-size: 1.2cm; color:#b34b00; letter-spacing: 0.05cm;">'.$first.' '.$last.'</div>
			<div style="font-family: \'pinyon\', cursive; font-size: 0.6cm; padding:0.3cm 0 0.2cm; color:#004588; letter-spacing: 0.03cm;">Adopted picture '.$product.' in the Wiedmann Bible for one year</div>
			<div style="position:relative; float:left; margin-left:0.3cm; padding-bottom:0.2cm; padding-top: 3.8cm; width: 7cm;">
				<div style="font-family:\'pinyon\', cursive; font-size: 0.7cm; color:#b34b00;">'.$date.'</div>
				<div style="font-family:\'amiri\', serif; font-size: 0.25cm; text-transform: uppercase; padding:0.2cm 0 0; color:#004588; letter-spacing: 0.1cm; border-top: solid 0.03cm #004588; width: 7cm;">date</div>
			</div>
			<div style="position:relative; float:left; margin-left:0.7cm; width:6cm; padding-top: 0.6cm;">
				<div style="position: relative;  border: solid 0.03cm #b29201;"><img style="position: absolute; bottom: -1cm; z-index: 200; border:solid 0.3cm #ffffff;" src="https://wiedmann.s3.amazonaws.com/images/l_'.$imagefile.'" width="100%" height="auto" alt=""/></div>
			</div>
			<div style="position:relative;float:right; margin-right:0.3cm; padding-bottom:0.2cm;  padding-top: 3.8cm; width: 7cm;">
				<div style="font-family: \'pinyon\', cursive; font-size: 0.7cm; color:#b34b00; ">Carolin D. Rossinsky</div>
				<div style="font-family:\'amiri\', serif; font-size: 0.25cm; text-transform: uppercase; padding:0.2cm 0 0; color:#004588; letter-spacing: 0.1cm; border-top: solid 0.03cm #004588; width: 7cm;">president</div>
			</div>
		</div>
	</div>
</div>
</body>

			',2);
			//$mpdf->WriteHTML('<h1>product_id:'.$product_id.'</h1><br><h1>product:'.$product.'</h1><br><h1>comment:'.$comment.'</h1>','',false,false);

		}

		$mpdf->Output(__DIR__.'/pdf/tmp/certificate_'.$order_id.'.pdf');
//	}
}

/**
 * Display field value on the order edit page
 */
/*
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__('First Name').':</strong> ' . get_post_meta( $order->id, 'First Name', true ) . '</p>';
	echo '<p><strong>'.__('Last Name').':</strong> ' . get_post_meta( $order->id, 'Last Name', true ) . '</p>';
	echo '<p><strong>'.__('Location').':</strong> ' . get_post_meta( $order->id, 'Location', true ) . '</p>';
	echo '<p><strong>'.__('How to show').':</strong> ' . get_post_meta( $order->id, 'How to show', true ) . '</p>';
}
*/

add_action ('woocommerce_order_status_cancelled','custom_fields_to_zero');

function custom_fields_to_zero($order_id) {
	$order = new WC_Order( $order_id );
	$items = $order->get_items();

	foreach ( $items as $item ) {
		$product_id = $item['product_id'];

		update_post_meta ($product_id,"owner","");
		update_post_meta ($product_id,"owner_last_name","");
		update_post_meta ($product_id,"location","");
		update_post_meta ($product_id,"owner_comment","");
		update_post_meta ($product_id,"how_to_show","");
	}
}


/*
 * add JS to checkout
 */
/*
add_filter( 'woocommerce_checkout_fields', 'misha_no_email_validation' );

function misha_no_email_validation( $fields ){

	unset( $fields['billing']['billing_email']['validate'] );
	return $fields;

}

add_action( 'woocommerce_after_checkout_validation', 'misha_validate_fname_lname', 10, 2);

function misha_validate_fname_lname( $fields, $errors ){

	if ( preg_match( '/\\d/', $fields[ 'billing_first_name' ] ) || preg_match( '/\\d/', $fields[ 'billing_last_name' ] )  ){
		$errors->add( 'validation', 'Your first or last name contains a number. Really?' );
	}
}
*/
/*
 * Скрыть категорию
 */



add_filter( 'get_terms', 'get_subcategory_terms', 10, 3 );

function get_subcategory_terms( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// если находится в товарной категории и на странице магазина
	if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'gold' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

add_filter( 'get_terms', 'get_subcategory_terms2', 10, 3 );

function get_subcategory_terms2( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// если находится в товарной категории и на странице магазина
	if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'silver' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

add_filter( 'get_terms', 'get_subcategory_terms3', 10, 3 );

function get_subcategory_terms3( $terms, $taxonomies, $args ) {

	$new_terms = array();

	// если находится в товарной категории и на странице магазина
	if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() && is_shop() ) {

		foreach ( $terms as $key => $term ) {

			if ( ! in_array( $term->slug, array( 'premium' ) ) ) {
				$new_terms[] = $term;
			}

		}

		$terms = $new_terms;
	}

	return $terms;
}

/*
* Добавить настраиваемое поле ввода текста на страницу продукта
*/

function  plugin_republic_add_text_field () {
	?>
	<br>
	<div  class="pr-field-wrap">
		<label  for="pr-field" class="product-label-textarea"><?php _e('Dedication ','plugin-Republic');?></label>
		<textarea  rows="3" name='pr-field'  id='pr-field' value='' placeholder="max 150 symbols" class="product-input-form" maxlength="150" onkeyup="countChar(this);view_comment();"></textarea>
	</div>
	<div class="left-symbols">
		<span id="left"></span>
		<span id="charNum"></span>
		<span id="symbols"></span>
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-first-name" class="product-label-form"><?php _e('First Name ','plugin-Republic');?></label>
		<input  type="text"  name='pr-field-first-name'  class="product-input-form" id='pr-field-first-name' value='' onkeyup="view_name()">
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-last-name" class="product-label-form"><?php _e('Last Name ','plugin-Republic');?></label>
		<input  type="text" name='pr-field-last-name'  class="product-input-form" id='pr-field-last-name' value='' onkeyup="view_name()">
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-city" class="product-label-form"><?php _e('City ','plugin-Republic');?></label>
		<input  type="text"  name='pr-field-city'  class="product-input-form" id='pr-field-city' value='' onkeyup="view_city()">
	</div>
	<div  class="pr-field-wrap">
		<label  for="pr-field-state" class="product-label-form"><?php _e('State/Country ','plugin-Republic');?></label>
		<input  type="text"  name='pr-field-state'  class="product-input-form" id='pr-field-state' value='' onkeyup="view_location()">
	</div>
	<div class="pr-field-wrap">
		<label  for="pr-field-how" class="product-label-form"><?php _e('How to show ','plugin-Republic');?></label>
		<select type="select" size="1" name="pr-field-how" id="pr-field-how" class="product-select-form" onchange="view_how()">
			<option value="Full">Full Name (John Smith)</option>
			<option value="First">First Name (John S.)</option>
			<option value="Initials">Initials (J.S.)</option>
		    <option value="Anonymous">Anonymous</option>
		</select>
	</div>
	<br>
	<?php
}

add_action ('woocommerce_before_add_to_cart_button', 'plugin_republic_add_text_field');


/**
 * Validate our custom text input field value
 */
function plugin_republic_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id=null ) {
/*	if( empty( $_POST['pr-field'] ) ) {
		$passed = false;
		wc_add_notice( __( 'Dedication is a required field.', 'plugin-republic' ), 'error' );
	}
*/
	if( empty( $_POST['pr-field-first-name'] ) ) {
		$passed = false;
		wc_add_notice( __( 'First Name is a required field.', 'plugin-republic' ), 'error' );
	}
	if( empty( $_POST['pr-field-last-name'] ) ) {
		$passed = false;
		wc_add_notice( __( 'Last Name is a required field.', 'plugin-republic' ), 'error' );
	}
	if( empty( $_POST['pr-field-city'] ) ) {
		$passed = false;
		wc_add_notice( __( 'City is a required field.', 'plugin-republic' ), 'error' );
	}
	if( empty( $_POST['pr-field-state'] ) ) {
		$passed = false;
		wc_add_notice( __( 'State/Country is a required field.', 'plugin-republic' ), 'error' );
	}
	return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'plugin_republic_add_to_cart_validation', 10, 4 );

/**
 * Add custom cart item data
 */
function plugin_republic_add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	if( !empty( $_POST['pr-field'] ) ) {
		$cart_item_data['pr_field'] = $_POST['pr-field'];
	}
	if( isset( $_POST['pr-field-first-name'] ) ) {
		$cart_item_data['pr_field-first-name'] = sanitize_text_field( $_POST['pr-field-first-name'] );
	}
	if( isset( $_POST['pr-field-last-name'] ) ) {
		$cart_item_data['pr_field-last-name'] = sanitize_text_field( $_POST['pr-field-last-name'] );
	}
	if( isset( $_POST['pr-field-city'] ) ) {
		$cart_item_data['pr_field-city'] = sanitize_text_field( $_POST['pr-field-city'] );
	}
	if( isset( $_POST['pr-field-state'] ) ) {
		$cart_item_data['pr_field-state'] = sanitize_text_field( $_POST['pr-field-state'] );
	}
	if( isset( $_POST['pr-field-how'] ) ) {
		$cart_item_data['pr_field-how'] = sanitize_text_field( $_POST['pr-field-how'] );
	}
	return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'plugin_republic_add_cart_item_data', 10, 3 );

/**
 * Display custom item data in the cart
 */

function plugin_republic_get_item_data( $item_data, $cart_item_data ) {
	if( isset( $cart_item_data['pr_field'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Dedication', 'plugin-republic' ),
			'value'   =>  wc_clean($cart_item_data['pr_field'])
		);
	}
	if( isset( $cart_item_data['pr_field-first-name'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Name', 'plugin-republic' ),
			'value'   => wc_clean( $cart_item_data['pr_field-first-name']).' '.wc_clean( $cart_item_data['pr_field-last-name'])
		);
	}
	if( isset( $cart_item_data['pr_field-city'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Location', 'plugin-republic' ),
			'value'   => wc_clean( $cart_item_data['pr_field-city']).' '.wc_clean( $cart_item_data['pr_field-state'] )
		);
	}
	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'plugin_republic_get_item_data', 10, 2 );


/**
 * Add custom meta to order
 */

function plugin_republic_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
	if( isset( $values['pr_field'] ) ) {
		$item->add_meta_data(
			__( 'Dedication', 'plugin-republic' ),
			$values['pr_field'],
			true
		);
	}
	if( isset( $values['pr_field-first-name'] ) ) {
		$item->add_meta_data(
			__( 'First Name', 'plugin-republic' ),
			$values['pr_field-first-name'],
			true
		);
	}
	if( isset( $values['pr_field-last-name'] ) ) {
		$item->add_meta_data(
			__( 'Last Name', 'plugin-republic' ),
			$values['pr_field-last-name'],
			true
		);
	}
	if( isset( $values['pr_field-city'] ) ) {
		$item->add_meta_data(
			__( 'City', 'plugin-republic' ),
			$values['pr_field-city'],
			true
		);
	}
	if( isset( $values['pr_field-state'] ) ) {
		$item->add_meta_data(
			__( 'State/Country', 'plugin-republic' ),
			$values['pr_field-state'],
			true
		);
	}
	if( isset( $values['pr_field-how'] ) ) {
		$item->add_meta_data(
			__( 'How to show', 'plugin-republic' ),
			$values['pr_field-how'],
			true
		);
	}
}
add_action( 'woocommerce_checkout_create_order_line_item', 'plugin_republic_checkout_create_order_line_item', 10, 4 );




/**
 * Add certificate to order
 */

add_filter( 'woocommerce_email_attachments', 'attach_certificate_pdf_to_email', 10, 3);
function attach_certificate_pdf_to_email ( $attachments , $id, $object ) {

//    $allowed_statuses = array( 'customer_invoice', 'customer_completed_order' );
    
//    if( isset( $status ) && in_array ( $status, $allowed_statuses ) ) {

        $your_pdf_path = get_template_directory() . '/pdf/tmp/certificate_'.$object->id.'.pdf';
	$attachments[] = $your_pdf_path;
//    }
    return $attachments;
        
        
}

add_filter( 'woocommerce_email_attachments', 'attach_certificate_pdf_to_email2', 10, 3);
function attach_certificate_pdf_to_email2 ( $attachments , $id, $object ) {

	//    $allowed_statuses = array( 'customer_invoice', 'customer_completed_order' );

	//    if( isset( $status ) && in_array ( $status, $allowed_statuses ) ) {


	$your_pdf_path = get_template_directory() . '/pdf/tmpbill/Charity-bill_'.$object->id.'.pdf';

	$attachments[] = $your_pdf_path;
	//    }
	return $attachments;


}

add_action('woocommerce_email_order_details', 'ts_email_order_details', 10, 4);
function ts_email_order_details($order, $sent_to_admin, $plain_text, $email) {
	$id=$order->id;
	$salutation = get_post_meta($id,'_billing_salutation',true);
	$salutat = ucfirst($salutation);
	if (!empty($salutat)) {
		$salut = $salutat.'.';
	} else {
		$salut = 'Mr.(Mrs.)';
	}
	echo 'Dear '.$salut.' '.$order->get_billing_last_name().',<br>';
	echo '<br>Thank you for being a part of the Wiedmann Bible Family! We are in receipt of your donation of $'.$order->get_total().'  on '.date('F j, Y').' order #'.$order->get_order_number().' to adopt a Wiedmann Bible painting. Your generosity helps further our mission to engage more people with the Bible visually through events, exhibits and education.  We appreciate your support very much.<br>';
	echo 'No goods or services were received in return for this gift.<br>';
	echo 'As a 501(c)(3) non-profit organization, tax laws require us to notify you that this letter is the official acknowledgment of your donation.<br>';
  	echo 'Our Federal Tax ID number is 83-3278854.<br>';
  	echo 'For details about income tax deductions for charitable contributions please see IRS Publication 526, Charitable Contributions, or consult your tax adviser.<br><br>';
  	echo 'Wishing you many blessings,<br>Carolyn D. Rossinsky<br>';
  	echo 'President<br>';
  	echo 'Wiedmann Bible Foundation, Inc.<br><br>';

  	//add pdf
	$mpdf = new \Mpdf\Mpdf(
		['format'=>'A4']

	);
	$stylesheet = file_get_contents(__DIR__.'/pdf/style_pdf.css');
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML('
		<div style="font-family:Arial; margin-left:150px; margin-right:80px; padding-top:30px;">
			<div style="width:2.2cm; margin: auto;"><img src="/wp-content/themes/charitab-wp/img/WB_Foundation_LogoRGB144_2019-1.jpg" width="100%" height="auto" alt=""></div>
			<div>
				<br>
				From: 
				<br>
				Wiedmann Bible Foundation, Inc.
				<br>
				120 Kingsport Road 
				<br>
				Holly Springs, NC 27540 
				<br>
				'.date('F j, Y').'
				<br>
				<br> 
				To: 
				<br>
				'.$salut.' '.$order->get_billing_first_name().' '.$order->get_billing_last_name().'
				<br>
				'.$order->get_billing_address_1().'
				<br>
				'.$order->get_billing_city().', '.$order->get_billing_state().' '.$order-> get_billing_postcode().'
				<br>
				<br>
				Re: Your Charitable Donation '.date('Y').' 
				<br>
				<br>
				<br>
				Dear '.$salut.' '.$order->get_billing_last_name().',
				<br><br> 
				Thank you for being a part of the Wiedmann Bible Family! We are in receipt of 
				your donation of $'.$order->get_total().'  on '.date('F j, Y').' order #'.$order->get_order_number().' to adopt a Wiedmann Bible painting. Your 
				generosity helps further our mission to engage more people with the Bible 
				visually through events, exhibits and education.  We appreciate your support 
				very much! 
				<br>
				<br>
				No goods or services were received in return for this gift.
				<br>
				<br>
				As a 501(c)(3) non-profit organization, tax laws require us to notify you that this letter is the official acknowledgment of your donation.
				<br>
				<br> 
				Our Federal Tax ID number is 83-3278854. 
				<br>
				<br>
				For details about income tax deductions for charitable contributions please see IRS Publication 526, Charitable Contributions, or consult your tax adviser.
				<br>
				<br>
				Wishing you many blessings, 
				<br>
				<br>
				<br>
				<br>
				<img src="/wp-content/themes/charitab-wp/pdf/сr-signature.png" width="50%" height="auto" alt="">
				<br><br>
				President 
				<br><br>
				Wiedmann Bible Foundation, Inc.
			</div>
		</div>
	',2);
	$mpdf->Output(__DIR__.'/pdf/tmpbill/Charity-bill_'.$id.'.pdf');
}

add_action ('woocommerce_product_thumbnails','visual_editor_product');

function visual_editor_product() {
	echo '
		<div class="image-product-comment">
			<div id="image-comment"></div>
			<br>
			<div id="image-name"></div>
			<div>
			<span id="image-city"></span> <span id="image-location"></span>
			</div>
		</div>
	';
}

add_action( 'woocommerce_review_order_before_payment', 'action_function_checkout' );
function action_function_checkout( $checkout ){
    echo '<a href="https://family.wiedmannbible.org/shop/" class="checkout-button button alt wc-forward btn btn-theme-colored1 btn-sm">
		Adopt more pictures</a><br><br>';
}

//replace text for button in checkout

add_filter( 'woocommerce_order_button_html', 'misha_custom_button_html' );

function misha_custom_button_html( $button_html ) {
	$button_html = str_replace( 'Place order', 'Donate Now', $button_html );
	return $button_html;
}
