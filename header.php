<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta http-equiv="X-DNS-Prefetch-Control" content="on" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<?php get_template_part( 'seo' ); ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
	if ( ox_get_option( 'darkmode' ) ): //开启 夜间模式
		$darkmode_time	= explode( ',', ox_get_option( 'darkmode_time' ) );
		$darkmode_start	= empty($darkmode_time[0]) ? 21 : $darkmode_time[0];
		$darkmode_end	= empty($darkmode_time[1]) ? 6 : $darkmode_time[1]; ?>
<meta name="color-scheme" content="light dark">
<script type= "text/javascript" >
	var darkmode_start = <?php echo $darkmode_start; ?>;var darkmode_end = <?php echo $darkmode_end; ?>;const rootElement=document.documentElement;const darkModeClassName="dark";const darkModeStorageKey="user-color-scheme";const darkModeTimeKey="user-color-scheme-time";const validColorModeKeys={dark:true,light:true};const invertDarkModeObj={dark:"light",light:"dark"};const setLocalStorage=(e,t)=>{try{localStorage.setItem(e,t)}catch(e){}};const removeLocalStorage=e=>{try{localStorage.removeItem(e)}catch(e){}};const getLocalStorage=e=>{try{return localStorage.getItem(e)}catch(e){return null}};const getModeFromCSSMediaQuery=()=>window.matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light";const resetRootDarkModeClassAndLocalStorage=()=>{rootElement.classList.remove(darkModeClassName);rootElement.classList.remove(invertDarkModeObj[darkModeClassName]);removeLocalStorage(darkModeStorageKey)};const applyCustomDarkModeSettings=e=>{const t=e||getLocalStorage(darkModeStorageKey);if(validColorModeKeys[t]){rootElement.classList.add(t);rootElement.classList.remove(invertDarkModeObj[t])}else{resetRootDarkModeClassAndLocalStorage()}};const toggleCustomDarkMode=()=>{let e=getLocalStorage(darkModeStorageKey);if(validColorModeKeys[e]){e=invertDarkModeObj[e]}else if(e===null){e=invertDarkModeObj[getModeFromCSSMediaQuery()]}else{return}setLocalStorage(darkModeStorageKey,e);setLocalStorage(darkModeTimeKey,+new Date);return e};const initDarkMode=e=>{const t=(e.getHours()<darkmode_end?new Date(e.getFullYear(),e.getMonth(),e.getDate()-1,darkmode_end):new Date(e.getFullYear(),e.getMonth(),e.getDate(),darkmode_end)).getTime();const o=(e.getHours()<darkmode_start?new Date(e.getFullYear(),e.getMonth(),e.getDate()-1,darkmode_start):new Date(e.getFullYear(),e.getMonth(),e.getDate(),darkmode_start)).getTime();const a=new Date(parseInt(getLocalStorage(darkModeTimeKey)||"0",10)).getTime();let r=null;e=e.getTime();if(t<o){if(o<a){applyCustomDarkModeSettings()}else{applyCustomDarkModeSettings(darkModeClassName);r=darkModeClassName}}else{if(t<a){applyCustomDarkModeSettings()}else{applyCustomDarkModeSettings(invertDarkModeObj[darkModeClassName]);r=invertDarkModeObj[darkModeClassName]}}if(r){setLocalStorage(darkModeStorageKey,r);setLocalStorage(darkModeTimeKey,+new Date)}};initDarkMode(new Date);
</script>
<?php 
	endif; //夜间模式 结束 ?>
<?php
	if ( check_ad_enabled() && ox_get_option( 'google_ads_js_code' ) ){ //开启 Google 广告，头部输出一次 adsbygoogle.js
		echo ox_get_option( 'google_ads_js_code' );
	}
?>
<?php wp_head(); ?>
<!-- Screen version -->
<link rel="stylesheet" href="https://npm.elemecdn.com/lxgw-wenkai-screen-webfont@1.1.0/style.css" />
  <style>
    body {
      /* Screen version */
      font-family: "LXGW WenKai Screen", sans-serif;
    }
  </style>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header">
		<hgroup><a href="https://yinji.org/" title="回到首页"><img src="https://dogefs.s3.ladydaily.com/lucy/storage/1680832936501.png" alt="胡鹤仙"width="70" height="70"/></a>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php
				//current_user_can('administrator') && 
				if ( ox_get_option( 'site_title_quote' ) ) {
						echo '<div class="site_quote">'.ox_get_option( "site_title_quote" ).'</div>';
				}
			?>
		</hgroup>

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></button>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'nav-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->

		<?php if ( get_header_image() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">
