<?php
/** Don't load directly */
defined( 'ABSPATH' ) || exit;

/** CORE FUNCTIONS */
require_once GULIR_CORE_PATH . 'includes/core-functions.php';
require_once GULIR_CORE_PATH . 'admin/setting-helpers.php';

/** LIBRARY */
if ( is_admin() && ! gulir_is_plugin_active( 'redux-framework/redux-framework.php' ) ) {
	include_once GULIR_CORE_PATH . 'lib/redux-framework/framework.php';
}

/** ADMIN ONLY */
if ( is_admin() ) {
	require_once GULIR_CORE_PATH . 'admin/updater.php';
	require_once GULIR_CORE_PATH . 'lib/rb-meta/rb-meta.php';
	require_once GULIR_CORE_PATH . 'lib/taxonomy/taxonomy.php';

	require_once GULIR_CORE_PATH . 'admin/sub-pages.php';

	/** adobe fonts */
	require_once GULIR_CORE_PATH . 'admin/fonts/init.php';
	require_once GULIR_CORE_PATH . 'admin/fonts/ajax-helpers.php';

	require_once GULIR_CORE_PATH . 'admin/translation/init.php';
	require_once GULIR_CORE_PATH . 'admin/info.php';
	require_once GULIR_CORE_PATH . 'admin/core.php';

	/** importer */
	require_once GULIR_CORE_PATH . 'admin/import/ajax-helpers.php';

	/** GTA */
	require_once GULIR_CORE_PATH . 'admin/gtm/ajax-helpers.php';

	/** author settings */
	require_once GULIR_CORE_PATH . 'admin/profile.php';
}

if ( ! gulir_is_plugin_active( 'gulir-elements/gulir-elements.php' ) ) {
	$element_file = GULIR_CORE_PATH . 'lib/gulir-elements/gulir-elements.php';
	if ( file_exists( $element_file ) ) {
		require_once $element_file;
	}
}

if ( is_admin() && ! class_exists( 'RB_OPENAI_ASSISTANT' ) ) {
	require_once GULIR_CORE_PATH . 'lib/ruby-openai/ruby-openai.php';
}

if ( gulir_is_plugin_active( 'bbpress/bbpress.php' ) ) {
	require_once GULIR_CORE_PATH . 'lib/bbp/bbp.php';
}

/** FUNCTIONS */
require_once GULIR_CORE_PATH . 'includes/function-helpers.php';

/** TEMPLATES */
require_once GULIR_CORE_PATH . 'includes/template-helpers.php';
require_once GULIR_CORE_PATH . 'includes/template-ads.php';
require_once GULIR_CORE_PATH . 'includes/template-share.php';
require_once GULIR_CORE_PATH . 'includes/template-socials.php';
require_once GULIR_CORE_PATH . 'includes/template-svg.php';
require_once GULIR_CORE_PATH . 'includes/template-widgets.php';
require_once GULIR_CORE_PATH . 'includes/gtm.php';

/** CLASSES */
require_once GULIR_CORE_PATH . 'includes/amp.php';
require_once GULIR_CORE_PATH . 'includes/optimized.php';
require_once GULIR_CORE_PATH . 'includes/shortcodes.php';
require_once GULIR_CORE_PATH . 'includes/table-contents.php';
require_once GULIR_CORE_PATH . 'includes/video-thumb.php';
require_once GULIR_CORE_PATH . 'includes/fonts.php';

/** PERSONALIZE */
require_once GULIR_CORE_PATH . 'personalize/database.php';
require_once GULIR_CORE_PATH . 'personalize/helpers.php';

/** REACTION */
require_once GULIR_CORE_PATH . 'reaction/reaction.php';

/** FRONTEND LOGIN */
require_once GULIR_CORE_PATH . 'frontend-login/templates.php';
require_once GULIR_CORE_PATH . 'frontend-login/login-screen.php';
require_once GULIR_CORE_PATH . 'frontend-login/init.php';

/** HOOKS */
require_once GULIR_CORE_PATH . 'includes/hooks.php';

/** RUBY TEMPLATE & ELEMENTOR */
if ( gulir_is_plugin_active( 'elementor/elementor.php' ) ) {
	require_once GULIR_CORE_PATH . 'elementor/template-helpers.php';
	require_once GULIR_CORE_PATH . 'elementor/control.php';
	require_once GULIR_CORE_PATH . 'elementor/ruby-templates/init.php';
	require_once GULIR_CORE_PATH . 'elementor/dark-supported.php';
	require_once GULIR_CORE_PATH . 'elementor/base.php';
}

/** MEMBERSHIP SUPPORTED */
require_once GULIR_CORE_PATH . 'membership/membership.php';
require_once GULIR_CORE_PATH . 'membership/settings.php';

/** RECIPE MARKER SUPPORTED */
require_once GULIR_CORE_PATH . 'wprm/wprm.php';
require_once GULIR_CORE_PATH . 'wprm/settings.php';

/** PODCAST */
require_once GULIR_CORE_PATH . 'podcast/init.php';

/** WIDGETS */
require_once GULIR_CORE_PATH . 'widgets/banner.php';
require_once GULIR_CORE_PATH . 'widgets/fw-instagram.php';
require_once GULIR_CORE_PATH . 'widgets/fw-mc.php';
require_once GULIR_CORE_PATH . 'widgets/ruby-template.php';
require_once GULIR_CORE_PATH . 'widgets/sb-ad-image.php';
require_once GULIR_CORE_PATH . 'widgets/sb-ad-script.php';
require_once GULIR_CORE_PATH . 'widgets/sb-address.php';
require_once GULIR_CORE_PATH . 'widgets/sb-facebook.php';
require_once GULIR_CORE_PATH . 'widgets/sb-flickr.php';
require_once GULIR_CORE_PATH . 'widgets/sb-follower.php';
require_once GULIR_CORE_PATH . 'widgets/sb-instagram.php';
require_once GULIR_CORE_PATH . 'widgets/sb-post.php';
require_once GULIR_CORE_PATH . 'widgets/sb-social-icon.php';
require_once GULIR_CORE_PATH . 'widgets/sb-weather.php';
require_once GULIR_CORE_PATH . 'widgets/sb-youtube.php';