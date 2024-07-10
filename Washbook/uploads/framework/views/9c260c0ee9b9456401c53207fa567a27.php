<?php global $s_v_data, $user, $title, $messages, $campaign; ?>
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
                    <?php if (!is_null($campaign)) { ?>
                    <h3><span class="fw-bolder"><?=  $campaign->title ; ?> </span>/ <span class="text-primary">Campaign Recipients</span></h3>
                    <?php } else { ?>
                    <h3><?=  $title ; ?></h3>
                    <?php } ?>
                    <p class="text-gray-500">List of sent sms messages.</p>
                </div>
                <div class="col-md-6 header-right">
                    <a class="btn btn-outline-light" href="<?=  url('Marketing@get') ; ?>"><span class="dropdown-svg-icon"><?=  icon('arrow-back-outline') ; ?></span> Go Back</a>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Sent To</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($messages)) { ?>
                            <?php foreach ($messages as $index => $message) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $message->name ; ?> <?=  $message->phonenumber ; ?></span>
                                            <small class="text-muted"><?=  date("F j, Y H:i", strtotime($message->created_at)) ; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?=  nl2br($message->message) ; ?></td>
                                <td>
                                    <?php if ($message->status == "Sent") { ?>
                                    <span class="badge badge-dim-success">Sent</span>
                                    <?php } else if ($message->status == "Queued") { ?>
                                    <span class="badge badge-dim-warning">Queued</span>
                                    <?php } else { ?>
                                    <span class="badge badge-dim-danger">Failed</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <?php if ($message->status == "Failed") { ?>
                                      <a class="dropdown-item send-to-server-click" href="" data="messageid:<?=  $message->id ; ?>" url="<?=  url('Marketing@resend') ; ?>"><span class="dropdown-svg-icon"><?=  icon('reload-outline') ; ?></span>Resend</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                    <?php } ?>
                                      <a class="dropdown-item send-to-server-click" data="messageid:<?=  $message->id ; ?>" url="<?=  url('Marketing@deletemessage') ; ?>" warning-title="Are you sure?" warning-message="This message will be deleted permanently." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Message</a>
                                  </div>
                                </td>
                            </tr><!-- .nk-tb-item  -->
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="5">It's empty here!</td>
                            </tr>
                            <?php } ?>
                         </tbody>
                     </table>
                </div>
            </div>
        </div>
    </main>


<?= view( 'includes/footer', $s_v_data ); ?>
<?= view( 'includes/scripts', $s_v_data ); ?>

</body>

</html>
<?php return;
