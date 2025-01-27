<?php global $s_v_data, $user, $title, $company, $notes, $branches, $members; ?>
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
                    <h3><span class="fw-bolder">Company </span>/ <span class="text-primary"><?=  $title ; ?></span></h3>
                    <p class="text-gray-500"> Company ID: <span class="text-dark fw-bold mr-4">C<?=  str_pad($company->id, 4, '0', STR_PAD_LEFT) ; ?></span><span class="text-muted mr-4">•</span> Created On: <span class="text-dark fw-bold"><?=  date("F j, Y h:ia", strtotime(timezoned($company->created_at, $user->parent->timezone))) ; ?></span></p>
                </div>
                <div class="col-md-6 header-right">
                    <a class="btn btn-outline-light" href="<?=  url('Companies@get') ; ?>"><span class="dropdown-svg-icon"><?=  icon('arrow-back-outline') ; ?></span> Go Back</a>
                    <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"><span class="dropdown-svg-icon"><?=  icon('more') ; ?></span> More Actions</button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item fetch-display-click" data="companyid:<?=  $company->id ; ?>" url="<?=  url('Companies@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                        <div class="line-divider small"><hr class="hr"></div>
                          <a class="dropdown-item send-to-server-click"  data="companyid:<?=  $company->id ; ?>" url="<?=  url('Companies@delete') ; ?>" warning-title="Are you sure?" warning-message="This company's profile, sales related and data will be deleted permanently. You could consider setting this company Inactive." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Company</a>
                  </div>
                </div>
            </div>
            <div class="craft-card">

                        <ul class="nav nav-tabs outer-tab">
                          <li>
                                <a class="nav-link <?php if (!isset($_GET['view'])) { ?>
                                active <?php } ?>" href="<?=  url('Companies@details', array('companyid' => $company->id)) ; ?>">
                                        <span class="nav-tabs-icon"><?=  icon('user') ; ?></span>
                                    Details
                                </a>
                            </li>
                          <li>
                                <a class="nav-link <?php if (isset($_GET['view']) && $_GET['view'] == 'branches') { ?>
                                        active <?php } ?>" href="<?=  url('Companies@details', array('companyid' => $company->id)) ; ?>?view=branches">
                                        <span class="nav-tabs-icon"><?=  icon('layers-outline') ; ?></span>
                                    Branches
                                </a>
                            </li>
                          <li>
                                <a class="nav-link <?php if (isset($_GET['view']) && $_GET['view'] == 'members') { ?>
                                    active <?php } ?>" href="<?=  url('Companies@details', array('companyid' => $company->id)) ; ?>?view=members">
                                        <span class="nav-tabs-icon"><?=  icon('people-outline') ; ?></span>
                                    Team Members
                                </a>
                            </li>
                        </ul>
                <div class="row space-nne">
                    <div class="col-12">
                        <?php if (!isset($_GET['view'])) { ?>
                          <div class="">
                            <div class="row space-nne">
                                <div class="col-md-10">
                                    <h3>Company Information</h3>
                                    <p class="text-gray-500">Basic info, that gives company summary.</p>
                                    <div class="row space-nne">
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Name</small>
                                            <p><?=  $company->name ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Owner</small>
                                            <p><?=  $company->owner->fname ; ?> <?=  $company->owner->lname ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Email Address</small>
                                            <p><?=  $company->email ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Phone Number</small>
                                            <p><?=  $company->phone ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Address</small>
                                            <p><?=  $company->address ; ?> • <?=  $company->city ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Branches</small>
                                            <p><?=  $company->branches ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Time Zone</small>
                                            <p><?=  $company->timezone ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Country</small>
                                            <p><?=  $company->country ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Currency</small>
                                            <p><?=  $company->currency ; ?> • <?=  currency($company->currency) ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Status</small>
                                            <p class="fw-bold">
                                                <?php if ($company->status == "Active") { ?>
                                                <span class="text-success">Active</span>
                                                <?php } else if ($company->status == "Expired") { ?>
                                                <span class="text-warning">Expired</span>
                                                <?php } else { ?>
                                                <span class="text-danger">Inactive</span>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="line-divider">
                                <hr class="hr" />
                            </div>

                            <div class="row space-nne">
                                <div class="col-md-6">
                                    <h3>Company Notes <?php if (!empty($notes)) { ?> 
                                    ( <?=  count($notes) ; ?> )  <?php } ?></h3>
                                    <p class="text-gray-500">Create & manage company notes here.</p>
                                </div>
                                <div class="col-md-6 header-right">
                                    <button class="btn btn-outline-light" data-toggle="modal" data-target="#createnote"><span class="dropdown-svg-icon"><?=  icon('plus') ; ?></span> Add a Note</button>
                                </div>
                            </div>
                            <div class="row space-nne">
                                <?php if (!empty($notes)) { ?> 
                                <?php foreach ($notes as $note) { ?>
                                <div class="col-md-12 note-holder">
                                    <div class="note-content"><?=  nl2br($note->note) ; ?></div>
                                    <div class="note-data">Added on <span class="text-dark fw-bold mr-4"><?=  date("F j, Y", strtotime(timezoned($note->created_at, $user->parent->timezone))) ; ?> at <?=  date("h:ia", strtotime(timezoned($note->created_at, $user->parent->timezone))) ; ?></span><span class="text-muted mr-4">•</span><a href="" class="text-danger fw-bold send-to-server-click"  data="noteid:<?=  $note->id ; ?>" url="<?=  url('Notes@delete') ; ?>" warning-title="Are you sure?" warning-message="This note will be deleted permanently." warning-button="Yes, delete!">Delete Note</a></div>
                                </div>
                                <?php } ?>
                                <?php } else { ?>
                                <div class="empty">
                                    <img src="<?=  asset('assets/images/empty.svg') ; ?>">
                                    <h4>No notes added yet!</h4>
                                </div>
                                <?php } ?>
                            </div>
                          </div>
                          <?php } else if (isset($_GET['view']) && $_GET['view'] == 'branches') { ?>
                            <div class="">
                                <div class="row space-nne">
                                    <div class="col-md-12">
                                        <h3>Branches</h3>
                                        <p class="text-gray-500">Branches of <?=  $company->name ; ?>.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row space-nne">
                                            <div class="col-md-12">
                                                <div class="table-holder">
                                                    <table class="datatable table" data-auto-responsive="false">
                                                         <thead>
                                                             <tr>
                                                                <th class="text-center">#</th>
                                                                <th>Branch</th>
                                                                <th>Phone Number</th>
                                                                <th>Location</th>
                                                                <th>Status</th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>

                                                            <?php if (!empty($branches)) { ?>
                                                            <?php foreach ($branches as $index => $branch) { ?>
                                                            <tr>
                                                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                                                <td>
                                                                    <div class="user-profile">
                                                                        <div class="text-avatar">
                                                                            <span><?=  mb_substr($branch->name, 0, 2, "UTF-8") ; ?></span>
                                                                        </div>
                                                                        <div class="d-inline-block">
                                                                            <span class="fw-bold d-block text-dark"><?=  $branch->name ; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><?=  $branch->phone ; ?></td>
                                                                <td><?=  $branch->location ; ?></td>
                                                                <td class="fw-bold"><span class="text-success">Active</span></td>
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
                                    </div>
                                </div>
                            </div>
                          <?php } else if (isset($_GET['view']) && $_GET['view'] == 'members') { ?>
                            <div class="">
                                <div class="row space-nne">
                                    <div class="col-md-12">
                                        <h3>Team Members</h3>
                                        <p class="text-gray-500">Team members of <?=  $company->name ; ?>.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row space-nne">
                                            <div class="col-md-12">
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
                                    </div>
                                </div>
                            </div>
                          <?php } ?>
                    </div>
                </div>  
            </div>
        </div>
    </main>



<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="createnote">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add a Note</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="icon-span">
                        <?=  icon('close-outline') ; ?>
                    </span>
                    </a>
            </div>
            <form class="simcy-form" action="<?=  url('Notes@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Add a note on this team member's account.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Write your note</label>
                                <textarea class="form-control form-control-lg" placeholder="Write your note" name="note" rows="5" required=""></textarea>
                                <input type="hidden" name="item" value="<?=  $company->id ; ?>" required="">
                                <input type="hidden" name="type" value="Company" required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="addpayment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Teampayment@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Record a payment.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                <input type="number" class="form-control form-control-lg" placeholder="Amount" name="amount" data-parsley-pattern="[0-9]*(\.?[0-9]{2}$)" value="0.00" step="0.01" required="">
                                <input type="hidden" name="member" value="<?=  $member->id ; ?>" required="">
                                <span class="input-note">Payment amount can't be updated once saved.</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Payment Note</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Payment Note" name="note">
                                <span class="input-note">Optional</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Payment Date</label>
                                <input type="date" class="form-control form-control-lg" placeholder="Payment Date" name="payment_date" value="<?=  date('Y-m-d') ; ?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Payment Mode</label>
                                <select class="form-control form-control-lg" name="mode">
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Mobile Payment">Mobile Payment</option>
                                    <option value="Online Payment">Online Payment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="craft-wrap craft-switch">
                                <input type="checkbox" name="deduct" id="deduct" class="craft-input" value="Yes" checked="">
                                <label class="craft-label" for="deduct">Deduct from <?=  $member->fname ; ?>'s balance of <strong><?=  money($member->balance, $user->parent->currency) ; ?></strong>?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Save Payment</button>
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
