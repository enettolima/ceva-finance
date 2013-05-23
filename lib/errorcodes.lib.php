<?php
//MySql Errors
define("RECORD_NOT_FOUND_CODE", "17");
define("RECORD_NOT_FOUND_MESG", "Records not found matching your search criteria");
define("QUERY_RETURNED_MULTIPLE_RECORDS_CODE", "18");
define("QUERY_RETURNED_MULTIPLE_RECORDS_MESG", "Your query returned multiple records, please refine your criteria to continue.");
define("MYSQL_INSERT_ERROR_CODE", "19");
define("MYSQL_INSERT_ERROR_MESG", "Your insert query was not completed, an error has been detected");
define("MYSQL_DELETE_ERROR_CODE", "20");
define("MYSQL_DELETE_ERROR_MESG", "Your delete query was not completed, an error has been detected");
define("MYSQL_UPDATE_ERROR_CODE", "21");
define("MYSQL_UPDATE_ERROR_MESG", "Your update query was not completed, an error has been detected");
///////////////////////////////////////////

//My info change password and group
define("INVALID_NEW_PASSWORD_CODE", "1001");
define("INVALID_NEW_PASSWORD_MESG", "Sorry but the new password you typed does not match, please try again!");
define("PASSWORD_NOTFOUND_CODE", "1002");
define("PASSWORD_NOTFOUND_MESG", "Sorry but the password you typed does not match with your user, please try again!");
define("INVALID_NEW_PASSWORD_LENGTH_CODE", "1003");
define("INVALID_NEW_PASSWORD_LENGTH_MESG", "Sorry but the password you typed is too short you will need at least 4 digits, please try again!");
define("PASSWORD_CHANGED_CODE", "1004");
define("PASSWORD_CHANGED_MESG", "Your password has been changed, you must <a href='logout.php'>log out</a> and log in again with your new password!");
define("GROUP_CHANGED_CODE", "1005");
define("GROUP_CHANGED_MESG", "Your Group has been updated successfully!");
define("MYINFO_SAVED_CODE", "1006");
define("MYINFO_SAVED_MESG", "Your information has been updated successfully, you must <a href='logout.php'>log out</a> and log in again to avoid system errors!");
define("USERINFO_SAVED_CODE", "1007");
define("USERINFO_SAVED_MESG", "User information has been updated successfully!");
define("USER_DELETED_CODE", "1008");
define("USER_DELETED_MESG", "User has been deleted successfully!");
define("USER_INSERTED_CODE", "1009");
define("USER_INSERTED_MESG", "New user saved, The login information has been sent to the user`s e-mail!");
define("USER_NOTFOUND_CODE", "1010");
define("USER_NOTFOUND_MESG", "User not found, please try again!");
define("GROUP_NOTFOUND_CODE", "1011");
define("GROUP_NOTFOUND_MESG", "Group not found, please try again!");
define("GROUP_ADDED_CODE", "1012");
define("GROUP_ADDED_MESG", "Group saved successfully!");
define("GROUP_DELETED_CODE", "1013");
define("GROUP_DELETED_MESG", "Group has been deleted successfully!");
define("USERINFO_DUPLICATEDUSER_CODE", "1014");
define("USERINFO_DUPLICATEDUSER_MESG", "Sorry but this username already exist, please try again!");
define("USERINFO_DUPLICATEDEMAIL_CODE", "1015");
define("USERINFO_DUPLICATEDEMAIL_MESG", "Sorry but this e-mail is already in use, please try again!");
define("GROUP_ERRORSAVE_CODE", "1016");
define("GROUP_ERRORSAVE_MESG", "This Group could not be updated  at this time! Please try again later!");
define("USER_NOT_INSERTED_CODE", "1017");
define("USER_NOT_INSERTED_MESG", "No User was created!!! Report this Error");
define("PARTNER_NOT_INSERTED_CODE", "1018");
define("PARTNER_NOT_INSERTED_MESG", "No Partner was created!!! Report this Error");
define("PARTNERINFO_SAVED_CODE", "1019");
define("PARTNERINFO_SAVED_MESG", "Partner information has been updated successfully!");
define("CUSTOMER_NOTFOUND_CODE", "1020");
define("CUSTOMER_NOTFOUND_MESG", "No Customer for this Partner!");
///////////////////////////////////////////


//Signup Messages



////////////////////////////////////////////
//Menus messages
define("MAINMENU_NOTFOUND_CODE", "1101");
define("MAINMENU_NOTFOUND_MESG", "Main menu not found, please contact your system administrator!");
define("HIGHER_MENU_POSITION_CODE", "1102");
define("HIGHER_MENU_POSITION_MESG", "The order of the menu is incorrect, plase check the form and try again!");
define("POSITION_NOTNUM_CODE", "1103");
define("POSITION_NOTNUM_MESG", "The \"position field\" must be numeric, plase check the form and try again!");
define("POSITION_MENU_UPDATED_CODE", "1104");
define("POSITION_MENU_UPDATED_MESG", "Menu updated successfully! We recomend that you reload your web page!");
define("MENU_REMOVED_CODE", "1104");
define("MENU_REMOVED_MESG", "Menu removed successfully! We recomend that you reload your web page!");
define("SUBMENU_NOTFOUND_CODE", "1105");
define("SUBMENU_NOTFOUND_MESG", "Sub menu not found, please contact your system administrator!");
define("SIDEMENU_NOTFOUND_CODE", "1106");
define("SIDEMENU_NOTFOUND_MESG", "Side menu not found, please contact your system administrator!");
//////////////////////////////////////////////

//Campaigns messages
define("CAMPAIGN_NOTFOUND_CODE", "1120");
define("CAMPAIGN_NOTFOUND_MESG", "Campaign not found, if you like you can create a new one by clicking here!");
define("CAMPAIGN_INSERT_CODE", "1121");
define("CAMPAIGN_INSERT_MESG", "Campaign saved successfully!<br>To start your campaign, please click on Upload List to upload your CSV file.");
define("CAMPAIGN_INSERTERROR_CODE", "1122");
define("CAMPAIGN_INSERTERROR_MESG", "This campaign could not be saved at this time, please check your form and try again!");
define("CAMPAIGN_DELETED_CODE", "1123");
define("CAMPAIGN_DELETED_MESG", "Campaign deleted successfully!");
define("CAMPAIGN_LISTFIELDINVALID_CODE", "1124");
define("CAMPAIGN_LISTFIELDINVALID_MESG", "You can not leave any blank field! Please try again!");
define("CAMPAIGN_LISTSAVED_CODE", "1125");
define("CAMPAIGN_LISTSAVED_MESG", "Table created successfully!");
define("CAMPAIGN_SEARCHNOTFOUND_CODE", "1126");
define("CAMPAIGN_SEARCHNOTFOUND_MESG", "Campaign not found, please try again!");
define("CAMPAIGN_FIELDRESERVED_CODE", "1127");
define("CAMPAIGN_FIELDRESERVED_MESG", "Sorry but you can not have field using status or id, these names are reserved!");
define("CAMPAIGN_LISTNOTFOUND_CODE", "1128");
define("CAMPAIGN_LISTNOTFOUND_MESG", "Sorry but there is no list on this campaign!");
/////////////////////////////////////////////

//Company messages
define("COMPANY_INFOSAVED_CODE", "1130");
define("COMPANY_INFOSAVED_MESG", "Company information saved successfully!");
define("COMPANY_APICHANGED_CODE", "1131");
define("COMPANY_APICHANGED_MESG", "Company`s API changed successfully!");
////////////////////////////////////////////

//Access Control Messages
define("ACL_LEVELUPDATED_CODE", "1141");
define("ACL_LEVELUPDATED_MESG", "Levels updated successfully!");
define("ACL_LEVELCREATED_CODE", "1142");
define("ACL_LEVELCREATED_MESG", "Level created successfully!");
define("ACL_LEVELDUPLICATED_CODE", "1143");
define("ACL_LEVELDUPLICATED_MESG", "Sorry, but this level or description already exist, Please try again!");
define("ACL_INVALIDLEVEL_CODE", "1144");
define("ACL_INVALIDLEVEL_MESG", "Invalid level! This field is numeric only!");
define("ACL_REMOVEOK_CODE", "1145");
define("ACL_REMOVEOK_MESG", "Level removed successfully!");
define("ACL_REMOVEERROR_CODE", "1146");
define("ACL_REMOVEERROR_MESG", "Sorry, we could not remove this level at this time, please try again later!");
define("ACL_INUSE_CODE", "1147");
define("ACL_INUSE_MESG", "Sorry, but this level is still in use for someone and we could not remove this level at this time, please try to move all the users from this level and try again later!");
///////////////////////////////////////////


//System Configuration Messages
define("SYSTEM_ONLYONE_CODE", "1150");
define("SYSTEM_ONLYONE_MESG", "Sorry but you can not insert more than one configuration here!");
define("SYSTEM_CONFIGSAVED_CODE", "1151");
define("SYSTEM_CONFIGSAVED_MESG", "System configuration saved successfully!");
define("SYSTEM_DOWNLOADFILE_CODE", "1152");
define("SYSTEM_DOWNLOADFILE_MESG", "Invalid password, please try again!");
define("SYSTEM_FTPSAVED_CODE", "1153");
define("SYSTEM_FTPSAVED_MESG", "FTP configuration saved successfully!");
define("SYSTEM_FTPNOTSAVED_CODE", "1153");
define("SYSTEM_FTPNOTSAVED_MESG", "FTP configuration could not be saved at this time, please try again!");
define("SYSTEM_FTPINVALFIELD_CODE", "1154");
define("SYSTEM_FTPINVALFIELD_MESG", "Sorry but one or more fields are invalid! You can not leave any blank field! Please try again!");

//////////////////////////////////////////

//Signup Messages
define("SIGNUP_BLANK_CODE", "1160");
define("SIGNUP_BLANK_MESG", "Please fill out all blank fields!");
define("SIGNUP_SAVED_CODE", "1161");
define("SIGNUP_SAVED_MESG", "Setup data created successfully!");
define("SIGNUP_SMALL_USERNAME_CODE", "1162");
define("SIGNUP_SMALL_USERNAME_MESG", "USERNAME too small!");

//////////////////////////////////////////

//Audio Management Messages
define("AUDIO_NOTFOUND_CODE", "1170");
define("AUDIO_NOTFOUND_MESG", "Audio file not found, click here to upload a new one!");
define("AUDIO_INVALLABEL_CODE", "1171");
define("AUDIO_INVALLABEL_MESG", "Invalid file label, this field can not be blank, please try again!");
define("AUDIO_INVALDESC_CODE", "1172");
define("AUDIO_INVALDESC_MESG", "Invalid file description, this field can not be blank, please try again!");
define("AUDIO_SAVED_CODE", "1173");
define("AUDIO_SAVED_MESG", "Audio list saved successfully!");
define("AUDIO_DELETED_CODE", "1174");
define("AUDIO_DELETED_MESG", "Audio deleted successfully!");
define("AUDIO_ERRORSAVING_CODE", "1175");
define("AUDIO_ERRORSAVING_MESG", "This audio file could not be saved at this time, please try again later!");
/////////////////////////////////////////////

//Order Management Messages
define("ORDER_NOTE_EMPTY_CODE", "1180");
define("ORDER_NOTE_EMPTY_MESG", "No notes for this order!");
define("ORDER_NOTE_SAVED_CODE", "1181");
define("ORDER_NOTE_SAVED_MESG", "New note was added and order updated sucessfully!");
define("ORDER_NOTE_ERRORSAVING_CODE", "1182");
define("ORDER_NOTE_ERRORSAVING_MESG", "You need to insert a valid text!");
define("ORDER_NOTE_CHANGE_TO_COMPLETE_STATUS_CODE", "1183");
define("ORDER_NOTE_CHANGE_TO_COMPLETE_STATUS_MESG", "You need to complete every single task for this Order, then the status will be changed to completed automatically!");

//Task Management Messages
define("ORDER_TASK_EMPTY_CODE", "1190");
define("ORDER_TASK_EMPTY_MESG", "No tasks for this order!");
define("ORDER_TASK_NOTE_EMPTY_CODE", "1191");
define("ORDER_TASK_NOTE_EMPTY_MESG", "No notes for this task!");
define("ORDER_TASK_NOTE_SAVED_CODE", "1192");
define("ORDER_TASK_NOTE_SAVED_MESG", "New note was added and task updated sucessfully!");
define("ORDER_TASK_NOTE_ERRORSAVING_CODE", "1193");
define("ORDER_TASK_NOTE_ERRORSAVING_MESG", "You need to insert a valid text!");

//Trouble Tickets Management Messages
define("TROUBLE_TICKET_NOTE_EMPTY_CODE", "1200");
define("TROUBLE_TICKET_NOTE_EMPTY_MESG", "No notes for this ticket!");
define("TROUBLE_TICKET_NOTE_SAVED_CODE", "1201");
define("TROUBLE_TICKET_NOTE_SAVED_MESG", "New note was added and ticket updated sucessfully!");
define("TROUBLE_TICKET_NOTE_ERRORSAVING_CODE", "1202");
define("TROUBLE_TICKET_NOTE_ERRORSAVING_MESG", "You need to insert a valid text!");

//Route Profile Management Messages
define("ROUTE_PROFILE_FEATURE_EMPTY_CODE", "1210");
define("ROUTE_PROFILE_FEATURE_EMPTY_MESG", "No features for this profile!");

//Quick List Errors
define("QUICKLIST_DEVICENOTFOUND_CODE", "1220");
define("QUICKLIST_DEVICENOTFOUND_MESG", "No devices were found matching this criteria!");

//User Creation
define("USER_ALREADYEXIST_CODE", "1240");
define("USER_ALREADYEXIST_MESG", "Sorry but this Username already exist, please try a different Username!");
define("FIRSTNAME_BLANK_CODE", "1241");
define("FIRSTNAME_BLANK_MESG", "Sorry but the First Name is blank, please check the form and try again!");
define("LASTNAME_BLANK_CODE", "1242");
define("LASTNAME_BLANK_MESG", "Sorry but the Last Name is blank, please check the form and try again!");
define("USERNAME_BLANK_CODE", "1243");
define("USERNAME_BLANK_MESG", "Sorry but the Username is blank, please check the form and try again!");
define("PIN_BLANK_CODE", "1244");
define("PIN_BLANK_MESG", "Sorry but the Pin Number is Invalid, Pin Number must be numeric and at least 4 digits!");
define("EMAIL_INVALID_CODE", "1245");
define("EMAIL_INVALID_MESG", "Sorry but the E-mail is Invalid, Please provide a valid e-mail!");
define("MOBILE_INVALID_CODE", "1246");
define("MOBILE_INVALID_MESG", "Sorry but the Mobile Number is Invalid, Please provide a valid 10 digit Phone Number!");

//Phone Number Errors
//define("INVALID_DID_CODE", "1250");
//define("INVALID_DID_MESG", "Sorry but the Phone Number is Invalid!<br>Please provide a valid 10 digit Phone Number(ie 5556667777)!");

?>
