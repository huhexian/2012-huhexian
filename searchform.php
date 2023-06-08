<div id="searchbar">
	<form role="search" method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label>
			<input type="search" class="search-field" placeholder="太多信息资源找不到？搜索试试！" value="<?php echo get_search_query(); ?>" name="s" />
		</label>
		<!--<button type="submit" class="search-submit">搜索</button>-->
	</form>
</div>