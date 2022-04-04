<?php
/**
 * Search view to search/filter Clubs
 */
?>
<div class="search-container">
	<p>Filter Riders By: </p>
	<form id="searchForm" method="post">
		@csrf

		<div class="form-element">
			<label>Keyword</label>
			<div class="form-input"><input type="text" name="keyword" value="{{ $keyword }}" /></div>
		</div>
<?php
/*
TODO: Add filter by select menu for
		'statesId',
*/
?>

		<div class="form-element">
			<label>&nbsp;</label>
			<div class="form-input"><input type="submit" name="search" value="Search" class="button" /></div>
		</div>
	</form>
</div>
