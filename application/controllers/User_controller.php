<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('User_Model');
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
            $this->load->view('user_login');
        } else {
            // If validation succeeds, check for email and password validity
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Perform your email and password validation logic here
            $valid_credentials = $this->User_Model->validate_credentials($email);

            if ($valid_credentials && password_verify($password, $valid_credentials['password'])) {                // If email and password are valid, load 'user_bot' view
                redirect('index.php/UserBot');
            } else {
                // If email or password is invalid, display error message
                echo '<script>alert("Invalid email or password.");';
                echo 'window.location.href = "' . base_url('index.php/UserLogin/') . '";</script>';
            }
        } 
    }

    public function register(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, show login form with errors
            $this->load->view('user_register');
        } else {
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $password = $this->input->post('password');

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Create an array to store user data
            $data = array(
                'email' => $email,
                'phone' => $phone,
                'password' => $hashedPassword
            );
            $this->User_Model->saveUser($data);
            $this->load->view('user_login');
        }   
    }

    public function user_chat_message() {
        // Validate form input
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('message', 'Message', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, display error message and reload the form
            redirect('index.php/UserChat');
        } else {
            // If validation succeeds, insert message into database and generate ticket
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $message = $this->input->post('message');
    
        // Combine email and phone number with the message
            $full_message = "Email: $email <br> Phone: $phone <br> Message: $message";
    
             // Check if user credentials are valid
             $valid_user = $this->User_Model->validateUser($email, $phone);
    
             if ($valid_user) {
                 // Generate a new ticket ID
                $ticket_id = $this->User_Model->generateTicket();
                $this->session->set_userdata('current_ticket', $ticket_id);
    
                // Insert message into the database with the current ticket ID
                $this->User_Model->saveMessage($full_message, 'user', $ticket_id);
                redirect('index.php/UserChat');    
             }
        } 
    }
    
    public function user_bot(){
        //$this->load->view('new/new_header');
        $this->load->view('new/user_bot');
        //$this->load->view('new/footer');
    }
    
    public function chat_view() {
        // Get the current ticket ID from the session
        $current_ticket_id = $this->session->userdata('current_ticket');
    
        // Check if the current ticket ID is set
        if (!empty($current_ticket_id)) {
            // Get existing messages for the current ticket ID
            $data['messages'] = $this->User_Model->getMessagesForTicket($current_ticket_id);
    
            // Load the chat view
            //$this->load->view('new/new_header');
            $this->load->view('new/chat_view', $data);
            //$this->load->view('new/footer');
        } else {
            // Handle the case where the ticket ID is not set
            echo 'Ticket ID not found';
        }
    }
    
    public function reply_message() {
        // Get the current ticket ID from the session
        $current_ticket_id = $this->session->userdata('current_ticket');
    
        // Check if the ticket ID is set
        if (!empty($current_ticket_id)) {
            // Retrieve the ticket status from the database
            $ticket_status = $this->User_Model->getTicketStatus($current_ticket_id);
    
            // Check if the ticket status is 'open'
            if ($ticket_status === 'open') {
                // Validate form input
                $this->form_validation->set_rules('user-input', 'Message', 'required');
    
                if($this->form_validation->run() === FALSE) {
                    // If validation fails, redirect back to chat view
                    //redirect('index.php/UserChat');
                    //echo "Heyo";
                    // If validation fails, print validation errors
                echo "Validation failed: ";
                echo validation_errors();

                // Debugging statement to check form data
                $postData = $this->input->post();
                var_dump($postData);
                }else {
                    // If validation succeeds, save the new message with the current ticket ID
                    $message = $this->input->post('user-input');
                    $this->User_Model->saveMessage($message, 'user', $current_ticket_id); // Pass ticket_id to saveMessage
                    redirect('index.php/UserChat');
                }
            } else {
                // Display a message indicating that the ticket is closed
                echo '<script>alert("Ticket is closed. Please start a new conversation.");';
                echo 'window.location.href = "' . base_url('index.php/UserBot/') . '";</script>';
            }
        } else {
            // Handle the case where the ticket ID is not set
            echo 'Ticket ID not found';
        }
    }    
    public function in(){
        $this-load->view('h1');
    }
}
?> 