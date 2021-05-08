<?php
namespace App\Model;

use App\Model\Currency;

class RateDAO extends DAO
{
    public function findEXRate($from, $to)
    {
        $sql = 'SELECT 1 FROM exrate WHERE `from` = :from ORDER BY created_at DESC LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('from', $from);
        $result = $stmt->execute();
        $exists = $result->fetchOne();
        if (!$exists) {
            throw new \InvalidArgumentException('not supported \'from\' currency', 10024);
        }
        $sql = 'SELECT 1 FROM exrate WHERE `to` = :to ORDER BY created_at DESC LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('to', $to);
        $result = $stmt->execute();
        $exists = $result->fetchOne();
        if (!$exists) {
            throw new \InvalidArgumentException('not supported \'to\' currency', 10025);
        }

        $sql = 'SELECT * FROM exrate WHERE `from` = :from AND `to` = :to ORDER BY created_at DESC LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('from', $from);
        $stmt->bindValue('to', $to);
        $result = $stmt->execute();
        $row = $result->fetchAssociative();
        $rate = new Rate(1);
        $rate->setFrom(new Currency($row['from']));
        $rate->addTo(new Currency($row['to']));
        $rate->updateEXRate($row['rate']);
        $rate->updateInverse($row['inverse']);
        return $rate;
    }
}
