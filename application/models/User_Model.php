<?php
date_default_timezone_set('Asia/Kolkata');
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model{
    protected $table = 'user_login'; // Your table name
    protected $primaryKey = 'user_id'; // Your primary key

    public function saveUser($data)
	{
        $this->db->insert($this->table, $data);
	}


	public function validate_credentials($email) {
		return $this->db->get_where($this->table, ['email' => $email])->row_array();
	}


	public function validateUser($email, $phone) {
        $query = $this->db->get_where('user_login', array('email' => $email, 'phone' => $phone));
        
        // Return true if the user with provided email and phone exists, otherwise false
        return $query->num_rows() > 0;
    }

    public function generateTicket() {
        // Get the last ticket ID from the database
        $last_ticket = $this->db->select('ticket_id')->order_by('id', 'DESC')->limit(1)->get('tickets')->row();
    
        if ($last_ticket) {
            // Extract the numeric part of the last ticket ID
            $last_ticket_number = (int) substr($last_ticket->ticket_id, 3);
            
            // Increment the last ticket number by 1
            $next_ticket_number = $last_ticket_number + 1;
        } else {
            // If there are no existing tickets, start from 101
            $next_ticket_number = 101;
        }
    
        // Generate the next ticket ID
        $ticket_id = 'TKT' . $next_ticket_number;
    
        // Insert the generated ticket ID into the 'tickets' table
        $this->db->insert('tickets', array('ticket_id' => $ticket_id));
    
        // Return the generated ticket ID
        return $ticket_id;
    }
    
    public function saveMessage($message, $sender, $ticket_id) {
        // Prepare data to insert into the database
        $data = array(
            'ticket_id' => $ticket_id,
            'message' => $message,
            'sender' => $sender
        );

        // Insert the message into the database
        $this->db->insert('messages', $data);
    }

    
    public function getMessagesForTicket($ticket_id) {
        // Fetch existing messages for the specified ticket ID from the database
        $query = $this->db->where('ticket_id', $ticket_id)->order_by('sent_at', 'ASC')->get('messages');
        return $query->result_array();
    }    

    public function getTicketStatus($ticket_id) {
        // Query the database to retrieve the status of the ticket
        $query = $this->db->select('status')->where('ticket_id', $ticket_id)->get('tickets');

        // Check if the query returned any rows
        if ($query->num_rows() > 0) {
            // Fetch the status from the result
            $row = $query->row();
            return $row->status;
        } else {
            // Return null if no ticket with the provided ID is found
            return null;
        }
    }    
}
?>