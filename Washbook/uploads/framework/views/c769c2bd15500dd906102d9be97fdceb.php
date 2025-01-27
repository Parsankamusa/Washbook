<?php global $s_v_data, $user, $title, $members, $clients, $campaigns; ?>
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
                    <p class="text-gray-500">Create and manage sms campaigns.</p>
                </div>
                <div class="col-md-6 header-right">
                    <a class="btn btn-outline-primary" href="<?=  url('Marketing@recipients') ; ?>"><span class="btn-svg-icon"><?=  icon('timer-outline') ; ?></span>SMS History</a>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create"><span class="btn-svg-icon"><?=  icon('plus') ; ?></span>Create Campaign</button>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Campaign</th>
                                <th>Date</th>
                                <th>Sent SMS</th>
                                <th>Credits</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($campaigns)) { ?>
                            <?php foreach ($campaigns as $index => $campaign) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $campaign->title ; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?=  date("F j, Y", strtotime($campaign->created_at)) ; ?></td>
                                <td><?=  $campaign->sent ; ?> / <?=  $campaign->messages ; ?></td>
                                <td><?=  number_format($campaign->cost, 2) ; ?></td>
                                <td>
                                    <?php if ($campaign->status == "Completed") { ?>
                                    <span class="badge badge-dim-success">Completed</span>
                                    <?php } else { ?>
                                    <span class="badge badge-dim-warning">Sending</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="<?=  url('Marketing@recipients') ; ?>?campaign=<?=  $campaign->id ; ?>"><span class="dropdown-svg-icon"><?=  icon('eye-outline') ; ?></span>View Recipients</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                      <a class="dropdown-item send-to-server-click" data="campaignid:<?=  $campaign->id ; ?>" url="<?=  url('Marketing@delete') ; ?>" warning-title="Are you sure?" warning-message="This campaign will be deleted permanently." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Campaign</a>
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
                <h5 class="modal-title">Create Campaign</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Marketing@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Create a campaign.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Campaign Title</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Campaign Title" name="title" required="">
                                <div class="input-note">This will not be shown to customers.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Send To</label>
                                <select class="form-control form-control-lg" name="sendto" required="">
                                    <option value="">Select</option>
                                    <option value="clients">All Clients</option>
                                    <option value="selectedclients">Selected Clients</option>
                                    <option value="members">All Team Members</option>
                                    <option value="selectedmembers">Selected Team Members</option>
                                    <option value="enternumber">Enter Number Manually</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 campaign-sendto" data-type="clients" style="display: none;">
                            <div class="form-group form-group-lg">
                                <label class="form-label">Send Clients</label>
                                <select class="form-control form-control-lg select2" name="clients[]" multiple="">
                                    <?php if (!empty($clients)) { ?>
                                    <?php foreach ($clients as $client) { ?>
                                    <option value="<?=  $client->id ; ?>"><?=  $client->fullname ; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 campaign-sendto" data-type="members" style="display: none;">
                            <div class="form-group form-group-lg">
                                <label class="form-label">Select Team Members</label>
                                <select class="form-control form-control-lg select2" name="members[]" multiple="">
                                    <?php if (!empty($members)) { ?>
                                    <?php foreach ($members as $member) { ?>
                                    <option value="<?=  $member->id ; ?>"><?=  $member->fname ; ?> <?=  $member->lname ; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 campaign-sendto" data-type="manually" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Enter Number Manually</label>
                                <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number">
                                <input class="hidden-phone" type="hidden" name="phonenumber">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Message</label>
                                <textarea class="form-control form-control-lg" placeholder="Message" rows="3" name="message" required=""></textarea>
                                <div class="input-note">We'll include your company name <strong><?=  $user->parent->name ; ?></strong> at the end of every message.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Send Campaign</button>
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
