<?php

namespace app\assets;

/**************************
    Global Messages
***************************/

class GlobalMessages
{
    const WELCOME = 'Welcome To NIM';
    //signup client
    const SIGNUP_CLIENT_ERROR = 'Email does exist. Please enter other email';
    const SIGNUP_CLIENT_ERROR_1 = 'Error - System (2.1)';

    //signup employee
    const SIGNUP_EMPLOYEE_SUCCESS = 'Signup success!!';
    const SIGNUP_EMPLOYEE_ERROR = 'Error - System (2.2)';    

    //login
    const LOGIN_ERROR_1 = 'Password is not correct. Pleasy try again';
    const LOGIN_ERROR_2 = 'User does not exist in system';

    //password recovery
    const PASSWORD_RECOVERY_SUCCESS = 'Update new password success!!';
    const PASSWORD_RECOVERY_ERROR = 'Oops! Your link expired. Please try logging in.';
    const PASSWORD_RECOVERY_ERROR_1 = 'Error - System (3)';

    //employees
    const ADD_EMPLOYEE_SUCCESS = 'Send email success';
    const ADD_EMPLOYEE_ERROR = 'Email does exist. Please enter other email';
    const ADD_EMPLOYEE_ERROR_1 = 'Error - System (4.1)';    
    const REMOVE_EMPLOYEE_SUCCESS = 'Remove employee success!!';
    const REMOVE_EMPLOYEE_ERROR = 'Error - System (4.2)';

    //customers
    const UPDATE_CUSTOMER_SUCCESS = 'Assign employee for customer success!!';
    const UPDATE_CUSTOMER_ERROR = 'Error - System (5)';

    //services
    const ADD_SERVICE_SUCCESS = 'Add new service success!!';
    const ADD_SERVICE_ERROR = 'Error - System (6)';
    const UPDATE_SERVICE_SUCCESS = 'Update service success!!';
    const UPDATE_SERVICE_ERROR = 'Error - System (6.1)';
    const REMOVE_SERVICE_SUCCESS = 'Remove service success!!';
    const REMOVE_SERVICE_ERROR = 'Error - System (6.2)';    

    //ADs management
    const ADD_ADS_SUCCESS = 'Add new ad success!!';
    const ADD_ADS_ERROR = 'Error - System (7)';
    const UPDATE_ADS_SUCCESS = 'Update ad success!!';
    const UPDATE_ADS_ERROR = 'Error - System (7.1)';
    const REMOVE_ADS_SUCCESS = 'Remove ad success!!';
    const REMOVE_ADS_ERROR = 'Error - System (7.2)';
}
