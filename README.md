# JsonDbQuery

[![Build Status](https://travis-ci.org/guidofaecke/jsonDbQuery.svg?branch=master)](https://travis-ci.org/guidofaecke/jsonDbQuery)

Build simple queries with JSON via REST and RPC calls.

Planned support
- Doctrine
- Zend-Db
- raw SQL

## Usage examples
### (not yet finalized)

http://<your_system>/api/get_some_data?query={"field" : {"$not" : val}}
http://<your_system>/api/get_some_data?query={"field" : {"$in" : [value1, value2, ...]}}
http://<your_system>/api/get_some_data?query={"$or": [{"status": "BLUE"}, {"status": "RED"}]}
http://<your_system>/api/get_some_data?query={"amount": {"$gt": 500}}
http://<your_system>/api/get_some_data?query={"amount": {"$lte": 500}}
http://<your_system>/api/get_some_data?query={"amount": {"$bt": [300, 640]}}