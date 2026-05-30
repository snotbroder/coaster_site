<?php
class ParkFilterModel
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
        $this->conditions[] = "park_title LIKE :query";
        $this->params[":query"] = "%" . $filter_search . "%";
        return $this;
    }

    public function fetch(PDO $db): array
    {
        $sql = "SELECT * FROM parks";

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
