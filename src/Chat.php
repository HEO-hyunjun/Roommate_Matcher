<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    private $dbConn;

    public function __construct() {
	echo "Server Start";
        $this->clients = new \SplObjectStorage;
 
        require_once dirname(__FILE__) . '/DbConnect.php'; 
        
        $db = new Connect(); 
       
        $this->dbCon = $db->connect();
    }

    public function onOpen(ConnectionInterface $conn) {
       
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        
        $Sender = "";
        $Receiver = "";
        $Text = "";
        
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        
        $array = explode(',', $msg, 3);

        if($array[0] == "load"){
            $from->resourceId = $array[1];
            foreach ($this->clients as $client) {
                if ($from == $client) {
                   
                    $client->resourceId = $array[1];
                }
            }
            $this->getMessage($from, $array[2]);
        }
       
        else {
            $Sender = $array[0];
            $Receiver = $array[1];
            $Text = $array[2];
            
            $this->saveChat($Sender, $Receiver, $Text);
            
            foreach ($this->clients as $client) {
                if ($client->resourceId == $array[1]) {
                    
                    $client->send("0".$Text);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    function saveChat($Sender, $Receiver, $Text){
        $stmt = $this->dbCon->prepare("INSERT INTO chat_tbl (sender, receiver, text)
                        VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $Sender, $Receiver, $Text);
        if($stmt->execute())
        return true; 
        return false; 
    }

    
    function getMessage(ConnectionInterface $from , $receiver){
        $stmt = $this->dbCon->prepare("SELECT sender, receiver, text FROM chat_tbl where (sender = ? and receiver = ?) or (sender = ? and receiver = ?)");
        $stmt->bind_param("ssss",$from->resourceId, $receiver, $receiver, $from->resourceId);
        $stmt->execute();
        $stmt->bind_result($sender, $receiver, $text);
        
        while($stmt->fetch()){

            foreach ($this->clients as $client) {
                if ($from == $client) {
                    if($sender == $from->resourceId)
                        $isSender = "1";
                    else
                        $isSender = "0";
                    
                    $client->send($isSender.$text);
                }
            }
        }
    }
    
}
