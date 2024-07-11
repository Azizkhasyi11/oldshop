<?php

class Products
{
  public $db = null;

  public function __construct(DBController $db)
  {
    if (!isset($db->con)) {
      $this->db = null;
    } else {
      $this->db = $db;
    }
  }

  // fetch product data using getData Method
  public function getData($table = 'products')
  {
    $result = $this->db->con->query("SELECT * FROM {$table}");

    $resultArray = [];

    // fetch product data one by one
    while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $resultArray[] = $item;
    }

    return $resultArray;
  }

  // get product using item id
  public function getProduct($item_id = null, $table = 'products')
  {
    if (isset($item_id)) {
      // Prepare statement to prevent SQL injection
      $stmt = $this->db->con->prepare("SELECT * FROM {$table} WHERE id = ?");
      $stmt->bind_param("i", $item_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        // fetch product data
        return $result->fetch_assoc();
      } else {
        // No product found
        return null;
      }
    }

    return null;
  }

}