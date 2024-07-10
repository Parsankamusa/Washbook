<?php global $s_v_data, $branch, $user, $services, $serviceids; ?>
            <form class="simcy-form" action="<?=  url('Branches@update') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Enter branch details.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Branch Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Service Name" value="<?=  $branch->name ; ?>" name="name" required="">
                                <input type="hidden" name="branchid" value="<?=  $branch->id ; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Branch Location</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Branch Location" name="location" value="<?=  $branch->location ; ?>" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch Phone</label>
                                <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" value="<?=  $branch->phone ; ?>" name="phone" required="">                                                                        
                                <input class="hidden-phone" type="hidden" name="phone" value="<?=  $branch->phone ; ?>">
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
                                    <?php if (in_array($service->id, $serviceids)) { ?>
                                    <input type="checkbox" name="services[]" id="service-update-<?=  $service->id ; ?>" class="craft-input" value="<?=  $service->id ; ?>" checked="">
                                    <?php } else { ?>
                                    <input type="checkbox" name="services[]" id="service-update-<?=  $service->id ; ?>" class="craft-input" value="<?=  $service->id ; ?>">
                                    <?php } ?>
                                    <label class="craft-label" for="service-update-<?=  $service->id ; ?>"><?=  $service->name ; ?></label>
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
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Save Changes</button>
                </div>
            </form>
            <script type="text/javascript">
                DottedCraft.initPhoneInput();
            </script>
<?php return;
