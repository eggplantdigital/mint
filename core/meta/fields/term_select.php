<?php $terms = get_terms( $field['options'][0], $field['options'][1] ); ?>
<label for="<?php echo $field['id']; ?>"><?php echo esc_html( $field['label'] ); ?></label>
<div class="mint-field-holder">	
	<select name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>">
		<?php
		if ( !empty( $terms ) && !is_wp_error( $terms ) ){ 
			?>
			<option value=""><?php _e('--- Select ---', 'mint'); ?></option>
			
			<?php foreach ( $terms as $term ) { 
				?>
	    		<option value="<?php echo $term->slug; ?>" <?php echo ( $meta==$term->slug ) ? 'selected' : ''; ?>><?php echo $term->name; ?></option>
		<?php }
		} else {
			echo '<span>'.__('Oops! Nothing Found', 'mint').'</span>';
		} ?>
	</select>
	<?php if ( ! empty( $field['desc'] ) ) : ?>
		<p class="mint-field-description"><?php echo $field['desc']; ?></p>
	<?php endif; ?>
</div>