<?php defined('ABSPATH') OR die('restricted access');

if ( ! class_exists( 'DEO_Meta_Box') ) :

	class DEO_Meta_Box {

		protected $_meta_box;

		protected $_mb_prefix;

		protected $_fields;

		protected $_self_path = DEO_CORE_URL;

		public $field_types = [];

		public function __construct ( $meta_box ) {

			if ( ! is_admin() ) {
				return;
			}

			$this->_meta_box = $meta_box;

			if ( ! $this->_meta_box ) {
				return;
			}

			$this->_mb_prefix = ( isset( $this->_meta_box['prefix'] ) ) ? $this->_meta_box['prefix'] : '';
			$this->_fields = $this->_meta_box['fields'];

			$this->insert_missing_keys();

			// Add metaboxes
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

			add_action( 'save_post', array( $this, 'save_meta_box' ) );

			add_action( 'admin_enqueue_scripts', [ $this, 'admin_fields_scripts'] );
		}

		public function admin_fields_scripts() {

			$plugin_path = $this->_self_path;

			global $typenow;

			if ( in_array( $typenow, $this->_meta_box['post_types'] ) && $this->is_current_page() ) {

				wp_enqueue_style( 'deo-meta-box', $plugin_path . 'admin/assets/css/metabox.css' );

				wp_enqueue_script( 'deo-meta-box', $plugin_path . 'admin/assets/js/metabox.js', array( 'jquery' ), null, true );

				foreach ( [ 'color' ] as $type ) {
					call_user_func ( array( $this, '_is_field_' . $type ) );
				}
			}
		}

		public function _is_field_color() {

			if ( $this->is_field( 'color' ) && $this->is_current_page() ) {
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );

				$inline_js = "
					jQuery(document).ready(function($) {
						if ( $('.deo-color-picker').length ) {
							$( '.deo-color-picker' ).wpColorPicker();
						}
					});
				";

				wp_add_inline_script( 'deo-meta-box', $inline_js );
			}
		}

		public function add_meta_box( $post_type ) {

			if ( in_array( $post_type, $this->_meta_box['post_types'] ) ) {
				add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array( $this, 'render_meta_box' ), $post_type, $this->_meta_box['context'], $this->_meta_box['priority'] );
			}
		}

		public function render_meta_box() {

			global $post;

			wp_nonce_field( basename(__FILE__), 'deo_meta_box_nonce' );

			echo '<table class="form-table deo-table">';
				foreach ( $this->_fields as $field ) {
					$field['multiple'] = isset( $field['multiple'] ) ? $field['multiple'] : false;
					$meta_value = get_post_meta( $post->ID, $field['id'], ! $field['multiple'] );
					$meta_value = ( $meta_value !== '' ) ? $meta_value : @$field['std'];

					if ( ! in_array( $field['type'], array( 'image', 'repeater','file' ) ) ) {
						$meta_value = is_array( $meta_value ) ? array_map( 'esc_attr', $meta_value ) : esc_attr( $meta_value );

						echo '<tr class="deo-row">';
							call_user_func ( array( $this, 'pop_field_' . $field['type'] ), $field, $meta_value );
						echo '</tr>';
					}
				}
			echo '</table>';
		}

		public function pop_field_begin( $field, $meta ) {

			echo "<th class='deo-field-th'>";
			echo "<label for='{$field['id']}' class='deo-label'>{$field['name']}</label>";
			echo "<span class='deo-description'>{$field['description']}</span>";
			echo "</th>";

			echo "<td class='deo-field-td'>";
		}

		public function pop_field_end( $field, $meta = NULL, $group = false ) {
			echo "</td>";
		}

		public function pop_field_text( $field, $meta ) {

			$this->pop_field_begin( $field, $meta );

			$field_class = '';

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			$style = '';

			if ( isset( $field['style'] ) ) {
				 $style = "style='{$field['style']}'";
			}

			if ( isset( $field['default'] ) && ! empty( $field['default'] ) && ! $meta ) {
				$meta = $field['default'];
			}

			echo "<input type='text' class='deo-text". esc_attr( $field_class ) ."' name='{$field['id']}' id='{$field['id']}' value='{$meta}' size='30' " . esc_attr( $style ) ."/>";

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_number( $field, $meta ) {

			$this->pop_field_begin( $field, $meta );

			$step = '1';
			$min  = '1';
			$max  = '10';
			$field_class = '';
			$style = '';

			if ( isset( $field['step'] ) && $field['step'] !== '1' ) {
				$step = "step=".$field['step']."";
			}

			if ( isset( $field['min'] ) ) {
				$min = "step".$field['min']."";
			}

			if ( isset( $field['max'] ) ) {
				$max = "step".$field['max']."";
			}

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			if ( isset( $field['style'] ) ) {
				 $style = "style='{$field['style']}'";
			}

			if ( ! $meta && isset( $field['default'] ) ) {
				$meta = $field['default'];
			}

			echo "<input type='number' class='deo-number". esc_attr( $field_class ) ."' name='{$field['id']}' id='{$field['id']}' value='{$meta}' size='30' ". esc_attr( $step ) . esc_attr( $min ) . esc_attr( $max ) . esc_attr( $style ) ."/>";

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_hidden( $field, $meta ) {

			$field_class = '';
			$style = '';

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			if ( isset( $field['style'] ) ) {
				 $style = "style='{$field['style']}'";
			}

			echo "<input type='hidden' ". esc_attr( $style ) ."class='deo-text". esc_attr( $field_class ) ."' name='{$field['id']}' id='{$field['id']}' value='{$meta}'/>";
		}

		public function pop_field_textarea( $field, $meta ) {

			$this->pop_field_begin( $field, $meta );

				$field_class = '';
				$style = '';

				if ( isset( $field['class'] ) ) {
					$field_class = $field['class'];
				}

				if ( isset( $field['style'] ) ) {
					 $style = "style='{$field['style']}'";
				}

				echo "<textarea class='deo-textarea ". $field_class ."' name='{$field['id']}' id='{$field['id']}' ". esc_attr( $style ) ." cols='60' rows='10'>{$meta}</textarea>";

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_select( $field, $meta_value ) {

			$this->pop_field_begin( $field, $meta_value );

			$field_class = '';
			$style = '';

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			if ( isset( $field['style'] ) ) {
				 $style = "style='{$field['style']}'";
			}

			echo "<select ". esc_attr( $style ) ." class='deo-select". esc_attr( $field_class ) ."' name='{$field['id']}" . ( $field['multiple'] ? "[]' id='{$field['id']}' multiple='multiple'" : "'" ) . ">";

			if ( ! isset( $field['default'] ) ) {
				$field['default'] = '';
			}

			$selected_item = ( $meta_value ) ? $meta_value : $field['default'];
			foreach ( $field['options'] as $key => $value ) {
				$selected = ( $key == $selected_item ) ? ' selected="selected"' : '';
				echo "<option value='{$key}'" . $selected . ">{$value}</option>";
			}

			echo "</select>";

			$this->pop_field_end( $field, $meta_value );
		}

		public function pop_field_radio( $field, $meta ) {

			if ( ! is_array( $meta ) ) {
				$meta = (array) $meta;
			}

			$this->pop_field_begin( $field, $meta );

				$field_class = '';
				$style = '';

				if ( isset( $field['class'] ) ) {
					$field_class = $field['class'];
				}

				if ( isset( $field['style'] ) ) {
					 $style = "style='{$field['style']}'";
				}

				foreach ( $field['options'] as $key => $value ) {
					echo "<input type='radio' ". $style ." class='deo-radio". esc_attr( $field_class ) ."' name='{$field['id']}' value='{$key}'" . checked( in_array( $key, $meta ), true, false ) . " /> <span class='deo-radio-label'>{$value}</span>";
				}

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_layout( $field, $meta ) {

			if ( ! is_array( $meta ) ) {
				$meta = (array) $meta;
			}

			$this->pop_field_begin( $field, $meta );

					$field_class = '';

					if ( isset( $field['class'] ) ) {
							$field_class = $field['class'];
					}

					echo '<div class="deo-layout-select-wrapper">';
					echo '<ul class="deo-layout-select-list">';

					$x = 1;

					foreach ( $field['options'] as $key => $value ) {

						if ( ! isset( $value['title'] ) ) {
							$value['title'] = '';
						}

						if ( ! isset( $value['alt'] ) ) {
							$value['alt'] = $value['title'];
						}

						$selected = ( checked( in_array( $key, $meta ), true, false ) != '' ) ? ' deo-layout-selected' : '';

						echo '<li class="deo-layout-select-item">';
						echo '<label class="' . $selected . $field['id'] . '_' . $x . '" for="' . $field['id'] . '_' . ( array_search( $key, array_keys( $field['options'] ) ) + 1 ) . '">';
						echo "<input type='radio' class='deo-layout-select-input". esc_attr( $field_class ) ."' name='{$field['id']}[]' value='{$key}'" . checked( in_array( $key, $meta ), true, false ) . " />";

						echo '<img src="' . $value['img'] . '" title="'. $value['alt'] . '" alt="' . $value['alt'] . '" class="deo-layout-select-img" />';
						echo '</label>';
						echo '</li>';
						$x ++;
					}

				echo '</ul>';
				echo '</div>';

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_switch( $field, $meta ) {

			$this->pop_field_begin( $field, $meta );

			$field_class = '';
			$style = '';

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			if ( isset( $field['style'] ) ) {
				 $style = "style='{$field['style']}'";
			}

			echo
				"<div class='deo-onoffswitch'>
					<input type='checkbox' ". esc_attr( $style ) ." class='deo-checkbox deo-onoffswitch-checkbox". esc_attr( $field_class ) ."' name='{$field['id']}' id='{$field['id']}'" . checked( ! empty( $meta ), true, false ) . " />
					<label class='deo-onoffswitch-label' for='{$field['id']}'>
						<span class='deo-onoffswitch-inner'></span>
					</label>
				</div>";

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_checkbox( $field, $meta_value ) {

			$this->pop_field_begin( $field, $meta_value );

			$field_class = '';
			$style = '';

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			if ( isset( $field['style'] ) ) {
				 $style = "style='{$field['style']}'";
			}

			if ( ! isset( $field['default'] ) ) {
				$field['default'] = '';
			}

			$selected_item = ( $meta_value ) ? $meta_value : $field['default'];

			echo "<input type='checkbox' ". esc_attr( $style ) ." class='deo-checkbox". esc_attr( $field_class ) ."' name='{$field['id']}' id='{$field['id']}'" . checked( ! empty( $selected_item ), true, false ) . " />";

			$this->pop_field_end( $field, $meta_value );
		}

		public function pop_field_checkbox_list( $field, $meta ) {

			if ( ! is_array( $meta ) ) {
				$meta = (array) $meta;
			}

			$this->pop_field_begin( $field, $meta );

				$input_html = [];
				$field_class = '';

				if ( isset( $field['class'] ) ) {
					$field_class = $field['class'];
				}

				foreach ( $field['options'] as $key => $value ) {
					$input_html[] = "<input type='checkbox' class='deo-checkbox_list". esc_attr( $field_class ) ."' name='{$field['id']}[]' value='{$key}'" . checked( in_array( $key, $meta ), true, false ) . " /> {$value}";
				}

				echo implode( '<br />' , $input_html );

			$this->pop_field_end($field, $meta);
		}

		public function pop_field_color( $field, $meta ) {

			if ( empty( $meta ) ) {
				$meta = '#';
			}

			$field_class = '';

			if ( isset( $field['class'] ) ) {
				$field_class = $field['class'];
			}

			$this->pop_field_begin( $field, $meta );

				if ( ! isset( $field['default'] ) ) {
					$field['default'] = '';
				}

				$meta = ( $meta ) ? $meta : $field['default'];

				if ( wp_style_is( 'wp-color-picker', 'registered' ) ) {
					echo "<input class='deo-color-picker ". $field_class ."' type='text' name='{$field['id']}' id='{$field['id']}' value='{$meta}' size='8' />";
				}

			$this->pop_field_end( $field, $meta );
		}

		public function pop_field_wysiwyg( $field, $meta, $in_repeater = false ) {

			$this->pop_field_begin( $field, $meta );

				$field_class = '';
				$style = '';

				if ( isset( $field['class'] ) ) {
					$field_class = $field['class'];
				}

				if ( isset( $field['style'] ) ) {
					 $style = "style='{$field['style']}'";
				}

				if ( $in_repeater ) {
					echo "<textarea class='deo-wysiwyg ". esc_attr( $field_class ) ."' name='{$field['id']}' id='{$field['id']}' cols='60' rows='10'>{$meta}</textarea>";
				} else {

					$settings = [];
					if ( isset( $field['settings'] ) && is_array( $field['settings'] ) ) {
						$settings = $field['settings'];
					}

					$settings['editor_class'] = 'deo-wysiwyg'. esc_attr( $field_class );

					$id = str_replace( "_","",$this->strip_number_to_string( strtolower( $field['id'] ) ) );

					wp_editor( html_entity_decode( $meta ), $id, $settings );
				}

			$this->pop_field_end( $field, $meta );
		}

		public function save_meta_box( $post_id ) {

			global $post_type;

			$pt_object = get_post_type_object( $post_type );

			if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )
				|| ( ! in_array( $post_type, $this->_meta_box['post_types'] ) )
				|| ( ! check_admin_referer( basename( __FILE__ ), 'deo_meta_box_nonce') )
				|| ( ! current_user_can( $pt_object->cap->edit_post, $post_id ) ) )
			{
				return $post_id;
			}

			foreach ( $this->_fields as $field ) {

				$field_name = $field['id'];

				$field_type = $field['type'];

				$old_value = get_post_meta( $post_id, $field_name, ! $field['multiple'] );

				$new_value = ( isset( $_POST[$field_name] ) ) ? $_POST[$field_name] : ( ( $field['multiple'] ) ? [] : '' );

				if ( $field_type != "paragraph" ) {

					$save_func = '_save_field_' . $field_type;

					if ( method_exists( $this, $save_func ) ) {
						call_user_func( array( $this, '_save_field_' . $field_type ), $post_id, $field, $old_value, $new_value );
					} else {
						$this->_save_field_data( $post_id, $field, $old_value, $new_value );
					}
				}
			}
		}

		public function _save_field_data( $post_id, $field, $old_value, $new_value ) {

			$field_name = $field['id'];

			delete_post_meta( $post_id, $field_name );

			if ( $new_value === '' || $new_value === [] ) {
				return;
			}

			if ( $field['multiple'] ) {
				foreach ( $new_value as $add_new ) {
					add_post_meta( $post_id, $field_name, $add_new, false );
				}
			} else {
				update_post_meta( $post_id, $field_name, $new_value );
			}
		}

		public function _save_field_image( $post_id, $field, $old_value, $new_value ) {

			$field_name = $field['id'];

			delete_post_meta( $post_id, $field_name );

			if ( $new_value === '' || $new_value === [] || $new_value['id'] == ''
				|| $new_value['url'] == '' ) {
				return;
			}

			update_post_meta( $post_id, $field_name, $new_value );
		}

		public function _save_field_wysiwyg( $post_id, $field, $old_value, $new_value ) {

			$id = str_replace( "_", "", $this->strip_number_to_string( strtolower( $field['id'] ) ) );

			if ( isset( $_POST[ $id ] ) ) {
				$new_value = $_POST[ $id ];
			} elseif ( $field['multiple'] ) {
				$new_value = [];
			} else {
				$new_value = '';
			}

			$this->_save_field_data( $post_id, $field, $old_value, $new_value );
		}

		public function _save_field_repeater( $post_id, $field, $old_value, $new_value ) {

			if ( is_array( $new_value ) && count( $new_value ) > 0 ) {

				foreach ( $new_value as $value ) {

					foreach ( $field['fields'] as $field ) {

						$field_type = $field['type'];

						switch( $field_type ) {
							case 'wysiwyg':
								$value[ $field['id'] ] = wpautop( $value[ $field['id'] ] );
							break;
							default:
							break;
						}
					}

					if ( ! $this->is_empty_array( $value ) ) {
						$temp_value[] = $value;
					}
				}

				if ( isset( $temp_value ) && count( $temp_value ) > 0 && ! $this->is_empty_array( $temp_value ) ) {
					update_post_meta( $post_id, $field['id'], $temp_value );
				} else {
					delete_post_meta( $post_id, $field['id'] );
				}

			} else {
				delete_post_meta( $post_id, $field['id'] );
			}
		}

		public function _save_field_file( $post_id, $field, $old_value, $new_value ) {

			$field_name = $field['id'];

			delete_post_meta( $post_id, $field_name );

			if ( $new_value === '' || $new_value === [] || $new_value['id'] == ''
				|| $new_value['url'] == '') {
				return;
			}

			update_post_meta( $post_id, $field_name, $new_value );
		}

		public function insert_missing_keys() {

			$this->_meta_box = array_merge(
				[
					'context' => 'normal',
					'priority' => 'high',
					'post_types' => [ 'post' ]
				], (array)$this->_meta_box
			);

			foreach ( $this->_fields as &$field ) {

				$field_type = $field['type'];

				$std = '';

				$field = array_merge(
					[
						'multiple'          => '',
						'std'               => $std,
						'description'       => '',
					], $field
				);
			}
		}

		public function is_field( $type ) {

			if ( count( $this->field_types ) > 0 ) {
				return in_array( $type, $this->field_types );
			}

			$temp_value = [];

			foreach ( $this->_fields as $field ) {
				$temp_value[] = $field['type'];
			}

			$this->field_types = array_unique( $temp_value );

			return $this->is_field( $type );
		}

		public function is_current_page() {
			global $pagenow;

			return in_array( $pagenow, [ 'post.php', 'post-new.php' ] );
		}

		public function strip_number_to_string( $string ) {
			return trim( str_replace( range( 0, 9 ), '', $string ) );
		}

		public static function register_meta_boxes() {
			$metaboxes = apply_filters( 'deo_meta_boxes', [] );

			foreach ( $metaboxes as $metabox ) {
				new DEO_Meta_Box( $metabox );
			}
		}
	}

endif;

add_action( 'init', function () {
	DEO_Meta_Box::register_meta_boxes();
});