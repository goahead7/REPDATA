<?php
class Bag
{
    private $bag_num;
    private $manufacturer;
    private $model;
    private $age;

    public function __construct($bag_num, $manufacturer, $model, $age)
    {
        $this->bag_num = $bag_num;
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->age = $age;
    }

    public function get_num()
    {
        return $this->bag_num;
    }

    public function get_model()
    {
        return $this->model;
    }

    public function get_manufacturer()
    {
        return $this->manufacturer;
    }
}

class bag_mapper{
    protected $pdo;

    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }
    public function save(Bag $bag ): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO bag (bag_num, manufacturer, model, age) values(?,?,?,?)");
        $stmt->bindParam(1, $this->bag_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->manufacturer, PDO::PARAM_STR, 20);
        $stmt->bindParam(3, $this->model, PDO::PARAM_STR, 20);
        $stmt->bindParam(4, $this->age, PDO::PARAM_INT, 2);
        return $stmt->execute();
    }

    public function remove($bag)
    {
        $stmt = $this->pdo->prepare("Delete from bag where bag_num = ?, manufacturer = ?, model = ?, age = ? ");
        $stmt->bindParam(1, $this->bag_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->manufacturer, PDO::PARAM_STR, 20);
        $stmt->bindParam(3, $this->model, PDO::PARAM_STR, 20);
        $stmt->bindParam(4, $this->age, PDO::PARAM_INT, 2);
        return $stmt->execute();
    }

    public function getById( $bag_num): Bag
    {
        $stmt = $this->pdo->prepare("Select * from bag where bag_num = ? ");
        $stmt->bindParam(1, $bag_num, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Bag($row['bag_num'], $row['manufacturer'], $row['model'], $row['age']);
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT bag_num, manufacturer, model, age  FROM bag");
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('bag_num' => $row['bag_num'], 'manufacturer' => $row['manufacturer'],
                'model' => $row['modul'],  'age' => $row['age']);
        }
        return $tableList;
    }

    public function getByField($fieldValue): array
    {
        $stmt = $this->pdo->prepare("Select ? from bag ");
        $stmt->bindParam(1, $fieldValue, PDO::PARAM_INT);
        $stmt->execute();
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('bag_num' => $row['bag_num'], 'manufacturer' => $row['manufacturer'],
                'model' => $row['modul'],  'age' => $row['age']);
        }
        return $tableList;
    }
}