<div id="mainpagepicker">
<?php /*<fieldset class="leftpicker">
	<button class="<?php if ($activepicker == "AddDetail") { echo('active'); } ?>pickerbutton" onClick="showAddDetail()">Add Detail</button>
</fieldset>*/ ?>
<fieldset class="picker">
	<button class="<?php if ($activepicker == "List") { echo('active'); } ?>pickerbutton" onClick="showList()">List</button>
	<button class="<?php if ($activepicker == "Map") { echo('active'); } ?>pickerbutton" onClick="showMap()">Map</button>
	<button class="<?php if ($activepicker == "Search") { echo('active'); } ?>pickerbutton" onClick="showSearch()">Search</button>
</fieldset>
</div>
