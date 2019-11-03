<?php


Class User
{

    public $user_id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $street_number;
    public $apartment_number;
    public $street_name;
    public $city;
    public $state;
    private $db;
    private $users = [];

    function __construct()
    {
        include('../Connection.php');
        $this->db = new Connection();

    }

    function records()
    {
        $sql = "Select * from user";
        $results = $this->db->listResults($sql);
        /** @var array $results */
        foreach ($results as $user) {

            $u = array(
                "email" => $user ["email"],
                "password" => $user["password"],
                "first_name" => $user["first_name"],
                "last_name" => $user["last_name"],
                "street_number" => $user["street_number"],
                "apartment_number" => $user["apartment_number"],
                "street_name" => $user["street_name"],
                "city" => $user["city"],
                "state" => $user["state"]
            );
            array_push($this->users, $u);

        }

        return $this->users;
    }

    /**returns boolean true/false*/
    function save($user)
    {
        $query = "INSERT INTO user (email,password,first_name,last_name,street_number,apartment_number,street_name,city,state) VALUES (:email,:password,:first_name,:last_name,:street_number,:apartment_number,:street_name,:city,:state)";

        $data = [
            "email" => $user->email,
            "password" => $user->password,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "street_number" => $user->street_number,
            "apartment_number" => $user->apartment_number,
            "street_name" => $user->street_name,
            "city" => $user->city,
            "state" => $user->state

        ];
        var_dump($data);
        /*returns true/false */
        return $this->db->save($query, $data);

    }
}

?>