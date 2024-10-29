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
	<div class="momo-ms-admin-content-main momorssfeed-editor-main" id="momorssfeed-editor-main-form">
		<div class="momo-be-block-section" id="momo-rssfeed-new-section">
			<h2 class="momo-be-block-section-header"><?php esc_html_e( 'Add Feed URL', 'momoacg' ); ?></h2>
			<p>
				<?php esc_html_e( 'Adding RSS feed url will generate title(s) from feed and add it to queue which will be processed automatically after some time', 'momoacg' ); ?>
			</p>
			<div class="momo-be-msg-block"></div>
			<div class="momo-be-block momo-cs-plan-form momo-mt-30">
				<div class="momo-be-messagebox"></div>
				<div class="momo-be-block momo-mb-20 momo-full-block">
					<label class="regular"><?php esc_html_e( 'Feed URL', 'momoacg' ); ?></label>
					<input type="text" class="full-width momo-green" name="momo_rssfeed_url" autocomplete="off" placeholder="<?php echo esc_url( 'http://test.momothemes.com/rss.xml' ); ?>">
				</div>
				<div class="momo-be-block momo-mb-20 momo-full-block">
					<div class="momo-be-block momo-half-block">
						<label class="regular">
							<?php esc_html_e( 'Select Category', 'momoacg' ); ?>
						</label>
						<select name="momo_rssfeed_category" class="full-width momo-green">
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
				</div>
				<div class="momo-be-block momo-full-block">
					<label class="regular">
						<?php esc_html_e( 'Save generated post as:', 'momoacg' ); ?>
					</label>
					<select name="momo_rssfeed_status" class="full-width momo-green">
						<option value="momoacg_post_draft"><?php esc_html_e( 'Plugin Draft', 'momoacg' ); ?></option>
						<option value="wp_post_draft"><?php esc_html_e( 'Post Draft', 'momoacg' ); ?></option>
						<option value="wp_post_publish"><?php esc_html_e( 'Post Publish', 'momoacg' ); ?></option>
					</select>
				</div>
				<div class="momo-be-block momo-mb-20 momo-w-80">
					<p class="regular">
						<?php esc_html_e( 'Generate title(s) and add to queue', 'momoacg' ); ?>
					</p>
					<span class="button button-secondary momo-rssfeed-generate-queue"><?php esc_html_e( 'Process', 'momoacg' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>
