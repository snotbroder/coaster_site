<?php
class CoasterFilterModel
{
    private array $conditions = [];
    private array $params = [];

    public function filterCountry(string $filter_country): static
    {
        $this->conditions[] = "park_country = :country";
        $this->params[":country"] = $filter_country;
        return $this;
    }

    public function filterSearch(string $filter_search): static
    {
        $this->conditions[] = "coaster_title LIKE :query";
        $this->params[":query"] = "%" . $filter_search . "%";
        return $this;
    }

    public function filterMinTopSpeed(int $filter_speed): static
    {
        $this->conditions[] = "coaster_top_speed >= :speed";
        $this->params[":speed"] = $filter_speed;
        return $this;
    }

    public function fetch(PDO $db): array
    {
        $sql = "SELECT * FROM coasters JOIN parks ON coaster_park_fk = park_pk";

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions); //Implode: join arrat with string
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
