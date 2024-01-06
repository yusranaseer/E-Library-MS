<?php

class FirestoreManager {
    private $firestore;

    public function __construct($firestore) {
        $this->firestore = $firestore;
    }

    public function getTotalCount($ref_table) {
        $tableRef = $this->firestore->collection($ref_table);
        $tableSnapshot = $tableRef->documents();
        $totalCount = $tableSnapshot->size();
        return $totalCount;
    }

    public function getRecentRecords($ref_table,$limit,$odering_column) {
        $collectionRef = $this->firestore->collection($ref_table);

        $query = $collectionRef->orderBy($odering_column, 'DESC')->limit($limit);
        $querySnapshot = $query->documents();

        return $querySnapshot;
    }

    public function getRecentActiveBooks($ref_table,$limit,$odering_column) {
        $collectionRef = $this->firestore->collection($ref_table);

        $query = $collectionRef->where('status', '=', 'active')->orderBy($odering_column, 'DESC')->limit($limit);
        $querySnapshot = $query->documents();

        return $querySnapshot;
    }
    public function getRecentActiveInnos($ref_table,$limit,$odering_column) {
        $collectionRef = $this->firestore->collection($ref_table);

        $query = $collectionRef->where('status', '=', 'accepted')->orderBy($odering_column)->limit($limit);
        $querySnapshot = $query->documents();

        return $querySnapshot;
    }

    public function getRecords($ref_table,$odering_column,$start_from,$limit) {
        $collectionRef = $this->firestore->collection($ref_table);

        $query = $collectionRef->orderBy($odering_column)->startAt([$start_from])->limit($limit);
        $querySnapshot = $query->documents();

        return $querySnapshot;
    }

    public function getInnovations($ref_table,$odering_column,$start_from,$limit) {
        $collectionRef = $this->firestore->collection($ref_table);

        $query = $collectionRef->where('status', '=', 'pending')->orderBy($odering_column)->startAt([$start_from])->limit($limit);
        $querySnapshot = $query->documents();

        return $querySnapshot;
    }

    public function getSumAndCount($ref_table,$Id) {
        $tableRef = $this->firestore->collection($ref_table)->documents();
        $totalRows = 0;
        $sum = 0;

        foreach ($tableRef as $tableDoc) {
            $tableData = $tableDoc->data();
            if($ref_table == 'feedback')
            {
                if ($Id == $tableData['bookId']) {
                    $totalRows++;
                    $sum += $tableData['rating'];
                }
            }
            else if($ref_table == 'viewTask')
            {
                if ($Id == $tableData['taskId']) {
                    $totalRows++;
                }
            }
        }

        return [
            'totalRows' => $totalRows,
            'sum' => $sum
        ];
    }

    public function validateUsername($ref_table,$username){
        $tableRef = $this->firestore->collection($ref_table);
        $query = $tableRef->where('username', '=', $username)->limit(1);
        $tableSnapshot = $query->documents();
        $totalCount = $tableSnapshot->size();

        return $totalCount;
    }

    public function getUsername($ref_table,$id,$columnName){
        $tableRef = $this->firestore->collection($ref_table);
        $query = $tableRef->where($columnName, '=', $id)->limit(1);
        $querySnapshot = $query->documents();

        $username = null;
        if($ref_table == 'staff')
        {
            foreach ($querySnapshot as $documentSnapshot) {
                $username = $documentSnapshot->get('Name');
                break;
            }
        }
        else{
            foreach ($querySnapshot as $documentSnapshot) {
                $username = $documentSnapshot->get('username');
                break;
            }
        }
        
        return $username;
    }
}
