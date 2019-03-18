<label for="<?php echo $field['id']; ?>"><?php echo esc_html( $field['label'] ); ?></label>
<div class="mint-field-holder">
	<input type="text" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" value="<?php echo htmlentities( $meta ); ?>" size="30" /> 
</div>
<?php if ( ! empty( $field['desc'] ) ) : ?>
<p class="mint-field-description"><?php echo $field['desc']; ?></p>
<?php endif; ?>