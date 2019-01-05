
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Form Elements</h3>
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
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Design <small>different form elements</small></h2>
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
				 <?php echo $this->session->flashdata('message'); ?>

                    <br />
                    <form id="demo-form2" method="post" action="<?php echo base_url();?>/garages/add" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="garage_name">Garage Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="garage_name" name="garage_name" required="required" value="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="email" name="email" required="required" value=""  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="registration_no" class="control-label col-md-3 col-sm-3 col-xs-12">Registration no</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="registration_no" class="form-control col-md-7 col-xs-12" value=""  type="text" name="registration_no">
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="phone" class="form-control col-md-7 col-xs-12" type="text" value=""  name="phone">
                        </div>
                      </div>
					    <div class="form-group">
                        <label for="logo" class="control-label col-md-3 col-sm-3 col-xs-12">Logo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="logo" class="form-control col-md-7 col-xs-12" type="text" value=""  name="logo">
                        </div>
                      </div>
					    <div class="form-group">
                        <label for="street_address1" class="control-label col-md-3 col-sm-3 col-xs-12">Street address 1</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="street_address1" class="form-control col-md-7 col-xs-12" type="text" value=""  name="street_address1">
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="street_address2" class="control-label col-md-3 col-sm-3 col-xs-12">Street address 2</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="street_address2" class="form-control col-md-7 col-xs-12" type="text" value="" name="street_address2">
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="city" class="form-control col-md-7 col-xs-12" type="text" value="" name="city">
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="state" class="control-label col-md-3 col-sm-3 col-xs-12">State</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="state" class="form-control col-md-7 col-xs-12" type="text" value="" name="state">
                        </div>
                      </div>
					   <div class="form-group">
                        <label for="zipcode" class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="zipcode" class="form-control col-md-7 col-xs-12" value="" type="text" name="zipcode">
                        </div>
                      </div>
                       <input id="id"  value="" type="hidden" name="id">

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button type="submit" name="submit" class="btn btn-success">Add</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- /page content -->