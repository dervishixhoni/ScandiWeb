<?php
require_once 'Database.php';
abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    private static $conn = null;
    public function __construct($sku, $name, $price, $type)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
    }
    public static function initialize() {
        if (self::$conn === null) {
            self::$conn = (new Database())->getConnection();
        }
    }

    public static function isSkuUnique($conn, $sku): bool
    {
        $query = "SELECT COUNT(*) FROM products WHERE sku = :sku";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count == 0;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    abstract public function save($conn);

    public static function getAll()
    {
        $query = "SELECT * FROM products ORDER BY id";
        $conn = Product::$conn;
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function delete($ids)
    {
        $query = "DELETE FROM products WHERE id IN (" . implode(',', $ids) . ")";
        $conn = Product::$conn;
        $stmt = $conn->prepare($query);
        return $stmt->execute();
    }

}


