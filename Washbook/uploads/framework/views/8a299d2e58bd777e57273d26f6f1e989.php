<?php global $s_v_data, $user, $title, $widgets, $revenue, $servicesales; ?>
    <div class="header-holder">
        <header class="main-header">
            <div class="header-brand">
                <a href="" class="btn-icon mobile-nav">
                    <span class="icon-span"><?=  icon('menu-outline') ; ?></span>
                </a>
                <a href="<?=  env('APP_URL') ; ?>">
                    <img src="<?=  asset('uploads/app/'.env('APP_LOGO')) ; ?>" alt="" role="presentation" />
                </a>
            </div>
            <div class="header-search">
                <form action="<?=  url('Clients@get') ; ?>">
                <div class="header-search-box">
                    <div class="header-search-icon">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.2 16.34a7.5 7.5 0 1 1 1.38-1.45l4.2 4.2a1 1 0 1 1-1.42 1.41l-4.16-4.16zm-4.7.16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"></path></svg></span>
                    </div>
                    <?php if (isset($_GET["search"])) { ?>
                    <input dir="auto" type="search" placeholder="Search client" value="<?=  $_GET['search'] ; ?>" name="search">
                    <?php } else { ?>
                    <input dir="auto" type="search" placeholder="Search client" name="search">
                    <?php } ?>
                </div>
                </form>
            </div>
            <div class="header-options">
                <ul>
                    <li class="hide-xs">
                        <a href="<?=  url('Settings@get') ; ?>" class="btn-icon" aria-label="Account settings">
                            <span class="icon-span"><?=  icon('settings-outline') ; ?></span>
                        </a>
                    </li>
                    <li>
                        <div class="nav-button-holder">
                            <a href="" class="btn-icon btn-primary fetch-display-click mobile-btn" data="secure:true" url="<?=  url('Sales@checkout') ; ?>" holder=".update-holder-lg" modal="#update-lg"><span class="icon-span"><?=  icon('plus') ; ?></span></a>
                            <button class="btn btn-primary fetch-display-click desktop-btn" data="secure:true" url="<?=  url('Sales@checkout') ; ?>" holder=".update-holder-lg" modal="#update-lg"><span class="btn-svg-icon"><?=  icon('plus') ; ?></span> Record a Sale</button>
                        </div>
                    </li>
                    <li>
                        <div class="nav-profile ml-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="nav-profile-details">
                                <p class="heading-text fw-bold">
                                    <?=  $user->fname ; ?> <?=  $user->lname ; ?>
                                </p>
                                <p class="heading-text text-gray-500 section-ellipsis fs-15">
                                    <?=  $user->branch->name ; ?>
                                </p>
                            </div>
                            <div class="nav-profile-image ml-3">
                                <button type="button" aria-expanded="false" aria-haspopup="menu" role="button">
                                    <?php if (!empty($user->avatar)) { ?>
                                    <span class="profile-image fs-hide" role="img" aria-label="<?=  $user->fname ; ?> <?=  $user->lname ; ?>" style='background-image: url("<?=  asset('uploads/avatar/'.$user->avatar) ; ?>");'></span>
                                    <?php } else { ?>
                                    <span class="profile-image fs-hide" role="img" aria-label="<?=  $user->fname ; ?> <?=  $user->lname ; ?>" style='background-image: url("<?=  asset('assets/images/avatar.png') ; ?>");'></span>
                                    <?php } ?>
                                </button>
                            </div>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <div class="pt-3 pl-4 p-r-3">
                                <p class="heading-text fw-bold">
                                    <?=  $user->fname ; ?> <?=  $user->lname ; ?>
                                </p>
                                <p class="heading-text text-gray-500 section-ellipsis fs-15">
                                    <?=  $user->email ; ?>
                                </p>
                            </div>
                          <div class="line-divider">
                              <hr class="hr">
                          </div>
                          <a class="dropdown-item" href="<?=  url('Sales@get') ; ?>"><span class="dropdown-svg-icon"><?=  icon('cart-alt') ; ?></span>View Sales</a>
                          <a class="dropdown-item" href="<?=  url('Settings@get') ; ?>"><span class="dropdown-svg-icon"><?=  icon('settings-outline') ; ?></span>Account Settings</a>
                          <a class="dropdown-item" href="<?=  url('Auth@signout') ; ?>"><span class="dropdown-svg-icon"><?=  icon('logout') ; ?></span>Log Out</a>
                      </div>
                    </li>
                </ul>
                
            </div>
        </header>
    </div>
<?php return;
