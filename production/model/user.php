<?php
include 'connection.php';

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
        $this->db = new connection();
    }

    /**returns all user records
     */
    function records()
    {
        $query = "Select * from user";
        $results = $this->db->listResults($query);
        /** @var array $results */
        foreach ($results as $user) {

            $u = array(
                "user_id" => $user ["user_id"],
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
        $fields = [
            'email',
            'password',
            'first_name',
            'last_name',
            'street_number',
            'apartment_number',
            'street_name',
            'city',
            'state'
        ];

        $fields_string = implode(',', $fields);
        $fields_string2 = implode(',:', $fields);
        $query = "INSERT INTO user ($fields_string) VALUES (:$fields_string2)";
        $data = array_intersect_key(json_decode(json_encode($user), true), array_flip($fields));

        return $this->db->save($query, $data);
    }

    /**
     * Update single user
     * @param array $user
     * returns 0  for false / 1 for true
     * @return  bool
     * **/
    function update($query,$data)
    {
        return $this->db->update($query,$data);
    }

    /**
     * @param $id
     * @return mixed
     */
    function view($id)
    {
        $data = [
            "user_id" => $id
        ];
        $query = "SELECT * from user WHERE user_id= :user_id ";
        $results = $this->db->singleResult($query, $data);
        $u = new User();
        $u->user_id = $results["user_id"];
        $u->email = $results["email"];
        $u->password = $results["password"];
        $u->first_name = $results["first_name"];
        $u->last_name = $results["last_name"];
        $u->street_number = $results["street_number"];
        $u->apartment_number = $results["apartment_number"];
        $u->street_name = $results["street_name"];
        $u->city = $results["city"];
        $u->state = $results["state"];
        return $u;
    }

    /**
     * delete users
     * @param int $id
     * @ returns 0  for false / 1 for true
     * @return bool
     */
    function delete($id)
    {
        $query = "DELETE FROM  user WHERE user_id = " . $id . " AND user_id = LAST_INSERT_ID(" . $id . ")";
        return $this->db->delete($query);

    }
}