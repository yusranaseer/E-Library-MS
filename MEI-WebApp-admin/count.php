<?php
class Count {
    private $firestore;

    public function __construct($firestore) {
        $this->firestore = $firestore;
    }

    public function getTotalDocumentCount($collectionName) {
        $collectionRef = $this->firestore->collection($collectionName);
        $collectionSnapshot = $collectionRef->documents();
        $totalCount = $collectionSnapshot->size();
        return $totalCount;
    }
}
?>