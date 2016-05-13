<?php
class PlaceOrder extends DB
{
    /*public function getTickets() {
        $sql = "SELECT t.id, t.title, t.description, c.component
            from tickets t
            join components c on (c.id = t.component_id)";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new TicketEntity($row);
        }
        return $results;
    }
    *
     * Get one ticket by its ID
     *
     * @param int $ticket_id The ID of the ticket
     * @return TicketEntity  The ticket
     
    public function getTicketById($ticket_id) {
        $sql = "SELECT t.id, t.title, t.description, c.component
            from tickets t
            join components c on (c.id = t.component_id)
            where t.id = :ticket_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["ticket_id" => $ticket_id]);
        if($result) {
            return new TicketEntity($stmt->fetch());
        }
    }*/
    public function save(OrderEntity $order) {
        
        $sql = "insert into orders
            (name, email, phone, address, tid, amount) values
            (:name, :email, :phone, :address, :tid, :amount)";
        $stmt = $this->db->prepare($sql);
        try {
            $result = $stmt->execute([
                "name" => $order->getName(),
                "phone" => $order->getPhone(),
                "email" => $order->getEmail(),
                "address" => $order->getAddress(),
                "tid" => $order->getTid(),
                "amount" => $order->getAmount(),
                //"delivery_date" => $order->getDeliveryDate(),   
            ]);   
            //print_r($result); exit;
            $orderId = $this->db->lastInsertId();

            $response = array('success'=>true,'message'=>'Order saved successfully.');           
        } catch (PDOException $e){
            $response = array('errors'=>true,'message'=>$e->getMessage());
        }


        //get soups and proteins array
        $soups = $order->getSoups();
        $proteins = $order->getProteins();
        //print_r($soups); exit;

        //insert soups in DB
        $soups_sql = "insert into orders_soups
            (order_id,soup_id, name, price) values
            (:order_id,:soup_id, :name, :price)";
        $soups_stmt = $this->db->prepare($soups_sql);
        try 
        {
            foreach ($soups as $soup) 
            {
                 $soups_result = $soups_stmt->execute([
                    'order_id' => $orderId,
                    'soup_id' => $soup['id'],
                    'name' => $soup['main'],
                    'price' => $soup['price']
                ]);
            }
                       
        } 
        catch (PDOException $e)
        {
            $response['soups'] = array('errors'=>true,'message'=>$e->getMessage());
        }
        
        //insert proteins in DB
        
        $proteins_sql = "insert into orders_proteins
            (order_id,protein_id, name, price) values
            (:order_id,:protein_id, :name, :price)";
        $proteins_stmt = $this->db->prepare($proteins_sql);

        try 
        {
            foreach ($proteins as $protein) 
            {
                $proteins_result = $proteins_stmt->execute([
                    'order_id' => $orderId,
                    'protein_id' => $protein['id'],
                    'name' => $protein['name'],
                    'price' => $protein['price']
                ]);
            }
        } 
        catch (PDOException $e)
        {
            $response['proteins'] = array('errors'=>true,'message'=>$e->getMessage());
        }
        
        /*
        $result = $stmt->execute([
            "protein_id" => $order->,
            "name" => $order->,
            "price" => $order->
        ]);*/

        return $response;
    }
}