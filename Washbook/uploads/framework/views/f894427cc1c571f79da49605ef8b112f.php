<?php global $s_v_data, $user, $title, $members, $branches; ?>
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
                    <p class="text-gray-500">List of company employees.</p>
                </div>
                <div class="col-md-6 header-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create"><span class="btn-svg-icon"><?=  icon('plus') ; ?></span> Add a Member</button>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Member</th>
                                <th>Role</th>
                                <th>Balance</th>
                                <th>S. Offered</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($members)) { ?>
                            <?php foreach ($members as $index => $member) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="text-avatar">
                                            <span><?=  mb_substr($member->fname, 0, 2, "UTF-8") ; ?></span>
                                        </div>
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $member->fname ; ?> <?=  $member->lname ; ?></span>
                                            <span><?=  $member->phonenumber ; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($member->role == "Owner") { ?>
                                    <span class="badge badge-dim-success">Owner</span>
                                    <?php } else if ($member->role == "Manager") { ?>
                                    <span class="badge badge-dim-warning">Manager</span>
                                    <?php } else { ?>
                                    <span class="badge badge-dim-dark">Staff</span>
                                    <?php } ?>
                                </td>
                                <td data-order="<?=  $member->balance ; ?>">
                                    <span class="tb-amount"><?=  money($member->balance, $user->parent->currency) ; ?> </span>
                                </td>
                                <td>
                                    <span><?=  number_format($member->sales) ; ?></span>
                                </td>
                                <td>
                                    <?php if ($member->role == "Owner") { ?>
                                    <span>Full Access</span>
                                    <?php } else { ?>
                                    <span><?=  $member->branch->name ; ?></span>
                                    <?php } ?>
                                </td>
                                <td class="fw-bold">
                                    <?php if ($member->status == "Active") { ?>
                                    <span class="text-success">Active</span>
                                    <?php } else if ($member->status == "On Leave") { ?>
                                    <span class="text-warning">On Leave</span>
                                    <?php } else { ?>
                                    <span class="text-danger">Unavailable</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="<?=  url('Team@details', array('teamid' => $member->id)) ; ?>"><span class="dropdown-svg-icon"><?=  icon('eye-outline') ; ?></span>View Details</a>
                                      <a class="dropdown-item fetch-display-click" data="teamid:<?=  $member->id ; ?>" url="<?=  url('Team@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span> Edit Details</a>
                                      <a class="dropdown-item send-sms" data-phonenumber="<?=  $member->phonenumber ; ?>" data-name="<?=  $member->fname ; ?> <?=  $member->lname ; ?>" href=""><span class="dropdown-svg-icon"><?=  icon('sms') ; ?></span> Send SMS</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                      <a class="dropdown-item send-to-server-click"  data="teamid:<?=  $member->id ; ?>" url="<?=  url('Team@delete') ; ?>" warning-title="Are you sure?" warning-message="This member's profile, sales related and data will be deleted permanently. You could consider setting this account Inactive." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Member</a>
                                  </div>
                                </td>
                            </tr><!-- .nk-tb-item  -->
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="8">It's empty here!</td>
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
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
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
