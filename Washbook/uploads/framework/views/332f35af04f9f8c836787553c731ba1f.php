<?php global $s_v_data, $user, $sale, $services, $staff; ?>
            <form class="simcy-form" action="<?=  url('Sales@update') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Update <span class="fw-bold"><?=  $sale->client->fullname ; ?>'s</span> sale details</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Number plate / Item cleaned</label>
                                <input type="text" class="form-control form-control-lg" name="item" placeholder="Number plate / Item cleaned" value="<?=  $sale->item ; ?>" required>
                                <input type="hidden" value="<?=  $sale->id ; ?>" name="saleid">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="line-divider">
                                <hr class="hr" />
                            </div>
                            <p class="text-gray-500">Select services offered;</p>
                        </div>
                    </div>
                        <?php if (!empty($services)) { ?>
                        <?php foreach ($services as $service) { ?>
                        <?php if (!empty($service->sale)) { ?>
                        <div class="sale-service-card selected-service">
                        <?php } else { ?>
                        <div class="sale-service-card">
                        <?php } ?>
                            <div class="row space-nne">
                                <div class="col-md-12">
                                    <div class="craft-wrap craft-switch">
                                        <?php if (!empty($service->sale)) { ?>
                                        <input type="checkbox" name="services[]" id="service-<?=  $service->id ; ?>" class="craft-input service-offered" value="<?=  $service->id ; ?>" checked>
                                        <?php } else { ?>
                                        <input type="checkbox" name="services[]" id="service-<?=  $service->id ; ?>" class="craft-input service-offered" value="<?=  $service->id ; ?>">
                                        <?php } ?>
                                        <label class="craft-label" for="service-<?=  $service->id ; ?>"><?=  $service->name ; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row space-nne sale-info">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                        <input type="number" class="form-control form-control-lg sale-cost" placeholder="Price" data-parsley-pattern="^[0-9]\d*(\.\d+)?$" name="cost-<?=  $service->id ; ?>" value="<?=  $service->cost ; ?>" step="0.01" min="0" <?=  $service->required ; ?>>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-lg">
                                        <label class="form-label">Performed by</label>
                                        <select class="form-control select2 form-control-lg select2-dynamic" name="perfomed_by-<?=  $service->id ; ?>">
                                            <option value="">Select Staff</option>
                                            <?php if (!empty($staff)) { ?>
                                            <?php foreach ($staff as $value) { ?>
                                             <option value="<?=  $value->id ; ?>" <?php if (!empty($service->sale) && $service->sale->provided_by == $value->id) { ?> 
                                                selected <?php } ?>><?=  $value->fname ; ?> <?=  $value->lname ; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Commission</label>
                                        <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                        <input type="number" class="form-control form-control-lg" placeholder="Commission" data-parsley-pattern="^[0-9]\d*(\.\d+)?$" name="commission-<?=  $service->id ; ?>" value="<?=  $service->commission ; ?>" step="0.01" min="0" <?=  $service->required ; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } else { ?>
                        <div class="row space-nne">
                            <div class="col-md-12">
                                <div class="empty">
                                    <img src="<?=  asset('assets/images/empty.svg') ; ?>">
                                    <h4>No services added yet!</h4>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row space-nne">
                            <div class="col-md-12">
                                <div class="line-divider">
                                    <hr class="hr" />
                                </div>
                                <p class="text-gray-500">Payment;</p>
                            </div>
                            <div class="col-md-4">
                                <div class="craft-wrap craft-switch">
                                    <?php if ($sale->paid == "Yes") { ?>
                                    <input type="checkbox" name="paid" id="service-paid" class="craft-input service-paid" value="Yes" checked>
                                    <?php } else { ?>
                                    <input type="checkbox" name="paid" id="service-paid" class="craft-input service-paid" value="Yes">
                                    <?php } ?>
                                    <label class="craft-label" for="service-paid">Paid • Total: <span class="text-primary fw-bold"><?=  currency($user->parent->currency) ; ?><span class="sale-total"><?=  $sale->total ; ?></span></span></label>
                                </div>
                            </div>
                            <?php if ($sale->paid == "Yes") { ?>
                            <div class="col-md-4 service-payment-method">
                            <?php } else { ?>
                            <div class="col-md-4 service-payment-method" style="display:none;">
                            <?php } ?>
                                <label class="form-label">Payment Method</label>
                                <select class="form-control form-control-lg payment-method" name="payment_method">
                                    <option value="Cash" <?php if ($sale->payment_method == "Cash") { ?> selected <?php } ?>>Cash</option>
                                    <option value="Card" <?php if ($sale->payment_method == "Card") { ?> selected <?php } ?>>Card</option>
                                    <option value="Bank" <?php if ($sale->payment_method == "Bank") { ?> selected <?php } ?>>Bank</option>
                                    <option value="Mobile Payment" <?php if ($sale->payment_method == "Mobile Payment") { ?> selected <?php } ?>>Mobile Payment</option>
                                    <option value="Online Payment" <?php if ($sale->payment_method == "Online Payment") { ?> selected <?php } ?>>Online Payment</option>
                                    <option value="Other" <?php if ($sale->payment_method == "Other") { ?> selected <?php } ?>>Other</option>
                                </select>
                            </div>
                            <?php if ($sale->paid == "Yes") { ?>
                            <div class="col-md-4 service-payment-method">
                            <?php } else { ?>
                            <div class="col-md-4 service-payment-method" style="display:none;">
                            <?php } ?>
                                <label class="form-label">Payment Reference</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Payment Reference" value="<?=  $sale->reference ; ?>" name="reference">
                            </div>
                        </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Save Changes</button>
                </div>
            </form>
            <script type="text/javascript">
                DottedCraft.createsale();
                DottedCraft.initPhoneInput();
                $(".select2-dynamic").select2({ minimumResultsForSearch: -1 });
            </script>
<?php return;
