<?php global $s_v_data, $user, $services, $staff; ?>
            <form class="simcy-form" action="<?=  url('Sales@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Record a sale.</p>
                    <div class="row space-nne">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Client Name</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Client Name" name="client_name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" required>
                                <input class="hidden-phone" type="hidden" name="phonenumber">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control form-control-lg" name="date" placeholder="Date" value="<?=  date('Y-m-d') ; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Time</label>
                                <input type="time" class="form-control form-control-lg" name="time" placeholder="Time" value="<?=  date('H:i') ; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Number plate / Item cleaned</label>
                                <input type="text" class="form-control form-control-lg" name="item" placeholder="Number plate / Item cleaned" required>
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
                        <div class="sale-service-card">
                            <div class="row space-nne">
                                <div class="col-md-12">
                                    <div class="craft-wrap craft-switch">
                                        <input type="checkbox" name="services[]" id="service-<?=  $service->id ; ?>" class="craft-input service-offered" value="<?=  $service->id ; ?>">
                                        <label class="craft-label" for="service-<?=  $service->id ; ?>"><?=  $service->name ; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row space-nne sale-info">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                        <input type="number" class="form-control form-control-lg sale-cost" placeholder="Price" data-parsley-pattern="^[0-9]\d*(\.\d+)?$" name="cost-<?=  $service->id ; ?>" value="<?=  $service->cost ; ?>" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-lg">
                                        <label class="form-label">Performed by</label>
                                        <select class="form-control select2 form-control-lg select2-dynamic" name="perfomed_by-<?=  $service->id ; ?>">
                                            <option value="">Select Staff</option>
                                            <?php if (!empty($staff)) { ?>
                                            <?php foreach ($staff as $value) { ?>
                                             <option value="<?=  $value->id ; ?>" ><?=  $value->fname ; ?> <?=  $value->lname ; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Commission</label>
                                        <div class="input-hint"><?=  currency($user->parent->currency) ; ?></div>
                                        <input type="number" class="form-control form-control-lg" placeholder="Commission" data-parsley-pattern="^[0-9]\d*(\.\d+)?$" name="commission-<?=  $service->id ; ?>" value="<?=  $service->commission ; ?>" step="0.01" min="0">
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
                                    <input type="checkbox" name="paid" id="service-paid" class="craft-input service-paid" value="Yes">
                                    <label class="craft-label" for="service-paid">Paid • Total: <span class="text-primary fw-bold"><?=  currency($user->parent->currency) ; ?><span class="sale-total">0.00</span></span></label>
                                </div>
                            </div>
                            <div class="col-md-4 service-payment-method" style="display:none;">
                                <label class="form-label">Payment Method</label>
                                <select class="form-control form-control-lg payment-method" name="payment_method">
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Mobile Payment">Mobile Payment</option>
                                    <option value="Online Payment">Online Payment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4 service-payment-method" style="display:none;">
                                <label class="form-label">Payment Reference</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Payment Reference" name="reference">
                            </div>
                        </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Create Sale</button>
                </div>
            </form>
            
            <script type="text/javascript">
                DottedCraft.createsale();
                DottedCraft.initPhoneInput();
                $(".select2-dynamic").select2({ minimumResultsForSearch: -1 });
                $(document).ready(function() {
                    $('form.simcy-form').on('submit', function(e) {
                        e.preventDefault();            
                        var formData = $(this).serialize(); 
            
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'), 
                            success: function(response) {
                                $('form.simcy-form').hide(); 
                                $('#success-message').show(); 
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                });
            </script>
            
            
<?php return;
