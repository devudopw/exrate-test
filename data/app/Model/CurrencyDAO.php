<?php
namespace App\Model;

class CurrencyDAO extends DAO
{
    public function findByCode($code)
    {
        $sql = 'SELECT * FROM currency WHERE code = :code LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('code', $code);
        $result = $stmt->execute();
        $row = $result->fetchAssociative();
        return new Currency($row['code']);
    }
}
