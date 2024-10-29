<?php
/**
 * MoMO AutoBlog - Settings Page
 *
 * @author MoMo Themes
 * @package momoacg
 * @since v3.5.0
 */

global $momoacg;
$all_styles = $momoacg->lang->momo_get_all_writing_style();
?>
<div class="momo-admin-content-box">
	<div class="momo-ms-admin-content-main momoautoblog-editor-main" id="momoautoblog-editor-main-form">
		<div class="momo-be-block-section" id="momo-auto-blog-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Auto Blog', 'momoacg' ); ?></h2>
			<div class="momo-be-msg-block"></div>
			<div class="momo-be-block momo-mt-30">
				<div class="momo-be-messagebox"></div>
				<div class="momo-be-block momo-mb-20 momo-full-block">
					<label class="regular">
						<?php esc_html_e( 'Select Category', 'momoacg' ); ?>
					</label>
					<select name="momo_autoblog_category" class="full-width momo-green">
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
				<div class="momo-row momo-mt-20">
					<div class="momo-col">
						<label  class="regular"><?php esc_html_e( 'Add Keywords', 'momoacg' ); ?>:</label>
						<input type="text" class="full-width momo-green" name="momo_autoblog_keywords" placeholder="<?php echo esc_html( 'nepali food, chinese food, indian food' ); ?>">
					</div>
				</div>
				<div class="momo-row momo-mt-20">
					<div class="momo-col">
						<label  class="regular"><?php esc_html_e( 'Number of posts', 'momoacg' ); ?>:</label>
						<select name="momo_autoblog_nop" class="full-width momo-green">
							<option value="1"><?php esc_html_e( '1', 'momoacg' ); ?></option>
							<option value="2"><?php esc_html_e( '2', 'momoacg' ); ?></option>
							<option value="3"><?php esc_html_e( '3', 'momoacg' ); ?></option>
							<option value="4"><?php esc_html_e( '4', 'momoacg' ); ?></option>
							<option value="5"><?php esc_html_e( '5', 'momoacg' ); ?></option>
						</select>
					</div>
					<div class="momo-col">
						<label  class="regular"><?php esc_html_e( 'Per', 'momoacg' ); ?>:</label>
						<select name="momo_autoblog_per" class="full-width momo-green">
							<option value="daily"><?php esc_html_e( 'Day', 'momoacg' ); ?></option>
							<option value="weekly"><?php esc_html_e( 'Week', 'momoacg' ); ?></option>
							<option value="monthly"><?php esc_html_e( 'Month', 'momoacg' ); ?></option>
							<option value="yearly"><?php esc_html_e( 'Year', 'momoacg' ); ?></option>
						</select>
					</div>
				</div>
				<div class="momo-row momo-mt-20">
					<div class="momo-col">
						<label class="regular">
							<?php esc_html_e( 'Writing Style', 'momoacg' ); ?>
						</label>
						<select name="momo_autoblog_writing_style" class="full-width momo-green">
							<?php foreach( $all_styles as $value => $name ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $name ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="momo-col">
						<label  class="regular"><?php esc_html_e( 'Number of paragraphs', 'momoacg' ); ?>:</label>
						<select name="momo_autoblog_nof_para" class="full-width momo-green">
							<option value="1"><?php esc_html_e( '1', 'momoacg' ); ?></option>
							<option value="2"><?php esc_html_e( '2', 'momoacg' ); ?></option>
							<option value="3"><?php esc_html_e( '3', 'momoacg' ); ?></option>
							<option value="4"><?php esc_html_e( '4', 'momoacg' ); ?></option>
							<option value="5"><?php esc_html_e( '5', 'momoacg' ); ?></option>
						</select>
					</div>
				</div>
				<div class="momo-row momo-mt-20">
					<div class="momo-col">
						<label class="regular">
							<?php esc_html_e( 'Generate Title', 'momoacg' ); ?>
						</label>
						<span class="momo-be-toggle-container">
							<label class="switch">
								<input type="checkbox" class="switch-input" name="momo_autoblog_generate_title" autocomplete="off">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
						</span>
					</div>
					<div class="momo-col">
						<label class="regular">
							<?php esc_html_e( 'Add Image', 'momoacg' ); ?>
						</label>
						<span class="momo-be-toggle-container">
							<label class="switch">
								<input type="checkbox" class="switch-input" name="momo_autoblog_add_image" autocomplete="off">
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
						</span>
					</div>
				</div>
				<div class="momo-be-block momo-mt-20 momo-full-block">
					<label class="regular">
						<?php esc_html_e( 'Save generated post as', 'momoacg' ); ?>
					</label>
					<select name="momo_autoblog_status"  class="full-width momo-green">
						<option value="momoacg_post_draft"><?php esc_html_e( 'Plugin Draft', 'momoacg' ); ?></option>
						<option value="wp_post_draft"><?php esc_html_e( 'Post Draft', 'momoacg' ); ?></option>
						<option value="wp_post_publish"><?php esc_html_e( 'Post Publish', 'momoacg' ); ?></option>
					</select>
				</div>
				<div class="momo-be-block momo-mb-20 momo-w-80">
					<p class="regular">
						<?php esc_html_e( 'Add to queue', 'momoacg' ); ?>
					</p>
					<span class="button button-secondary momo-autoblog-generate-queue"><?php esc_html_e( 'Process', 'momoacg' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>
