<?php
date_default_timezone_set('Asia/Kolkata');

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Chat_model');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('form_validation');
    }
    
    public function login() {
        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        // Run validation
        if ($this->form_validation->run() === FALSE) {
            // If validation fails, display login form with errors
            $this->load->view('support_login');
        } else {
            // If validation succeeds, check for email and password validity
            $email = $this->input->post('email');
            $password = $this->input->post('password');
    
            // Perform your email and password validation logic here
            $valid_credentials = $this->Chat_model->validate_credentials($email);
    
            if ($valid_credentials && password_verify($password, $valid_credentials['password'])) {
                $this->session->set_userdata('user_email', $email);
                // If email and password are valid, redirect to fetch_open_tickets function
                redirect('index.php/support_chat');
            } else {
                // If email or password is invalid, display error message
                echo '<script>alert("Invalid email or password.");';
                echo 'window.location.href = "' . base_url('index.php/SupportLogin') . '";</script>';
            }
        }
    }


    public function chat_dashboard() {
        // Fetch open tickets from the model
        $open_tickets = $this->Chat_model->get_open_tickets();
    
        // Check if open_tickets is null
        if ($open_tickets !== null) {
            // Pass the open tickets to the view
            $data['open_tickets'] = $open_tickets;
        } else {
            // If open_tickets is null, set an empty array
            $data['open_tickets'] = [];
        }
    
        // Fetch the count of tickets arrived
        $data['ticket_count'] = $this->Chat_model->count_all_tickets();
        
        // Fetch the count of tickets accepted by the current user
        $user_email = $this->session->userdata('user_email');
        $data['accepted_tickets_count'] = $this->Chat_model->count_accepted_tickets($user_email);
    
        // Load the view with the fetched data
        //$this->load->view('support/header');
        $this->load->view('support/tickets_view', $data);
        //$this->load->view('support/footer');
    }
    
////////////////// REGISTER THE USER ///////////////////////

    public function register(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, show login form with errors
            $this->load->view('support_register');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
            // Create an array to store user data
            $data = array(
                'email' => $email,
                'password' => $hashedPassword
            );
            $this->Chat_model->saveUser($data);
            $this->load->view('support_login');
        }   
    }

/////////////////////// DISPLAY ALL THE OPEN TICKETS ///////////

public function fetch_open_tickets() {
    // Fetch open tickets from the model
    $data['open_tickets'] = $this->Chat_model->get_open_tickets();
    $data['ticket_count'] = $this->Chat_model->count_all_tickets();
    
    // Fetch the count of tickets accepted by the current user
    $user_email = $this->session->userdata('user_email');
    $data['accepted_tickets_count'] = $this->Chat_model->count_accepted_tickets($user_email);

    // Retrieve accepted ticket IDs from session
    $accepted_tickets = $this->session->userdata('accepted_tickets');
    
    // Initialize an empty array to store messages for all accepted tickets
    $all_messages = array();

    // Retrieve messages for each accepted ticket and store them in $all_messages array
    foreach ($accepted_tickets as $ticket_id) {
         // Check if the ticket is currently open
         $is_ticket_open = $this->Chat_model->isTicketOpen($ticket_id);
        
         // If the ticket is open, retrieve its messages
         if ($is_ticket_open) {
            $all_messages[$ticket_id] = $this->Chat_model->getMessagesForTicket($ticket_id);
        }
    }

    // Pass the array containing messages for all accepted tickets to the view
    $data['all_messages'] = $all_messages;

    // Check if there are open tickets and accepted tickets
    if (!empty($data['open_tickets']) && $data['accepted_tickets_count'] > 0) {
        // Load views for displaying chats
        //$this->load->view('support/header');
        $this->load->view('support/tickets_view', $data);
        $this->load->view('support/support_chat', $data);
        //$this->load->view('support/footer');
    } else {
        // Load views for displaying only ticket view
        //$this->load->view('support/header');
        $this->load->view('support/tickets_view', $data);
        //$this->load->view('support/footer');
    }
}


////////////////// AFTER SENDING THE REPLY //////////////////

public function sendReply() {
    // Retrieve the ticket ID from the form submission
    $current_ticket_id = $this->input->post('ticket_id');

    // Check if the ticket ID exists
    if (!empty($current_ticket_id)) {
        // Retrieve the status of the ticket
        $ticket_status = $this->Chat_model->getTicketStatus($current_ticket_id);
        
        // Check if the ticket is open
        if ($ticket_status == 'open') {
            // Validate form input
            $this->form_validation->set_rules('message', 'Message', 'required');

            if ($this->form_validation->run() == FALSE) {
                // If validation fails, reload the chat view with existing messages
                redirect('index.php/SupportChat');
            } else {
                // If validation succeeds, save the new message
                $message = $this->input->post('message');
                $this->Chat_model->saveMessageForTicket($message, 'admin', $current_ticket_id);
                redirect('index.php/SupportChat');
            }
        } else {
            // If the ticket is closed, display an error message
            echo 'Ticket is closed. You cannot send a message.';
        }
    } else {
        // If the ticket ID is not provided, handle the error
        echo 'Ticket ID not provided.';
    }
}


   
///////////// DISPLAY SUPPORT CHAT VIEW /////////////////////

public function chat()
{
    // Retrieve accepted ticket IDs from session
    $accepted_tickets = $this->session->userdata('accepted_tickets');
    
    // Initialize an empty array to store messages for all accepted tickets
    $all_messages = array();

    // Retrieve messages for each accepted ticket and store them in $all_messages array
    foreach ($accepted_tickets as $ticket_id) {
        // Check if the ticket is currently open
        $is_ticket_open = $this->Chat_model->isTicketOpen($ticket_id);
        
        // If the ticket is open, retrieve its messages
        if ($is_ticket_open) {
            $all_messages[$ticket_id] = $this->Chat_model->getMessagesForTicket($ticket_id);
        }
    }
    
    // Load necessary data for displaying open tickets count and other relevant information
    $data['open_tickets'] = $this->Chat_model->get_open_tickets();
    $data['ticket_count'] = $this->Chat_model->count_all_tickets();
    $user_email = $this->session->userdata('user_email');
    $data['accepted_tickets_count'] = $this->Chat_model->count_accepted_tickets($user_email);

    // Pass the array containing messages for all accepted tickets to the view
    $data['all_messages'] = $all_messages;

    // Load views
    //$this->load->view('support/header');
    $this->load->view('support/tickets_view', $data);
    $this->load->view('support/support_chat', $data);
    //$this->load->view('support/footer');
}

///////////////////////// CLOSE TICKET FROM CHAT ////////////////////////

public function close_ticket() {
    // Retrieve the ticket ID from the POST data
    $ticket_id = $this->input->post('ticket_id');

    // Retrieve the session data containing the array of accepted tickets
    $accepted_tickets = $this->session->userdata('accepted_tickets');

    // Check if the session data is set and if the current ticket ID exists
    if (!empty($accepted_tickets) && in_array($ticket_id, $accepted_tickets)) {
        // Update the status of the ticket to 'closed' in the database
        $this->Chat_model->updateTicketStatus($ticket_id, 'closed');

        // Redirect back to the appropriate page
        redirect('index.php/SupportChat');
    } else {
        // Handle the case where the ticket ID is not found or not accepted
        echo 'Invalid ticket ID or ticket not accepted';
    }
}

//////////////////////////////////////// CLOSE PENDING TICKET FROM PENDING VIEW /////////////////////////////

public function close_pending($ticket_id) {
    // Update the status of the ticket to 'closed' in the database
    $this->Chat_model->updateTicketStatus($ticket_id, 'closed');

    // Redirect back to the pending view
    redirect('index.php/Pending');
}

////////////// WHEN THE USER CLICK ON THE TICKET ID THEN THE STATUS CHANGES TO ACCEPTED and further messages can be saved//////////

public function accept_ticket($ticket_id) {
    // Initialize the session variable if it doesn't exist
    if (!$this->session->has_userdata('accepted_tickets')) {
        $this->session->set_userdata('accepted_tickets', array());
    }

    // Check if the ticket with the provided ID is already accepted
    $ticket_status = $this->Chat_model->getAcceptStatus($ticket_id);

    if ($ticket_status === 'accepted') {
        echo '<script>alert("Ticket is already accepted.");';
        echo 'window.location.href = "' . base_url('Fetch') . '";</script>';
    } else {
        // Get the email of the user who is accepting tickets (assuming you have stored it in session)
        $user_email = $this->session->userdata('user_email');
        
        // Update the acceptance status of the ticket to "accepted" in the database
        $this->Chat_model->updateAcceptance($ticket_id, $user_email);

        // Add the current ticket ID to the accepted_tickets session array
        $accepted_tickets = $this->session->userdata('accepted_tickets');
        $accepted_tickets[] = $ticket_id;
        $this->session->set_userdata('accepted_tickets', $accepted_tickets);

        // Set the current ticket ID in session (optional)
        // $this->session->set_userdata('current_ticket', $ticket_id);

        // Validate the form input
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, reload the chat view with existing messages
            redirect('index.php/SupportChat');
        } else {
            // If validation succeeds, save the new message
            $message = $this->input->post('message');
            $this->Chat_model->saveMessageForTicket($message, 'admin', $ticket_id);

            // Redirect to the chat view of the accepted ticket
            redirect('index.php/SupportChat');
        }
    }
}



//////////////////// IN TICKET VIEW TO FILTER TICKETS BY DATE ///////////////////////////


    public function filterTicketsByDateRange() {
        // Check if form data is submitted
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
            // Retrieve the start and end dates from the form submission
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
        } else {
            // Set default values for start and end dates to today's date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }
    
        $current_ticket_id = $this->session->userdata('current_ticket');
        $data['messages'] = $this->Chat_model->getMessagesForTicket($current_ticket_id);
    
        // Fetch open tickets within the specified date range
        $data['open_tickets'] = $this->Chat_model->getTicketsByDateRange($start_date, $end_date);
    
        // Fetch the total count of arrived tickets within the date range
        $data['ticket_count'] = $this->Chat_model->countTicketsByDateRange($start_date, $end_date);
    
        // Fetch the count of accepted tickets within the date range for the current user
        $user_email = $this->session->userdata('user_email');
        $data['accepted_tickets_count'] = $this->Chat_model->countAcceptedTicketsByDateRange($user_email, $start_date, $end_date);
    
        // Pass the selected date range back to the view
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Load the view with the filtered tickets data
        //$this->load->view('support/header');
        $this->load->view('support/tickets_view', $data);
        //$this->load->view('support/footer');
    }


////////////////// ARRIVED BUTTON //////////////////

    public function arrived() {
        // Fetch tickets from the model
        $data['tickets'] = $this->Chat_model->arrived_tickets();

        // Pass the fetched tickets data to your view
        //$this->load->view('support/header');
        $this->load->view('support/arrived_view', $data);
        //$this->load->view('support/footer');
    }

    ////////////////// ACCEPTED BUTTON //////////////////

    public function accepted() {
        // Fetch tickets from the model
        $data['tickets'] = $this->Chat_model->accepted_tickets();

        // Pass the fetched tickets data to your view
        //$this->load->view('support/header');
        $this->load->view('support/accepted_view', $data);
        //$this->load->view('support/footer');
    }

    ////////////////// CLOSED BUTTON //////////////////

    public function closed() {
        // Fetch tickets from the model
        $data['tickets'] = $this->Chat_model->closed_tickets();

        // Pass the fetched tickets data to your view\
        //$this->load->view('support/header');
        $this->load->view('support/closed_view', $data);
        //$this->load->view('support/footer');
    }

    ////////////////// PENDING BUTTON //////////////////

    public function pending() {
        // Fetch tickets from the model
        $data['tickets'] = $this->Chat_model->pending_tickets();

        // Pass the fetched tickets data to your view
        //$this->load->view('support/header');
        $this->load->view('support/pending_view', $data);
        //$this->load->view('support/footer');
    }

////////////////// ARRIVED BUTTON AFTER SELECTING THE DATE RANGE //////////////////

    public function arrived_filter_tickets() {
        // Check if form data is submitted
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
            // Retrieve the start and end dates from the form submission
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
        } else {
            // Set default values for start and end dates to today's date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $data['tickets'] = $this->Chat_model->arrived_tickets_date($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        // Load the view with filtered ticket data
        //$this->load->view('support/header');
        $this->load->view('support/arrived_view', $data);
        //$this->load->view('support/footer');
    }

////////////////// ACCEPTED BUTTON AFTER SELECTING THE DATE RANGE //////////////////

    public function accepted_filter_tickets() {
        // Check if form data is submitted
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
            // Retrieve the start and end dates from the form submission
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
        } else {
            // Set default values for start and end dates to today's date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $data['tickets'] = $this->Chat_model->accepted_tickets_date($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        // Load the view with filtered ticket data
        //$this->load->view('support/header');
        $this->load->view('support/accepted_view', $data);
        //$this->load->view('support/footer');
    }

////////////////// CLOSED BUTTON AFTER SELECTING THE DATE RANGE //////////////////

    public function closed_filter_tickets() {
        // Check if form data is submitted
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
            // Retrieve the start and end dates from the form submission
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
        } else {
            // Set default values for start and end dates to today's date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $data['tickets'] = $this->Chat_model->closed_tickets_date($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // Load the view with filtered ticket data
        //$this->load->view('support/header');
        $this->load->view('support/closed_view', $data);
        //$this->load->view('support/footer');
    }

////////////////// PENDING BUTTON AFTER SELECTING THE DATE RANGE //////////////////

    public function pending_filter_tickets() {
        // Check if form data is submitted
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
            // Retrieve the start and end dates from the form submission
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
        } else {
            // Set default values for start and end dates to today's date
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }

        $data['tickets'] = $this->Chat_model->pending_tickets_date($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // Load the view with filtered ticket data
        //$this->load->view('support/header');
        $this->load->view('support/pending_view', $data);
        //$this->load->view('support/footer');
    }

/////////////// AFTER CLICKING ON THE ID IN THE BUTTONS THEN THE CHAT OF THAT ID SHOULD BE DISPLAYED ///////

    public function view_messages($ticket_id) {
    
        // Fetch messages for the specified ticket ID
        $data['messages'] = $this->Chat_model->get_messages($ticket_id);
        $data['ticket_id'] = $ticket_id;
    
        // Load the view to display messages
        //$this->load->view('support/header');
        $this->load->view('support/view_messages', $data);
        //$this->load->view('support/footer');
    }
    
}
