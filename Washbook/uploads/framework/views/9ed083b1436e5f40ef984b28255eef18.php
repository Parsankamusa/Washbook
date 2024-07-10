<?php global $s_v_data, $user, $title, $sales; ?>
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
                    <p class="text-gray-500">Create and manage your sales here.</p>
                </div>
                <div class="col-md-6 header-right">
                    <button class="btn btn-primary fetch-display-click" data="secure:true" url="<?=  url('Sales@checkout') ; ?>" holder=".update-holder-lg" modal="#update-lg"><?=  icon('plus') ; ?></span>Record a Sale</button>
                </div>
            </div>
            <div class="craft-card">
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
                                      <a class="dropdown-item mark-as-paid" data-id="<?=  $sale->id ; ?>" data-total="<?=  money($sale->total, $user->parent->currency) ; ?>"><span class="dropdown-svg-icon"><?=  icon('card-outline') ; ?></span> Record Payment</a>
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
    </main>


<?= view( 'includes/footer', $s_v_data ); ?>
<?= view( 'includes/scripts', $s_v_data ); ?>

</body>

</html>
<?php return;
