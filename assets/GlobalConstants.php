<?php

namespace app\assets;

/**************************
    Global Constants
***************************/

class GlobalConstants
{
    const WELCOME = 'Welcome To NIM';
    // General Constants
    const TRUE = 1;
    const FALSE = 0;
    const NIL = -1;
    const LIMIT_ROW = 10;
    const SUCCESS = 'success';
    const ERROR = 'error';

    // Gender Constants
    const MALE = 1;
    const FEMALE = 0;
    const ADMIN_NAME = "Northern Interactive Media";
    const ADMIN_EMAIL = "support@northerninteractivemedia.com";

    // Roles
    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';
    const ADSPECIALIST = 'ad-specialist';
    const COPYWRITER = 'copywriter';
    const CLIENT = 'client';
    const DESIGNER = 'designer';
    const GENERAL = 'general';
    const MARKETINGDIRECTOR = 'marketing-director';
    const SALEPERSON = 'sale-person';

    // Role Types
    const USER_TYPE_ID = '1';
    const PERMISSION_TYPE_ID = '2';

    // Role Permissions
    const SUPERADMIN_PERMISSIONS = 'superadmin-permissions';
    const ADMIN_PERMISSIONS = 'admin-permissions';
    const ADSPECIALIST_PERMISSIONS = 'ad-specialist-permissions';
    const COPYWRITER_PERMISSIONS = 'copywriter-permissions';
    const DESIGNER_PERMISSIONS = 'designer-permissions';
    const GENERAL_PERMISSIONS = 'general-permissions';
    const MARKETINGDIRECTOR_PERMISSIONS = 'marketing-director-permissions';
    const SALEPERSON_PERMISSIONS = 'sale-person-permissions';
    const CLIENT_PERMISSIONS = 'client-permissions';

    // User Types
    const SUPERADMIN_TYPE_ID = '1';
    const ADMIN_TYPE_ID = '2';
    const ADSPECIALIST_TYPE_ID = '3';
    const MARKETINGDIRECTOR_TYPE_ID = '4';
    const COPYWRITER_TYPE_ID = '5';
    const DESIGNER_TYPE_ID = '6';
    const SALEPERSON_TYPE_ID = '7';
    const GENERAL_TYPE_ID = '8';
    const CLIENT_TYPE_ID = '9';

    const ONLINE = 'Online';
    const OFFLINE = 'Offline';
    const BUSY = 'Busy';

    const IMAGE_TYPE = 'image';
    const VIDEO_TYPE = 'video';
    const ARTICLE_TYPE = 'article';

    const NEW_CUSTOMER = 'new-customer';
    const EXISTING_CUSTOMER = 'existing-customer';
    const LOST_CUSTOMER = 'lost-customer';
    const DISCOUNT_PROMOTION = 'discount-promotion';
    const GIVE_AWAY_PROMOTION = 'give-away-promotion';
    const INCREASE_SALE_PROMOTION = 'increase-sale-promotion';

    const AD_TYPE_MARKETING_ACTIVITES = 5;
    const INDICATE_THE_DEMAND = 1;
    const PROFITABLE_HOLIDAYS = 2;
    const TARGET_CUSTOMER = 3;
    const CUSTOMER_RELATIONSHIP = 4;
}
