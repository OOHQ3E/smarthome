
Table "esp" {
  "id" int(10) [pk, not null, increment]
  "room_id" int(10) [not null]
  "type" varchar(255) [not null]
  "ip_End" tinyint(3) [not null]
  "name" varchar(255) [not null]
  "created_at" timestamp [default: NULL]
  "updated_at" timestamp [default: NULL]

Indexes {
  room_id [name: "esp_room_id_foreign"]
}
}

Table "esp_sensor_data" {
  "id" int(10) [pk, not null, increment]
  "room_id" int(10) [not null]
  "humidity" double(8,2) [not null]
  "temperature" double(8,2) [not null]
  "created_at" timestamp [default: NULL]
  "updated_at" timestamp [default: NULL]

Indexes {
  room_id [name: "esp_sensor_data_room_id_foreign"]
}
}

Table "room" {
  "id" int(10) [pk, not null, increment]
  "name" varchar(255) [not null]
  "created_at" timestamp [default: NULL]
  "updated_at" timestamp [default: NULL]
}


Ref "esp_room_id_foreign":"room"."id" < "esp"."room_id" [delete: cascade]

Ref "esp_sensor_data_room_id_foreign":"room"."id" < "esp_sensor_data"."room_id" [delete: cascade]
