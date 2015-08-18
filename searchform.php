<div id="sb-search-searchform" class="sb-search row sb-search-open">
	<form action="<?php echo home_url('/erg-search'); ?>" method="get">
		<input class="sb-search-input" placeholder="Search the ERG website..." type="text" value="" name="search_for" id="s">
		<input class="sb-search-submit" type="submit" value="">
		<span class="sb-icon-search glyphicon glyphicon-search"></span>
	</form>
</div>

<script>
new UISearch( document.getElementById( 'sb-search-searchform' ) );
</script>