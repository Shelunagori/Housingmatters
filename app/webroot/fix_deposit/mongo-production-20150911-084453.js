
/** flat_types indexes **/
db.getCollection("flat_types").ensureIndex({
  "_id": NumberInt(1)
},[
  
]);

/** flat_types records **/
db.getCollection("flat_types").insert({
  "_id": ObjectId("55d9d9b55f66fb9003000000"),
  "auto_id": NumberInt(2),
  "charge": [
    [
      NumberInt(84),
      NumberInt(1),
      "625"
    ],
    [
      NumberInt(86),
      NumberInt(1),
      "416.67"
    ],
    [
      NumberInt(42),
      NumberInt(1),
      "1291.67"
    ],
    [
      NumberInt(79),
      NumberInt(1),
      "285"
    ],
    [
      NumberInt(80),
      NumberInt(1),
      "865"
    ],
    [
      NumberInt(83),
      NumberInt(1),
      "300"
    ],
    [
      NumberInt(87),
      NumberInt(1),
      "35"
    ],
    [
      NumberInt(81),
      NumberInt(1),
      "43"
    ],
    [
      NumberInt(82),
      NumberInt(1),
      "18.33"
    ],
    [
      NumberInt(95),
      NumberInt(1),
      "4888"
    ],
    [
      NumberInt(94),
      NumberInt(1),
      "0"
    ]
  ],
  "created": ISODate("2015-08-23T14:33:25.0Z"),
  "flat_type_id": NumberInt(2),
  "modified": ISODate("2015-08-23T14:33:25.0Z"),
  "noc_charge": [
    NumberInt(1),
    "280"
  ],
  "number_of_flat": NumberInt(5),
  "society_id": NumberInt(3),
  "status": NumberInt(0)
});
db.getCollection("flat_types").insert({
  "_id": ObjectId("55d9da575f66fb0402000000"),
  "auto_id": NumberInt(3),
  "charge": [
    [
      NumberInt(84),
      NumberInt(1),
      "1116.67"
    ],
    [
      NumberInt(86),
      NumberInt(1),
      "625"
    ],
    [
      NumberInt(42),
      NumberInt(1),
      "2800"
    ],
    [
      NumberInt(79),
      NumberInt(1),
      "425"
    ],
    [
      NumberInt(80),
      NumberInt(1),
      "1250"
    ],
    [
      NumberInt(83),
      NumberInt(1),
      "300"
    ],
    [
      NumberInt(87),
      NumberInt(1),
      "110"
    ],
    [
      NumberInt(81),
      NumberInt(1),
      "50"
    ],
    [
      NumberInt(82),
      NumberInt(1),
      "25"
    ],
    [
      NumberInt(95),
      NumberInt(1),
      "4884"
    ],
    [
      NumberInt(94),
      NumberInt(1),
      "300"
    ]
  ],
  "created": ISODate("2015-08-23T14:36:07.0Z"),
  "flat_type_id": NumberInt(3),
  "modified": ISODate("2015-08-23T14:36:07.0Z"),
  "noc_charge": [
    NumberInt(1),
    "280"
  ],
  "number_of_flat": NumberInt(6),
  "society_id": NumberInt(3),
  "status": NumberInt(0)
});
db.getCollection("flat_types").insert({
  "_id": ObjectId("55d9d9825f66fb3423000000"),
  "auto_id": NumberInt(1),
  "charge": [
    [
      NumberInt(84),
      NumberInt(1),
      "625"
    ],
    [
      NumberInt(86),
      NumberInt(1),
      "416.67"
    ],
    [
      NumberInt(42),
      NumberInt(1),
      "1291.67"
    ],
    [
      NumberInt(79),
      NumberInt(1),
      "180"
    ],
    [
      NumberInt(80),
      NumberInt(1),
      "180"
    ],
    [
      NumberInt(83),
      NumberInt(1),
      "300"
    ],
    [
      NumberInt(87),
      NumberInt(1),
      "35"
    ],
    [
      NumberInt(81),
      NumberInt(1),
      "43"
    ],
    [
      NumberInt(82),
      NumberInt(1),
      "18.33"
    ],
    [
      NumberInt(95),
      NumberInt(1),
      "284.33"
    ],
    [
      NumberInt(94),
      NumberInt(1),
      "0"
    ]
  ],
  "created": ISODate("2015-08-23T14:32:34.0Z"),
  "flat_type_id": NumberInt(1),
  "modified": ISODate("2015-08-23T14:32:34.0Z"),
  "noc_charge": [
    NumberInt(1),
    "280"
  ],
  "number_of_flat": NumberInt(20),
  "society_id": NumberInt(3),
  "status": NumberInt(0)
});
db.getCollection("flat_types").insert({
  "_id": ObjectId("55f2713a5f66fb8815000000"),
  "auto_id": NumberInt(4),
  "charge": [
    [
      NumberInt(42),
      NumberInt(2),
      "3.5"
    ]
  ],
  "created": ISODate("2015-09-11T06:14:18.0Z"),
  "flat_type_id": NumberInt(5),
  "modified": ISODate("2015-09-11T06:14:18.0Z"),
  "noc_charge": [
    NumberInt(1),
    "300"
  ],
  "number_of_flat": NumberInt(17),
  "society_id": NumberInt(2),
  "status": NumberInt(0)
});
db.getCollection("flat_types").insert({
  "_id": ObjectId("55f2713b5f66fb8815000001"),
  "auto_id": NumberInt(5),
  "charge": [
    [
      NumberInt(42),
      NumberInt(2),
      "2.75"
    ]
  ],
  "created": ISODate("2015-09-11T06:14:19.0Z"),
  "flat_type_id": NumberInt(2),
  "modified": ISODate("2015-09-11T06:14:19.0Z"),
  "noc_charge": [
    NumberInt(1),
    "300"
  ],
  "number_of_flat": NumberInt(48),
  "society_id": NumberInt(2),
  "status": NumberInt(0)
});
