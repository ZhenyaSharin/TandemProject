<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;
use PDO;
use Carbon\Carbon;

class Persons extends Model
{
    use HasFactory;

    public $age;

    private function ageOfPerson($birthdate)
    {
        // $data = self::getPersonById($id);
        // $birthdate = $data[0]["birth_date"];
        // $this->age = Carbon::parse($birthdate)->diffInYears();
        $result = Carbon::parse($birthdate)->diffInYears();
        return $result;
    }

    public function getAgePersonById($id)
    {
        $brd = self::getPersonById($id)[0]['birth_date'];
        $this->age = Carbon::parse($brd)->diffInYears();
        return $this->age;
    }

    public function getPersonById($id)
    {
        try {
            $pdo = DB::connection()->getPDO();
            $pdo->beginTransaction();
            $stm = $pdo->prepare('SELECT * FROM "persons" WHERE "id" = :userid');
            $stm->bindValue('userid', $id);
            $stm->execute(); 
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            $result[0]['age'] = self::ageOfPerson($result[0]['birth_date']);
            return $result;
        } catch (\PDOException | Throwable $e) {
            if ($pdo && $pdo->inTransaction()) {
                $pdo->rollback();
            }
            // throw new DatabaseException($e->getMessage());
        }
    }


    public function getRange()
    {
        try {
            $pdo = DB::connection()->getPDO();
            $pdo->beginTransaction();
            $stm = $pdo->prepare('SELECT "id" FROM "persons" ORDER BY "id" ASC LIMIT 1');
            $stm->execute(); 
            $result['start'] = $stm->fetch(PDO::FETCH_ASSOC)['id'];
            $stm2 = $pdo->prepare('SELECT "id" FROM "persons" ORDER BY "id" DESC LIMIT 1');
            $stm2->execute(); 
            $result['end'] = $stm2->fetch(PDO::FETCH_ASSOC)['id'];
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