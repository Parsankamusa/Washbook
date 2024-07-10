<?php global $s_v_data, $user, $title, $companies; ?>
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
                <div class="col-md-12">
                    <h3><?=  $title ; ?></h3>
                    <p class="text-gray-500">List of companies that have created accounts.</p>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Company</th>
                                <th>Owner</th>
                                <th>Branches</th>
                                <th>Staff</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($companies)) { ?>
                            <?php foreach ($companies as $index => $company) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="text-avatar">
                                            <span><?=  mb_substr($company->name, 0, 2, "UTF-8") ; ?></span>
                                        </div>
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $company->name ; ?></span>
                                            <span><?=  $company->phone ; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-profile">
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $company->owner->fname ; ?> <?=  $company->owner->lname ; ?></span>
                                            <span><?=  $company->owner->phonenumber ; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?=  number_format($company->branches) ; ?> </td>
                                <td> <?=  number_format($company->staff) ; ?> </td>
                                <td class="fw-bold">
                                    <?php if ($company->status == "Active") { ?>
                                    <span class="text-success">Active</span>
                                    <?php } else if ($company->status == "Expired") { ?>
                                    <span class="text-warning">Expired</span>
                                    <?php } else { ?>
                                    <span class="text-danger">Inactive</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="<?=  url('Companies@details', array('companyid' => $company->id)) ; ?>"><span class="dropdown-svg-icon"><?=  icon('eye-outline') ; ?></span>View Details</a>
                                      <a class="dropdown-item fetch-display-click" data="companyid:<?=  $company->id ; ?>" url="<?=  url('Companies@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                      <a class="dropdown-item send-to-server-click"  data="companyid:<?=  $company->id ; ?>" url="<?=  url('Companies@delete') ; ?>" warning-title="Are you sure?" warning-message="This company's profile, sales related and data will be deleted permanently. You could consider setting this company Inactive." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Company</a>
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
                <h5 class="modal-title">Add a Team Member</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Team@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Enter team member details.</p>
                    <div class="row space-nne">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="First Name" name="fname" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Last Name" name="lname" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control form-control-lg" placeholder="Email Address" name="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" required>
                                <input class="hidden-phone" type="hidden" name="phonenumber" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Address" name="address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Role <span class="text-primary d-inline" data-toggle="tooltip" title="Owner and Manager have access to the system and require and email access to login. Staff accounts have no access to the system."><em class="icon ni ni-info"></em></span></label>
                                <select class="form-control form-control-lg" name="role">
                                    <option value="Staff">Staff</option>
                                    <option value="Manager">Manager - Branch Access</option>
                                    <?php if ($user->role == "Owner") { ?>
                                    <option value="Owner">Owner - Full Access</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Branch</label>
                                <select class="form-control form-control-lg" name="branchid">
                                    <?php if (!empty($branches)) { ?>
                                    <?php foreach ($branches as $branch) { ?>
                                    <option value="<?=  $branch->id ; ?>"><?=  $branch->name ; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Type</label>
                                <select class="form-control form-control-lg" name="type">
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Subcontractor">Subcontractor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-control form-control-lg" name="status">
                                    <option value="Active">Active</option>
                                    <option value="On Leave">On Leave</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Add a Member</button>
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
