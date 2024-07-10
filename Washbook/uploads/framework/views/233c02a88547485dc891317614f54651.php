<?php global $s_v_data, $user, $title, $widgets, $revenue, $servicesales; ?>
    <footer>
        <span class=""> &copy; <?=  date("Y") ; ?> <?=  env('APP_NAME') ; ?> • All Rights Reserved.</span>
    </footer>


<!-- Update Modal -->
<div class="modal fade" tabindex="-1" id="update">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=  env("APP_NAME") ; ?></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <div class="update-holder"></div>
        </div>
    </div>
</div>


<!-- Update XL Modal -->
<div class="modal fade" tabindex="-1" id="update-xl">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=  env("APP_NAME") ; ?></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <div class="update-holder-xl"></div>
        </div>
    </div>
</div>

<!-- Update XL Modal -->
<div class="modal fade" tabindex="-1" id="update-lg">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=  env("APP_NAME") ; ?></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <div class="update-holder-lg"></div>
        </div>
    </div>
</div>


<!-- Send SMS -->
<div class="modal fade" tabindex="-1" id="sendsms">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send SMS</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Marketing@create') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Send an SMS message.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Send To</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Send To" name="name" required="">
                                <input type="hidden" name="sendto" value="enternumber" required="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control form-control-lg phone-input" name="phonenumber" placeholder="Phone Number" required="">
                                <input class="hidden-phone" type="hidden" name="phonenumber">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Message</label>
                                <textarea class="form-control form-control-lg" placeholder="Message" rows="3" name="message" required=""></textarea>
                                <span class="input-note">We'll include your company name <strong class="fw-bold"><?=  $user->parent->name ; ?></strong> at the end of the message.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="deletesale">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            <form class="simcy-form" action="<?=  url('Sales@delete') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <h4>Delete a Sale</h4>
                    <p class="text-gray-700"><strong>Are you sure you want to delete this sale?</strong></p>
                    <p class="text-gray-500">If you delete, you'll lose your your record on this sale. You can check the switch below to deduct commision paid to the staff assigned.</p>
                    <div class="row space-nne">
                        <div class="col-md-12">                                    
                            <div class="form-group">
                                <div class="craft-wrap craft-switch">
                                    <input type="checkbox" name="deduct" class="craft-input" id="deduct-commission" value="Yes" checked="">
                                    <label class="craft-label" for="deduct-commission">Deduct commission from staff assigned</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Enter your password to confirm deletion</label>
                                <input type="password" class="form-control form-control-lg" placeholder="*********" name="password" required="">
                                <input type="hidden" name="saleid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Never mind, don't delete</button>
                    <button class="btn btn-danger"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Delete Sale</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Send SMS -->
<div class="modal fade" tabindex="-1" id="markaspaid">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Mark Sale as Paid</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <span class="icon-span"> <?=  icon('close-outline') ; ?> </span> </a>
            </div>
            <form class="simcy-form" action="<?=  url('Sales@paid') ; ?>" data-parsley-validate="" method="POST" loader="true">
                <div class="modal-body">
                    <p class="text-gray-500">Close a sale.</p>
                    <div class="row space-nne">
                        <div class="col-sm-12">
                            <h3>Total: <span class="text-primary fw-bold"><span class="close-sale-total">0.00</span></span></h3>
                            <input type="hidden" name="saleid" required>
                        </div>
                        <div class="col-md-12">
                            <div class="line-divider">
                                <hr class="hr">
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Payment Method</label>
                            <select class="form-control form-control-lg payment-method" name="payment_method">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="Mobile Payment">Mobile Payment</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Payment Reference</label>
                            <input type="text" class="form-control form-control-lg" placeholder="Payment Reference" name="reference">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary" data-dismiss="modal"><span class="btn-svg-icon"><?=  icon('close-outline') ; ?></span> Close</button>
                    <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span> Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php return;
