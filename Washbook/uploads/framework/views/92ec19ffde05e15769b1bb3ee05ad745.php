<?php global $s_v_data, $user, $title, $branches, $services; ?>
<?= view( 'includes/head', $s_v_data ); ?>
<body>
    <!-- Header -->
    <?= view( 'includes/header', $s_v_data ); ?>

    <!-- Aside -->
    <?= view( 'includes/aside', $s_v_data ); ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="craft-container">
            <div class="row craft-page-head">
                <div class="col-md-6">
                    <h3><?=  $title ; ?></h3>
                    <p class="text-gray-500">List of company branches.</p>
                </div>
                <div class="col-md-6 header-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create"><span class="btn-svg-icon"><?=  icon('plus') ; ?></span>Add a Branch</button>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Name / Services</th>
                                <th>Location</th>
                                <th>Phone Number</th>
                                <th>Revenue</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($branches)) { ?>
                            <?php foreach ($branches as $index => $branch) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $branch->name ; ?></span>
                                            <span><?=  $branch->services ; ?> services offered</span>
                                        </div>
                                    </div>
                                </td>
                                <td><?=  $branch->location ; ?> </td>
                                <td><?=  $branch->phone ; ?> </td>
                                <td> <?=  money($branch->revenue, $user->parent->currency) ; ?> </td>
                                <td class="fw-bold">
                                    <span class="text-success">Active</span>
                                </td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="<?=  url('Branches@details', array('branchid' => $branch->id)) ; ?>"><span class="dropdown-svg-icon"><?=  icon('eye-outline') ; ?></span>View Details</a>
                                      <a class="dropdown-item fetch-display-click" data="branchid:<?=  $branch->id ; ?>" url="<?=  url('Branches@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                      <a class="dropdown-item send-to-server-click"  data="branchid:<?=  $branch->id ; ?>" url="<?=  url('Branches@delete') ; ?>" warning-title="Are you sure?" warning-message="This branch and all it's sales data will be deleted permanently." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Branch</a>
                                  </div>
                                </td>
                            </tr><!-- .nk-tb-item  -->
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="7">It's empty here!</td>
                            </tr>
                            <?php } ?>
                         </tbody>
                     </table>
                </div>
            </div>
        </div>
    </main>


<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="create">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Branch</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Branches@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Enter branch details.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Branch Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Service Name" name="name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Branch Location</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Branch Location" name="location" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch Phone</label>
                                <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" name="phone" required="">                                                                        
                                <input class="hidden-phone" type="hidden" name="phone">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="line-divider">
                                <hr class="hr" />
                            </div>
                            <p class="text-gray-500">Select services offered at this branch;</p>
                        </div>
                            <?php if (!empty($services)) { ?>
                            <?php foreach ($services as $service) { ?>
                            <div class="col-md-6">
                                <div class="craft-wrap craft-switch">
                                    <input type="checkbox" name="services[]" id="service-<?=  $service->id ; ?>" class="craft-input" value="<?=  $service->id ; ?>" checked="">
                                    <label class="craft-label" for="service-<?=  $service->id ; ?>"><?=  $service->name ; ?></label>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="col-md-12">
                                <div class="empty">
                                    <img src="<?=  asset('assets/images/empty.svg') ; ?>">
                                    <h4>No services added yet!</h4>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Add a Branch</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?= view( 'includes/footer', $s_v_data ); ?>
<?= view( 'includes/scripts', $s_v_data ); ?>

</body>

</html>
<?php return;
