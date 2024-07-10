<?php global $s_v_data, $user, $title, $company, $timezones, $currencies, $countries; ?>
<?= view( 'includes/head', $s_v_data ); ?>
<body>
    <!-- Header -->
    <?= view( 'includes/header', $s_v_data ); ?>

    <!-- Aside -->
    <?= view( 'includes/aside', $s_v_data ); ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="craft-container">
            <div class="craft-card">

                        <ul class="nav nav-tabs outer-tab">
                          <li>
                                <a data-toggle="tab" class="nav-link active" href="#personal">
                                        <span class="nav-tabs-icon"><?=  icon('user') ; ?></span>
                                    Personal
                                </a>
                            </li>
                            <?php if ($user->role == "Admin" || $user->role == "Owner") { ?>
                          <li>
                                <a data-toggle="tab" class="nav-link" href="#company">
                                        <span class="nav-tabs-icon"><?=  icon('albums-outline') ; ?></span>
                                    Company
                                </a>
                            </li>
                            <?php } ?>
                            <?php if ($user->role == "Admin") { ?>
                          <li>
                                <a data-toggle="tab" class="nav-link" href="#system">
                                        <span class="nav-tabs-icon"><?=  icon('globe-outline') ; ?></span>
                                    System
                                </a>
                            </li>
                            <?php } ?>
                          <li>
                                <a data-toggle="tab" class="nav-link" href="#security">
                                        <span class="nav-tabs-icon"><?=  icon('lock') ; ?></span>
                                    Security
                                </a>
                            </li>
                        </ul>
                <div class="row space-nne">
                    <div class="col-12">

                        <div class="tab-content">
                          <div id="personal" class="tab-pane fade in active show">
                            <div class="row space-nne">
                                <div class="col-md-7">
                                    <h3>Personal Information</h3>
                                    <p class="text-gray-500">Basic info, like your name and email, that you use on the system.</p>
                                    <form class="simcy-form" action="<?=  url('Settings@updateprofile') ; ?>" data-parsley-validate="" method="POST" loader="true">
                                        <div class="form-group">
                                            <label class="form-label" for="password">First Name</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="First Name" name="fname" value="<?=  $user->fname ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Last Name</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Last Name" name="lname" value="<?=  $user->lname ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Email Address</label>
                                            <input type="email" class="form-control form-control-lg" placeholder="Email Address" name="email" value="<?=  $user->email ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Phone Number</label>
                                            <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" value="<?=  $user->phonenumber ; ?>">
                                            <input class="hidden-phone" type="hidden" name="phonenumber" value="<?=  $user->phonenumber ; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Address</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Address" name="address" value="<?=  $user->address ; ?>">
                                        </div>
                                        <div class="form-group text-right">
                                            <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span>Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                          <?php if ($user->role == "Admin" || $user->role == "Owner") { ?>
                          <div id="company" class="tab-pane fade">
                            <div class="row space-nne">
                                <div class="col-md-7">
                                    <h3>Company Information</h3>
                                    <p class="text-gray-500">Basic company information and system preferences.</p>

                                    <form class="simcy-form" action="<?=  url('Settings@updatecompany') ; ?>" data-parsley-validate="" method="POST" loader="true">
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Company Name" name="name" value="<?=  $company->name ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email Address</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Email Address" name="email" value="<?=  $company->email ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" class="form-control form-control-lg phone-input" placeholder="Phone Number" name="phone" value="<?=  $company->phone ; ?>" required="">
                                            <input class="hidden-phone" type="hidden" name="phone" value="<?=  $company->phone ; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Address" name="address" value="<?=  $company->address ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Town/City</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Town/City" name="city" value="<?=  $company->city ; ?>" required="">
                                        </div>
                                        <div class="form-group form-group-lg">
                                            <label class="form-label">Country</label>
                                            <select class="form-control form-control-lg select2" name="country">
                                                <?php foreach ($countries as $country) { ?>
                                                <option value="<?=  $country->name ; ?>" <?php if ($country->name == $company->country) { ?> 
                                                    selected <?php } ?>><?=  $country->name ; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="line-divider medium">
                                            <hr class="hr">
                                        </div>
                                        <p class="text-gray-500">Timezone & Currency</p>
                                        <div class="form-group form-group-lg">
                                            <label class="form-label">Timezone</label>
                                            <select class="form-control form-control-lg select2" name="timezone">
                                                <?php foreach ($timezones as $timezone) { ?>
                                                <option value="<?=  $timezone->zone ; ?>" <?php if ($timezone->zone == $company->timezone) { ?> 
                                                    selected <?php } ?>><?=  $timezone->name ; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group form-group-lg">
                                            <label class="form-label">Currency</label>
                                            <select class="form-control form-control-lg select2" name="currency">
                                                <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?=  $currency->code ; ?>" <?php if ($currency->code == $company->currency) { ?> 
                                                    selected <?php } ?>><?=  $currency->name ; ?> ( <?=  $currency->code ; ?> )</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="line-divider medium">
                                            <hr class="hr">
                                        </div>         
                                        <p class="text-gray-500">Thank you note</p>                                                   
                                        <div class="form-group">
                                            <div class="craft-wrap craft-switch">
                                                <?php if ($company->send_thankyou == "Enabled") { ?>
                                                <input type="checkbox" name="send_thankyou" class="craft-input" id="send-thankyou" value="Enabled" checked="">
                                                <?php } else { ?>
                                                <input type="checkbox" name="send_thankyou" class="craft-input" id="send-thankyou" value="Enabled">
                                                <?php } ?>
                                                <label class="craft-label" for="send-thankyou">Enable thank you message.</label>
                                            </div>
                                        </div>
                                        <?php if ($company->send_thankyou == "Enabled") { ?>
                                        <div class="form-group thankyou-message">
                                        <?php } else { ?>
                                        <div class="form-group thankyou-message" style="display:none;">
                                        <?php } ?>
                                            <label class="form-label">Thank You Message</label>
                                            <textarea class="form-control form-control-lg unset-mh" placeholder="Thank you message" rows="4" name="thankyou_message"><?=  $company->thankyou_message ; ?></textarea>
                                            <div class="input-note">Message sent to customer after a service. You can use the tag <code>{customer_name}</code> and <code>{company_name}</code></div>
                                        </div>                                                                
                                        <div class="form-group text-right">
                                            <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span>Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                          <?php } ?>
                          <?php if ($user->role == "Admin") { ?>
                          <div id="system" class="tab-pane fade">
                            <div class="row space-nne">
                                <div class="col-md-7">
                                    <h3>System Settings</h3>
                                    <p class="text-gray-500">Update system settings and preferences.</p>

                                    <form class="simcy-form" action="<?=  url('Settings@updatesystem') ; ?>" data-parsley-validate="" method="POST" loader="true">
                                        <div class="form-group">
                                            <label class="form-label">System Name</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="System Name" name="APP_NAME" value="<?=  env('APP_NAME') ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">System Logo</label>
                                            <input type="file" name="APP_LOGO" class="croppie" default="<?=  asset('uploads/app/'.env('APP_LOGO')) ; ?>" crop-width="320" crop-height="60" accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">System Logo</label>
                                            <input type="file" name="APP_ICON" class="croppie" default="<?=  asset('uploads/app/'.env('APP_ICON')) ; ?>" crop-width="64" crop-height="64" accept="image/*">
                                        </div>
                                        <div class="line-divider medium">
                                            <hr class="hr">
                                        </div>
                                        <p class="text-gray-500">Email SMTP Settings & Credentials</p>
                                        <div class="form-group">
                                            <label class="form-label">SMTP Username</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="SMTP Username" name="MAIL_USERNAME" value="<?=  env('MAIL_USERNAME'); ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">SMTP Sender Email</label>
                                            <input type="email" class="form-control form-control-lg" placeholder="SMTP Sender Email" name="MAIL_SENDER" value="<?=  env('MAIL_SENDER'); ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">SMTP Host</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="SMTP Host" name="SMTP_HOST" value="<?=  env('SMTP_HOST'); ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">SMTP Port</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="SMTP Port" name="SMTP_PORT" value="<?=  env('SMTP_PORT'); ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">SMTP Password</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="SMTP Password" name="SMTP_PASSWORD" value="<?=  env('SMTP_PASSWORD'); ; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">SMTP Encryption</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="SMTP Encryption" name="MAIL_ENCRYPTION" value="<?=  env('MAIL_ENCRYPTION'); ; ?>" required="">
                                        </div>                                           
                                        <div class="form-group">
                                            <div class="craft-wrap craft-switch">
                                                <?php if (env('SMTP_AUTH')) { ?>
                                                <input type="checkbox" name="SMTP_AUTH" class="craft-input" id="smtp-auth" value="Enabled" checked="">
                                                <?php } else { ?>
                                                <input type="checkbox" name="SMTP_AUTH" class="craft-input" id="smtp-auth" value="Enabled">
                                                <?php } ?>
                                                <label class="craft-label" for="smtp-auth">Enable SMTP Authentication</label>
                                            </div>
                                        </div>
                                        <div class="line-divider medium">
                                            <hr class="hr">
                                        </div>
                                        <p class="text-gray-500">Sms Settings & Credentials</p>
                                        <div class="form-group">
                                            <label class="form-label">SMS Provider</label>
                                            <select class="form-control form-control-lg sms-provider-select" name="SMS_PROVIDER">
                                                <option value="twillio" <?php if (env('SMS_PROVIDER') == "twilio") { ?> selected <?php } ?>>Twilio</option>
                                                <option value="africastalking" <?php if (env('SMS_PROVIDER') == "africastalking") { ?> selected <?php } ?>>Africa's Talking</option>
                                            </select>
                                        </div>
                                        <?php if (env('SMS_PROVIDER') == "africastalking") { ?>
                                        <div class="africastalking-input form-group">
                                        <?php } else { ?>
                                        <div class="africastalking-input form-group" style="display:none;">
                                        <?php } ?>
                                            <div class="form-group">
                                                <label class="form-label">Africa's Talking Username</label>
                                                <input type="text" class="form-control form-control-lg" placeholder="Username" name="AFRICASTALKING_USERNAME" value="<?=  env('AFRICASTALKING_USERNAME'); ; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Africa's Talking API Key</label>
                                                <input type="text" class="form-control form-control-lg" placeholder="API Key" name="AFRICASTALKING_KEY" value="<?=  env('AFRICASTALKING_KEY'); ; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Africa's Talking Sender ID</label>
                                                <input type="text" class="form-control form-control-lg" placeholder="Sender ID" name="AFRICASTALKING_SENDERID" value="<?=  env('AFRICASTALKING_SENDERID'); ; ?>">
                                            </div>   
                                        </div>
                                        <?php if (env('SMS_PROVIDER') == "twillio") { ?>
                                        <div class="twilio-input form-group">
                                        <?php } else { ?>
                                        <div class="twilio-input form-group" style="display:none;">
                                        <?php } ?>
                                            <div class="form-group">
                                                <label class="form-label"> SID</label>
                                                <input type="text" class="form-control form-control-lg" placeholder="Twilio SID" name="TWILIO_SID" value="<?=  env('TWILIO_SID'); ; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Twilio Auth Token</label>
                                                <input type="text" class="form-control form-control-lg" placeholder="Twilio Auth Token" name="TWILIO_AUTHTOKEN" value="<?=  env('TWILIO_AUTHTOKEN'); ; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Twilio Sender ID</label>
                                                <input type="text" class="form-control form-control-lg" placeholder="Twilio Sender ID" name="TWILIO_PHONENUMBER" value="<?=  env('TWILIO_PHONENUMBER'); ; ?>">
                                            </div> 
                                        </div>                                                           
                                        <div class="form-group text-right">
                                            <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span>Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                          <?php } ?>
                          <div id="security" class="tab-pane fade">
                            <div class="row space-nne">
                                <div class="col-md-7">
                                    <h3>Security Settings</h3>
                                    <p class="text-gray-500">Set a unique password to protect your account.</p>
                                    <form class="simcy-form" action="<?=  url('Settings@updatepassword') ; ?>" data-parsley-validate="" method="POST" loader="true">
                                        <div class="form-group">
                                            <label class="form-label" for="password">Current Password</label>
                                            <input type="password" class="form-control form-control-lg" id="current" name="current" placeholder="Enter your current password" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">New Password</label>
                                            <input type="password" class="form-control form-control-lg" minlength="6" id="password" name="password" placeholder="Enter your new password" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Confirm New Password</label>
                                            <input type="password" class="form-control form-control-lg" id="confirm" name="password" placeholder="Confirm new password" data-parsley-required="true" data-parsley-equalto="#password" data-parsley-error-message="Passwords don't Match!">
                                        </div>
                                        <div class="form-group text-right">
                                            <button class="btn btn-primary"><span class="btn-svg-icon"><?=  icon('check') ; ?></span>Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </main>



<?= view( 'includes/footer', $s_v_data ); ?>
<?= view( 'includes/scripts', $s_v_data ); ?>

</body>

</html>
<?php return;
