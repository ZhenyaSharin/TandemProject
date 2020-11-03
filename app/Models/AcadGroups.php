<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;
use PDO;

class AcadGroups extends Model
{
    use HasFactory;

    public function getPersonsByGroupId($groupid)
    {
        try {
            $pdo = DB::connection()->getPDO();
            $pdo->beginTransaction();
            $stm = $pdo->prepare('SELECT * FROM "academicgroups" WHERE "id" = :id AND "archive" = false');
            $stm->bindValue('id', $groupid);
            $stm->execute(); 
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) != 0) {
                $stm2 = $pdo->prepare('SELECT * FROM "persons" WHERE "group_id" = :groupid AND "active" = true');
                $stm2->bindValue('groupid', $groupid);
                $stm2->execute(); 
                $persons = $stm2->fetchAll(PDO::FETCH_ASSOC);
                $result[0]['persons'] = $persons;
                $pdo->commit();
                return $result;
            } else {
                return false;
            }
        } catch (\PDOException | Throwable $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollback();
            }
            // throw new DatabaseException($e->getMessage());
        }
    }

    public function getAllGroups()
    {
        try {
            $pdo = DB::connection()->getPDO();
            $pdo->beginTransaction();
            $stm = $pdo->prepare('SELECT * FROM "academicgroups" WHERE "archive" = false');
            $stm->execute(); 
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            return $result;
        } catch (\PDOException | Throwable $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollback();
            }
            // throw new DatabaseException($e->getMessage());
        }
    }
}
