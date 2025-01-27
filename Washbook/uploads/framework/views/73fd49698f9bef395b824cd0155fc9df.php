<?php global $s_v_data, $user, $title, $widgets, $revenue, $servicesales; ?>
<aside class="aside">
    <div class="aside-holder" style="height: calc(100vh - 72px);">
        <div class="aside-menu-holder">
            <div class="aside-menu-items">

                <div>
                    <p class="text-black fw-bold aside-menu-head">Overview</p>
                </div>
                <a href="<?=  env('APP_URL') ; ?>" class="aside-link overview" home-url=>
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('home-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Overview</p>
                    </span>
                </a>
                <a href="<?=  url('Sales@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('cart-alt') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Sales</p>
                    </span>
                </a>
                <a href="<?=  url('Reports@index') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('layers-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Reports</p>
                    </span>
                </a>
                <div class="line-divider">
                    <hr class="hr" />
                </div>
                <div>
                    <p class="text-black fw-bold aside-menu-head">System</p>
                </div>
                <a href="<?=  url('Clients@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('users-plus') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Clients</p>
                    </span>
                </a>

                <a href="<?=  url('Services@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('bookmarks-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Services</p>
                    </span>
                </a>

                <?php if ($user->role == "Admin" || $user->role == "Owner") { ?>
                <a href="<?=  url('Branches@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('layers-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Branches</p>
                    </span>
                </a>
                <?php } ?>

                <a href="<?=  url('Marketing@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('globe-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Marketing</p>
                    </span>
                </a>

                <div class="line-divider">
                    <hr class="hr" />
                </div>
                <div>
                    <p class="text-black fw-bold aside-menu-head">Management </p>
                </div>
                <?php if ($user->role == "Admin") { ?>
                <a href="<?=  url('Companies@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('albums-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Companies</p>
                    </span>
                </a>
                <?php } ?>
                <?php if ($user->role == "Admin" || $user->role == "Owner" || $user->role == "Manager") { ?>
                <a href="<?=  url('Team@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('people-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Team Members</p>
                    </span>
                </a>
                <?php } ?>
                <a href="<?=  url('Settings@get') ; ?>" class="aside-link">
                    <span class="aside-link-icon-holder">
                        <span class="aside-link-icon"><?=  icon('settings-outline') ; ?></span>
                    </span>
                    <span class="aside-link-text-holder">
                        <p class="aside-link-text">Settings</p>
                    </span>
                </a>
            </div>
        </div>
    </div>
</aside>

<?php return;
