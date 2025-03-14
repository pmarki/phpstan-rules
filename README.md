# phpstan-rules
Set of additional PHPStan rules


TODO
- duplicated array keys
- foreach key value used outside or name duplicated
- remove concat cast 

-if (empty($values)) {
+if ([] === $values) {


-array_search("searching", $array) !== false;
+in_array("searching", $array); 