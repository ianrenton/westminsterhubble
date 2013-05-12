            <?php /*$activepicker = "AddDetail";
			include('mainpagepicker.php');*/ ?>

			<div id="adddetail">
                <div id="explanation"><p>We're always looking for more sources of information.  Do you know the website, blog, Twitter or Facebook account of an MP that we don't?  Just enter their name and URL/username in the boxes below, and we'll check it out and get it added to the system.</p></div>
				<form id="adddetailform" name="adddetailform" method="post" action="setdetail.php">
				<fieldset class="adddetail">
                	<label for="name">Name: </label><input type="text" name="name" id="name" class="name" autocomplete="off" value="" />
					<label for="url">URL/Username: </label><input type="text" name="url" id="url" class="url" autocomplete="off" value="" />
					<button class="submit" type="submit" name="submit" title="Submit">Submit</button>
                </fieldset>
				</form>
		  </div>