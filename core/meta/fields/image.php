<label for="<?php echo $field['id']; ?>"><?php echo esc_html( $field['label'] ); ?></label>
<div class="mint-image-upload-wrapper">
	<div class="mint-image-display mint-image-upload-button">
		<!-- Image -->
		<?php if ( isset( $meta ) && $meta != '' ) : ?>
		<?php $img = wp_get_attachment_image_src( $meta, 'slide-image' ); ?>
		<div class="mint-background-image-holder">
			<img src="<?php echo $img[0]; ?>" class="mint-background-image-preview" />
		</div>
		<a class="mint-image-remove" href="#"><span class="dashicons dashicons-no"></span></a>
		<?php else : ?>
		<div class="placeholder"><span class="dashicons dashicons-format-image"></span></div>
		<!-- Remove button -->
		<a class="mint-image-remove hidden" href="#"><span class="dashicons dashicons-no"></span></a>
		<?php endif; ?>
	</div>
	<input type="hidden" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" value="<?php if ( isset ( $meta ) ) echo $meta; ?>" class="mint-image-upload-field" />
	<input type="button" class="button button-primary mint-image-button mint-choose-image" value="<?php _e('Choose Image', 'mint'); ?>" />
</div>
<?php if ( ! empty( $field['desc'] ) ) : ?>
	<p class="mint-field-description"><?php echo $field['desc']; ?></p>
<?php endif; ?>