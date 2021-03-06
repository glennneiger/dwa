<h2>Lead Tracker (for Internal Use Only)</h2>
<h3>Welcome back <?=$user->first_name?>!</h3>
			
<table class="tablesorter">
  <caption>
	Leads To Be Worked
  </caption>
  <thead>
	<tr>
	  <th>Lead #</th>
	  <th>Date Entered</th>
	  <th>Street Address</th>
	  <th>City</th>
	  <th>State</th>
	  <th>Status</th>
	  <th>Delete</th>	  
	</tr>
  </thead>
  
  <tbody id="table_results">      
	 <!-- Table Results placeholder -->
  
	<? foreach($leads as $lead): ?>    <!-- (i.e. $key=>lead) -->
		
		<!-- Print this row of table -->
		<!-- Give each row an id so we can fade it out after deleting the lead (Susan) -->
		<tr id="lead_row_<?=$lead['lead_id']?>">				
			<td><?=$lead['lead_id']?></td>
			<td><?=Time::display($lead['created'])?>  </td> 		 <!-- Time & Date entered -->
			<td><?=$lead['address']?></td>  
			<td><?=$lead['city']?></td>
			<td><?=$lead['state']?></td>	
			<td id="lead_row_<?=$lead['lead_id']?>_status>">     
				<!-- <?=$lead['status']?> for debugging -->
				<!-- Make this modifiable (Pending, Accepted, Rejected) -->	
				<!-- Use HTML 5 data attributes to associate lead_id and status with record -->
				
				<!-- Susan's solution -->
				<select name="status" class="status" data-lead-id="<?=$lead['lead_id']?>"
													 data-status-value="<?=$lead['status']?>">								 
					<option value="pending" <? if($lead['status'] == "pending") echo 'selected="selected"' ?>>pending</option>
					<option value="accepted" <? if($lead['status'] == "accepted") echo 'selected="selected"' ?>>accepted</option>
					<option value="rejected" <? if($lead['status'] == "rejected") echo "selected" ?>>rejected</option>
				</select>							
				
			</td>
				
			<!-- Susan: Here's our Delete button. -->
			<!-- Note we're using the HTML 5 "data attribute" to associate the lead_id with it -->
			<!-- More about the data attribute here: http://ejohn.org/blog/html-5-data-attributes/ -->
			<td><input type='button' class='delete' data-lead-id="<?=$lead['lead_id']?>" 
				 value='Delete Lead'>
			</td>
		</tr>	

	<? endforeach; ?>
  </tbody>		  
</table>  
		  
		
		

<script type='text/javascript'>

    // Set up Tablesorter
	$("table.tablesorter").tablesorter({widgets: ['zebra']}); 


	// Use Ajax to do the row deletion and then have JS visually remove that row from the table (Susan)
	// This avoids re-rendering the whole table after deleting a record
	$('.delete').click(function() {
		
		// Figure out the lead_id based on the data attribute
		var lead_id = $(this).attr('data-lead-id');
	
		// Call delete method in our leads controller to do the ajax work of deleting this lead from DB
		$.ajax({
			type: 'POST',
			url: '/leads/delete/',
			success: function(response) { 
				
				// Fade out this lead row since it has now been deleted
				$('#lead_row_' + lead_id).hide('slow');				
			},
			data: {
				// Make sure we tell our method what the lead_id is
				lead_id: lead_id,
			},
		});
		
	});


		
		
	// Use Ajax to change "status" field in DB after user changes status in drop-down menu  

	// Either $(".status") or $("select").change(function()) will work
	//$('.status').change(function() {  
	$("select").change(function () {

		// Figure out the lead_id based on the data attribute
		var lead_id = $(this).attr('data-lead-id');		
		console.log(lead_id);
		
		// Figure out the status (pending, accepted, rejected) based on the data attribute
		var status = $(this).attr('data-status-value');  //original DB status (for debugging)
		console.log(status);		
        status =  $(this).attr('value');				 //new selected status to insert into DB 
		console.log(status);
	
		// Call update_status method in leads controller to do the ajax work of updating status in DB
		$.ajax({
			type: 'POST',
			url: '/leads/update_status/',
			success: function(response) { 				
				// Update the status field in this row? Already have changed it! No need.				
			},
			data: {
				// Make sure we tell our method the lead_id and status 
				lead_id: lead_id,			
				status: status,
			},
		});
		
	});
</script>		