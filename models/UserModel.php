<?php
class UserModel
{
    private array $conditions = [];
    private array $params = [];

    // public function filterCountry(string $filter_country): static
    // {
    //     $this->conditions[] = "park_country = :country";
    //     $this->params[":country"] = $filter_country;
    //     return $this;
    // }



    public function fetch(PDO $db): array
    {
        $sql = "SELECT * FROM users";

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions); //Implode: join arrat with string
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
