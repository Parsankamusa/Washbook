<?php global $s_v_data, $user, $title, $branch, $notes, $members, $sales, $payments; ?>
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
                    <h3><span class="fw-bolder">Branch </span>/ <span class="text-primary"><?=  $title ; ?></span></h3>
                    <p class="text-gray-500"> Branch ID: <span class="text-dark fw-bold mr-4">B<?=  str_pad($branch->id, 4, '0', STR_PAD_LEFT) ; ?></span><span class="text-muted mr-4">•</span> Created On: <span class="text-dark fw-bold"><?=  date("F j, Y h:ia", strtotime(timezoned($branch->created_at, $user->parent->timezone))) ; ?></span></p>
                </div>
                <div class="col-md-6 header-right">
                    <a class="btn btn-outline-light" href="<?=  url('Branches@get') ; ?>"><span class="dropdown-svg-icon"><?=  icon('arrow-back-outline') ; ?></span> Go Back</a>
                    <button class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"><span class="dropdown-svg-icon"><?=  icon('more') ; ?></span>  More Actions</button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item fetch-display-click" data="branchid:<?=  $branch->id ; ?>" url="<?=  url('Branches@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                        <div class="line-divider small"><hr class="hr"></div>
                          <a class="dropdown-item send-to-server-click"  data="branchid:<?=  $branch->id ; ?>" url="<?=  url('Branches@delete') ; ?>" warning-title="Are you sure?" warning-message="This branch and all it's sales data will be deleted permanently." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Branch</a>
                  </div>
                </div>
            </div>
            <div class="craft-card">

                        <ul class="nav nav-tabs outer-tab">
                          <li>
                                <a class="nav-link <?php if (!isset($_GET['view'])) { ?>
                                active <?php } ?>" href="<?=  url('Branches@details', array('branchid' => $branch->id)) ; ?>">
                                        <span class="nav-tabs-icon"><?=  icon('layers-outline') ; ?></span>
                                    Details
                                </a>
                            </li>
                          <li>
                                <a class="nav-link <?php if (isset($_GET['view']) && $_GET['view'] == 'members') { ?>
                                    active <?php } ?>" href="<?=  url('Branches@details', array('branchid' => $branch->id)) ; ?>?view=members">
                                        <span class="nav-tabs-icon"><?=  icon('people-outline') ; ?></span>
                                    Team Members
                                </a>
                            </li>
                          <li>
                                <a class="nav-link <?php if (isset($_GET['view']) && $_GET['view'] == 'sales') { ?>
                                        active <?php } ?>" href="<?=  url('Branches@details', array('branchid' => $branch->id)) ; ?>?view=sales">
                                        <span class="nav-tabs-icon"><?=  icon('cart-outline') ; ?></span>
                                    Sales
                                </a>
                            </li>
                        </ul>
                <div class="row space-nne">
                    <div class="col-12">
                        <?php if (!isset($_GET['view'])) { ?>
                          <div class="">
                            <div class="row space-nne">
                                <div class="col-md-10">
                                    <h3>Branch Information</h3>
                                    <p class="text-gray-500">Basic info, that gives branch summary.</p>
                                    <div class="row space-nne">
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Name</small>
                                            <p><?=  $branch->name ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Location</small>
                                            <p><?=  $branch->location ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Phone Number</small>
                                            <p><?=  $branch->phone ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Sales</small>
                                            <p><?=  $branch->services ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Revenue</small>
                                            <p><?=  money($branch->revenue, $user->parent->currency) ; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-gray-500">Status</small>
                                            <p class="fw-bold">
                                                <span class="text-success">Active</span>
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
                                    <h3>Branch Notes <?php if (!empty($notes)) { ?> 
                                    ( <?=  count($notes) ; ?> )  <?php } ?></h3>
                                    <p class="text-gray-500">Create & manage branch notes here.</p>
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
                          <?php } else if (isset($_GET['view']) && $_GET['view'] == 'sales') { ?>
                            <div class="">
                                <div class="row space-nne">
                                    <div class="col-md-12">
                                        <h3>Branch Sales</h3>
                                        <p class="text-gray-500">Sales for <?=  $branch->name ; ?> branch.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row space-nne">
                                            <div class="col-md-12">
                                                <div class="table-holder">
                                                    <table class="datatable table" data-auto-responsive="false">
                                                         <thead>
                                                             <tr>
                                                                <th class="text-center">#</th>
                                                                <th>Client</th>
                                                                <th>Amount / Comm.</th>
                                                                <th>Item / Services</th>
                                                                <th>Performed by</th>
                                                                <th>Payment Method</th>
                                                                <th class="text-right"></th>
                                                             </tr>
                                                         </thead>
                                                         <tbody>

                                                            <?php if (!empty($sales)) { ?>
                                                            <?php foreach ($sales as $index => $sale) { ?>
                                                            <tr>
                                                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                                                <td>
                                                                    <div class="user-profile">
                                                                        <div class="text-avatar">
                                                                            <span><?=  mb_substr($sale->client->fullname, 0, 2, "UTF-8") ; ?></span>
                                                                        </div>
                                                                        <div class="d-inline-block">
                                                                            <span class="fw-bold d-block text-dark"><?=  $sale->client->fullname ; ?></span>
                                                                            <span><?=  $sale->client->phonenumber ; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="fw-bold d-block text-dark"><?=  money($sale->total, $user->parent->currency) ; ?> • <?=  money($sale->commission, $user->parent->currency) ; ?> </span>
                                                                    <span><?=  date("M d, Y, h:ia", strtotime($sale->created_at)) ; ?></span>
                                                                </td>
                                                                <td>
                                                                    <span class="fw-bold d-block text-dark"><?=  $sale->item ; ?></span>
                                                                    <span class="mb-2"  data-toggle="popover" title="Services Offered" data-trigger="hover" data-html="true" data-content="
                                                                    <?php if (!empty($sale->servicesales)) { ?>
                                                                    <?php foreach ($sale->servicesales as $key => $servicesale) { ?>
                                                                    <?=  $key + 1 ; ?>.) <?=  $servicesale->service->name ; ?><br>
                                                                    <?php } ?>
                                                                    <?php } else { ?>
                                                                    No services offered!
                                                                    <?php } ?>
                                                                    ">
                                                                        <?php if (empty($sale->servicesales)) { ?>
                                                                        No services offered!
                                                                        <?php } else if (count($sale->servicesales) == 1) { ?>
                                                                        <?=  $sale->servicesales[0]->service->name ; ?>
                                                                        <?php } else if (count($sale->servicesales) > 1) { ?>
                                                                        <?=  $sale->servicesales[0]->service->name ; ?> <sup class="text-warning fw-bold">(+<?=  count($sale->servicesales) - 1 ; ?>)</sup>
                                                                        <?php } ?>
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="d-block"  data-toggle="popover" title="Performed By" data-trigger="hover" data-html="true" data-content="
                                                                    <?php if (!empty($sale->servicesales)) { ?>
                                                                    <?php foreach ($sale->servicesales as $key => $member) { ?>
                                                                    <?=  $key + 1 ; ?>.) <?=  $member->staff->fname ; ?> <?=  $member->staff->lname ; ?><br>
                                                                    <?php } ?>
                                                                    <?php } else { ?>
                                                                    -|-
                                                                    <?php } ?>
                                                                    ">
                                                                        <?php if (empty($sale->servicesales)) { ?>
                                                                        -|-
                                                                        <?php } else if (count($sale->servicesales) == 1) { ?>
                                                                        <?=  $sale->servicesales[0]->staff->fname ; ?> <?=  $sale->servicesales[0]->staff->lname ; ?>
                                                                        <?php } else if (count($sale->servicesales) > 1) { ?>
                                                                        <?=  $sale->servicesales[0]->staff->fname ; ?> <?=  $sale->servicesales[0]->staff->lname ; ?> <sup class="text-warning fw-bold">(+<?=  count($sale->servicesales) - 1 ; ?>)</sup>
                                                                        <?php } ?>
                                                                    </span>
                                                                    <span class="mb-2">Branch: <strong><?=  $sale->branch->name ; ?></strong></span>
                                                                </td>
                                                                <td>
                                                                    <?php if ($sale->paid == 'Yes' ) { ?>                                                        
                                                                    <span class="badge badge-dim-success">Paid</span> • <?=  $sale->payment_method ; ?>
                                                                    <?php } else { ?>
                                                                    <span class="badge badge-dim-danger">Unpaid</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                      <?php if ($sale->paid == 'No' ) { ?>
                                                                      <a class="dropdown-item mark-as-paid" data-id="<?=  $sale->id ; ?>" data-total="<?=  money($sale->total, $user->parent->currency) ; ?>"><span class="dropdown-svg-icon"><?=  icon('eye-outline') ; ?></span>Record Payment</a>
                                                                      <?php } ?>
                                                                      <a class="dropdown-item fetch-display-click" data="saleid:<?=  $sale->id ; ?>" url="<?=  url('Sales@updateview') ; ?>" holder=".update-holder-lg" modal="#update-lg" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                                                                      <?php if ($user->role == "Admin") { ?>
                                                                    <div class="line-divider small"><hr class="hr"></div>
                                                                      <a class="dropdown-item delete-sale" data-id="<?=  $sale->id ; ?>" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Sale</a>
                                                                      <?php } ?>
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
                                    </div>
                                </div>
                            </div>
                          <?php } else if (isset($_GET['view']) && $_GET['view'] == 'members') { ?>
                            <div class="">
                                <div class="row space-nne">
                                    <div class="col-md-12">
                                        <h3>Team Members</h3>
                                        <p class="text-gray-500">Team members of <?=  $branch->name ; ?>.</p>
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
                                                                      <a class="dropdown-item fetch-display-click" data="teamid:<?=  $member->id ; ?>" url="<?=  url('Team@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                                                                      <a class="dropdown-item send-sms" data-phonenumber="<?=  $member->phonenumber ; ?>" data-name="<?=  $member->fname ; ?> <?=  $member->lname ; ?>" href="">
                                                                        <span class="dropdown-svg-icon"><?=  icon('sms') ; ?></span>Send SMS</a>
                                                                    <div class="line-divider small"><hr class="hr"></div>
                                                                      <a class="dropdown-item send-to-server-click"  data="teamid:<?=  $member->id ; ?>" url="<?=  url('Team@delete') ; ?>" warning-title="Are you sure?" warning-message="This member's profile, sales related and data will be deleted permanently. You could consider setting this account Inactive." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Member</a>
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
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Notes@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Add a note on this team member's account.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Write your note</label>
                                <textarea class="form-control form-control-lg" placeholder="Write your note" name="note" rows="5" required=""></textarea>
                                <input type="hidden" name="item" value="<?=  $branch->id ; ?>" required="">
                                <input type="hidden" name="type" value="Branch" required="">
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
