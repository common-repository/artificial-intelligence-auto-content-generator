<?php
/**
 * MoMO BulkCW - Editor Page
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v1.0.0
 */

?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momobulkcw-editor-main" id="momobulkcw-editor-main-form">
		<div class="momo-be-msg-block"></div>
		<div class="momo-be-block-section" id="momo-bulkcw-title-tow-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Title(s) List', 'momoacg' ); ?></h2>
			<div class="momo-be-block">
				<table class="momo-acg-bulkcw-titles-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Title', 'momoacg' ); ?></th>
							<th class="momo-be-center"><?php esc_html_e( 'Schedule', 'momoacg' ); ?></th>
							<th><?php esc_html_e( 'Paragraphs', 'momoacg' ); ?></th>
							<th><?php esc_html_e( 'Category', 'momoacg' ); ?></th>
							<th><?php esc_html_e( 'Image', 'momoacg' ); ?></th>
						</tr>
					</thead>
					<tbody data-row_count="1">
						<?php $momoacg->bulkcwfn->momo_echo_bulkcw_title_row(); ?>
					</tbody>
				</table>
			</div>
			<div class="momo-be-hr-line"></div>
			<div class="momo-be-block">
				<span class="momo-be-btn-secondary momo-be-btn momo_bulkcw_add_new_title_row"><?php esc_html_e( 'Add new Title', 'momoacg' ); ?></span>
			</div>
		</div>
		<div class="momo-be-hr-line"></div>
		<div class="momo-be-block-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Save generated content as :', 'momoacg' ); ?></h2>
			<div class="momo-row momo-be-block momo-bulkcw-bottom-column">
				<div class="momo-col">
					<span class="momo-radio-button-holder">
						<input type="radio" id="momoacg_post_draft" name="momo_bulkcw_post_type" value="momoacg_post_draft" checked="checked">
					</span>
					<label for="html"><?php esc_html_e( 'Plugin Draft', 'momoacg' ); ?></label>
				</div>
				<div class="momo-col">
					<span class="momo-radio-button-holder">
						<input type="radio" id="wp_post_draft" name="momo_bulkcw_post_type" value="wp_post_draft">
					</span>
					<label for="html"><?php esc_html_e( 'Post Draft', 'momoacg' ); ?></label>
				</div>
				<div class="momo-col">
					<span class="momo-radio-button-holder">
						<input type="radio" id="wp_post_publish" name="momo_bulkcw_post_type" value="wp_post_publish">
					</span>
					<label for="html"><?php esc_html_e( 'Post Publish', 'momoacg' ); ?></label>
				</div>
			</div>
			<div class="momo-be-block momo-bulkcw-category-section momo-hidden">
				<!-- <div class="momo-row">
					<div class="momo-col"></div>
					<div class="momo-col momo-mt-15">
						<label class="regular">
							<?php esc_html_e( 'Select Category', 'momoacg' ); ?>
						</label>
						<select name="momo_bulkcw_category">
						<?php
						$categories = get_categories(
							array(
								'orderby' => 'name',
								'order'   => 'ASC',
							)
						);

						foreach ( $categories as $category ) {
							?>
							<option value="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></option>
							<?php
						}
						?>
						</select>
					</div>
					<div class="momo-col"></div>
				</div> -->
			</div>
		</div>
		<div class="momo-be-hr-line no-line"></div>
		<div class="momo-center momo-be-generate-bulk-buttons">
			<span class="momo-be-btn-primary momo-be-btn momo_bulkcw_generate_bulk_content"><?php esc_html_e( 'Add title(s) to queue', 'momoacg' ); ?></span>
		</div>
	</div>
</div>
