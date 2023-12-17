<?php
define('ABSPATHOUT', $_SERVER['HTTP_HOST']);//$_SERVER['SERVER_NAME']
if ( //strlen($_SERVER['REQUEST_URI']) > 384 ||
	strpos($_SERVER['REQUEST_URI'], "eval(") ||
	strpos($_SERVER['REQUEST_URI'], "base64")) {
		@header("HTTP/1.1 414 Request-URI Too Long");
		@header("Status: 414 Request-URI Too Long");
		@header("Connection: Close");
		@exit;
}
if ( !function_exists( 'base64url_encode' ) ) {
  function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }
}
if ( !function_exists( 'base64url_decode' ) ) {
  function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
  }
}
$t_url = preg_replace('/^url=(.*)$/i','$1',$_SERVER["QUERY_STRING"]);

if(!empty($t_url)) {
	//判断取值是否加密
    if ($t_url == base64url_encode(base64url_decode($t_url))) {
        $t_url =  base64url_decode($t_url);
    }else if ($t_url == base64_encode(base64_decode($t_url))) {
        $t_url =  base64_decode($t_url);
    }
	preg_match('/(http|https):\/\//',$t_url,$matches);
	if($matches){
		$url=$t_url;
	} else {
		$url = 'https://'.ABSPATHOUT;
	}
} else {
	$url = 'https://'.ABSPATHOUT;
}

$url = str_replace(",", "%2C", $url ); ?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="robots" content="noindex, nofollow" />
<style>body,div,h1,h2,h3,h4,html,span{border:0;font-family:inherit;font-size:100%;font-style:inherit;margin:0;outline:0;padding:0;vertical-align:baseline}html{font-size:10px;overflow-y:scroll;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#333}body,html{background:#faeee4}.serif,body,button,input,select,textarea{font-family:-apple-system,BlinkMacSystemFont,"Helvetica Neue",Arial,"PingFang SC","Microsoft YaHei","Source Han Sans SC","Noto Sans CJK SC","WenQuanYi Micro Hei",sans-serif;font-size:1.5rem;font-size:15px;font-weight:400;line-height:1.6}a, a:visited{color:#800000}a, a:visited{text-decoration:underline;text-underline-offset:2px}a:hover{color:#00e}.gray, .gray a{color:#888}.link_clr a, a.link_clr{color:#1a237e}#red{color:#ea4335;font-weight:bold}#purple{color:#4D049F;font-weight:bold}#blue{color:#4285f4}#green{color:#34a853}ul{list-style:circle;margin:8px 0 0;padding:0 0 0 22px}ul li:not(:first-child){padding-top:4px}.scene{width:360px;margin:18px auto}h1.scene-title{overflow:hidden;white-space:nowrap;word-break:normal;text-overflow:ellipsis}.scene-title a{color:#222;text-decoration:none}.scene-nav{margin:8px 0;padding:0 8px}.scene-card{border:3px solid #800000;border-radius:6px 6px 0 0}.scene-card-title{font-weight:700;padding:8px;background:#f90;color:#000;text-align:center}.scene-card-content{margin:8px 0;padding:0 8px}.scene-card-content h2{margin:0 0 0 6px}.scene-card-notice{margin:0;color:#4D049F}.scene-card-meta{color:#aaa;font-weight:700;background:#800000;padding:10px 6px;text-align:center}.scene-card-meta a{color:#fff}.scene-card-meta a:hover{color:#eee}.scene-card-ad1{margin:2px 0 0}.scene-card-ad4{margin:0 0 2px}@media screen and (max-width:480px){.serif,body,button,input,select,textarea{font-size:15px;font-size:1.5rem}}</style>
<noscript><meta http-equiv="refresh" content="1;url='<?php echo $url;?>';"></noscript>
<script>
	function link_jump() {
		var MyHOST = new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>");
		if (!MyHOST.test(document.referrer)) {
			location.href="https://" + MyHOST;
		}
		location.href="<?php echo $url;?>";
	}
	setTimeout(link_jump, 1688);
	setTimeout(function(){window.opener=null;window.close();}, 222222);
</script>

<title>页面加载中,请稍候...</title>
</head>
<body>

<div class="scene">
	<div class="scene-card">
		<div class="scene-card-title">页面加载中，请稍后……</div>
		<div class="scene-card-content">
			<ul>
				<li><a title="推荐VPS" href="https://yinji.org/RackNerd.html" target="_blank" rel="noopener">超值特惠</a>：RackNerd</li>
				<li><a title="推荐VPS" href="https://yinji.org/CloudCone.html" target="_blank" rel="noopener">超值特惠</a>：CloudCone</li>
			</ul>
		</div>

		<div class="scene-card-meta">
			「<a href="<?php echo 'https://'.ABSPATHOUT;?>" rel="bookmark">首页</a>」或「<a title="立即前往" href="<?php echo $url;?>" rel="nofollow noopener noreferrer">传送门</a>」或「<a title="立即前往" href="<?php echo $url;?>" rel="nofollow noopener noreferrer">立即前往</a>」
		</div>
	</div>
</div>
</body>
</html>