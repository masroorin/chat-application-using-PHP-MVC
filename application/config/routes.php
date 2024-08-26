<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// $route['UserLogin']= "User_controller/login";
// $route['UserRegister']= "User_controller/register";
// $route['UserReply'] = "User_controller/reply_message";
// $route['UserMessage'] = "User_controller/user_chat_message"; //when user sends the first message
// $route['UserChat'] = "User_controller/chat_view"; //to view the chats
// $route['UserBot'] = "User_controller/user_bot";

// $route['SupportLogin']= "Chat_controller/chat_dashboard";
// $route['SupportRegister']= "Chat_controller/register";
// $route['SupportReply'] = "Chat_controller/sendReply";
// $route['SupportChat']= "Chat_controller/chat";
// $route['CloseTicket'] = "Chat_controller/close_ticket";
// $route['Fetch'] = "Chat_controller/fetch_open_tickets";
// $route['Arrived'] = "Chat_controller/arrived";
// $route['Accepted'] = "Chat_controller/accepted";
// $route['Closed'] = "Chat_controller/closed";
// $route['Pending'] = "Chat_controller/pending";
// $route['ArrivedDate'] = "Chat_controller/arrived_filter_tickets";
// $route['AcceptedDate'] = "Chat_controller/accepted_filter_tickets";
// $route['ClosedDate'] = "Chat_controller/closed_filter_tickets";
// $route['PendingDate'] = "Chat_controller/pending_filter_tickets";
// $route['ViewMessages/(:any)'] = "Chat_controller/view_messages/$1"; //for 4 buttons view message

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$route['UserLogin']= "User_controller/login";
$route['UserRegister']= "User_controller/register";
$route['User_controller']='User_controller';
$route['UserReply'] = $route['User_controller'].'/reply_message';
$route['UserMessage'] = $route['User_controller'].'/user_chat_message'; //when user sends the first message
$route['UserChat'] = $route['User_controller'].'/chat_view'; //to view the chats
$route['UserBot'] = $route['User_controller'].'/user_bot';

$route['Chat_controller']= 'Chat_controller';
$route['SupportLogin']= "Chat_controller/login";
$route['SupportRegister']= 'Chat_controller/register';
$route['Chat_controller'] = 'Chat_controller';
$route['support_chat'] = $route['Chat_controller'].'/chat_dashboard';
$route['SupportReply'] = $route['Chat_controller'].'/sendReply';
$route['SupportChat']= $route['Chat_controller'].'/chat';
$route['CloseTicket'] = $route['Chat_controller'].'/close_ticket';
$route['ClosePending/(:any)'] = $route['Chat_controller'].'/close_pending/$1';
$route['Fetch'] = $route['Chat_controller'].'/fetch_open_tickets';
$route['Arrived'] = $route['Chat_controller'].'/arrived';
$route['Accepted'] = $route['Chat_controller'].'/accepted';
$route['Closed'] = $route['Chat_controller'].'/closed';
$route['Pending'] = $route['Chat_controller'].'/pending';
$route['ArrivedDate'] = $route['Chat_controller'].'/arrived_filter_tickets';
$route['AcceptedDate'] = $route['Chat_controller'].'/accepted_filter_tickets';
$route['ClosedDate'] = $route['Chat_controller'].'/closed_filter_tickets';
$route['PendingDate'] = $route['Chat_controller'].'/pending_filter_tickets';
$route['ViewMessages/(:any)'] = $route['Chat_controller'].'/view_messages/$1'; //for 4 buttons view message
$route['FindbyDate'] = $route['Chat_controller'].'/filterTicketsByDateRange';  //in tickets view
$route['AcceptTicket/(:any)'] = $route['Chat_controller'].'/accept_ticket/$1'; //accept ticket when click on it
