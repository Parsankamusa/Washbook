<?php global $s_v_data, $user, $title, $clients; ?>
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
                    <p class="text-gray-500">List of company clients from all branches.</p>
                </div>
                <div class="col-md-6 header-right">
                    <?php if (isset($_GET["search"])) { ?>
                    <a class="btn btn-outline-light" href="<?=  url('Clients@get') ; ?>"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span>Clear Search</a>
                    <?php } ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create"><span class="btn-svg-icon"><?=  icon('plus') ; ?></span>Add a Client</button>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Client</th>
                                <th>Payments</th>
                                <th>Unpaid</th>
                                <th>N.Visits <div class="icon-text text-warning" data-toggle="tooltip" title="Number Of Visits"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path d="M250.26 166.05L256 288l5.73-121.95a5.74 5.74 0 00-5.79-6h0a5.74 5.74 0 00-5.68 6z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 367.91a20 20 0 1120-20 20 20 0 01-20 20z" fill="currentColor"/></svg></div></th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($clients)) { ?>
                            <?php foreach ($clients as $index => $client) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="text-avatar">
                                            <span><?=  mb_substr($client->fullname, 0, 2, "UTF-8") ; ?></span>
                                        </div>
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $client->fullname ; ?></span>
                                            <?php if (!empty($client->phonenumber)) { ?>
                                            <span><?=  $client->phonenumber ; ?></span>
                                            <?php } else { ?>
                                            <span>--|--</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?=  money($client->payments, $user->parent->currency) ; ?> </td>
                                <td><?=  money($client->balance, $user->parent->currency) ; ?> </td>
                                <td><?=  number_format($client->sales) ; ?> </td>
                                <td><?=  date("F j, Y", strtotime($client->created_at)) ; ?></td>
                                <td><span class="badge badge-dim-success">Active</span></td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="<?=  url('Clients@details', array('clientid' => $client->id)) ; ?>"><span class="dropdown-svg-icon"><?=  icon('eye-outline') ; ?></span>View Details</a>
                                      <a class="dropdown-item fetch-display-click" data="clientid:<?=  $client->id ; ?>" url="<?=  url('Clients@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                                      <a class="dropdown-item send-sms" data-phonenumber="<?=  $client->phonenumber ; ?>" data-name="<?=  $client->fullname ; ?>" href="">
                                        <span class="dropdown-svg-icon"><?=  icon('sms') ; ?></span>Send SMS</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                      <a class="dropdown-item send-to-server-click" data="clientid:<?=  $client->id ; ?>" url="<?=  url('Clients@delete') ; ?>" warning-title="Are you sure?" warning-message="This client's profile and data will be deleted permanently." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Client</a>
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
            <div class="modal-header">
                <h5 class="modal-title">Add a Client</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Clients@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Enter client details.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Full Name" name="fullname" required="">
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
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Add a Client</button>
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
