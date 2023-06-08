<?php

//The template for optionsframework option page

function optionsframework_option_name() {
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

function optionsframework_options() {

	$imagepath =  get_template_directory_uri() . '/inc/options/images/';

	$options = array();

	// 首页设置

	$options[] = array(
		'name' => '基本设置',
		'type' => 'heading'
	);

	$options[] = array(
		'name' => '首页描述',
		'desc' => '首页 SEO 描述',
		'id' => 'home_description',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '首页关键词',
		'desc' => '首页 SEO 关键词',
		'id' => 'home_keywords',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '开启夜间模式',
		'desc' => '开启、关闭夜间模式',
		'id' => 'darkmode',
		'class' => 'be_ico',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '夜间模式时段',
		'desc' => '夜间模式起始时间，默认晚上21时~早上6时，21,6',
		'id' => 'darkmode_time',
		'class' => '',
		'std' => '21,6',
		'type' => 'text'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '文章内容密码',
		'desc' => '加密内容密码，建议公众号关键词自动发送',
		'id' => 'post-secret-code',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '公众号名称',
		'desc' => '关键词自动发送密码公众号名称',
		'id' => 'post-secret-name',
		'class' => '',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '公众号二维码',
		'desc' => '关键词自动发送密码公众号二维码地址',
		'id' => 'post-secret-qrcode',
		'class' => '',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '站点名称右侧短语',
		'desc' => '站点名称右侧短语，建议20字左右',
		'id' => 'site_title_quote',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '插入内容段落',
		'desc' => '文章快速插入预定内容段落，多段用 | 分割，[theme_insert_content_block ids=x] 短代码调用，如第一段，x=1',
		'id' => 'content_block_text',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '首页排除指定分类',
		'desc' => '排除指定分类，多个分类ID用半角逗号","隔开',
		'id' => 'home_exclude_cat',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '首页排除标签',
		'desc' => '排除指定标签，多个标签ID用半角逗号","隔开',
		'id' => 'home_exclude_tag',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '主页第一篇文章下插播指定分类文章',
		'desc' => '输入插播分类ID，多个分类用半角逗号","隔开，建议单个',
		'id' => 'home_set_cat',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'id' => 'clear'
	);


	$options[] = array(
		'name' => 'FastCGI 缓存路径、文章/页面浏览数量',
		'desc' => '启用 FastCGI_Cache，使用 js 更新浏览数；日志路径 /var/run/nginx-cache/purge.log；缓存路径 /var/run/nginx-cache',
		'id' => 'post_views_fastcgi_cache',
		'class' => 'be_ico',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => '不显示浏览数量',
		'desc' => '访客不展示文章、页面浏览数量',
		'id' => 'post_views_guest_off',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '禁用 Feed',
		'desc' => '开启/禁用 RSS Feed',
		'id' => 'feed_rss_enable',
		'class' => 'be_ico',
		'std' => '0',
		'type' => 'checkbox'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '自定义 Favicon 信息',
		'desc' => '可使用 https://realfavicongenerator.net 工具生成完整 html 代码',
		'id' => 'custom_favicon',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'name' => '自定义后台 Favicon 图标',
		'desc' => '格式：&lt;link rel="shortcut icon" href="//xuv.cc/favicon.ico"&gt;',
		'id' => 'custom_favicon_admin',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => 'WordPress 站点图标',
		'desc' => 'site_icon hook 格式：//xuv.cc/site_icon.png',
		'id' => 'custom_site_icon_hook',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '统计代码',
		'desc' => 'Google Analytics 等完整统计代码，页脚加载。',
		'id' => 'analyticscode',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '页脚信息',
		'desc' => '建站日期，格式 1972-11-11',
		'id' => 'copyright',
		'class' => 'be_ico',
		'std' => '1911-11-11',
		'type' => 'text'
	);

	$options[] = array(
		'name' => '页脚第一行信息',
		'desc' => '显示在第一行结尾，支持 html',
		'id' => 'footerinfo_first',
		'class' => '',
		'std' => '',
		'type' => 'editor'
	);

	$options[] = array(
		'name' => '页脚第二行信息',
		'desc' => '显示页脚第二行（第一行下面），支持 html',
		'id' => 'footerinfo',
		'class' => '',
		'std' => '',
		'type' => 'editor'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '文章开始信息',
		'desc' => '文章第一段后插入指定内容，支持 html',
		'id' => 'article_info_head',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'editor'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '文章末尾信息',
		'desc' => '文章最后插入指定内容，支持 html',
		'id' => 'article_info_foot',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'editor'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => 'Gravatar 头像镜像源',
		'desc' => 'Gravatar 镜像源地址，如 cn.gravatar.com',
		'id' => 'cn_avatar_url',
		'class' => 'be_ico',
		'std' => 'cravatar.cn',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '评论名称黑名单',
		'desc' => '黑名单禁止提交评论，使用半角逗号","隔开',
		'id' => 'comments_name_blacklist',
		'class' => 'be_ico',
		'std' => 'seo,排行榜,销量,赚,新闻网,婚纱摄影,公司,网站优化,关键词,厂家,品牌,液压机,烘干机,服务器,生产,美容,护肤,教程,价格,培训,化妆,网贷,.com,销售,娱乐,赌,体育,彩票,兼职,0,1,2,3,4,5,6,7,8,9,什么,买,店铺,美图,网址,论文,代写,电影,商店,母婴,自媒体,搬瓦工,主机,科学,上网,减肥,减脂,瘦腰,澳门,商学院,割样机,媒体,电视机,mei体,游戏,棋牌,.net,.com,.cn,企业,vps,泵,资源,vultr,鬼子',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '评论 Email 黑名单',
		'desc' => 'Email 黑名单禁止提交评论，使用半角逗号","隔开',
		'id' => 'comments_email_blacklist',
		'class' => 'be_ico',
		'std' => 'fgd@163.com,2712914619@qq.com,qq@qq.com,admin@admin.com,xxx@qq.com,xxx@163.com,103551@qq.com',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '文章内容替换',
		'desc' => '格式：z701.com->545c.com，多组使用半角逗号","隔开',
		'id' => 'text_ctfile_replace',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '评论内容自动替换关键词',
		'desc' => '格式：翻强->番茄，关键词使用半角逗号","隔开',
		'id' => 'text_content_replace',
		'class' => 'be_ico',
		'std' => '翻强->番茄',
		'type' => 'textarea'
	);

	// 广告设置

	$options[] = array(
		'name' => '广告管理',
		'type' => 'heading'
	);

	// 是否 启用 Google 广告 / 自动广告
	$google_ads_en_array = array( "0" => "禁用 Google 广告", "1" => "启用 Google 广告" );
	$options[] = array(
		'name' => 'Google 广告管理',
		'desc' => '启用/禁用 Google 广告',
		'id' => 'google_ads_enable',
		'class' => 'be_ico',
		'std' => '0',
		'type' => 'radio',
		"options" => $google_ads_en_array
	);

	$options[] = array(
		'name' => 'Google 广告JS代码',
		'desc' => 'Google 广告JS代码 &lt;/head&gt; 前',
		'id' => 'google_ads_js_code',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '排除广告文章/页面 ID',
		'desc' => '指定文章/页面 ID 不显示广告',
		'id' => 'google_ec_post_page_ids',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '首页 Google 广告 1',
		'desc' => '首页 特定分类文章下 或 首页第1篇文章下 Google 广告',
		'id' => 'google_ad_info_index',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '首页 Google 广告 2',
		'desc' => '首页 第二页开始 文章列表前 Google 广告',
		'id' => 'google_ad_info_index_paged',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '文章 Google 广告 1',
		'desc' => '文章第一段后 Google 广告',
		'id' => 'google_ads_single_first',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '文章 Google 广告 2',
		'desc' => '文章最后一段前 Google 广告',
		'id' => 'google_ads_single_last',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '其它广告管理-分类/标签页面文章列表前广告',
		'desc' => '分类/标签页面文章列表前广告，支持 html',
		'id' => 'archive_ad_info',
		'class' => 'be_ico',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'id' => 'clear'
	);

	$options[] = array(
		'name' => '评论框广告',
		'desc' => '评论框下文字广告，支持 html',
		'id' => 'commentform_ad_info',
		'class' => '',
		'std' => '',
		'type' => 'textarea'
	);
	return $options;
}