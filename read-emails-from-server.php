<?php
/**
 * Class : Email Reader
 *
 * @version 1.0
 * @category Server Email
 * @author Tuhin <tuhin@codesolz.net>
 * @license http://URL MIT
 */

class Email_reader {

    // imap server connection
    public $conn;
    
    // inbox storage and inbox message count
    private $inbox;
    private $msg_cnt;
    
    // email login credentials
    private $server = ''; //enter your server address
    private $user = ''; //enter your email username
    private $pass = ''; //enter your email account password
    private $port = 110; // adjust according to server settings

    /**
     * Init class
     * connect to the server and get the inbox emails
     * 
     */
    function __construct() {
        $this->connect();
        $this->inbox();
    }

    /**
     * close the server connection
     * 
     */
    function close() {
        $this->inbox = array();
        $this->msg_cnt = 0;

        imap_close($this->conn);
    }

    /**
     * open the server connection
     * the imap_open function parameters will need to be changed for the particular server
     * these are laid out to connect to a Dreamhost IMAP server
     * 
     */
    function connect() {
        $this->conn = imap_open('{' . $this->server . '/notls}', $this->user, $this->pass);
        //$this->conn =imap_open('{'.$this->server.':'.$this->port.'/imap/ssl/novalidate-cert}INBOX', $this->user, $this->pass) or die('Cannot connect: ' . print_r(imap_errors(), true));
    }

    /**
     * move the message to a new folder
     * 
     * @param type $msg_index
     * @param type $folder
     */
    function move($msg_index, $folder = 'INBOX.Processed') {
        imap_mail_move($this->conn, $msg_index, $folder);
        imap_expunge($this->conn);

        // re-read the inbox
        $this->inbox();
    }

    /**
     * get a specific message (1 = first email, 2 = second email, etc.)
     * 
     * @param type $msg_index
     * @return type
     */
    function get($msg_index = NULL) {
        if (count($this->inbox) <= 0) {
            return array();
        } elseif (!is_null($msg_index) && isset($this->inbox[$msg_index])) {
            return $this->inbox[$msg_index];
        }

        return $this->inbox;
    }

    /**
     * Delete email froms erver
     * 
     * @param type $msgNumber
     */
    function delete($msgNumber) {
        imap_delete($this->conn, $msgNumber) or die('Cannot Delete: ' . print_r(imap_errors(), true));
    }

    /**
     * Read the inbox
     */
    function inbox() {
        $this->msg_cnt = imap_num_msg($this->conn);

        $in = array();
        for ($i = 1; $i <= $this->msg_cnt; $i++) {
            $in[] = array(
                'index' => $i,
                'header' => imap_headerinfo($this->conn, $i),
                // 'body'      => imap_body($this->conn, $i),
                //'structure' => imap_fetchstructure($this->conn, $i)
            );
        }

        $this->inbox = $in;
    }
}
?>