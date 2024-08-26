<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model{
    protected $table = 'support_login'; // Your table name
    protected $primaryKey = 's_id'; // Your primary key

//////////////// SAVE THE INFORMATION OF SUPPORT AFTER REGISTRATION ///////////

    public function saveUser($data)
	{
        $this->db->insert($this->table, $data);
	}


//////////// CHECK CREDENTIALS ////////////////////////////

	public function validate_credentials($email) {
		return $this->db->get_where($this->table, ['email' => $email])->row_array();
	}

///////// FETCH THE OPEN TICKETS FROM TABLE ////////

    public function get_open_tickets() {
        // Query to fetch open tickets from the database
        $query = $this->db->where('status', 'open')->where('acceptance !=', 'accepted')->get('tickets');
        
        // Check if there are any open tickets
        if ($query->num_rows() > 0) {
            // Return the open tickets as an array of rows
            return $query->result_array();
        } else {
            // If no open tickets found, return an empty array
            return array();
        }
    }


//////////////// FETCH THE MESSAGES FOR THE PARTICULAR TICKET WHILE CHATTING ///////////// 

    public function getMessagesForTicket($ticket_id) {
        // Fetch messages for the specified ticket ID
        $this->db->where('ticket_id', $ticket_id);
        $query = $this->db->get('messages');
        
        // Check if there are any messages
        if ($query->num_rows() > 0) {
            // Return messages as an array of rows
            return $query->result_array();
        } else {
            // If no messages found, return an empty array
            return array();
        }
    }

////////////// CHECK WHETHER THE TICKET IS OPEN OR CLOSED /////////////////

    public function getTicketStatus($ticket_id) {
        // Fetch the status of the specified ticket ID
        $query = $this->db->select('status')->where('ticket_id', $ticket_id)->get('tickets');

        // Check if the ticket exists
        if ($query->num_rows() == 1) {
            // Return the status of the ticket
            $result = $query->row_array();
            return $result['status'];
        } else {
            // If the ticket does not exist, return null or handle the case accordingly
            return null;
        }
    }

    
    public function isTicketAcceptedByUser($ticket_id, $user_email) {
        // Query the database to check if the ticket with the given ID is accepted by the user
        $this->db->where('ticket_id', $ticket_id);
        $this->db->where('accepted_by', $user_email);
        $this->db->where('acceptance', 'accepted');
        $query = $this->db->get('tickets');

        // Check if any row is returned
        if ($query->num_rows() > 0) {
            return true; // Ticket is accepted by the user
        } else {
            return false; // Ticket is not accepted by the user
        }
    }
/////////////// WHEN SUPPORT CLOSE THE TICKET THEN THE STATUS SHOULD BE UPDATED TO CLOSED ////////////

    public function updateTicketStatus($ticket_id, $status) {
    $closed_at = date('Y-m-d H:i:s');

    // Update the status and closed_at columns of the ticket in the database
    $data = array(
        'status' => $status,
        'closed_at' => $closed_at // Update closed_at with current timestamp
    );

    $this->db->where('ticket_id', $ticket_id);
    $this->db->update('tickets', $data);
    }

////////// WHILE CHATTING SAVE THE MESSAGES INTO TABLE FOR THAT CURRENT TICKET ////////////

    public function saveMessageForTicket($message, $sender, $ticket_id) {
        // Prepare data to insert into the database
        $data = array(
            'ticket_id' => $ticket_id,
            'message' => $message,
            'sender' => $sender
        );
        $this->db->insert('messages', $data);
    }

/////////// WHEN THE SUPPORT CLICK ON THE TICKET IN THE TICKET VIEW THEN UPDATE IT TO "ACCEPTED" /////

    public function updateAcceptance($ticket_id, $user_email) {
        $accepted_at = date('Y-m-d H:i:s');
        $data = array(
            'acceptance' => 'accepted',
            'accepted_at' => $accepted_at,
            'accepted_by' => $user_email
        );
        $this->db->where('ticket_id', $ticket_id);
        $this->db->update('tickets', $data);
    }

///// COUNT THE TICKETS ACCEPTED BY THAT PARTICULAR/CURRENT USER'S EMAIL ///////////////// 

    public function count_accepted_tickets($user_email) {
        // Count the number of tickets accepted by the user with the provided email
        $this->db->where('accepted_by', $user_email);
        $this->db->where('acceptance', 'accepted'); // Filter for accepted tickets
        return $this->db->count_all_results('tickets');
    }

////////////// BEFORE OPENING THE TICKETS CHECK WHETHER IT IS ALREADY ACCEPTED OR NOT ///////////////

    public function getAcceptStatus($ticket_id) {
        // Fetch the status of the specified ticket ID
        $query = $this->db->select('acceptance')->where('ticket_id', $ticket_id)->get('tickets');

        // Check if the ticket exists
        if ($query->num_rows() == 1) {
            // Return the status of the ticket
            $result = $query->row_array();
            return $result['acceptance'];
        } else {
            // If the ticket does not exist, return null or handle the case accordingly
            return null;
        }
    }

//////////////// FOR ARRIVED TICKETS COUNT ALL THE TICKETS ////////////////

    public function count_all_tickets() {
        // Count all tickets in the database
        return $this->db->count_all('tickets');
    }


///////////// IN TICKET VIEW GET ALL THE OPEN  TICKETS OF THAT PARTICULAR DATE RANGE /////////////

    public function getTicketsByDateRange($start_date, $end_date) {
        // Initialize the query builder
        $this->db->where('status', 'open')->where('acceptance !=', 'accepted');
        
        // Add date range conditions if start and end dates are provided
        if ($start_date !== null && $end_date !== null) {
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
        }
        
        $query = $this->db->get('tickets');
        return $query->result_array();
    }
    
//////// FOR TICKET VIEW GET ALL THE ARRIVED TICKETS ///////////////

    public function countTicketsByDateRange($start_date, $end_date) {
        // Add date range conditions if start and end dates are provided
        if ($start_date !== null && $end_date !== null) {
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
        }
        
        return $this->db->count_all_results('tickets');
    }
    

////////////// COUNT HOW MANY TICKETS ACCEPTED WITHIN THAT DATE RANGE ////////////

    public function countAcceptedTicketsByDateRange($user_email, $start_date, $end_date) {
        // Count accepted tickets by the current user within the specified date range
        $this->db->where('acceptance', 'accepted');
        $this->db->where('accepted_by', $user_email);
        
        // Add date range conditions if start and end dates are provided
        if ($start_date !== null && $end_date !== null) {
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
        }
        
        return $this->db->count_all_results('tickets');
    }

///////////////// DISPLAY ARRIVED TICKETS INITIALLY WITHOUT SELECTING DATE /////////////////////////

    public function arrived_tickets() {
        $this->db->order_by('created_at', 'asc');
        $this->db->where('status','open');
        $this->db->where('acceptance !=','accepted');
        return $this->db->get('tickets')->result_array();
    }

///////////////// DISPLAY ACCEPTED TICKETS INITIALLY WITHOUT SELECTING DATE /////////////////////////

    public function accepted_tickets() {
        $this->db->order_by('created_at', 'asc');
        $this->db->where('acceptance', 'accepted');
        return $this->db->get('tickets')->result_array();
    }

///////////////// DISPLAY CLOSED TICKETS INITIALLY WITHOUT SELECTING DATE /////////////////////////

    public function closed_tickets() {
        $this->db->order_by('created_at', 'asc');
        $this->db->where('status', 'closed');
        return $this->db->get('tickets')->result_array();
    }

///////////////// PENDING ARRIVED TICKETS INITIALLY WITHOUT SELECTING DATE /////////////////////////

    public function pending_tickets() {
        $this->db->order_by('created_at', 'asc');
        $this->db->where('acceptance', 'accepted');
        $this->db->where('status !=','closed');
        return $this->db->get('tickets')->result_array();
    }
  
///////////////// DISPLAY ARRIVED TICKETS AFTER SELECTING DATE /////////////////////////    

    public function arrived_tickets_date($start_date, $end_date) {
        if ($start_date !== null && $end_date !== null){
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $this->db->order_by('created_at', 'asc');
        }

        return $this->db->get('tickets')->result_array();
    }

///////////////// DISPLAY ACCEPTED TICKETS AFTER SELECTING DATE /////////////////////////

    public function accepted_tickets_date($start_date, $end_date) {
        if ($start_date !== null && $end_date !== null){
            $this->db->where('acceptance', 'accepted');
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $this->db->order_by('created_at', 'asc');
        }

        return $this->db->get('tickets')->result_array();
    }

///////////////// DISPLAY CLOSED TICKETS AFTER SELECTING DATE /////////////////////////

    public function closed_tickets_date($start_date, $end_date) {
        if ($start_date !== null && $end_date !== null){
            $this->db->where('status', 'closed');
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $this->db->order_by('created_at', 'asc');
        }

        return $this->db->get('tickets')->result_array();
    }

///////////////// DISPLAY PENDING TICKETS AFTER SELECTING DATE /////////////////////////

    public function pending_tickets_date($start_date, $end_date) {
        if ($start_date !== null && $end_date !== null){
            $this->db->where('acceptance', 'pending');
            $this->db->where('created_at >=', $start_date);
            $this->db->where('created_at <=', $end_date);
            $this->db->order_by('created_at', 'asc');
        }

        return $this->db->get('tickets')->result_array();
    }
    
///////////////// THIS FUNCTION IS FOR DISPLAYING THE CONVERSATION FOR THE PARTICULAR TICKET ID /////////////////////////

    public function get_messages($ticket_id) {
        $this->db->where('ticket_id', $ticket_id);
        $query = $this->db->get('messages');

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return array of messages
        } else {
            return array(); // Return an empty array if no messages found
        }
    }
    public function getNewMessages($lastMessageId) {
        // Assuming you have a database table named 'messages' with columns 'id', 'message', and 'sender'
    
        // Query to fetch new messages
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where('id >', $lastMessageId); // Fetch messages with IDs greater than the last message ID
        $query = $this->db->get();
    
        // Check if there are new messages
        if ($query->num_rows() > 0) {
            // Return new messages as an array
            return $query->result_array();
        } else {
            // If no new messages, return an empty array
            return array();
        }
    }

////////////////////// Check if that ticket is open or not //////////////////////////////
    
    public function isTicketOpen($ticket_id) {
        $this->db->select('status');
        $this->db->where('ticket_id', $ticket_id);
        $query = $this->db->get('tickets');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->status == 'open'; 
        } else {
            return false;
        }
    }

////////////// Check if the ticket belongs to the user /////////////////////////////////////////
    
    public function isTicketBelongsToUser($ticket_id, $user_email) {
        $this->db->select('accepted_by');
        $this->db->where('ticket_id', $ticket_id);
        $query = $this->db->get('tickets');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->accepted_by == $user_email;
        } else {
            return false;
        }
    }
} 
?>