<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Garages <small>Listing </small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Listing <?php //print_r($listing); ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <p>Simple table with project listing with progress and editing options</p>

                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 1%">#</th>
                          <th style="width: 20%">Garage</th>
                          <th>Email</th>
                          <th>Registration Number</th>
                          <th>City</th>
                          <th style="width: 20%">#Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                      
						<?php foreach($listing->list as $list) { ?>
						  <tr>
						<td>#</td>
						<td><?php echo $list->name; ?></td>
						<td><?php echo $list->email; ?></td>
						<td><?php echo $list->registration_no; ?></td>
						<td><?php echo $list->city; ?></td>
						<td>
                            <a href="<?php echo base_url();?>garages/view/<?php echo $list->garage_id; ?> " class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                            <a href="<?php echo base_url();?>garages/view/<?php echo $list->garage_id; ?> " class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                            <a href="#" class="btn btn-danger btn-xs delete" data="<?php echo $list->garage_id; ?>" id="delete"><i class="fa fa-trash-o"></i> Delete </a>
                          </td>	
						 </tr>
						<?php  } ?>
                      </tbody>
                    </table>
                    <!-- end project list -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script>
		$(".delete").click(function() {
			var id= $(this).attr("data");
			if(confirm("Are you sure want to delete?")) {
				$(this).parent().parent().fadeOut();
			$.ajax({  
			type: "POST",  
			url: "http://careermarshalletters.com/app/api/garage/deletegarage",  
			data: {'key':'t1E1a6p3j2','garage_id':id},  
			success: function(dataString) {  
				//$('#mentor_list').html(dataString);
				
				console.log('**mentor_list div updated via ajax.**'); 
			}			
		}
  
		) }});  
		</script>
        <!-- /page content -->