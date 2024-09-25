<?php

namespace FlexibleCouponsVendor;

$editor_data = isset($editor_data) ? $editor_data : [];
?>
<script>
	window.WPDeskCanvaEditorData = <?php 
echo \json_encode($editor_data, \JSON_NUMERIC_CHECK);
?>;
</script>
<div class="publishing-actions-box">
	<div class="black-box"></div>
	<div class="pro-link-box">
	<?php 
\printf(
    /* translators: %1$s: break line, %2$s: anchor opening tag, %3$s: anchor closing tag */
    \esc_html__('%1$sUpgrade to PRO →%2$s to fully unlock all the features', 'flexible-coupons'),
    '<a href="' . \esc_url($pro_url) . '-button" target="_blank" class="pro-link">',
    '</a>'
);
?>
	</div>
	<span class="process_save"><span id="process_save_template"></span><span class="spinner"></span></span>
	<input name="save_wpdesk_canva_template" type="button" class="button button-primary button-large" id="save_wpdesk_canva_template" value="<?php 
\esc_attr_e('Save template', 'flexible-coupons');
?>">
</div>
<div id="wpdesk-canva-root"></div>
<input type="hidden" id="editor_post_id" name="post_ID" value="<?php 
echo isset($post->ID) ? $post->ID : '';
?>"/>
<div class="editor-objects-dev" style="display:none">
	<?php 
\print_r($editor_data);
?>
</div>
<?php 
