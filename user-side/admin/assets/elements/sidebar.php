<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="index.html" class="sidebar-logo">
            <img src="<?= get_site_option('site_url') ?>assets/images/logos/<?= get_site_option('logo') ?>" alt="<?= get_site_option('site_title') ?> Logo" class="light-logo">
            <img src="<?= get_site_option('site_url') ?>assets/images/logos/<?= get_site_option('light_logo') ?>" alt="<?= get_site_option('site_title') ?> Light Logo" class="dark-logo">
            <img src="<?= get_site_option('site_url') ?>assets/images/logos/<?= get_site_option('logo_icon') ?>" alt="" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="<?= get_site_option('dashboard_url') ?>">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-menu-group-title">Data Management</li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Members</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=members-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Members</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-member"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Member</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mage:megaphone-b" class="menu-icon"></iconify-icon>
                    <span>Announcements</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=announcements-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Announcements</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-announcement"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Announcement</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                    <span>Notices</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=notices-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Notices</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-notice"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Notice</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=notice-categories"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Notice Categories</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="teenyicons:invoice-outline" class="menu-icon"></iconify-icon>
                    <span>Bills</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=bills-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Bills</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-bill"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Bill</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="streamline-ultimate:meeting-remote" class="menu-icon"></iconify-icon>
                    <span>AGBMs</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=agbms-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All AGBMs</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-agbm"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New AGBM</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:gallery-bold" class="menu-icon"></iconify-icon>
                    <span>Gallery</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=gallery-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Gallery Images</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-gallery-image"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Gallery Image</a>
                    </li>
                </ul>
            </li>
            <li>
            <a href="chat-message.html">
                <iconify-icon icon="bi:chat-dots" class="menu-icon"></iconify-icon>
                <span>Chat</span> 
            </a>
            </li>
            <li>
            <a href="calendar-main.html">
                <iconify-icon icon="solar:calendar-outline" class="menu-icon"></iconify-icon>
                <span>Calendar</span> 
            </a>
            </li>
            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                <span>Invoice</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="invoice-list.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                </li>
                <li>
                <a href="invoice-preview.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Preview</a>
                </li>
                <li>
                <a href="invoice-add.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add new</a>
                </li>
                <li>
                <a href="invoice-edit.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Edit</a>
                </li>
            </ul>
            </li>

            <li class="sidebar-menu-group-title">Application</li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                    <span>Emails</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=emails-management"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Emails</a>
                    </li>
                    <li>
                        <a href="<?= get_site_option('dashboard_url') ?>?page=add-email"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Email</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                <span>Components</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="typography.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Typography</a>
                </li>
                <li>
                <a href="colors.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Colors</a>
                </li>
                <li>
                <a href="button.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Button</a>
                </li>
                <li>
                <a href="dropdown.html"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i> Dropdown</a>
                </li>
                <li>
                <a href="alert.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Alerts</a>
                </li>
                <li>
                <a href="card.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Card</a>
                </li>
                <li>
                <a href="carousel.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Carousel</a>
                </li>
                <li>
                <a href="avatar.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Avatars</a>
                </li>
                <li>
                <a href="progress.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Progress bar</a>
                </li>
                <li>
                <a href="tabs.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Tab & Accordion</a>
                </li>
                <li>
                <a href="pagination.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Pagination</a>
                </li>
                <li>
                <a href="badges.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Badges</a>
                </li>
                <li>
                <a href="tooltip.html"><i class="ri-circle-fill circle-icon text-lilac-600 w-auto"></i> Tooltip & Popover</a>
                </li>
                <li>
                <a href="videos.html"><i class="ri-circle-fill circle-icon text-cyan w-auto"></i> Videos</a>
                </li>
                <li>
                <a href="star-rating.html"><i class="ri-circle-fill circle-icon text-indigo w-auto"></i> Star Ratings</a>
                </li>
                <li>
                <a href="tags.html"><i class="ri-circle-fill circle-icon text-purple w-auto"></i> Tags</a>
                </li>
                <li>
                <a href="list.html"><i class="ri-circle-fill circle-icon text-red w-auto"></i> List</a>
                </li>
                <li>
                <a href="calendar.html"><i class="ri-circle-fill circle-icon text-yellow w-auto"></i> Calendar</a>
                </li>
                <li>
                <a href="radio.html"><i class="ri-circle-fill circle-icon text-orange w-auto"></i> Radio</a>
                </li>
                <li>
                <a href="switch.html"><i class="ri-circle-fill circle-icon text-pink w-auto"></i> Switch</a>
                </li>
                <li>
                <a href="image-upload.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Upload</a>
                </li>
            </ul>
            </li>
            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                <span>Forms</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="form.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Input Forms</a>
                </li>
                <li>
                <a href="form-layout.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Input Layout</a>
                </li>
                <li>
                <a href="form-validation.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Form Validation</a>
                </li>
            </ul>
            </li>
            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                <span>Table</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="table-basic.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Basic Table</a>
                </li>
                <li>
                <a href="table-data.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Data Table</a>
                </li>
            </ul>
            </li>
            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="solar:pie-chart-outline" class="menu-icon"></iconify-icon>
                <span>Chart</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="line-chart.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Line Chart</a>
                </li>
                <li>
                <a href="column-chart.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Column Chart</a>
                </li>
                <li>
                <a href="pie-chart.html"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Pie Chart</a>
                </li>
            </ul>
            </li>
            <li>
            <a href="widgets.html">
                <iconify-icon icon="fe:vector" class="menu-icon"></iconify-icon>
                <span>Widgets</span> 
            </a>
            </li>
            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                <span>Users</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="users-list.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List</a>
                </li>
                <li>
                <a href="users-grid.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Users Grid</a>
                </li>
                <li>
                <a href="add-user.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add User</a>
                </li>
                <li>
                <a href="view-profile.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> View Profile</a>
                </li>
            </ul>
            </li>

            <li class="sidebar-menu-group-title">Application</li>

            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="simple-line-icons:vector" class="menu-icon"></iconify-icon>
                <span>Authentication</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="sign-in.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Sign In</a>
                </li>
                <li>
                <a href="sign-up.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Sign Up</a>
                </li>
                <li>
                <a href="forgot-password.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Forgot Password</a>
                </li>
            </ul>
            </li>
            <li>
            <a href="gallery.html">
                <iconify-icon icon="solar:gallery-wide-linear" class="menu-icon"></iconify-icon>
                <span>Gallery</span> 
            </a>
            </li>
            <li>
            <a href="pricing.html">
                <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                <span>Pricing</span> 
            </a>
            </li>
            <li>
            <a href="faq.html">
                <iconify-icon icon="mage:message-question-mark-round" class="menu-icon"></iconify-icon>
                <span>FAQs.</span> 
            </a>
            </li>
            <li>
            <a href="error.html">
                <iconify-icon icon="streamline:straight-face" class="menu-icon"></iconify-icon>
                <span>404</span> 
            </a>
            </li>
            <li>
            <a href="terms-condition.html">
                <iconify-icon icon="octicon:info-24" class="menu-icon"></iconify-icon>
                <span>Terms & Conditions</span> 
            </a>
            </li>
            <li class="dropdown">
            <a href="javascript:void(0)">
                <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                <span>Settings</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                <a href="company.html"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Company</a>
                </li>
                <li>
                <a href="notification.html"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Notification</a>
                </li>
                <li>
                <a href="notification-alert.html"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Notification Alert</a>
                </li>
                <li>
                <a href="theme.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Theme</a>
                </li>
                <li>
                <a href="currencies.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Currencies</a>
                </li>
                <li>
                <a href="language.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Languages</a>
                </li>
                <li>
                <a href="payment-gateway.html"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Payment Gateway</a>
                </li>
            </ul>
            </li>
        </ul>
    </div>
</aside>