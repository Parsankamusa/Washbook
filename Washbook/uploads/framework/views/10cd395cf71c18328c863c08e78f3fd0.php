<?php global $s_v_data, $user, $title, $services, $branches; ?>
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
                    <p class="text-gray-500">List of services offered.</p>
                </div>
                <div class="col-md-6 header-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#create"><span class="btn-svg-icon"><?=  icon('plus') ; ?></span>Add a Service</button>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" data-auto-responsive="false">
                         <thead>
                             <tr>
                                <th class="text-center">#</th>
                                <th>Name </th>
                                <th>Cost</th>
                                <th>Commision</th>
                                <th>Revenue</th>
                                <th>Sales</th>
                                <th>Status</th>
                                <th class="text-right"></th>
                             </tr>
                         </thead>
                         <tbody>

                            <?php if (!empty($services)) { ?>
                            <?php foreach ($services as $index => $service) { ?>
                            <tr>
                                <td class="text-center"><?=  $index + 1 ; ?></td>
                                <td>
                                    <div class="user-profile">
                                        <div class="d-inline-block">
                                            <span class="fw-bold d-block text-dark"><?=  $service->name ; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td><?=  money($service->cost, $user->parent->currency) ; ?></td>
                                <td><?=  money($service->commission, $user->parent->currency) ; ?></td>
                                <td><?=  money($service->revenue, $user->parent->currency) ; ?></td>
                                <td><?=  $service->sales ; ?> </td>
                                <td>
                                    <?php if ($service->branches > 0) { ?>
                                    <span class="badge badge-dim-success">Offered</span>
                                    <?php } else { ?>
                                    <span class="badge badge-dim-dark">Not Offered</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="" class="btn-icon dropdown-toggle" data-toggle="dropdown"><?=  icon('more') ; ?></a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item fetch-display-click" data="serviceid:<?=  $service->id ; ?>" url="<?=  url('Services@updateview') ; ?>" holder=".update-holder" modal="#update" href=""><span class="dropdown-svg-icon"><?=  icon('edit') ; ?></span>Edit Details</a>
                                    <div class="line-divider small"><hr class="hr"></div>
                                      <a class="dropdown-item send-to-server-click"  data="serviceid:<?=  $service->id ; ?>" url="<?=  url('Services@delete') ; ?>" warning-title="Are you sure?" warning-message="This service will be deleted permanently." warning-button="Yes, delete!" href=""><span class="dropdown-svg-icon"><?=  icon('trash-outline') ; ?></span> Delete Service</a>
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
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Add a Service</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Services@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Enter service details.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Service Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Service Name" name="name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Service Cost</label>
                                <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                <input type="number" class="form-control form-control-lg" placeholder="Service Cost" data-parsley-pattern="^[0-9]\d*(\.\d+)?$" name="cost" value="0.00" step="0.01" min="0" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Service Commission <div class="icon-text text-warning" data-toggle="tooltip" title="Commission paid to employee for performing the service."><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path d="M250.26 166.05L256 288l5.73-121.95a5.74 5.74 0 00-5.79-6h0a5.74 5.74 0 00-5.68 6z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 367.91a20 20 0 1120-20 20 20 0 01-20 20z" fill="currentColor"/></svg></div></label>
                                <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                <input type="number" class="form-control form-control-lg" placeholder="Service Commission" data-parsley-pattern="^[0-9]\d*(\.\d+)?$" name="commission" value="0.00" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="line-divider">
                                <hr class="hr" />
                            </div>
                            <p class="text-gray-500">Select branches that will offer this service;</p>
                        </div>
                            <?php if (!empty($branches)) { ?>
                            <?php foreach ($branches as $branch) { ?>
                            <div class="col-md-6">
                                <div class="craft-wrap craft-switch">
                                    <input type="checkbox" name="branches[]" id="branch-<?=  $branch->id ; ?>" class="craft-input" value="<?=  $branch->id ; ?>" checked="">
                                    <label class="craft-label" for="branch-<?=  $branch->id ; ?>"><?=  $branch->name ; ?></label>
                                </div>
                            </div>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="col-md-12">
                                <div class="empty">
                                    <img src="<?=  asset('assets/images/empty.svg') ; ?>">
                                    <h4>No branches added yet!</h4>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Add a Service</button>
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
